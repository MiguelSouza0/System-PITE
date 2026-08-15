<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Atrativo;
use App\Models\Categoria;
use App\Models\Roteiro;
use App\Services\AiItineraryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoteiroController extends Controller
{
    protected $aiService;

    public function __construct(AiItineraryService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Catálogo de roteiros turísticos (predefinidos e oficiais) + gerador inteligente.
     */
    public function index(Request $request)
    {
        $query = Roteiro::where('ativo', true)->with('atrativos');

        // Filtro por Tema / Categoria
        if ($request->filled('tema') && $request->tema !== 'todos') {
            $query->where('tema', $request->tema);
        }

        // Filtro por Dificuldade
        if ($request->filled('dificuldade') && $request->dificuldade !== 'todas') {
            $query->where('nivel_dificuldade', $request->dificuldade);
        }

        // Filtro por Meio de Transporte
        if ($request->filled('meio_transporte') && $request->meio_transporte !== 'todos') {
            $query->where('meio_transporte', $request->meio_transporte);
        }

        // Filtro por Duração Máxima (horas)
        if ($request->filled('duracao_max')) {
            $query->where('duracao_estimada_horas', '<=', (int) $request->duracao_max);
        }

        // Filtro por Acessibilidade PNE
        if ($request->filled('acessivel')) {
            $query->where('acessivel_pne', true);
        }

        // Filtro por Orçamento
        if ($request->filled('orcamento') && $request->orcamento !== 'todos') {
            $query->where('orcamento_nivel', $request->orcamento);
        }

        // Busca textual
        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function ($q) use ($busca) {
                $q->where('titulo', 'like', "%{$busca}%")
                  ->orWhere('descricao', 'like', "%{$busca}%")
                  ->orWhere('ponto_partida', 'like', "%{$busca}%")
                  ->orWhere('ponto_chegada', 'like', "%{$busca}%");
            });
        }

        $roteirosProntos = $query->orderBy('gerado_por_ia', 'asc')->latest()->paginate(9);
        $categorias = Categoria::where('ativo', true)->get();

        return view('portal.roteiros', compact('roteirosProntos', 'categorias'));
    }

    /**
     * Exibição detalhada de um roteiro turístico com mapa, paradas e orientações.
     */
    public function show($slug)
    {
        $roteiro = Roteiro::with(['atrativos' => function ($q) {
            $q->orderBy('roteiro_atrativo.ordem');
        }])->where('slug', $slug)->firstOrFail();

        // Atrativos com dados completos para o mapa Leaflet
        $atrativosMapData = $roteiro->atrativos->map(function ($at, $index) {
            return [
                'id' => $at->id,
                'ordem' => $index + 1,
                'nome' => $at->nome,
                'descricao' => $at->descricao_curta ?? $at->descricao,
                'lat' => (float) $at->latitude,
                'lng' => (float) $at->longitude,
                'endereco' => $at->endereco,
                'horario' => $at->horario_funcionamento,
                'preco' => $at->preco_medio > 0 ? 'R$ ' . number_format($at->preco_medio, 2, ',', '.') : 'Gratuito',
                'tempo_estimado' => $at->pivot->tempo_estimado ?? '45min',
                'observacao' => $at->pivot->observacao ?? '',
                'url' => route('portal.atrativos.show', $at->slug),
                'acessivel' => !empty($at->niveis_acessibilidade['cadeirante'])
            ];
        });

        // Roteiros relacionados
        $roteirosRelacionados = Roteiro::where('id', '!=', $roteiro->id)
            ->where('ativo', true)
            ->where(function ($q) use ($roteiro) {
                $q->where('tema', $roteiro->tema)
                  ->orWhere('nivel_dificuldade', $roteiro->nivel_dificuldade);
            })
            ->take(3)
            ->get();

        // Lista completa de atrativos para o modal de adição de pontos
        $todosAtrativos = Atrativo::where('ativo', true)->get()->map(function($at) {
            return [
                'id' => $at->id,
                'nome' => $at->nome,
                'descricao' => $at->descricao_curta ?? Str::limit($at->descricao, 90),
                'lat' => (float) $at->latitude,
                'lng' => (float) $at->longitude,
                'endereco' => $at->endereco ?? 'Centro',
                'slug' => $at->slug,
                'url' => route('portal.atrativos.show', $at->slug),
                'acessivel' => !empty($at->niveis_acessibilidade['cadeirante'])
            ];
        });

        return view('portal.roteiros.show', compact('roteiro', 'atrativosMapData', 'roteirosRelacionados', 'todosAtrativos'));
    }

    /**
     * Gerador de Roteiros Inteligentes via Inteligência Artificial Multicritério.
     */
    public function gerar(Request $request)
    {
        $validated = $request->validate([
            'perfil' => 'required|string|max:50',
            'duracao_horas' => 'required|integer|min:1|max:24',
            'orcamento' => 'nullable|string|in:gratuito,economico,moderado,premium',
            'meio_transporte' => 'nullable|string|in:a_pe,bicicleta,carro,transporte_publico,misto',
            'acessivel' => 'nullable|boolean',
            'criancas' => 'nullable|boolean',
            'faixa_etaria' => 'nullable|string|in:livre,criancas,jovens,adultos,melhor_idade',
            'interesses' => 'nullable|array',
            'interesses.*' => 'string'
        ]);

        $preferencias = [
            'perfil' => $validated['perfil'],
            'duracao_horas' => (int) $validated['duracao_horas'],
            'orcamento' => $validated['orcamento'] ?? 'moderado',
            'meio_transporte' => $validated['meio_transporte'] ?? 'a_pe',
            'acessivel' => $request->boolean('acessivel'),
            'criancas' => $request->boolean('criancas'),
            'faixa_etaria' => $validated['faixa_etaria'] ?? 'livre',
            'interesses' => $validated['interesses'] ?? [],
        ];

        $roteiro = $this->aiService->gerarRoteiroPersonalizado($preferencias);

        // Carregar atrativos associados ordenados
        $roteiro->load(['atrativos' => function ($q) {
            $q->orderBy('roteiro_atrativo.ordem');
        }]);

        if ($request->wantsJson()) {
            return response()->json([
                'sucesso' => true,
                'mensagem' => 'Roteiro inteligente gerado com sucesso!',
                'roteiro' => $roteiro,
                'atrativos' => $roteiro->atrativos,
                'url_detalhe' => route('portal.roteiros.show', $roteiro->slug)
            ]);
        }

        return redirect()->route('portal.roteiros.show', $roteiro->slug)
            ->with('sucesso', 'Seu roteiro inteligente foi gerado sob medida!');
    }

    /**
     * Tela dedicada e payload para o Modo Offline (Trilhas e Áreas sem Conectividade).
     */
    public function offline($slug = null)
    {
        $roteiro = null;
        if ($slug) {
            $roteiro = Roteiro::with('atrativos')->where('slug', $slug)->first();
        }

        $roteirosDisponiveis = Roteiro::where('ativo', true)->with('atrativos')->take(10)->get();

        return view('portal.roteiros.offline', compact('roteiro', 'roteirosDisponiveis'));
    }

    /**
     * Retorna payload JSON completo para cache offline no navegador.
     */
    public function offlineData($id)
    {
        $roteiro = Roteiro::with(['atrativos' => function ($q) {
            $q->orderBy('roteiro_atrativo.ordem');
        }])->findOrFail($id);

        return response()->json([
            'sucesso' => true,
            'roteiro' => $roteiro,
            'telefones_emergencia' => [
                'Polícia Militar' => '190',
                'SAMU Ambulância' => '192',
                'Corpo de Bombeiros' => '193',
                'Defesa Civil' => '199',
                'Guarda Municipal' => '153',
                'Secretaria de Turismo' => '(83) 3333-0000'
            ],
            'salvo_em' => now()->toIso8601String()
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atrativo;
use App\Models\Avaliacao;
use App\Models\Categoria;
use App\Models\Empreendedor;
use App\Models\Evento;
use App\Models\IndicadorEsg;
use App\Models\User;
use App\Services\AiItineraryService;
use App\Services\EsgMetricService;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $esgService;
    protected $aiService;

    public function __construct(EsgMetricService $esgService, AiItineraryService $aiService)
    {
        $this->esgService = $esgService;
        $this->aiService = $aiService;
    }

    public function index()
    {
        $user = auth()->user();

        // 1. --- CONTADORES EXECUTIVOS GERAIS ---
        $stats = [
            'total_atrativos'          => Atrativo::count(),
            'atrativos_ativos'         => Atrativo::where('ativo', true)->count(),
            'atrativos_pendentes'      => Atrativo::pendente()->count(),
            'atrativos_suspensos'      => Atrativo::suspenso()->count(),
            'total_empreendedores'     => Empreendedor::count(),
            'empreendedores_aprovados' => Empreendedor::where('status_aprovacao', 'aprovado')->count(),
            'empreendedores_pendentes' => Empreendedor::where('status_aprovacao', 'pendente')->count(),
            'total_eventos'            => Evento::count(),
            'eventos_ativos'           => Evento::where('ativo', true)->count(),
            'eventos_pendentes'        => Evento::pendente()->count(),
            'eventos_suspensos'        => Evento::suspenso()->count(),
            'total_avaliacoes'         => Avaliacao::count(),
            'media_avaliacoes'         => round(Avaliacao::avg('nota') ?? 0, 1),
            'total_usuarios'           => User::count(),
            'total_categorias'         => Categoria::count(),
        ];

        // 2. --- INTELIGÊNCIA DE SAZONALIDADE & FLUXO (Últimos 12 meses) ---
        $mesesNomes = [
            1 => 'Jan', 2 => 'Fev', 3 => 'Mar', 4 => 'Abr', 5 => 'Mai', 6 => 'Jun',
            7 => 'Jul', 8 => 'Ago', 9 => 'Set', 10 => 'Out', 11 => 'Nov', 12 => 'Dez'
        ];

        // Fluxo de avaliações/visitas por mês
        $visitasPorMesRaw = Avaliacao::select(
                DB::raw('EXTRACT(MONTH FROM created_at) as mes'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $fluxoMensal = [];
        for ($m = 1; $m <= 12; $m++) {
            $registro = $visitasPorMesRaw->firstWhere('mes', $m);
            $fluxoMensal[$mesesNomes[$m]] = $registro ? (int) $registro->total : 0;
        }

        // 3. --- PERFIL E ORIGEM DO TURISTA ---
        $origemTuristas = Avaliacao::select('origem_turista', DB::raw('count(*) as total'))
            ->whereNotNull('origem_turista')
            ->groupBy('origem_turista')
            ->get()
            ->mapWithKeys(function ($item) {
                $labels = [
                    'local' => 'Moradores Locais',
                    'nacional' => 'Turistas Nacionais',
                    'internacional' => 'Turistas Internacionais'
                ];
                return [$labels[$item->origem_turista] ?? ucfirst($item->origem_turista) => $item->total];
            });

        // 4. --- AVALIAÇÃO DO SETOR & IMPACTO ECONÔMICO ---
        $ticketMedio = Atrativo::where('preco_medio', '>', 0)->avg('preco_medio') ?? 0;
        $eventosGratuitos = Evento::where('gratuito', true)->count();
        $eventosPagos = Evento::where('gratuito', false)->count();

        // 5. --- DIAGNÓSTICO DE ACESSIBILIDADE (PNE) ---
        $atrativosAcessiveis = Atrativo::whereJsonContains('niveis_acessibilidade->cadeirante', true)->count();
        $percentualAcessibilidade = $stats['total_atrativos'] > 0 
            ? round(($atrativosAcessiveis / $stats['total_atrativos']) * 100, 1) 
            : 0;

        // 6. --- ATRATIVOS POR CATEGORIA ---
        $atrativosPorCategoria = Atrativo::select('categoria_id', DB::raw('count(*) as total'))
            ->groupBy('categoria_id')
            ->with('categoria:id,nome')
            ->get()
            ->map(fn($item) => [
                'categoria' => $item->categoria->nome ?? 'Sem categoria',
                'total' => $item->total,
            ]);

        // 7. --- EMPREENDEDORES POR STATUS ---
        $empreendedoresPorStatus = Empreendedor::select('status_aprovacao', DB::raw('count(*) as total'))
            ->groupBy('status_aprovacao')
            ->pluck('total', 'status_aprovacao');

        // 8. --- ÚLTIMOS ATRATIVOS & PENDENTES ---
        $ultimosAtrativos = Atrativo::with('categoria')->latest()->take(5)->get();
        $pendentes = Empreendedor::where('status_aprovacao', 'pendente')->latest()->take(5)->get();

        // 9. --- INDICADORES ESG & PILARES ---
        $indicadoresEsg = $this->esgService->consolidarIndicadoresMunicipais();
        $esgPorPilar = IndicadorEsg::select('pilar', DB::raw('AVG(valor) as media'))
            ->groupBy('pilar')
            ->pluck('media', 'pilar');

        // 10. --- INTELIGÊNCIA ARTIFICIAL: ANÁLISE DE SENTIMENTO & AVALIAÇÕES (SEÇÃO 6) ---
        $analiseSentimentoIa = $this->aiService->analisarSentimentoAvaliacoes();

        $viewData = compact(
            'stats',
            'fluxoMensal',
            'origemTuristas',
            'ticketMedio',
            'eventosGratuitos',
            'eventosPagos',
            'percentualAcessibilidade',
            'atrativosPorCategoria',
            'empreendedoresPorStatus',
            'ultimosAtrativos',
            'pendentes',
            'indicadoresEsg',
            'esgPorPilar',
            'analiseSentimentoIa'
        );

        if ($user && ($user->isPrefeito() || $user->isSecretario())) {
            return view('admin.dashboard.prefeito', $viewData);
        }

        return view('admin.dashboard.servidor', $viewData);
    }
}

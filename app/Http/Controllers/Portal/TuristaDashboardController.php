<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Atrativo;
use App\Models\Avaliacao;
use App\Models\Categoria;
use App\Models\Evento;
use App\Models\Favorito;
use App\Models\HistoricoVisita;
use App\Models\Roteiro;
use App\Models\AiPlanoTurismo;
use Illuminate\Http\Request;

class TuristaDashboardController extends Controller
{
    /**
     * Dashboard principal do turista — resumo da jornada.
     */
    public function index()
    {
        $user = auth()->user();

        // Estatísticas da jornada
        $totalVisitas = $user->historicoVisitas()->count();
        $totalAvaliacoes = $user->avaliacoes()->count();
        $totalFavoritos = $user->favoritos()->count();
        $totalRoteiros = AiPlanoTurismo::doUsuario($user->id)->count();

        // Últimas visitas
        $ultimasVisitas = $user->historicoVisitas()
            ->with('atrativo.categoria')
            ->latest('visitado_em')
            ->take(5)
            ->get();

        // Favoritos recentes
        $favoritosRecentes = $user->favoritos()
            ->with('favoritavel')
            ->latest()
            ->take(4)
            ->get();

        // Recomendações baseadas nos interesses
        $recomendacoes = $this->gerarRecomendacoes($user);

        // Próximos eventos
        $proximosEventos = Evento::where('ativo', true)
            ->where('data_inicio', '>=', now())
            ->orderBy('data_inicio')
            ->take(3)
            ->get();

        // Últimas avaliações do turista
        $ultimasAvaliacoes = $user->avaliacoes()
            ->with('atrativo')
            ->latest()
            ->take(3)
            ->get();

        return view('portal.turista.dashboard', compact(
            'user',
            'totalVisitas',
            'totalAvaliacoes',
            'totalFavoritos',
            'totalRoteiros',
            'ultimasVisitas',
            'favoritosRecentes',
            'recomendacoes',
            'proximosEventos',
            'ultimasAvaliacoes'
        ));
    }

    /**
     * Página de edição de perfil e interesses.
     */
    public function perfil()
    {
        $user = auth()->user();
        $categorias = Categoria::orderBy('nome')->get();
        return view('portal.turista.perfil', compact('user', 'categorias'));
    }

    /**
     * Atualiza perfil do turista.
     */
    public function atualizarPerfil(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nacionalidade' => 'nullable|string|max:100',
            'cep' => 'nullable|string|max:20',
            'cidade_origem' => 'nullable|string|max:255',
            'estado_origem' => 'nullable|string|max:255',
            'pais_origem' => 'nullable|string|max:255',
            'possui_conjuge' => 'nullable|boolean',
            'possui_filhos' => 'nullable|boolean',
            'quantidade_filhos' => 'nullable|integer|min:0|max:20',
            'interesses' => 'nullable|array',
            'interesses.*' => 'string',
            'necessidades_especiais' => 'nullable|array',
        ]);

        $user = auth()->user();
        
        $possuiFilhos = $request->boolean('possui_filhos');
        $quantidadeFilhos = $possuiFilhos ? (int) ($validated['quantidade_filhos'] ?? 1) : 0;

        $user->update([
            'name' => $validated['name'],
            'nacionalidade' => $validated['nacionalidade'] ?? $user->nacionalidade,
            'cep' => $validated['cep'] ?? null,
            'cidade_origem' => $validated['cidade_origem'] ?? null,
            'estado_origem' => $validated['estado_origem'] ?? null,
            'pais_origem' => $validated['pais_origem'] ?? 'Brasil',
            'possui_conjuge' => $request->boolean('possui_conjuge'),
            'possui_filhos' => $possuiFilhos,
            'quantidade_filhos' => $quantidadeFilhos,
            'interesses' => $validated['interesses'] ?? [],
            'necessidades_especiais' => $validated['necessidades_especiais'] ?? [],
        ]);

        return redirect()->route('turista.perfil')
            ->with('sucesso', 'Perfil atualizado com sucesso!');
    }

    /**
     * Listagem de favoritos do turista.
     */
    public function favoritos(Request $request)
    {
        $user = auth()->user();
        $tipo = $request->get('tipo', 'todos');

        $query = $user->favoritos()->with('favoritavel');

        if ($tipo === 'atrativos') {
            $query->where('favoritavel_type', Atrativo::class);
        } elseif ($tipo === 'eventos') {
            $query->where('favoritavel_type', Evento::class);
        }

        $favoritos = $query->latest()->paginate(12);

        return view('portal.turista.favoritos', compact('favoritos', 'tipo'));
    }

    /**
     * Toggle favoritar/desfavoritar (AJAX).
     */
    public function toggleFavorito(Request $request)
    {
        $request->validate([
            'favoritavel_id' => 'required|integer',
            'favoritavel_type' => 'required|string|in:atrativo,evento',
        ]);

        $user = auth()->user();
        $type = $request->favoritavel_type === 'atrativo' ? Atrativo::class : Evento::class;

        $existente = Favorito::where('user_id', $user->id)
            ->where('favoritavel_id', $request->favoritavel_id)
            ->where('favoritavel_type', $type)
            ->first();

        if ($existente) {
            $existente->delete();
            $acao = 'removido';
        } else {
            Favorito::create([
                'user_id' => $user->id,
                'favoritavel_id' => $request->favoritavel_id,
                'favoritavel_type' => $type,
            ]);
            $acao = 'adicionado';
        }

        if ($request->wantsJson()) {
            return response()->json([
                'sucesso' => true,
                'acao' => $acao,
                'total' => $user->favoritos()->count(),
            ]);
        }

        return redirect()->back()->with('sucesso', "Favorito {$acao} com sucesso!");
    }

    /**
     * Histórico de visitas e avaliações.
     */
    public function historico()
    {
        $user = auth()->user();

        $visitas = $user->historicoVisitas()
            ->with('atrativo.categoria')
            ->latest('visitado_em')
            ->paginate(10);

        $avaliacoes = $user->avaliacoes()
            ->with('atrativo')
            ->latest()
            ->get();

        return view('portal.turista.historico', compact('visitas', 'avaliacoes'));
    }

    /**
     * Registra uma visita a um atrativo.
     */
    public function registrarVisita(Request $request)
    {
        $validated = $request->validate([
            'atrativo_id' => 'required|exists:atrativos,id',
            'notas_pessoais' => 'nullable|string|max:500',
        ]);

        $user = auth()->user();

        HistoricoVisita::updateOrCreate(
            [
                'user_id' => $user->id,
                'atrativo_id' => $validated['atrativo_id'],
                'visitado_em' => now()->toDateString(),
            ],
            [
                'notas_pessoais' => $validated['notas_pessoais'] ?? null,
            ]
        );

        if ($request->wantsJson()) {
            return response()->json(['sucesso' => true, 'mensagem' => 'Visita registrada!']);
        }

        return redirect()->back()->with('sucesso', 'Visita registrada com sucesso! 🎉');
    }

    /**
     * Página de recomendações personalizadas.
     */
    public function recomendacoes()
    {
        $user = auth()->user();
        $recomendacoes = $this->gerarRecomendacoes($user, 12);
        return view('portal.turista.recomendacoes', compact('recomendacoes'));
    }

    /**
     * Gera recomendações personalizadas baseadas nos interesses do turista.
     */
    private function gerarRecomendacoes($user, int $limite = 6)
    {
        $interesses = $user->interesses ?? [];
        $visitadosIds = $user->historicoVisitas()->pluck('atrativo_id')->toArray();

        $query = Atrativo::with('categoria')
            ->where('ativo', true)
            ->whereNotIn('id', $visitadosIds); // Não recomendar já visitados

        // Se tem interesses, priorizar atrativos de categorias relacionadas
        if (!empty($interesses)) {
            $categoriasRelacionadas = Categoria::where(function ($q) use ($interesses) {
                foreach ($interesses as $interesse) {
                    $q->orWhere('nome', 'like', "%{$interesse}%")
                      ->orWhere('slug', 'like', "%{$interesse}%");
                }
            })->pluck('id')->toArray();

            if (!empty($categoriasRelacionadas)) {
                $query->orderByRaw(
                    'CASE WHEN categoria_id IN (' . implode(',', $categoriasRelacionadas) . ') THEN 0 ELSE 1 END'
                );
            }
        }

        // Priorizar destaques
        $query->orderBy('destaque', 'desc');

        return $query->take($limite)->get();
    }

    /**
     * Exibe a página de Meus Planos de Turismo gerados pela IA
     */
    public function planosIa()
    {
        $user = auth()->user();

        $planos = AiPlanoTurismo::doUsuario($user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('portal.turista.meus-planos', compact('planos'));
    }
}

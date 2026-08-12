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
use App\Services\EsgMetricService;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $esgService;

    public function __construct(EsgMetricService $esgService)
    {
        $this->esgService = $esgService;
    }

    public function index()
    {
        $user = auth()->user();

        // --- Contadores reais ---
        $stats = [
            'total_atrativos'          => Atrativo::count(),
            'atrativos_ativos'         => Atrativo::where('status', 'ativo')->count(),
            'total_empreendedores'     => Empreendedor::count(),
            'empreendedores_aprovados' => Empreendedor::where('status_aprovacao', 'aprovado')->count(),
            'empreendedores_pendentes' => Empreendedor::where('status_aprovacao', 'pendente')->count(),
            'total_eventos'            => Evento::count(),
            'eventos_ativos'           => Evento::where('ativo', true)->count(),
            'total_avaliacoes'         => Avaliacao::count(),
            'media_avaliacoes'         => round(Avaliacao::avg('nota') ?? 0, 1),
            'total_usuarios'           => User::count(),
            'total_categorias'         => Categoria::count(),
        ];

        // --- Atrativos por categoria (para gráfico de pizza) ---
        $atrativosPorCategoria = Atrativo::select('categoria_id', DB::raw('count(*) as total'))
            ->groupBy('categoria_id')
            ->with('categoria:id,nome')
            ->get()
            ->map(fn($item) => [
                'categoria' => $item->categoria->nome ?? 'Sem categoria',
                'total' => $item->total,
            ]);

        // --- Empreendedores por status (para gráfico de barras) ---
        $empreendedoresPorStatus = Empreendedor::select('status_aprovacao', DB::raw('count(*) as total'))
            ->groupBy('status_aprovacao')
            ->pluck('total', 'status_aprovacao');

        // --- Últimos atrativos cadastrados ---
        $ultimosAtrativos = Atrativo::with('categoria')
            ->latest()
            ->take(5)
            ->get();

        // --- Empreendedores pendentes ---
        $pendentes = Empreendedor::where('status_aprovacao', 'pendente')
            ->latest()
            ->take(5)
            ->get();

        // --- Indicadores ESG ---
        $indicadoresEsg = $this->esgService->consolidarIndicadoresMunicipais();

        // --- ESG por pilar (para gráfico radar) ---
        $esgPorPilar = IndicadorEsg::select('pilar', DB::raw('AVG(valor) as media'))
            ->groupBy('pilar')
            ->pluck('media', 'pilar');

        $viewData = compact(
            'stats',
            'atrativosPorCategoria',
            'empreendedoresPorStatus',
            'ultimosAtrativos',
            'pendentes',
            'indicadoresEsg',
            'esgPorPilar'
        );

        if ($user && $user->isPrefeito()) {
            return view('admin.dashboard.prefeito', $viewData);
        }

        return view('admin.dashboard.secretaria', $viewData);
    }
}

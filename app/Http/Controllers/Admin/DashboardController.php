<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atrativo;
use App\Models\Empreendedor;
use App\Models\Evento;
use App\Models\User;
use App\Services\EsgMetricService;
use Illuminate\Http\Request;

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

        $stats = [
            'total_atrativos' => Atrativo::count(),
            'total_empreendedores' => Empreendedor::where('status_aprovacao', 'aprovado')->count(),
            'empreendedores_pendentes' => Empreendedor::where('status_aprovacao', 'pendente')->count(),
            'total_eventos' => Evento::where('ativo', true)->count(),
        ];

        $indicadoresEsg = $this->esgService->consolidarIndicadoresMunicipais();

        if ($user && $user->isPrefeito()) {
            return view('admin.dashboard.prefeito', compact('stats', 'indicadoresEsg'));
        }

        return view('admin.dashboard.secretaria', compact('stats', 'indicadoresEsg'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auditoria;
use Illuminate\Http\Request;

class AuditoriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Auditoria::with('usuario');

        if ($request->filled('acao')) {
            $query->where('acao', $request->acao);
        }

        if ($request->filled('tabela')) {
            $query->where('tabela', $request->tabela);
        }

        if ($request->filled('usuario')) {
            $query->whereHas('usuario', function ($q) use ($request) {
                $q->where('name', 'ilike', '%' . $request->usuario . '%');
            });
        }

        if ($request->filled('data_inicio')) {
            $query->where('created_at', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->where('created_at', '<=', $request->data_fim . ' 23:59:59');
        }

        $logs = $query->latest('created_at')->paginate(20);

        // Dados para os filtros
        $acoes = Auditoria::select('acao')->distinct()->orderBy('acao')->pluck('acao');
        $tabelas = Auditoria::select('tabela')->distinct()->orderBy('tabela')->pluck('tabela');

        return view('admin.auditoria.index', compact('logs', 'acoes', 'tabelas'));
    }
}

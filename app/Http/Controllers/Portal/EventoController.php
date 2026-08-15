<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index(Request $request)
    {
        $query = Evento::query()->where('ativo', true);

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('titulo', 'ilike', "%{$busca}%")
                  ->orWhere('descricao', 'ilike', "%{$busca}%")
                  ->orWhere('local', 'ilike', "%{$busca}%");
            });
        }

        if ($request->boolean('gratuito')) {
            $query->where('gratuito', true);
        }

        $eventos = $query->orderBy('data_inicio', 'asc')->paginate(9);

        return view('portal.eventos.index', compact('eventos'));
    }

    public function show(string $slug)
    {
        $evento = Evento::where('slug', $slug)->where('ativo', true)->firstOrFail();
        return view('portal.eventos.show', compact('evento'));
    }
}

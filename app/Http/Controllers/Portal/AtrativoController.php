<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Atrativo;
use App\Models\Categoria;
use Illuminate\Http\Request;

class AtrativoController extends Controller
{
    public function index(Request $request)
    {
        $query = Atrativo::with('categoria')->where('ativo', true);

        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        if ($request->filled('acessivel')) {
            $query->whereJsonContains('niveis_acessibilidade->cadeirante', true);
        }

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function ($q) use ($busca) {
                $q->where('nome', 'like', "%{$busca}%")
                  ->orWhere('descricao', 'like', "%{$busca}%");
            });
        }

        $atrativos = $query->paginate(9);
        $categorias = Categoria::where('ativo', true)->get();

        return view('portal.atrativos.index', compact('atrativos', 'categorias'));
    }

    public function show($slug)
    {
        $atrativo = Atrativo::with(['categoria', 'avaliacoes.usuario'])
            ->where('slug', $slug)
            ->where('ativo', true)
            ->firstOrFail();

        return view('portal.atrativos.show', compact('atrativo'));
    }
}

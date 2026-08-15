<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Atrativo;
use App\Models\Categoria;
use App\Models\Evento;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $atrativosDestaque = Atrativo::with('categoria')
            ->where('destaque', true)
            ->where('ativo', true)
            ->take(6)
            ->get();

        $categorias = Categoria::where('ativo', true)->get();

        $proximosEventos = Evento::where('ativo', true)
            ->where('data_inicio', '>=', now())
            ->orderBy('data_inicio', 'asc')
            ->take(4)
            ->get();

        return view('portal.home', compact('atrativosDestaque', 'categorias', 'proximosEventos'));
    }
}

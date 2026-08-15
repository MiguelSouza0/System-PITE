<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Atrativo;
use App\Models\Categoria;

class MapaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::orderBy('nome')->get();
        return view('portal.mapa', compact('categorias'));
    }

    /**
     * Retorna atrativos em JSON para alimentar os markers do Leaflet.
     */
    public function atrativosJson()
    {
        $atrativos = Atrativo::with('categoria')
            ->where('status', 'ativo')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(fn($at) => [
                'id' => $at->id,
                'nome' => $at->nome,
                'slug' => $at->slug,
                'descricao' => \Illuminate\Support\Str::limit($at->descricao, 120),
                'categoria' => $at->categoria->nome ?? 'Geral',
                'icone' => $at->categoria->icone ?? 'bi-geo-alt',
                'lat' => (float) $at->latitude,
                'lng' => (float) $at->longitude,
                'horario' => $at->horario_funcionamento,
                'acessivel' => $at->niveis_acessibilidade['cadeirante'] ?? false,
                'url' => route('portal.atrativos.show', $at->slug),
            ]);

        return response()->json($atrativos);
    }
}

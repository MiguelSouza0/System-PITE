<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Atrativo;
use App\Models\Categoria;
use App\Models\Evento;
use Illuminate\Support\Str;

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
            ->where('ativo', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(fn($at) => [
                'id' => $at->id,
                'tipo' => 'atrativo',
                'nome' => $at->nome,
                'slug' => $at->slug,
                'descricao' => Str::limit($at->descricao, 120),
                'categoria' => $at->categoria->nome ?? 'Geral',
                'icone' => $at->categoria->icone ?? 'bi-geo-alt',
                'lat' => (float) $at->latitude,
                'lng' => (float) $at->longitude,
                'endereco' => $at->endereco,
                'horario' => $at->horario_funcionamento,
                'preco' => $at->preco_medio > 0 ? 'R$ ' . number_format($at->preco_medio, 2, ',', '.') : 'Gratuito',
                'acessivel' => $at->niveis_acessibilidade['cadeirante'] ?? false,
                'url' => route('portal.atrativos.show', $at->slug),
            ]);

        return response()->json($atrativos);
    }

    /**
     * Retorna eventos em JSON para alimentar os markers do Leaflet.
     * Eventos herdam coordenadas do atrativo vinculado.
     */
    public function eventosJson()
    {
        $eventos = Evento::with('atrativo.categoria')
            ->where('ativo', true)
            ->whereHas('atrativo', function ($q) {
                $q->whereNotNull('latitude')->whereNotNull('longitude');
            })
            ->get()
            ->map(fn($ev) => [
                'id' => $ev->id,
                'tipo' => 'evento',
                'nome' => $ev->titulo,
                'slug' => $ev->slug,
                'descricao' => Str::limit($ev->descricao, 120),
                'categoria' => 'Evento',
                'icone' => 'bi-calendar-event',
                'lat' => (float) $ev->atrativo->latitude,
                'lng' => (float) $ev->atrativo->longitude,
                'endereco' => $ev->local,
                'horario' => $ev->data_inicio?->format('d/m/Y H:i') . ' — ' . $ev->data_fim?->format('d/m/Y H:i'),
                'preco' => $ev->gratuito ? 'Gratuito' : 'R$ ' . number_format($ev->preco_ingresso, 2, ',', '.'),
                'organizador' => $ev->organizador,
                'acessivel' => false,
                'url' => route('portal.eventos.show', $ev->slug),
            ]);

        return response()->json($eventos);
    }
}

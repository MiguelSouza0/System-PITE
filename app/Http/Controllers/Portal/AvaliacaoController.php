<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Atrativo;
use App\Models\Avaliacao;
use Illuminate\Http\Request;

class AvaliacaoController extends Controller
{
    public function store(Request $request, string $slug)
    {
        $atrativo = Atrativo::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'nota' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:1000',
            'origem_turista' => 'nullable|string|in:local,nacional,internacional',
            'visitado_em' => 'nullable|date',
        ]);

        Avaliacao::create([
            'atrativo_id' => $atrativo->id,
            'user_id' => auth()->id(),
            'nota' => $validated['nota'],
            'comentario' => $validated['comentario'],
            'origem_turista' => $validated['origem_turista'] ?? 'local',
            'visitado_em' => $validated['visitado_em'] ?? now(),
            'status_verificacao' => 'verificado', // Transparência imediata para protótipo
        ]);

        return redirect()->back()->with('sucessoAvaliacao', 'Sua avaliação foi enviada com sucesso! Obrigado por contribuir para o turismo municipal.');
    }
}

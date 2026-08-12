<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Atrativo;
use App\Models\Roteiro;
use App\Services\AiItineraryService;
use Illuminate\Http\Request;

class RoteiroController extends Controller
{
    protected $aiService;

    public function __construct(AiItineraryService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function index()
    {
        $roteirosProntos = Roteiro::where('ativo', true)->with('atrativos')->latest()->take(6)->get();
        return view('portal.roteiros', compact('roteirosProntos'));
    }

    public function gerar(Request $request)
    {
        $validated = $request->validate([
            'perfil' => 'required|string',
            'duracao_horas' => 'required|integer|min:1|max:24',
            'acessivel' => 'nullable|boolean',
        ]);

        $preferencias = [
            'perfil' => $validated['perfil'],
            'duracao_horas' => (int) $validated['duracao_horas'],
            'acessivel' => $request->boolean('acessivel'),
        ];

        $roteiro = $this->aiService->gerarRoteiroPersonalizado($preferencias);

        // Se AJAX
        if ($request->wantsJson()) {
            // Carregar atrativos associados
            $atrativos = Atrativo::whereIn('id', $roteiro->atrativos_ids ?? [])->get();
            return response()->json([
                'sucesso' => true,
                'roteiro' => $roteiro,
                'atrativos' => $atrativos
            ]);
        }

        return redirect()->route('portal.roteiros')->with('roteiroGerado', $roteiro);
    }
}

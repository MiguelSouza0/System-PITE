<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atrativo;
use App\Models\Auditoria;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventoAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Evento::with('atrativo');

        if ($request->filled('busca')) {
            $query->where('titulo', 'ilike', '%' . $request->busca . '%');
        }

        if ($request->filled('status')) {
            $query->where('ativo', $request->status === 'ativo');
        }

        $eventos = $query->latest()->paginate(15);
        return view('admin.eventos.index', compact('eventos'));
    }

    public function create()
    {
        $atrativos = Atrativo::where('ativo', true)->orderBy('nome')->get();
        return view('admin.eventos.create', compact('atrativos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo'          => 'required|string|max:255',
            'descricao'       => 'required|string',
            'data_inicio'     => 'required|date',
            'data_fim'        => 'required|date|after_or_equal:data_inicio',
            'local'           => 'required|string|max:255',
            'atrativo_id'     => 'nullable|exists:atrativos,id',
            'organizador'     => 'nullable|string|max:255',
            'preco_ingresso'  => 'nullable|numeric|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['titulo']);
        $validated['gratuito'] = $request->boolean('gratuito');
        $validated['ativo'] = true;

        // Evitar slug duplicado
        $count = Evento::where('slug', $validated['slug'])->count();
        if ($count > 0) {
            $validated['slug'] .= '-' . ($count + 1);
        }

        $evento = Evento::create($validated);

        Auditoria::registrar('criou', 'eventos', $evento->id, null, $evento->toArray());

        return redirect()
            ->route('admin.eventos.index')
            ->with('sucesso', 'Evento "' . $evento->titulo . '" criado com sucesso!');
    }

    public function edit(Evento $evento)
    {
        $atrativos = Atrativo::where('ativo', true)->orderBy('nome')->get();
        return view('admin.eventos.edit', compact('evento', 'atrativos'));
    }

    public function update(Request $request, Evento $evento)
    {
        $validated = $request->validate([
            'titulo'          => 'required|string|max:255',
            'descricao'       => 'required|string',
            'data_inicio'     => 'required|date',
            'data_fim'        => 'required|date|after_or_equal:data_inicio',
            'local'           => 'required|string|max:255',
            'atrativo_id'     => 'nullable|exists:atrativos,id',
            'organizador'     => 'nullable|string|max:255',
            'preco_ingresso'  => 'nullable|numeric|min:0',
        ]);

        $antes = $evento->toArray();

        $validated['slug'] = Str::slug($validated['titulo']);
        $validated['gratuito'] = $request->boolean('gratuito');
        $validated['ativo'] = $request->boolean('ativo');

        $evento->update($validated);

        Auditoria::registrar('editou', 'eventos', $evento->id, $antes, $evento->fresh()->toArray());

        return redirect()
            ->route('admin.eventos.index')
            ->with('sucesso', 'Evento "' . $evento->titulo . '" atualizado!');
    }

    public function destroy(Evento $evento)
    {
        $antes = $evento->toArray();

        $evento->update(['ativo' => false]);

        Auditoria::registrar('desativou', 'eventos', $evento->id, $antes, $evento->fresh()->toArray());

        return redirect()
            ->route('admin.eventos.index')
            ->with('sucesso', 'Evento "' . $evento->titulo . '" desativado.');
    }
}

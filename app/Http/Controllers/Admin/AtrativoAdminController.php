<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atrativo;
use App\Models\Auditoria;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AtrativoAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Atrativo::with('categoria');

        if ($request->filled('busca')) {
            $query->where('nome', 'ilike', '%' . $request->busca . '%');
        }
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }
        if ($request->filled('status')) {
            $query->where('ativo', $request->status === 'ativo');
        }

        $atrativos = $query->latest()->paginate(15);
        $categorias = Categoria::orderBy('nome')->get();

        return view('admin.atrativos.index', compact('atrativos', 'categorias'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nome')->get();
        return view('admin.atrativos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'endereco' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'horario_funcionamento' => 'nullable|string|max:255',
            'valor_entrada' => 'nullable|numeric|min:0',
            'contato_telefone' => 'nullable|string|max:20',
            'contato_email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'tempo_medio_visita' => 'nullable|string|max:100',
        ]);

        $validated['slug'] = Str::slug($validated['nome']);
        $validated['ativo'] = true;
        $validated['niveis_acessibilidade'] = [
            'cadeirante' => $request->boolean('acess_cadeirante'),
            'visual' => $request->boolean('acess_visual'),
            'auditiva' => $request->boolean('acess_auditiva'),
            'piso_tatil' => $request->boolean('acess_piso_tatil'),
        ];

        $atrativo = Atrativo::create($validated);

        // Registra na trilha de auditoria
        Auditoria::registrar('criou', 'atrativos', $atrativo->id, null, $atrativo->toArray());

        return redirect()
            ->route('admin.atrativos.index')
            ->with('sucesso', 'Atrativo "' . $atrativo->nome . '" cadastrado com sucesso!');
    }

    public function edit(Atrativo $atrativo)
    {
        $categorias = Categoria::orderBy('nome')->get();
        return view('admin.atrativos.edit', compact('atrativo', 'categorias'));
    }

    public function update(Request $request, Atrativo $atrativo)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'endereco' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'horario_funcionamento' => 'nullable|string|max:255',
            'valor_entrada' => 'nullable|numeric|min:0',
            'contato_telefone' => 'nullable|string|max:20',
            'contato_email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'tempo_medio_visita' => 'nullable|string|max:100',
            'ativo' => 'nullable|boolean',
        ]);

        $antes = $atrativo->toArray();
        $validated['slug'] = Str::slug($validated['nome']);
        $validated['niveis_acessibilidade'] = [
            'cadeirante' => $request->boolean('acess_cadeirante'),
            'visual' => $request->boolean('acess_visual'),
            'auditiva' => $request->boolean('acess_auditiva'),
            'piso_tatil' => $request->boolean('acess_piso_tatil'),
        ];

        $atrativo->update($validated);

        Auditoria::registrar('editou', 'atrativos', $atrativo->id, $antes, $atrativo->fresh()->toArray());

        return redirect()
            ->route('admin.atrativos.index')
            ->with('sucesso', 'Atrativo "' . $atrativo->nome . '" atualizado!');
    }

    public function destroy(Atrativo $atrativo)
    {
        $antes = $atrativo->toArray();

        // Exclusão lógica (conforme documentação)
        $atrativo->update(['ativo' => false]);

        Auditoria::registrar('desativou', 'atrativos', $atrativo->id, $antes, $atrativo->fresh()->toArray());

        return redirect()
            ->route('admin.atrativos.index')
            ->with('sucesso', 'Atrativo "' . $atrativo->nome . '" desativado.');
    }
}

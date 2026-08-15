<?php

namespace App\Http\Controllers\Empreendedor;

use App\Http\Controllers\Controller;
use App\Models\Auditoria;
use App\Models\Empreendedor;
use Illuminate\Http\Request;

class EmpreendedorDashboardController extends Controller
{
    /**
     * Exibe o painel do empreendedor com seus estabelecimentos e status de homologação.
     */
    public function index()
    {
        $user = auth()->user();
        $estabelecimentos = Empreendedor::where('user_id', $user->id)
            ->latest()
            ->get();

        $stats = [
            'total' => $estabelecimentos->count(),
            'aprovados' => $estabelecimentos->where('status_aprovacao', 'aprovado')->count(),
            'pendentes' => $estabelecimentos->where('status_aprovacao', 'pendente')->count(),
            'rejeitados' => $estabelecimentos->where('status_aprovacao', 'rejeitado')->count(),
            'selos_ativos' => $estabelecimentos->where('selo_validado', true)->count(),
        ];

        return view('empreendedor.dashboard', compact('estabelecimentos', 'stats'));
    }

    /**
     * Formulário de novo autocadastro de estabelecimento.
     */
    public function create()
    {
        return view('empreendedor.cadastro');
    }

    /**
     * Salva a solicitação de cadastro do empreendedor para moderação da Secretaria.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'razao_social' => 'required|string|max:255',
            'nome_fantasia' => 'nullable|string|max:255',
            'cnpj_cpf' => 'required|string|max:20',
            'tipo_servico' => 'required|string|in:hospedagem,gastronomia,guia,artesanato,transporte,agencia,experiencia',
            'descricao' => 'nullable|string|max:1000',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'instagram' => 'nullable|string|max:100',
            'endereco' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:100',
        ]);

        $empreendedor = Empreendedor::create([
            'user_id' => auth()->id(),
            'razao_social' => $validated['razao_social'],
            'nome_fantasia' => $validated['nome_fantasia'] ?? $validated['razao_social'],
            'cnpj_cpf' => $validated['cnpj_cpf'],
            'tipo_servico' => $validated['tipo_servico'],
            'descricao' => $validated['descricao'] ?? null,
            'telefone' => $validated['telefone'] ?? null,
            'email' => $validated['email'] ?? auth()->user()->email,
            'website' => $validated['website'] ?? null,
            'instagram' => $validated['instagram'] ?? null,
            'endereco' => $validated['endereco'] ?? null,
            'bairro' => $validated['bairro'] ?? null,
            'status_aprovacao' => 'pendente',
            'selo_validado' => false,
        ]);

        Auditoria::registrar(
            'cadastrou_estabelecimento',
            'empreendedores',
            $empreendedor->id,
            null,
            $empreendedor->toArray()
        );

        return redirect()
            ->route('empreendedor.dashboard')
            ->with('sucesso', 'Cadastro do estabelecimento "' . ($empreendedor->nome_fantasia ?? $empreendedor->razao_social) . '" enviado com sucesso! Aguarde a homologação da Secretaria Municipal de Turismo.');
    }
}

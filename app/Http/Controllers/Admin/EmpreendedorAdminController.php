<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auditoria;
use App\Models\Empreendedor;
use Illuminate\Http\Request;

class EmpreendedorAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Empreendedor::with('usuario');

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function ($q) use ($busca) {
                $q->where('razao_social', 'ilike', "%{$busca}%")
                  ->orWhere('nome_fantasia', 'ilike', "%{$busca}%")
                  ->orWhere('cnpj_cpf', 'ilike', "%{$busca}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status_aprovacao', $request->status);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo_servico', $request->tipo);
        }

        $empreendedores = $query->latest()->paginate(15);

        $contadores = [
            'total'     => Empreendedor::count(),
            'pendentes' => Empreendedor::where('status_aprovacao', 'pendente')->count(),
            'aprovados' => Empreendedor::where('status_aprovacao', 'aprovado')->count(),
            'rejeitados' => Empreendedor::where('status_aprovacao', 'rejeitado')->count(),
        ];

        return view('admin.empreendedores.index', compact('empreendedores', 'contadores'));
    }

    public function aprovar(Request $request, Empreendedor $empreendedor)
    {
        $antes = $empreendedor->toArray();

        $empreendedor->update([
            'status_aprovacao'    => 'aprovado',
            'selo_validado'       => true,
            'aprovado_por_user_id' => auth()->id(),
            'observacoes_admin'   => $request->input('observacoes', 'Aprovado pela Secretaria de Turismo.'),
        ]);

        Auditoria::registrar(
            'aprovou',
            'empreendedores',
            $empreendedor->id,
            $antes,
            $empreendedor->fresh()->toArray()
        );

        return redirect()
            ->route('admin.empreendedores.index')
            ->with('sucesso', 'Empreendedor "' . $empreendedor->razao_social . '" aprovado e Selo Municipal concedido!');
    }

    public function rejeitar(Request $request, Empreendedor $empreendedor)
    {
        $request->validate([
            'motivo' => 'required|string|max:500',
        ]);

        $antes = $empreendedor->toArray();

        $empreendedor->update([
            'status_aprovacao'    => 'rejeitado',
            'selo_validado'       => false,
            'aprovado_por_user_id' => auth()->id(),
            'observacoes_admin'   => $request->motivo,
        ]);

        Auditoria::registrar(
            'rejeitou',
            'empreendedores',
            $empreendedor->id,
            $antes,
            $empreendedor->fresh()->toArray()
        );

        return redirect()
            ->route('admin.empreendedores.index')
            ->with('sucesso', 'Cadastro de "' . $empreendedor->razao_social . '" foi rejeitado.');
    }

    public function revogarSelo(Empreendedor $empreendedor)
    {
        $antes = $empreendedor->toArray();

        $empreendedor->update([
            'status_aprovacao'    => 'suspenso',
            'selo_validado'       => false,
            'aprovado_por_user_id' => auth()->id(),
            'observacoes_admin'   => 'Selo revogado pela administração.',
        ]);

        Auditoria::registrar(
            'revogou_selo',
            'empreendedores',
            $empreendedor->id,
            $antes,
            $empreendedor->fresh()->toArray()
        );

        return redirect()
            ->route('admin.empreendedores.index')
            ->with('sucesso', 'Selo Municipal de "' . $empreendedor->razao_social . '" foi revogado.');
    }
}

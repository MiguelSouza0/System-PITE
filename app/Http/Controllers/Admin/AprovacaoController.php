<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atrativo;
use App\Models\Auditoria;
use App\Models\Evento;
use Illuminate\Http\Request;

class AprovacaoController extends Controller
{
    /**
     * Lista todos os cadastros pendentes (atrativos + eventos) para aprovação do Prefeito.
     */
    public function pendentes(Request $request)
    {
        $filtroTipo = $request->input('tipo', 'todos');

        $atrativosPendentes = collect();
        $eventosPendentes = collect();

        if ($filtroTipo === 'todos' || $filtroTipo === 'atrativos') {
            $atrativosPendentes = Atrativo::with('categoria')
                ->pendente()
                ->latest()
                ->get();
        }

        if ($filtroTipo === 'todos' || $filtroTipo === 'eventos') {
            $eventosPendentes = Evento::with('atrativo')
                ->pendente()
                ->latest()
                ->get();
        }

        // Contadores gerais para cards de resumo
        $contadores = [
            'atrativos_pendentes' => Atrativo::pendente()->count(),
            'atrativos_aprovados' => Atrativo::aprovado()->count(),
            'atrativos_suspensos' => Atrativo::suspenso()->count(),
            'eventos_pendentes'   => Evento::pendente()->count(),
            'eventos_aprovados'   => Evento::aprovado()->count(),
            'eventos_suspensos'   => Evento::suspenso()->count(),
        ];

        // Itens suspensos (para acompanhamento)
        $atrativosSuspensos = Atrativo::with('categoria')->suspenso()->latest()->get();
        $eventosSuspensos = Evento::with('atrativo')->suspenso()->latest()->get();

        return view('admin.aprovacao.pendentes', compact(
            'atrativosPendentes',
            'eventosPendentes',
            'atrativosSuspensos',
            'eventosSuspensos',
            'contadores',
            'filtroTipo'
        ));
    }

    // =============================================
    // ATRATIVOS
    // =============================================

    /**
     * Aprovar um atrativo — torna-o oficialmente cadastrado e visível no portal.
     */
    public function aprovarAtrativo(Request $request, Atrativo $atrativo)
    {
        $antes = $atrativo->toArray();

        $atrativo->update([
            'status_aprovacao'     => 'aprovado',
            'ativo'                => true,
            'aprovado_por_user_id' => auth()->id(),
            'observacoes_admin'    => $request->input('observacoes', 'Aprovado pelo Prefeito.'),
        ]);

        Auditoria::registrar('aprovou', 'atrativos', $atrativo->id, $antes, $atrativo->fresh()->toArray());

        return redirect()
            ->route('admin.aprovacao.pendentes')
            ->with('sucesso', 'Atrativo "' . $atrativo->nome . '" aprovado com sucesso! Agora está visível no portal.');
    }

    /**
     * Rejeitar um atrativo — deleta o registro, mas preserva a trilha de auditoria.
     */
    public function rejeitarAtrativo(Request $request, Atrativo $atrativo)
    {
        $request->validate([
            'motivo' => 'required|string|max:500',
        ]);

        $antes = $atrativo->toArray();
        $nomeAtrativo = $atrativo->nome;

        // Registrar auditoria ANTES de deletar
        Auditoria::registrar('rejeitou', 'atrativos', $atrativo->id, $antes, ['motivo_rejeicao' => $request->motivo]);

        // Deletar permanentemente o registro
        $atrativo->delete();

        return redirect()
            ->route('admin.aprovacao.pendentes')
            ->with('sucesso', 'Cadastro do atrativo "' . $nomeAtrativo . '" foi rejeitado e removido. Auditoria preservada.');
    }

    /**
     * Suspender um atrativo por desatualização — oculta do portal, mapa e turista.
     * Para reativar: o Técnico deve atualizar os dados, gerando status 'pendente'.
     */
    public function suspenderAtrativo(Request $request, Atrativo $atrativo)
    {
        $antes = $atrativo->toArray();

        $atrativo->update([
            'status_aprovacao'     => 'suspenso',
            'ativo'                => false,
            'aprovado_por_user_id' => auth()->id(),
            'observacoes_admin'    => $request->input('motivo', 'Suspenso por desatualização.'),
        ]);

        Auditoria::registrar('suspendeu', 'atrativos', $atrativo->id, $antes, $atrativo->fresh()->toArray());

        return redirect()
            ->route('admin.aprovacao.pendentes')
            ->with('sucesso', 'Atrativo "' . $atrativo->nome . '" suspenso. O Técnico deve atualizar as informações para reativação.');
    }

    // =============================================
    // EVENTOS
    // =============================================

    /**
     * Aprovar um evento.
     */
    public function aprovarEvento(Request $request, Evento $evento)
    {
        $antes = $evento->toArray();

        $evento->update([
            'status_aprovacao'     => 'aprovado',
            'ativo'                => true,
            'aprovado_por_user_id' => auth()->id(),
            'observacoes_admin'    => $request->input('observacoes', 'Aprovado pelo Prefeito.'),
        ]);

        Auditoria::registrar('aprovou', 'eventos', $evento->id, $antes, $evento->fresh()->toArray());

        return redirect()
            ->route('admin.aprovacao.pendentes')
            ->with('sucesso', 'Evento "' . $evento->titulo . '" aprovado com sucesso!');
    }

    /**
     * Rejeitar um evento — deleta o registro, preserva auditoria.
     */
    public function rejeitarEvento(Request $request, Evento $evento)
    {
        $request->validate([
            'motivo' => 'required|string|max:500',
        ]);

        $antes = $evento->toArray();
        $tituloEvento = $evento->titulo;

        Auditoria::registrar('rejeitou', 'eventos', $evento->id, $antes, ['motivo_rejeicao' => $request->motivo]);

        $evento->delete();

        return redirect()
            ->route('admin.aprovacao.pendentes')
            ->with('sucesso', 'Evento "' . $tituloEvento . '" foi rejeitado e removido. Auditoria preservada.');
    }

    /**
     * Suspender um evento por desatualização.
     */
    public function suspenderEvento(Request $request, Evento $evento)
    {
        $antes = $evento->toArray();

        $evento->update([
            'status_aprovacao'     => 'suspenso',
            'ativo'                => false,
            'aprovado_por_user_id' => auth()->id(),
            'observacoes_admin'    => $request->input('motivo', 'Suspenso por desatualização.'),
        ]);

        Auditoria::registrar('suspendeu', 'eventos', $evento->id, $antes, $evento->fresh()->toArray());

        return redirect()
            ->route('admin.aprovacao.pendentes')
            ->with('sucesso', 'Evento "' . $evento->titulo . '" suspenso.');
    }
}

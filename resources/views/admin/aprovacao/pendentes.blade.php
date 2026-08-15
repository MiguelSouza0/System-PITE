@extends('layouts.app')

@section('title', 'Aprovações Pendentes — Supervisão do Prefeito')

@push('styles')
<style>
    .aprovacao-header {
        background: linear-gradient(135deg, #022c22, #064e3b);
        padding: 32px 0;
    }
    .aprovacao-header h1 {
        color: #fff;
        font-size: 1.6rem;
        font-weight: 700;
    }
    .aprovacao-header p {
        color: rgba(255,255,255,0.7);
        margin: 0;
    }
    .counter-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #f1f5f9;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .counter-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }
    .counter-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem;
    }
    .counter-value {
        font-size: 1.8rem;
        font-weight: 800;
        line-height: 1;
    }
    .counter-label {
        font-size: 0.78rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }
    .item-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 20px;
        margin-bottom: 16px;
        transition: box-shadow 0.2s;
    }
    .item-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    }
    .item-card .item-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }
    .item-card .item-meta {
        font-size: 0.82rem;
        color: #64748b;
    }
    .item-card .item-desc {
        font-size: 0.88rem;
        color: #475569;
        margin: 10px 0;
    }
    .section-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
    }
    .section-title .badge {
        font-size: 0.72rem;
        padding: 4px 10px;
        border-radius: 20px;
    }
    .badge-pendente { background: rgba(245,158,11,0.12); color: #d97706; }
    .badge-aprovado { background: rgba(4,120,87,0.12); color: #047857; }
    .badge-suspenso { background: rgba(99,102,241,0.12); color: #6366f1; }
    .badge-rejeitado { background: rgba(244,63,94,0.12); color: #e11d48; }
    .btn-aprovar {
        background: linear-gradient(135deg, #047857, #059669);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 7px 16px;
        font-size: 0.82rem;
        font-weight: 600;
    }
    .btn-aprovar:hover { background: #047857; color: #fff; transform: translateY(-1px); }
    .btn-rejeitar {
        background: rgba(244,63,94,0.1);
        color: #e11d48;
        border: 1px solid rgba(244,63,94,0.2);
        border-radius: 10px;
        padding: 7px 16px;
        font-size: 0.82rem;
        font-weight: 600;
    }
    .btn-rejeitar:hover { background: rgba(244,63,94,0.2); }
    .btn-suspender {
        background: rgba(99,102,241,0.1);
        color: #6366f1;
        border: 1px solid rgba(99,102,241,0.2);
        border-radius: 10px;
        padding: 7px 16px;
        font-size: 0.82rem;
        font-weight: 600;
    }
    .btn-suspender:hover { background: rgba(99,102,241,0.2); }
    .empty-state {
        text-align: center;
        padding: 48px 20px;
        color: #94a3b8;
    }
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 12px;
        display: block;
    }
    .nav-tabs-aprovacao .nav-link {
        border: none;
        border-radius: 10px;
        padding: 8px 18px;
        font-weight: 600;
        font-size: 0.88rem;
        color: #64748b;
        background: transparent;
        transition: all 0.2s;
    }
    .nav-tabs-aprovacao .nav-link.active {
        background: #047857;
        color: #fff;
    }
    .nav-tabs-aprovacao .nav-link:hover:not(.active) {
        background: rgba(4,120,87,0.08);
        color: #047857;
    }
</style>
@endpush

@section('content')
{{-- Header --}}
<div class="aprovacao-header">
    <div class="container">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-white bg-opacity-10 rounded-3 p-2">
                <i class="bi bi-clipboard-check text-white" style="font-size: 1.6rem;"></i>
            </div>
            <div>
                <h1 class="mb-0">Painel de Aprovações</h1>
                <p>Supervisão e aprovação de cadastros — Atrativos e Eventos</p>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    {{-- Mensagem de sucesso --}}
    @if(session('sucesso'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('sucesso') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Cards de Contadores --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4 col-lg-2">
            <div class="counter-card">
                <div class="counter-icon mb-2" style="background: rgba(245,158,11,0.12);">
                    <i class="bi bi-hourglass-split" style="color: #d97706;"></i>
                </div>
                <div class="counter-value" style="color: #d97706;">{{ $contadores['atrativos_pendentes'] + $contadores['eventos_pendentes'] }}</div>
                <div class="counter-label">Pendentes</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="counter-card">
                <div class="counter-icon mb-2" style="background: rgba(4,120,87,0.12);">
                    <i class="bi bi-check-circle" style="color: #047857;"></i>
                </div>
                <div class="counter-value" style="color: #047857;">{{ $contadores['atrativos_aprovados'] + $contadores['eventos_aprovados'] }}</div>
                <div class="counter-label">Aprovados</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="counter-card">
                <div class="counter-icon mb-2" style="background: rgba(99,102,241,0.12);">
                    <i class="bi bi-pause-circle" style="color: #6366f1;"></i>
                </div>
                <div class="counter-value" style="color: #6366f1;">{{ $contadores['atrativos_suspensos'] + $contadores['eventos_suspensos'] }}</div>
                <div class="counter-label">Suspensos</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="counter-card">
                <div class="counter-icon mb-2" style="background: rgba(14,165,233,0.12);">
                    <i class="bi bi-geo-alt" style="color: #0ea5e9;"></i>
                </div>
                <div class="counter-value" style="color: #0ea5e9;">{{ $contadores['atrativos_pendentes'] }}</div>
                <div class="counter-label">Atrativos Pend.</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="counter-card">
                <div class="counter-icon mb-2" style="background: rgba(168,85,247,0.12);">
                    <i class="bi bi-calendar-event" style="color: #a855f7;"></i>
                </div>
                <div class="counter-value" style="color: #a855f7;">{{ $contadores['eventos_pendentes'] }}</div>
                <div class="counter-label">Eventos Pend.</div>
            </div>
        </div>
    </div>

    {{-- Tabs de navegação --}}
    <ul class="nav nav-tabs-aprovacao d-flex gap-2 mb-4 flex-wrap" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#tab-pendentes" role="tab">
                <i class="bi bi-hourglass-split me-1"></i>Pendentes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab-suspensos" role="tab">
                <i class="bi bi-pause-circle me-1"></i>Suspensos
            </a>
        </li>
    </ul>

    <div class="tab-content">
        {{-- TAB PENDENTES --}}
        <div class="tab-pane fade show active" id="tab-pendentes" role="tabpanel">

            {{-- Atrativos Pendentes --}}
            <div class="section-title">
                <i class="bi bi-geo-alt-fill" style="color: #0ea5e9;"></i>
                Atrativos Pendentes
                <span class="badge badge-pendente">{{ $atrativosPendentes->count() }}</span>
            </div>

            @forelse($atrativosPendentes as $atrativo)
                <div class="item-card">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div class="flex-grow-1">
                            <div class="item-title">
                                <i class="bi bi-geo-alt me-1" style="color: #0ea5e9;"></i>
                                {{ $atrativo->nome }}
                            </div>
                            <div class="item-meta">
                                <span class="me-3"><i class="bi bi-tag me-1"></i>{{ $atrativo->categoria->nome ?? 'Sem categoria' }}</span>
                                @if($atrativo->endereco)
                                    <span class="me-3"><i class="bi bi-pin-map me-1"></i>{{ $atrativo->endereco }}</span>
                                @endif
                                <span><i class="bi bi-clock me-1"></i>{{ $atrativo->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="item-desc">{{ Str::limit($atrativo->descricao, 180) }}</div>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            {{-- Aprovar --}}
                            <form action="{{ route('admin.aprovacao.atrativos.aprovar', $atrativo) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-aprovar" title="Aprovar cadastro">
                                    <i class="bi bi-check-lg me-1"></i>Aprovar
                                </button>
                            </form>

                            {{-- Suspender --}}
                            <form action="{{ route('admin.aprovacao.atrativos.suspender', $atrativo) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-suspender" title="Suspender por desatualização">
                                    <i class="bi bi-pause-fill me-1"></i>Suspender
                                </button>
                            </form>

                            {{-- Rejeitar (com modal) --}}
                            <button type="button" class="btn btn-rejeitar" data-bs-toggle="modal" data-bs-target="#rejeitar-atrativo-{{ $atrativo->id }}">
                                <i class="bi bi-x-lg me-1"></i>Rejeitar
                            </button>

                            {{-- Modal de Rejeição --}}
                            <div class="modal fade" id="rejeitar-atrativo-{{ $atrativo->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content rounded-4">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title"><i class="bi bi-exclamation-triangle text-danger me-2"></i>Rejeitar Atrativo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.aprovacao.atrativos.rejeitar', $atrativo) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <p class="text-muted">Ao rejeitar, o cadastro de <strong>"{{ $atrativo->nome }}"</strong> será permanentemente removido. A auditoria será preservada.</p>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Motivo da rejeição *</label>
                                                    <textarea name="motivo" class="form-control" rows="3" required placeholder="Descreva o motivo..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-trash me-1"></i>Confirmar Rejeição
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-check-circle"></i>
                    <p class="mb-0">Nenhum atrativo pendente de aprovação.</p>
                </div>
            @endforelse

            <hr class="my-4">

            {{-- Eventos Pendentes --}}
            <div class="section-title">
                <i class="bi bi-calendar-event-fill" style="color: #a855f7;"></i>
                Eventos Pendentes
                <span class="badge badge-pendente">{{ $eventosPendentes->count() }}</span>
            </div>

            @forelse($eventosPendentes as $evento)
                <div class="item-card">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div class="flex-grow-1">
                            <div class="item-title">
                                <i class="bi bi-calendar-event me-1" style="color: #a855f7;"></i>
                                {{ $evento->titulo }}
                            </div>
                            <div class="item-meta">
                                @if($evento->atrativo)
                                    <span class="me-3"><i class="bi bi-geo-alt me-1"></i>{{ $evento->atrativo->nome }}</span>
                                @endif
                                <span class="me-3"><i class="bi bi-pin-map me-1"></i>{{ $evento->local }}</span>
                                <span class="me-3">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $evento->data_inicio?->format('d/m/Y') }} — {{ $evento->data_fim?->format('d/m/Y') }}
                                </span>
                                <span><i class="bi bi-clock me-1"></i>{{ $evento->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="item-desc">{{ Str::limit($evento->descricao, 180) }}</div>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <form action="{{ route('admin.aprovacao.eventos.aprovar', $evento) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-aprovar">
                                    <i class="bi bi-check-lg me-1"></i>Aprovar
                                </button>
                            </form>

                            <form action="{{ route('admin.aprovacao.eventos.suspender', $evento) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-suspender">
                                    <i class="bi bi-pause-fill me-1"></i>Suspender
                                </button>
                            </form>

                            <button type="button" class="btn btn-rejeitar" data-bs-toggle="modal" data-bs-target="#rejeitar-evento-{{ $evento->id }}">
                                <i class="bi bi-x-lg me-1"></i>Rejeitar
                            </button>

                            <div class="modal fade" id="rejeitar-evento-{{ $evento->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content rounded-4">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title"><i class="bi bi-exclamation-triangle text-danger me-2"></i>Rejeitar Evento</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.aprovacao.eventos.rejeitar', $evento) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <p class="text-muted">Ao rejeitar, o evento <strong>"{{ $evento->titulo }}"</strong> será permanentemente removido. A auditoria será preservada.</p>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Motivo da rejeição *</label>
                                                    <textarea name="motivo" class="form-control" rows="3" required placeholder="Descreva o motivo..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-trash me-1"></i>Confirmar Rejeição
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-check-circle"></i>
                    <p class="mb-0">Nenhum evento pendente de aprovação.</p>
                </div>
            @endforelse
        </div>

        {{-- TAB SUSPENSOS --}}
        <div class="tab-pane fade" id="tab-suspensos" role="tabpanel">

            {{-- Atrativos Suspensos --}}
            <div class="section-title">
                <i class="bi bi-geo-alt-fill" style="color: #6366f1;"></i>
                Atrativos Suspensos
                <span class="badge badge-suspenso">{{ $atrativosSuspensos->count() }}</span>
            </div>

            @forelse($atrativosSuspensos as $atrativo)
                <div class="item-card" style="border-left: 4px solid #6366f1;">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div class="flex-grow-1">
                            <div class="item-title">
                                <i class="bi bi-pause-circle me-1" style="color: #6366f1;"></i>
                                {{ $atrativo->nome }}
                                <span class="badge badge-suspenso ms-2">Suspenso</span>
                            </div>
                            <div class="item-meta">
                                <span class="me-3"><i class="bi bi-tag me-1"></i>{{ $atrativo->categoria->nome ?? 'Sem categoria' }}</span>
                                @if($atrativo->observacoes_admin)
                                    <span class="me-3"><i class="bi bi-chat-text me-1"></i>{{ $atrativo->observacoes_admin }}</span>
                                @endif
                            </div>
                            <div class="item-desc text-muted fst-italic">
                                <i class="bi bi-info-circle me-1"></i>
                                Aguardando atualização pelo Técnico para retornar à fila de aprovação.
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-check-circle"></i>
                    <p class="mb-0">Nenhum atrativo suspenso.</p>
                </div>
            @endforelse

            <hr class="my-4">

            {{-- Eventos Suspensos --}}
            <div class="section-title">
                <i class="bi bi-calendar-event-fill" style="color: #6366f1;"></i>
                Eventos Suspensos
                <span class="badge badge-suspenso">{{ $eventosSuspensos->count() }}</span>
            </div>

            @forelse($eventosSuspensos as $evento)
                <div class="item-card" style="border-left: 4px solid #6366f1;">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div class="flex-grow-1">
                            <div class="item-title">
                                <i class="bi bi-pause-circle me-1" style="color: #6366f1;"></i>
                                {{ $evento->titulo }}
                                <span class="badge badge-suspenso ms-2">Suspenso</span>
                            </div>
                            <div class="item-meta">
                                <span class="me-3"><i class="bi bi-pin-map me-1"></i>{{ $evento->local }}</span>
                                @if($evento->observacoes_admin)
                                    <span><i class="bi bi-chat-text me-1"></i>{{ $evento->observacoes_admin }}</span>
                                @endif
                            </div>
                            <div class="item-desc text-muted fst-italic">
                                <i class="bi bi-info-circle me-1"></i>
                                Aguardando atualização pelo Técnico para retornar à fila de aprovação.
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-check-circle"></i>
                    <p class="mb-0">Nenhum evento suspenso.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

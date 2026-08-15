@extends('layouts.app')
@section('title', 'Painel Operacional — Servidor Técnico')

@push('styles')
<style>
    .admin-hero {
        background: linear-gradient(135deg, #0c4a6e, #1e40af);
        padding: 40px 0 60px;
        color: #fff;
    }
    .kpi-card {
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        border: 1px solid #f1f5f9;
        transition: var(--pite-transition);
        position: relative;
        overflow: hidden;
    }
    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 4px; height: 100%;
    }
    .kpi-card:hover { transform: translateY(-4px); box-shadow: var(--pite-shadow-lg); }
    .kpi-emerald::before { background: linear-gradient(180deg, var(--pite-emerald), var(--pite-teal)); }
    .kpi-gold::before { background: linear-gradient(180deg, var(--pite-gold), var(--pite-gold-warm)); }
    .kpi-sky::before { background: linear-gradient(180deg, var(--pite-sky), #38bdf8); }
    .kpi-coral::before { background: linear-gradient(180deg, var(--pite-coral), #fb7185); }
    .kpi-violet::before { background: linear-gradient(180deg, #7c3aed, #8b5cf6); }
    .kpi-value {
        font-family: 'Outfit', sans-serif;
        font-weight: 800;
        font-size: 2.2rem;
        line-height: 1;
    }
    .panel-card {
        background: #fff;
        border-radius: 20px;
        padding: 28px;
        border: 1px solid #f1f5f9;
        box-shadow: var(--pite-shadow);
        height: 100%;
    }
    .action-btn {
        display: flex; align-items: center; gap: 12px;
        padding: 14px 18px;
        border-radius: 14px;
        border: 1.5px solid #f1f5f9;
        background: #fff;
        color: var(--pite-text);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.88rem;
        transition: var(--pite-transition);
    }
    .action-btn:hover {
        border-color: var(--pite-sky);
        background: rgba(14,165,233,0.03);
        transform: translateX(4px);
        color: var(--pite-sky);
    }
    .action-icon {
        width: 40px; height: 40px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .audit-item {
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .audit-item:last-child { border-bottom: none; }
    .badge-status-pendente { background: rgba(245,158,11,0.12); color: #d97706; }
    .badge-status-aprovado { background: rgba(4,120,87,0.12); color: #047857; }
    .badge-status-rejeitado { background: rgba(244,63,94,0.12); color: #e11d48; }
    .badge-status-suspenso { background: rgba(99,102,241,0.12); color: #6366f1; }
    .badge-acao-criou { background: rgba(14,165,233,0.12); color: #0284c7; }
    .badge-acao-editou { background: rgba(245,158,11,0.12); color: #d97706; }
    .badge-acao-aprovou { background: rgba(4,120,87,0.12); color: #047857; }
    .badge-acao-rejeitou { background: rgba(244,63,94,0.12); color: #e11d48; }
    .badge-acao-suspendeu { background: rgba(99,102,241,0.12); color: #6366f1; }
    .badge-acao-desativou { background: rgba(100,116,139,0.12); color: #64748b; }
    .create-card {
        border: 2px dashed rgba(14,165,233,0.3);
        border-radius: 16px;
        padding: 24px;
        text-align: center;
        transition: var(--pite-transition);
        background: rgba(14,165,233,0.02);
    }
    .create-card:hover {
        border-color: var(--pite-sky);
        background: rgba(14,165,233,0.05);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(14,165,233,0.1);
    }
    .create-card a { text-decoration: none; color: inherit; }
    .create-card i { font-size: 2rem; color: var(--pite-sky); margin-bottom: 8px; display: block; }
</style>
@endpush

@section('content')
<div class="admin-hero">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <div class="chip mb-2" style="background:rgba(255,255,255,0.08); color:#94a3b8;">
                    <i class="bi bi-tools"></i> Painel Operacional
                </div>
                <h2 class="section-title" style="font-size:1.8rem;">Gestão de Conteúdo e Cadastros</h2>
                <p style="color:#94a3b8; margin:0;">Cadastro, edição e acompanhamento de atrativos, eventos e dados do turismo municipal</p>
            </div>
            <div class="badge-status" style="background:rgba(255,255,255,0.08); color:#94a3b8; padding:10px 20px; font-size:0.85rem;">
                <i class="bi bi-person-badge me-1"></i> Servidor Técnico
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-top:-36px; position:relative; z-index:2;">
    <!-- KPIs -->
    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-3" data-animate>
            <div class="kpi-card kpi-emerald">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="small fw-semibold text-muted text-uppercase mb-1" style="font-size:0.72rem; letter-spacing:0.05em;">Atrativos</p>
                        <div class="kpi-value" style="color:var(--pite-emerald);">{{ $stats['total_atrativos'] ?? 0 }}</div>
                        <small class="text-success"><i class="bi bi-check-circle me-1"></i>{{ $stats['atrativos_ativos'] ?? 0 }} aprovados</small>
                    </div>
                    <div class="icon-box" style="background:rgba(4,120,87,0.08); color:var(--pite-emerald); width:44px; height:44px; font-size:1.1rem;">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3" data-animate>
            <div class="kpi-card kpi-gold">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="small fw-semibold text-muted text-uppercase mb-1" style="font-size:0.72rem; letter-spacing:0.05em;">Pendentes Aprovação</p>
                        <div class="kpi-value" style="color:var(--pite-gold);">{{ ($stats['atrativos_pendentes'] ?? 0) + ($stats['eventos_pendentes'] ?? 0) }}</div>
                        <small class="text-warning"><i class="bi bi-hourglass-split me-1"></i>aguardando o Prefeito</small>
                    </div>
                    <div class="icon-box" style="background:rgba(245,158,11,0.08); color:var(--pite-gold); width:44px; height:44px; font-size:1.1rem;">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3" data-animate>
            <div class="kpi-card kpi-coral">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="small fw-semibold text-muted text-uppercase mb-1" style="font-size:0.72rem; letter-spacing:0.05em;">Eventos</p>
                        <div class="kpi-value" style="color:var(--pite-coral);">{{ $stats['total_eventos'] ?? 0 }}</div>
                        <small class="text-success"><i class="bi bi-check-circle me-1"></i>{{ $stats['eventos_ativos'] ?? 0 }} aprovados</small>
                    </div>
                    <div class="icon-box" style="background:rgba(244,63,94,0.08); color:var(--pite-coral); width:44px; height:44px; font-size:1.1rem;">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3" data-animate>
            <div class="kpi-card kpi-violet">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="small fw-semibold text-muted text-uppercase mb-1" style="font-size:0.72rem; letter-spacing:0.05em;">Suspensos</p>
                        <div class="kpi-value" style="color:#7c3aed;">{{ ($stats['atrativos_suspensos'] ?? 0) + ($stats['eventos_suspensos'] ?? 0) }}</div>
                        <small class="text-muted"><i class="bi bi-arrow-repeat me-1"></i>necessitam atualização</small>
                    </div>
                    <div class="icon-box" style="background:rgba(124,58,237,0.08); color:#7c3aed; width:44px; height:44px; font-size:1.1rem;">
                        <i class="bi bi-pause-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cadastro Rápido + Ações -->
    <div class="row g-4 mb-4">
        <!-- Atalhos de Cadastro -->
        <div class="col-lg-8" data-animate>
            <div class="panel-card">
                <h5 style="font-family:'Outfit'; font-weight:700; margin-bottom:20px;">
                    <i class="bi bi-plus-circle" style="color:var(--pite-sky);"></i> Cadastro Rápido
                </h5>
                <div class="row g-3">
                    <div class="col-sm-6 col-md-3">
                        <div class="create-card">
                            <a href="{{ route('admin.atrativos.create') }}">
                                <i class="bi bi-geo-alt-fill"></i>
                                <div class="fw-bold small" style="color: var(--pite-text);">Novo Atrativo</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Ponto turístico</div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="create-card">
                            <a href="{{ route('admin.eventos.create') }}">
                                <i class="bi bi-calendar-plus"></i>
                                <div class="fw-bold small" style="color: var(--pite-text);">Novo Evento</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Festival, show, etc.</div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="create-card">
                            <a href="{{ route('admin.atrativos.index') }}">
                                <i class="bi bi-list-columns-reverse" style="color: var(--pite-emerald);"></i>
                                <div class="fw-bold small" style="color: var(--pite-text);">Ver Atrativos</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Listar e editar</div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="create-card">
                            <a href="{{ route('admin.eventos.index') }}">
                                <i class="bi bi-list-columns-reverse" style="color: var(--pite-coral);"></i>
                                <div class="fw-bold small" style="color: var(--pite-text);">Ver Eventos</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Listar e editar</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações Rápidas -->
        <div class="col-lg-4" data-animate>
            <div class="panel-card">
                <h5 style="font-family:'Outfit'; font-weight:700; margin-bottom:20px;">
                    <i class="bi bi-lightning-charge" style="color:var(--pite-gold);"></i> Ações Rápidas
                </h5>
                <div class="d-flex flex-column gap-3">
                    <a href="{{ route('admin.atrativos.create') }}" class="action-btn">
                        <div class="action-icon" style="background:rgba(4,120,87,0.08); color:var(--pite-emerald);"><i class="bi bi-plus-circle"></i></div>
                        Cadastrar Atrativo
                    </a>
                    <a href="{{ route('admin.eventos.create') }}" class="action-btn">
                        <div class="action-icon" style="background:rgba(244,63,94,0.08); color:var(--pite-coral);"><i class="bi bi-calendar-plus"></i></div>
                        Cadastrar Evento
                    </a>
                    <a href="{{ route('admin.empreendedores.index') }}" class="action-btn">
                        <div class="action-icon" style="background:rgba(14,165,233,0.08); color:var(--pite-sky);"><i class="bi bi-shop"></i></div>
                        Ver Empreendedores
                    </a>
                    <a href="{{ route('admin.auditoria.index') }}" class="action-btn">
                        <div class="action-icon" style="background:rgba(100,116,139,0.08); color:#64748b;"><i class="bi bi-journal-text"></i></div>
                        Logs de Auditoria
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Acompanhamento de Status dos Cadastros -->
    <div class="row g-4 mb-4">
        <!-- Atrativos Pendentes e Suspensos -->
        <div class="col-lg-6" data-animate>
            <div class="panel-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 style="font-family:'Outfit'; font-weight:700; margin:0;">
                        <i class="bi bi-geo-alt-fill" style="color:var(--pite-emerald);"></i> Meus Atrativos — Status
                    </h5>
                    <a href="{{ route('admin.atrativos.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">Ver Todos</a>
                </div>

                @php
                    $atrativosPendentes = \App\Models\Atrativo::with('categoria')->pendente()->latest()->take(5)->get();
                    $atrativosSuspensos = \App\Models\Atrativo::with('categoria')->suspenso()->latest()->take(3)->get();
                @endphp

                @if($atrativosPendentes->count() > 0)
                    <div class="mb-2">
                        <small class="fw-bold text-uppercase" style="font-size: 0.7rem; color: #d97706; letter-spacing: 0.05em;">
                            <i class="bi bi-hourglass-split me-1"></i>Aguardando Aprovação
                        </small>
                    </div>
                    @foreach($atrativosPendentes as $at)
                        <div class="audit-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold small">{{ $at->nome }}</div>
                                <small class="text-muted">{{ $at->categoria->nome ?? '—' }} · {{ $at->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <span class="badge badge-status-pendente px-2 py-1 rounded-pill" style="font-size: 0.7rem;">Pendente</span>
                                <a href="{{ route('admin.atrativos.edit', $at) }}" class="btn btn-sm btn-outline-secondary rounded-pill py-0 px-2" style="font-size: 0.72rem;">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif

                @if($atrativosSuspensos->count() > 0)
                    <div class="mt-3 mb-2">
                        <small class="fw-bold text-uppercase" style="font-size: 0.7rem; color: #6366f1; letter-spacing: 0.05em;">
                            <i class="bi bi-pause-circle me-1"></i>Suspensos — Requer Atualização
                        </small>
                    </div>
                    @foreach($atrativosSuspensos as $at)
                        <div class="audit-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold small">{{ $at->nome }}</div>
                                <small class="text-muted">{{ $at->observacoes_admin ?? 'Suspenso por desatualização' }}</small>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <span class="badge badge-status-suspenso px-2 py-1 rounded-pill" style="font-size: 0.7rem;">Suspenso</span>
                                <a href="{{ route('admin.atrativos.edit', $at) }}" class="btn btn-sm btn-outline-primary rounded-pill py-0 px-2" style="font-size: 0.72rem;" title="Atualizar para reenviar à aprovação">
                                    <i class="bi bi-arrow-repeat"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif

                @if($atrativosPendentes->count() === 0 && $atrativosSuspensos->count() === 0)
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-check-circle d-block fs-3 mb-2" style="color: var(--pite-emerald);"></i>
                        <small>Todos os atrativos estão aprovados!</small>
                    </div>
                @endif
            </div>
        </div>

        <!-- Eventos Pendentes e Suspensos -->
        <div class="col-lg-6" data-animate>
            <div class="panel-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 style="font-family:'Outfit'; font-weight:700; margin:0;">
                        <i class="bi bi-calendar-event-fill" style="color:var(--pite-coral);"></i> Meus Eventos — Status
                    </h5>
                    <a href="{{ route('admin.eventos.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">Ver Todos</a>
                </div>

                @php
                    $eventosPendentes = \App\Models\Evento::with('atrativo')->pendente()->latest()->take(5)->get();
                    $eventosSuspensos = \App\Models\Evento::with('atrativo')->suspenso()->latest()->take(3)->get();
                @endphp

                @if($eventosPendentes->count() > 0)
                    <div class="mb-2">
                        <small class="fw-bold text-uppercase" style="font-size: 0.7rem; color: #d97706; letter-spacing: 0.05em;">
                            <i class="bi bi-hourglass-split me-1"></i>Aguardando Aprovação
                        </small>
                    </div>
                    @foreach($eventosPendentes as $ev)
                        <div class="audit-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold small">{{ $ev->titulo }}</div>
                                <small class="text-muted">{{ $ev->local }} · {{ $ev->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <span class="badge badge-status-pendente px-2 py-1 rounded-pill" style="font-size: 0.7rem;">Pendente</span>
                                <a href="{{ route('admin.eventos.edit', $ev) }}" class="btn btn-sm btn-outline-secondary rounded-pill py-0 px-2" style="font-size: 0.72rem;">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif

                @if($eventosSuspensos->count() > 0)
                    <div class="mt-3 mb-2">
                        <small class="fw-bold text-uppercase" style="font-size: 0.7rem; color: #6366f1; letter-spacing: 0.05em;">
                            <i class="bi bi-pause-circle me-1"></i>Suspensos — Requer Atualização
                        </small>
                    </div>
                    @foreach($eventosSuspensos as $ev)
                        <div class="audit-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold small">{{ $ev->titulo }}</div>
                                <small class="text-muted">{{ $ev->observacoes_admin ?? 'Suspenso por desatualização' }}</small>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <span class="badge badge-status-suspenso px-2 py-1 rounded-pill" style="font-size: 0.7rem;">Suspenso</span>
                                <a href="{{ route('admin.eventos.edit', $ev) }}" class="btn btn-sm btn-outline-primary rounded-pill py-0 px-2" style="font-size: 0.72rem;" title="Atualizar para reenviar à aprovação">
                                    <i class="bi bi-arrow-repeat"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif

                @if($eventosPendentes->count() === 0 && $eventosSuspensos->count() === 0)
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-check-circle d-block fs-3 mb-2" style="color: var(--pite-emerald);"></i>
                        <small>Todos os eventos estão aprovados!</small>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Trilha de Auditoria Recente -->
    <div class="row g-4 mb-5">
        <div class="col-12" data-animate>
            <div class="panel-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 style="font-family:'Outfit'; font-weight:700; margin:0;">
                        <i class="bi bi-journal-text" style="color:#64748b;"></i> Últimas Ações na Auditoria
                    </h5>
                    <a href="{{ route('admin.auditoria.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">Ver Histórico Completo</a>
                </div>
                <small class="text-muted d-block mb-3">Acompanhe o que aconteceu com seus cadastros — aprovações, rejeições e suspensões</small>

                @php
                    $ultimasAuditorias = \App\Models\Auditoria::with('usuario')
                        ->whereIn('tabela', ['atrativos', 'eventos'])
                        ->latest('created_at')
                        ->take(8)
                        ->get();
                @endphp

                @forelse($ultimasAuditorias as $log)
                    <div class="audit-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="action-icon flex-shrink-0" style="width:36px; height:36px; font-size:0.9rem;
                                background: {{ $log->acao === 'aprovou' ? 'rgba(4,120,87,0.08)' : ($log->acao === 'rejeitou' ? 'rgba(244,63,94,0.08)' : ($log->acao === 'suspendeu' ? 'rgba(99,102,241,0.08)' : ($log->acao === 'criou' ? 'rgba(14,165,233,0.08)' : 'rgba(245,158,11,0.08)'))) }};
                                color: {{ $log->acao === 'aprovou' ? '#047857' : ($log->acao === 'rejeitou' ? '#e11d48' : ($log->acao === 'suspendeu' ? '#6366f1' : ($log->acao === 'criou' ? '#0284c7' : '#d97706'))) }};">
                                <i class="bi bi-{{ $log->acao === 'aprovou' ? 'check-circle' : ($log->acao === 'rejeitou' ? 'x-circle' : ($log->acao === 'suspendeu' ? 'pause-circle' : ($log->acao === 'criou' ? 'plus-circle' : 'pencil'))) }}"></i>
                            </div>
                            <div>
                                <div class="small">
                                    <span class="fw-semibold">{{ $log->usuario->name ?? 'Sistema' }}</span>
                                    <span class="badge badge-acao-{{ $log->acao }} px-2 py-1 rounded-pill ms-1" style="font-size: 0.68rem;">{{ $log->acao }}</span>
                                    em <span class="fw-semibold">{{ $log->tabela }}</span>
                                    <span class="text-muted">#{{ $log->registro_id }}</span>
                                </div>
                                <small class="text-muted">{{ $log->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        @if($log->dados_depois && isset($log->dados_depois['nome']))
                            <small class="text-muted d-none d-md-block" style="max-width: 200px;">{{ Str::limit($log->dados_depois['nome'] ?? $log->dados_depois['titulo'] ?? '', 30) }}</small>
                        @endif
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-journal-text d-block fs-3 mb-2"></i>
                        <small>Nenhuma atividade registrada ainda.</small>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

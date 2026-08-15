@extends('layouts.app')
@section('title', 'Painel de Gestão — System-PITE')

@push('styles')
<style>
    .admin-hero {
        background: linear-gradient(135deg, var(--pite-dark) 0%, #1e293b 100%);
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
        border-color: var(--pite-emerald);
        background: rgba(4,120,87,0.03);
        transform: translateX(4px);
        color: var(--pite-emerald);
    }
    .action-icon {
        width: 40px; height: 40px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .esg-mini {
        padding: 16px;
        border-radius: 14px;
        height: 100%;
    }
</style>
@endpush

@section('content')
<div class="admin-hero">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <div class="chip mb-2" style="background:rgba(255,255,255,0.08); color:#94a3b8;">
                    <i class="bi bi-grid-1x2"></i> Painel Administrativo
                </div>
                <h2 class="section-title" style="font-size:1.8rem;">Gestão do Turismo Municipal</h2>
                <p style="color:#64748b; margin:0;">Indicadores, empreendedores, auditoria e sustentabilidade ESG</p>
            </div>
            <div class="badge-status" style="background:rgba(255,255,255,0.08); color:#94a3b8; padding:10px 20px; font-size:0.85rem;">
                <i class="bi bi-person-badge me-1"></i> {{ auth()->user()->perfil?->nome ?? 'Gestor Municipal' }}
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-top:-36px; position:relative; z-index:2;">
      {{-- KPIs Principais --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4 col-xl" data-animate>
            <div class="kpi-card kpi-sky">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="small fw-semibold text-muted text-uppercase mb-1" style="font-size:0.72rem; letter-spacing:0.05em;">Acessos ao Portal</p>
                        <div class="kpi-value" style="color:var(--pite-sky);">{{ number_format($stats['total_visitas_site'] ?? 0, 0, ',', '.') }}</div>
                        <small class="text-primary" style="font-size:0.75rem;"><i class="bi bi-eye me-1"></i>{{ $stats['visitas_hoje'] ?? 0 }} hoje</small>
                    </div>
                    <div class="icon-box" style="background:rgba(14,165,233,0.08); color:var(--pite-sky); width:44px; height:44px; font-size:1.1rem;">
                        <i class="bi bi-globe2"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl" data-animate>
            <div class="kpi-card kpi-emerald">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="small fw-semibold text-muted text-uppercase mb-1" style="font-size:0.72rem; letter-spacing:0.05em;">Atrativos Ativos</p>
                        <div class="kpi-value" style="color:var(--pite-emerald);">{{ $stats['total_atrativos'] ?? 0 }}</div>
                        <small class="text-success" style="font-size:0.75rem;"><i class="bi bi-check-circle me-1"></i>{{ $stats['atrativos_ativos'] ?? 0 }} online</small>
                    </div>
                    <div class="icon-box" style="background:rgba(4,120,87,0.08); color:var(--pite-emerald); width:44px; height:44px; font-size:1.1rem;">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl" data-animate>
            <div class="kpi-card kpi-sky">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="small fw-semibold text-muted text-uppercase mb-1" style="font-size:0.72rem; letter-spacing:0.05em;">Empreendedores</p>
                        <div class="kpi-value" style="color:var(--pite-sky);">{{ $stats['total_empreendedores'] ?? 0 }}</div>
                        <small class="text-info" style="font-size:0.75rem;"><i class="bi bi-shop me-1"></i>{{ $stats['empreendedores_aprovados'] ?? 0 }} com selo</small>
                    </div>
                    <div class="icon-box" style="background:rgba(14,165,233,0.08); color:var(--pite-sky); width:44px; height:44px; font-size:1.1rem;">
                        <i class="bi bi-shop"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-6 col-xl" data-animate>
            <div class="kpi-card kpi-gold">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="small fw-semibold text-muted text-uppercase mb-1" style="font-size:0.72rem; letter-spacing:0.05em;">Pendentes</p>
                        <div class="kpi-value" style="color:var(--pite-gold);">{{ $stats['empreendedores_pendentes'] ?? 0 }}</div>
                        <small class="text-warning" style="font-size:0.75rem;"><i class="bi bi-clock me-1"></i>Para homologação</small>
                    </div>
                    <div class="icon-box" style="background:rgba(245,158,11,0.08); color:var(--pite-gold); width:44px; height:44px; font-size:1.1rem;">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-6 col-xl" data-animate>
            <div class="kpi-card kpi-coral">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="small fw-semibold text-muted text-uppercase mb-1" style="font-size:0.72rem; letter-spacing:0.05em;">Eventos</p>
                        <div class="kpi-value" style="color:var(--pite-coral);">{{ $stats['total_eventos'] ?? 0 }}</div>
                        <small class="text-danger" style="font-size:0.75rem;"><i class="bi bi-calendar-check me-1"></i>{{ $stats['eventos_ativos'] ?? 0 }} ativos</small>
                    </div>
                    <div class="icon-box" style="background:rgba(244,63,94,0.08); color:var(--pite-coral); width:44px; height:44px; font-size:1.1rem;">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ESG + Actions -->
    <div class="row g-4 mb-5">
        <div class="col-lg-8" data-animate>
            <div class="panel-card">
                <h5 style="font-family:'Outfit'; font-weight:700; margin-bottom:20px;">
                    <i class="bi bi-leaf" style="color:var(--pite-emerald);"></i> Matriz ESG Municipal
                </h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="esg-mini" style="background:rgba(5,150,105,0.06);">
                            <h6 style="font-family:'Outfit'; font-weight:700; color:#059669; font-size:0.9rem;">
                                <i class="bi bi-tree me-1"></i> Ambiental
                            </h6>
                            <p class="small text-muted mb-0">Reciclagem, economia de água e preservação de trilhas.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="esg-mini" style="background:rgba(14,165,233,0.06);">
                            <h6 style="font-family:'Outfit'; font-weight:700; color:#0284c7; font-size:0.9rem;">
                                <i class="bi bi-people me-1"></i> Social
                            </h6>
                            <p class="small text-muted mb-0">Acessibilidade PNE, inclusão e renda local.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="esg-mini" style="background:rgba(217,119,6,0.06);">
                            <h6 style="font-family:'Outfit'; font-weight:700; color:#d97706; font-size:0.9rem;">
                                <i class="bi bi-shield-check me-1"></i> Governança
                            </h6>
                            <p class="small text-muted mb-0">Dados abertos, selos validados e LGPD.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4" data-animate>
            <div class="panel-card">
                <h5 style="font-family:'Outfit'; font-weight:700; margin-bottom:20px;">
                    <i class="bi bi-lightning-charge" style="color:var(--pite-gold);"></i> Ações Rápidas
                </h5>
                <div class="d-flex flex-column gap-3">
                    <a href="{{ route('admin.empreendedores.index') }}" class="action-btn">
                        <div class="action-icon" style="background:rgba(4,120,87,0.08); color:var(--pite-emerald);"><i class="bi bi-check-circle"></i></div>
                        Aprovar Empreendedores
                    </a>
                    <a href="{{ route('admin.atrativos.index') }}" class="action-btn">
                        <div class="action-icon" style="background:rgba(13,148,136,0.08); color:var(--pite-teal);"><i class="bi bi-compass"></i></div>
                        Gerenciar Atrativos
                    </a>
                    <a href="{{ route('admin.eventos.index') }}" class="action-btn">
                        <div class="action-icon" style="background:rgba(244,63,94,0.08); color:var(--pite-coral);"><i class="bi bi-calendar-event"></i></div>
                        Gerenciar Eventos
                    </a>
                    <a href="{{ route('admin.esg.index') }}" class="action-btn">
                        <div class="action-icon" style="background:rgba(5,150,105,0.08); color:#059669;"><i class="bi bi-plus-circle"></i></div>
                        Cadastrar Métrica ESG
                    </a>
                    <a href="{{ route('admin.auditoria.index') }}" class="action-btn">
                        <div class="action-icon" style="background:rgba(100,116,139,0.08); color:#64748b;"><i class="bi bi-journal-text"></i></div>
                        Logs de Auditoria
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

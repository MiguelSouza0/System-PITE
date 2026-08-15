@extends('layouts.app')
@section('title', 'Indicadores ESG — System-PITE')

@push('styles')
<style>
    .esg-hero {
        background: linear-gradient(160deg, #022c22 0%, #064e3b 50%, #047857 100%);
        padding: 64px 0;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .esg-hero::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -15%;
        width: 500px; height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(16,185,129,0.15) 0%, transparent 70%);
    }
    .pillar-card {
        background: #fff;
        border-radius: 24px;
        padding: 36px 28px;
        border: 1px solid #f1f5f9;
        transition: var(--pite-transition);
        position: relative;
        overflow: hidden;
        height: 100%;
    }
    .pillar-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
    }
    .pillar-card:hover { transform: translateY(-6px); box-shadow: var(--pite-shadow-lg); }
    .pillar-env::after { background: linear-gradient(90deg, #059669, #10b981); }
    .pillar-soc::after { background: linear-gradient(90deg, #0284c7, #0ea5e9); }
    .pillar-gov::after { background: linear-gradient(90deg, #d97706, #f59e0b); }
    .metric-item {
        display: flex; align-items: flex-start; gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f8fafc;
        font-size: 0.88rem;
        color: var(--pite-text-muted);
        line-height: 1.5;
    }
    .metric-item:last-child { border: none; }
    .metric-check {
        width: 22px; height: 22px;
        border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.7rem;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .score-ring {
        width: 120px; height: 120px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center; flex-direction: column;
        font-family: 'Outfit', sans-serif;
        font-weight: 800;
        font-size: 2rem;
        color: #fff;
        margin: 0 auto;
    }
</style>
@endpush

@section('content')
<div class="esg-hero">
    <div class="container" style="position:relative; z-index:2;">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="chip mb-3" style="background:rgba(16,185,129,0.2); color:#6ee7b7;">
                    <i class="bi bi-shield-check"></i> Transparência Pública
                </div>
                <h1 class="section-title" style="font-size:clamp(2rem,4vw,3rem);">Painel de Indicadores ESG</h1>
                <p style="color:rgba(255,255,255,0.7); max-width:500px; line-height:1.7;">
                    Transparência total dos compromissos ambientais, sociais e de governança do turismo municipal.
                </p>
            </div>
            <div class="col-lg-5 text-center mt-4 mt-lg-0">
                <div class="score-ring" style="background:linear-gradient(135deg, #059669, #10b981); box-shadow:0 12px 40px rgba(16,185,129,0.3);">
                    85.5
                    <span style="font-size:0.7rem; font-weight:500; opacity:0.8;">Índice Geral</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-top:-32px; position:relative; z-index:2;">
    <div class="row g-4 mb-5">
        <div class="col-md-4" data-animate>
            <div class="pillar-card pillar-env">
                <div class="icon-box mb-3" style="background:rgba(5,150,105,0.1); color:#059669;">
                    <i class="bi bi-tree"></i>
                </div>
                <h4 style="font-family:'Outfit'; font-weight:800; color:#059669;">Ambiental</h4>
                <p class="small text-muted mb-3">Environmental — Preservação e gestão sustentável de recursos naturais.</p>
                <div class="metric-item">
                    <div class="metric-check" style="background:rgba(5,150,105,0.1); color:#059669;"><i class="bi bi-check-lg"></i></div>
                    100% dos resíduos de eventos públicos reciclados
                </div>
                <div class="metric-item">
                    <div class="metric-check" style="background:rgba(5,150,105,0.1); color:#059669;"><i class="bi bi-check-lg"></i></div>
                    Redução de 25% na pegada de carbono no centro histórico
                </div>
                <div class="metric-item">
                    <div class="metric-check" style="background:rgba(5,150,105,0.1); color:#059669;"><i class="bi bi-check-lg"></i></div>
                    Proteção ativa de 3 áreas de preservação ambiental
                </div>
            </div>
        </div>

        <div class="col-md-4" data-animate>
            <div class="pillar-card pillar-soc">
                <div class="icon-box mb-3" style="background:rgba(2,132,199,0.1); color:#0284c7;">
                    <i class="bi bi-people"></i>
                </div>
                <h4 style="font-family:'Outfit'; font-weight:800; color:#0284c7;">Social</h4>
                <p class="small text-muted mb-3">Inclusão, acessibilidade e impacto socioeconômico positivo.</p>
                <div class="metric-item">
                    <div class="metric-check" style="background:rgba(2,132,199,0.1); color:#0284c7;"><i class="bi bi-check-lg"></i></div>
                    80% dos atrativos adequados à acessibilidade PNE
                </div>
                <div class="metric-item">
                    <div class="metric-check" style="background:rgba(2,132,199,0.1); color:#0284c7;"><i class="bi bi-check-lg"></i></div>
                    Incentivo à renda de 120+ empreendedores locais
                </div>
                <div class="metric-item">
                    <div class="metric-check" style="background:rgba(2,132,199,0.1); color:#0284c7;"><i class="bi bi-check-lg"></i></div>
                    Capacitação continuada em atendimento inclusivo
                </div>
            </div>
        </div>

        <div class="col-md-4" data-animate>
            <div class="pillar-card pillar-gov">
                <div class="icon-box mb-3" style="background:rgba(217,119,6,0.1); color:#d97706;">
                    <i class="bi bi-bank"></i>
                </div>
                <h4 style="font-family:'Outfit'; font-weight:800; color:#d97706;">Governança</h4>
                <p class="small text-muted mb-3">Transparência pública, dados abertos e conformidade legal.</p>
                <div class="metric-item">
                    <div class="metric-check" style="background:rgba(217,119,6,0.1); color:#d97706;"><i class="bi bi-check-lg"></i></div>
                    Dados abertos e integridade auditável via código público
                </div>
                <div class="metric-item">
                    <div class="metric-check" style="background:rgba(217,119,6,0.1); color:#d97706;"><i class="bi bi-check-lg"></i></div>
                    100% de conformidade com a LGPD
                </div>
                <div class="metric-item">
                    <div class="metric-check" style="background:rgba(217,119,6,0.1); color:#d97706;"><i class="bi bi-check-lg"></i></div>
                    Moderação ativa contra avaliações falsas
                </div>
            </div>
        </div>
    </div>
</div>
<div style="height:40px;"></div>
@endsection

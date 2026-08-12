@extends('layouts.app')
@section('title', 'Roteiros Inteligentes — System-PITE')

@push('styles')
<style>
    .roteiro-hero {
        background: linear-gradient(160deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
        padding: 64px 0;
        position: relative;
        overflow: hidden;
    }
    .roteiro-hero::before {
        content: '';
        position: absolute;
        top: -40%;
        right: -20%;
        width: 600px; height: 600px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(245,158,11,0.1) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }
    .form-panel {
        background: #fff;
        border-radius: 24px;
        padding: 36px;
        box-shadow: var(--pite-shadow-lg);
        border: 1px solid #f1f5f9;
    }
    .result-panel {
        background: #fff;
        border-radius: 24px;
        padding: 36px;
        box-shadow: var(--pite-shadow);
        border: 1px solid #f1f5f9;
    }
    .timeline-step {
        padding: 20px;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        transition: var(--pite-transition);
        position: relative;
        margin-bottom: 16px;
    }
    .timeline-step:hover {
        transform: translateX(4px);
        border-color: var(--pite-emerald);
        box-shadow: 0 4px 16px rgba(4,120,87,0.08);
    }
    .timeline-step::before {
        content: '';
        position: absolute;
        left: -24px;
        top: 50%;
        transform: translateY(-50%);
        width: 12px; height: 12px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--pite-emerald), var(--pite-teal));
        box-shadow: 0 0 0 4px rgba(4,120,87,0.15);
    }
    .timeline-line {
        border-left: 2px dashed rgba(4,120,87,0.2);
        padding-left: 24px;
        margin-left: 5px;
    }
    .ai-badge {
        background: linear-gradient(135deg, #818cf8, #6366f1);
        color: #fff;
        font-size: 0.72rem;
        padding: 4px 12px;
        border-radius: 99px;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="roteiro-hero text-white" style="position:relative; z-index:1;">
    <div class="container" style="position:relative; z-index:2;">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="ai-badge mb-3 d-inline-block"><i class="bi bi-stars me-1"></i> IA Auditável & Transparente</span>
                <h1 class="section-title mb-3" style="font-size:clamp(2rem,4vw,3rem);">Gerador de Roteiros Inteligentes</h1>
                <p style="color:rgba(255,255,255,0.7); max-width:480px; line-height:1.7;">
                    Nossa IA cria roteiros sob medida considerando perfil, tempo, acessibilidade e preferências — com supervisão humana garantida.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-top:-40px; position:relative; z-index:2;">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="form-panel">
                <h5 style="font-family:'Outfit'; font-weight:700; margin-bottom:20px;">
                    <i class="bi bi-sliders" style="color:var(--pite-violet);"></i> Suas Preferências
                </h5>
                <form onsubmit="event.preventDefault(); document.getElementById('resultPanel').style.display='block';">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Perfil de Passeio</label>
                        <select class="form-select form-select-pite">
                            <option value="familia">👨‍👩‍👧 Família com Crianças</option>
                            <option value="aventura">🏔️ Ecoturismo e Aventura</option>
                            <option value="cultural">🏛️ Histórico e Cultural</option>
                            <option value="gastronomico">🍽️ Gastronomia Local</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Tempo Disponível</label>
                        <input type="number" class="form-control form-control-pite" value="4" min="1" max="24">
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="acessivelCheck" checked>
                        <label class="form-check-label small" for="acessivelCheck">♿ 100% Acessível (PNE)</label>
                    </div>
                    <button type="submit" class="btn btn-pite w-100 btn-lg">
                        <i class="bi bi-lightning-charge me-2"></i> Gerar Roteiro
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="result-panel" id="resultPanel">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 style="font-family:'Outfit'; font-weight:700; margin:0;">
                        <i class="bi bi-route" style="color:var(--pite-emerald);"></i> Roteiro Sugerido
                    </h5>
                    <span class="ai-badge"><i class="bi bi-cpu me-1"></i> Gerado por IA</span>
                </div>

                <div class="p-3 mb-4" style="background:rgba(4,120,87,0.05); border-radius:14px; border-left:4px solid var(--pite-emerald);">
                    <h6 style="font-family:'Outfit'; font-weight:700; margin-bottom:4px;">Roteiro Cultural & Acessível — 4 Horas</h6>
                    <p class="small text-muted mb-0">Atrativos oficiais validados pelo município · Supervisão humana ativa</p>
                </div>

                <div class="timeline-line">
                    <div class="timeline-step">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <span class="badge-status" style="background:rgba(4,120,87,0.1); color:var(--pite-emerald);">09:00 — 10:30</span>
                            <span class="badge-status" style="background:rgba(16,185,129,0.1); color:#059669; font-size:0.7rem;">♿ Acessível</span>
                        </div>
                        <h6 style="font-family:'Outfit'; font-weight:700; margin:8px 0 4px;">Centro Histórico & Feira de Artesanato</h6>
                        <p class="small text-muted mb-0">Rampa de acesso · Banheiros adaptados · Piso tátil</p>
                    </div>
                    <div class="timeline-step">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <span class="badge-status" style="background:rgba(245,158,11,0.1); color:var(--pite-gold-warm);">11:00 — 12:30</span>
                            <span class="badge-status" style="background:rgba(4,120,87,0.08); color:var(--pite-emerald); font-size:0.7rem;">🍽️ Gastronomia</span>
                        </div>
                        <h6 style="font-family:'Outfit'; font-weight:700; margin:8px 0 4px;">Restaurante Típico Municipal</h6>
                        <p class="small text-muted mb-0">Selo Alimento Seguro · Empreendedor local validado</p>
                    </div>
                    <div class="timeline-step">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <span class="badge-status" style="background:rgba(14,165,233,0.1); color:var(--pite-sky);">13:00 — 14:00</span>
                            <span class="badge-status" style="background:rgba(16,185,129,0.1); color:#059669; font-size:0.7rem;">♿ Acessível</span>
                        </div>
                        <h6 style="font-family:'Outfit'; font-weight:700; margin:8px 0 4px;">Parque Botânico Acessível</h6>
                        <p class="small text-muted mb-0">Trilha plana em alvenaria · Audio-guia disponível</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="height:80px;"></div>
@endsection

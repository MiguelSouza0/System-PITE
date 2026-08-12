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
                <form id="iaRoteiroForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Perfil de Passeio</label>
                        <select name="perfil" id="perfil" class="form-select form-select-pite">
                            <option value="familia">👨‍👩‍👧 Família com Crianças</option>
                            <option value="aventura">🏔️ Ecoturismo e Aventura</option>
                            <option value="cultural">🏛️ Histórico e Cultural</option>
                            <option value="gastronomico">🍽️ Gastronomia Local</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Tempo Disponível (horas)</label>
                        <input type="number" name="duracao_horas" id="duracao_horas" class="form-control form-control-pite" value="4" min="1" max="24">
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="acessivel" value="1" id="acessivelCheck" checked>
                        <label class="form-check-label small" for="acessivelCheck">♿ 100% Acessível (PNE)</label>
                    </div>
                    <button type="submit" class="btn btn-pite w-100 btn-lg" id="btnGerar">
                        <i class="bi bi-lightning-charge me-2"></i> Gerar Roteiro
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="result-panel" id="resultPanel">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 style="font-family:'Outfit'; font-weight:700; margin:0;" id="roteiroTitulo">
                        <i class="bi bi-route" style="color:var(--pite-emerald);"></i> Roteiro Sugerido
                    </h5>
                    <span class="ai-badge"><i class="bi bi-cpu me-1"></i> Gerado por IA</span>
                </div>

                <div class="p-3 mb-4" style="background:rgba(4,120,87,0.05); border-radius:14px; border-left:4px solid var(--pite-emerald);">
                    <h6 style="font-family:'Outfit'; font-weight:700; margin-bottom:4px;" id="roteiroSubtitulo">Roteiro Cultural & Acessível</h6>
                    <p class="small text-muted mb-0" id="roteiroDescricao">Atrativos oficiais validados pelo município · Supervisão humana ativa</p>
                </div>

                <div class="timeline-line" id="timelineContainer">
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-compass fs-1 d-block mb-2" style="color:var(--pite-emerald);"></i>
                        Preencha suas preferências ao lado e clique em <strong>Gerar Roteiro</strong> para criar uma sugestão personalizada!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="height:80px;"></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('iaRoteiroForm');
    const btn = document.getElementById('btnGerar');
    const container = document.getElementById('timelineContainer');
    const titulo = document.getElementById('roteiroTitulo');
    const subtitulo = document.getElementById('roteiroSubtitulo');
    const descricao = document.getElementById('roteiroDescricao');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processando IA...';

        const formData = new FormData(form);

        fetch('{{ route("portal.roteiros.gerar") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-lightning-charge me-2"></i> Gerar Novo Roteiro';

            if (data.sucesso) {
                const rot = data.roteiro;
                const atrativos = data.atrativos;

                subtitulo.textContent = rot.titulo;
                descricao.textContent = rot.descricao;

                if (atrativos.length === 0) {
                    container.innerHTML = '<div class="alert alert-info rounded-4">Nenhum atrativo encontrado com esses filtros exatos, tente ajustar as preferências!</div>';
                    return;
                }

                let html = '';
                let horaAtual = 9; // Começa às 9h

                atrativos.forEach((at, index) => {
                    const horaInicio = (horaAtual < 10 ? '0' : '') + horaAtual + ':00';
                    horaAtual += 1;
                    const horaFim = (horaAtual < 10 ? '0' : '') + horaAtual + ':30';
                    horaAtual += 1;

                    const acess = at.niveis_acessibilidade && at.niveis_acessibilidade.cadeirante ?
                        '<span class="badge-status" style="background:rgba(16,185,129,0.1); color:#059669; font-size:0.7rem;">♿ Acessível</span>' : '';

                    html += `
                        <div class="timeline-step">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="badge-status" style="background:rgba(4,120,87,0.1); color:var(--pite-emerald);">${horaInicio} — ${horaFim}</span>
                                ${acess}
                            </div>
                            <h6 style="font-family:'Outfit'; font-weight:700; margin:8px 0 4px;">${at.nome}</h6>
                            <p class="small text-muted mb-2">${at.descricao}</p>
                            <div class="d-flex align-items-center gap-3">
                                <small class="text-muted"><i class="bi bi-geo-alt me-1"></i> ${at.endereco || 'Centro'}</small>
                                <a href="/atrativos/${at.slug}" class="small text-success fw-semibold text-decoration-none" target="_blank">Ver detalhes <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    `;
                });

                container.innerHTML = html;
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-lightning-charge me-2"></i> Gerar Roteiro';
            alert('Erro ao gerar roteiro via IA. Tente novamente.');
        });
    });
});
</script>
@endpush

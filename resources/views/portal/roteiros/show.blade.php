@extends('layouts.app')
@section('title', $roteiro->titulo . ' — System-PITE')

@push('styles')
<style>
    .roteiro-detail-hero {
        background: linear-gradient(160deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
        padding: 48px 0 32px;
        color: #fff;
        position: relative;
    }
    .map-route-wrapper {
        border-radius: 20px;
        overflow: hidden;
        border: 2px solid rgba(4,120,87,0.2);
        box-shadow: var(--pite-shadow-lg);
        position: relative;
    }
    .timeline-full-step {
        position: relative;
        padding-left: 56px;
        padding-bottom: 32px;
    }
    .timeline-full-step:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 42px;
        bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, var(--pite-emerald), #cbd5e1);
    }
    .step-pin {
        position: absolute;
        left: 0;
        top: 0;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--pite-emerald), var(--pite-teal));
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.1rem;
        box-shadow: 0 4px 14px rgba(4,120,87,0.4);
        border: 3px solid #fff;
    }
    .info-card {
        background: #fff;
        border-radius: 18px;
        padding: 24px;
        box-shadow: var(--pite-shadow);
        border: 1px solid #f1f5f9;
    }
    .audio-player-box {
        background: linear-gradient(135deg, #312e81, #4338ca);
        border-radius: 18px;
        padding: 20px 24px;
        color: #fff;
        box-shadow: 0 8px 24px rgba(49,46,129,0.3);
    }
    .pulse-gps {
        animation: pulseGps 1.8s infinite;
    }
    @keyframes pulseGps {
        0% { box-shadow: 0 0 0 0 rgba(14,165,233,0.7); }
        70% { box-shadow: 0 0 0 16px rgba(14,165,233,0); }
        100% { box-shadow: 0 0 0 0 rgba(14,165,233,0); }
    }
    /* Drag-and-drop Sortable */
    .timeline-full-step {
        cursor: grab;
        user-select: none;
        position: relative;
    }
    .timeline-full-step:active {
        cursor: grabbing;
    }
    .timeline-full-step.sortable-ghost {
        opacity: 0.35;
        background: rgba(4,120,87,0.1) !important;
        border: 2px dashed var(--pite-emerald) !important;
        border-radius: 14px;
    }
    .timeline-full-step.sortable-chosen {
        transform: scale(1.02);
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }
    .timeline-full-step.sortable-drag {
        opacity: 0.95;
        cursor: grabbing !important;
    }
    .drag-handle-badge {
        position: absolute;
        right: 12px;
        top: 12px;
        background: #f1f5f9;
        color: #475569;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        cursor: grab;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 4px;
        z-index: 5;
        border: 1px solid #cbd5e1;
    }
    .timeline-editing .drag-handle-badge {
        background: #047857;
        color: #ffffff;
        border-color: #047857;
        box-shadow: 0 2px 8px rgba(4,120,87,0.3);
    }
    .timeline-editing .timeline-full-step .card {
        border: 1.5px dashed var(--pite-emerald) !important;
        background: #f0fdf4 !important;
    }
    .timeline-edit-toolbar {
        display: none;
        gap: 8px;
        flex-wrap: wrap;
    }
    .timeline-edit-toolbar.active { display: flex; }
    .btn-step-actions {
        display: none;
        gap: 6px;
        margin-top: 8px;
        padding-top: 8px;
        border-top: 1px dashed rgba(4,120,87,0.2);
    }
    .timeline-editing .btn-step-actions { display: flex; }
    @media print {
        .navbar-pite, .a11y-bar, .footer-pite, #gpsTrackerBtn, #audioPlayerBox, #btnSalvarOffline, .btn-print-hide, .timeline-edit-toolbar, .drag-handle-badge, .btn-step-actions {
            display: none !important;
        }
        body { background: #fff !important; color: #000 !important; }
        .map-route-wrapper { height: 350px !important; }
    }
</style>
@endpush

@section('content')

<!-- ═══ HERO DO DETALHE ═══ -->
<div class="roteiro-detail-hero">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0" style="font-size:0.85rem;">
                <li class="breadcrumb-item"><a href="{{ route('portal.home') }}" class="text-white text-opacity-75 text-decoration-none">Início</a></li>
                <li class="breadcrumb-item"><a href="{{ route('portal.roteiros') }}" class="text-white text-opacity-75 text-decoration-none">Roteiros</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $roteiro->titulo }}</li>
            </ol>
        </nav>

        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                    <span class="badge rounded-pill px-3 py-1" style="background:rgba(245,158,11,0.2); color:#fbbf24; font-size:0.75rem; font-weight:700;">
                        {{ $roteiro->tema_label }}
                    </span>
                    @if($roteiro->gerado_por_ia)
                        <span class="badge rounded-pill px-3 py-1" style="background:rgba(99,102,241,0.25); color:#a5b4fc; font-size:0.75rem;">
                            <i class="bi bi-stars me-1"></i> Roteiro Gerado com IA
                        </span>
                    @else
                        <span class="badge rounded-pill px-3 py-1" style="background:rgba(16,185,129,0.25); color:#6ee7b7; font-size:0.75rem;">
                            <i class="bi bi-patch-check-fill me-1"></i> Roteiro Oficial Validado
                        </span>
                    @endif
                    @if($roteiro->acessivel_pne)
                        <span class="badge rounded-pill px-3 py-1" style="background:rgba(16,185,129,0.25); color:#6ee7b7; font-size:0.75rem;">
                            ♿ 100% Acessível PNE
                        </span>
                    @endif
                </div>

                <h1 class="section-title mb-3" style="font-size:clamp(1.8rem, 3.5vw, 2.6rem); color:#fff;">
                    {{ $roteiro->titulo }}
                </h1>
                <p style="color:rgba(255,255,255,0.85); font-size:1.02rem; line-height:1.6; max-width:650px;">
                    {{ $roteiro->descricao }}
                </p>

                <!-- Pontos de Partida e Chegada -->
                <div class="d-flex flex-wrap gap-4 text-white text-opacity-90 small mt-3 pt-3 border-top border-white border-opacity-10">
                    <div>
                        <strong class="text-warning d-block" style="font-size:0.75rem; text-transform:uppercase;">Ponto de Partida</strong>
                        <span><i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $roteiro->ponto_partida ?? 'Centro Histórico' }}</span>
                    </div>
                    <div>
                        <strong class="text-warning d-block" style="font-size:0.75rem; text-transform:uppercase;">Ponto de Chegada</strong>
                        <span><i class="bi bi-flag-fill text-success me-1"></i>{{ $roteiro->ponto_chegada ?? 'Mirante da Serra' }}</span>
                    </div>
                </div>
            </div>

            <!-- Card de Ações Rápidas -->
            <div class="col-lg-4">
                <div class="p-3 bg-white bg-opacity-10 rounded-4 border border-white border-opacity-15 backdrop-blur">
                    <div class="row g-2 text-center text-white mb-3">
                        <div class="col-4">
                            <div class="p-2 rounded-3 bg-dark bg-opacity-25">
                                <small class="text-muted d-block" style="font-size:0.7rem;">Duração</small>
                                <strong>{{ $roteiro->tempo_formatado }}</strong>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded-3 bg-dark bg-opacity-25">
                                <small class="text-muted d-block" style="font-size:0.7rem;">Distância</small>
                                <strong>{{ $roteiro->distancia_formatada }}</strong>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded-3 bg-dark bg-opacity-25">
                                <small class="text-muted d-block" style="font-size:0.7rem;">Dificuldade</small>
                                <strong style="font-size:0.8rem;">{{ $roteiro->nivel_dificuldade_label }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        <button class="btn btn-pite w-100 rounded-3 fw-semibold" id="btnSalvarOffline">
                            <i class="bi bi-cloud-arrow-down me-2"></i> Salvar Roteiro Offline
                        </button>
                        <button class="btn btn-outline-light w-100 rounded-3 fw-semibold btn-print-hide" onclick="window.print();">
                            <i class="bi bi-printer me-2"></i> Imprimir Guia / Exportar PDF
                        </button>
                    </div>
                    <small class="d-block text-center text-white text-opacity-60 mt-2" style="font-size:0.72rem;" id="offlineStatusMsg">
                        Disponível mesmo sem conexão nas trilhas.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ═══ CONTEÚDO PRINCIPAL ═══ -->
<div class="container py-4">
    <div class="row g-4">

        <!-- Coluna Esquerda: Mapa Interativo com Rota traçada + GPS -->
        <div class="col-lg-7">
            <!-- Bloco do Mapa -->
            <div class="info-card mb-4 p-0 overflow-hidden">
                <div class="p-3 d-flex justify-content-between align-items-center bg-light border-bottom">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark" style="font-family:'Outfit';">
                            <i class="bi bi-map-fill text-success me-1"></i> Mapa Interativo do Percurso
                        </h6>
                        <small class="text-muted">Traçado da rota com {{ $roteiro->atrativos->count() }} paradas programadas</small>
                    </div>
                    <!-- Botão GPS em Tempo Real -->
                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold" id="btnGpsTracker">
                        <i class="bi bi-crosshair me-1"></i> Minha Posição (GPS)
                    </button>
                </div>
                <div class="map-route-wrapper">
                    <div id="mapa-roteiro" style="height: 440px; width: 100%;"></div>
                </div>
                <div class="p-3 bg-light border-top d-flex justify-content-between align-items-center small text-muted" style="font-size:0.8rem;">
                    <span><i class="bi bi-info-circle text-primary me-1"></i> Clique nos marcadores numerados para ver detalhes de cada ponto.</span>
                    <span id="gpsDistanceInfo" class="fw-bold text-primary"></span>
                </div>
            </div>

            <!-- Player de Audiodescrição Universal (Seção 6) -->
            <div class="audio-player-box mb-4" id="audioPlayerBox">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px; height:36px; background:rgba(255,255,255,0.2);">
                            <i class="bi bi-soundwave fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0" style="font-family:'Outfit';">Audiodescrição Inteligente</h6>
                            <small class="text-white text-opacity-75">Acessibilidade universal com narração do roteiro</small>
                        </div>
                    </div>
                    <span class="badge bg-light text-dark rounded-pill px-3 py-1 small">Voz Português (BR)</span>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-warning rounded-circle" id="btnPlayAudio" style="width:44px; height:44px;">
                        <i class="bi bi-play-fill fs-5"></i>
                    </button>
                    <button class="btn btn-outline-light rounded-circle" id="btnPauseAudio" style="width:44px; height:44px;">
                        <i class="bi bi-pause-fill fs-5"></i>
                    </button>
                    <button class="btn btn-outline-light rounded-circle" id="btnStopAudio" style="width:44px; height:44px;">
                        <i class="bi bi-stop-fill fs-5"></i>
                    </button>
                    <div class="ms-2 flex-grow-1">
                        <small class="d-block text-white text-opacity-80" id="audioStatusText">Pronto para narrar o trajeto completo.</small>
                        <div class="progress mt-1" style="height: 4px; background: rgba(255,255,255,0.2);">
                            <div class="progress-bar bg-warning" id="audioProgressBar" style="width: 0%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ficha Técnica de Características do Percurso -->
            <div class="info-card mb-4">
                <h5 class="fw-bold mb-3" style="font-family:'Outfit';"><i class="bi bi-geo text-danger me-2"></i>Características do Percurso</h5>
                @php $caract = $roteiro->caracteristicas_percurso ?? []; @endphp
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <strong class="d-block small text-dark mb-1"><i class="bi bi-graph-up text-success me-1"></i> Relevo e Terreno</strong>
                            <span class="small text-muted">{{ $caract['relevo'] ?? 'Relevo predominantemente plano e acessível' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <strong class="d-block small text-dark mb-1"><i class="bi bi-border-style text-primary me-1"></i> Pavimentação e Piso</strong>
                            <span class="small text-muted">{{ $caract['pavimentacao'] ?? 'Calçadão e piso com guia tátil' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <strong class="d-block small text-dark mb-1"><i class="bi bi-tree text-success me-1"></i> Sombreamento</strong>
                            <span class="small text-muted">{{ $caract['sombreamento'] ?? 'Áreas sombreadas e praças ao longo do trajeto' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <strong class="d-block small text-dark mb-1"><i class="bi bi-bicycle text-warning me-1"></i> Tipo de Deslocamento</strong>
                            <span class="small text-muted">{{ $roteiro->meio_transporte_label }} · {{ $roteiro->faixa_etaria }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Serviços Disponíveis ao Longo do Caminho -->
            <div class="info-card mb-4">
                <h5 class="fw-bold mb-3" style="font-family:'Outfit';"><i class="bi bi-hospital text-primary me-2"></i>Serviços no Trajeto</h5>
                @php $servicos = $roteiro->servicos_disponiveis ?? []; @endphp
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-droplet-fill text-info fs-5 mt-1"></i>
                            <div>
                                <strong class="d-block small text-dark">Pontos de Água / Hidratação</strong>
                                <span class="small text-muted">{{ is_array($servicos['pontos_agua'] ?? null) ? implode(', ', $servicos['pontos_agua']) : 'Bebedouros públicos nas praças e estabelecimentos' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-door-closed-fill text-secondary fs-5 mt-1"></i>
                            <div>
                                <strong class="d-block small text-dark">Sanitários Públicos / Adaptados</strong>
                                <span class="small text-muted">{{ is_array($servicos['banheiros'] ?? null) ? implode(', ', $servicos['banheiros']) : 'Sanitários acessíveis PNE nos pontos de parada' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-egg-fried text-warning fs-5 mt-1"></i>
                            <div>
                                <strong class="d-block small text-dark">Alimentação & Gastronomia</strong>
                                <span class="small text-muted">{{ is_array($servicos['alimentacao'] ?? null) ? implode(', ', $servicos['alimentacao']) : 'Restaurantes típicos e lanchonetes credenciadas' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-heart-pulse-fill text-danger fs-5 mt-1"></i>
                            <div>
                                <strong class="d-block small text-dark">Postos de Saúde & Emergência</strong>
                                <span class="small text-muted">{{ is_array($servicos['postos_saude'] ?? null) ? implode(', ', $servicos['postos_saude']) : 'UPA 24h e suporte da rede municipal de saúde' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna Direita: Timeline Passo a Passo + Segurança & Emergência -->
        <div class="col-lg-5">

            <!-- Linha do Tempo Ordenada de Visitação -->
            <div class="info-card mb-4" id="ordemVisitacaoCard">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h5 class="fw-bold mb-0" style="font-family:'Outfit';"><i class="bi bi-list-ol text-success me-2"></i>Ordem Sugerida de Visitação</h5>
                    <button class="btn btn-sm btn-outline-success rounded-pill px-3" id="btnEditarOrdem">
                        <i class="bi bi-pencil-square me-1"></i> Editar Ordem
                    </button>
                </div>
                <p class="small text-muted mb-2">Sequência otimizada geograficamente para minimizar deslocamentos</p>

                <!-- Toolbar de Edição (oculta por padrão) -->
                <div class="timeline-edit-toolbar mb-3" id="editToolbar">
                    <button class="btn btn-sm btn-success rounded-pill px-3" id="btnAdicionarPonto">
                        <i class="bi bi-plus-circle me-1"></i> Adicionar Ponto
                    </button>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" id="btnResetarOrdem">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Resetar Original
                    </button>
                    <small class="text-muted d-flex align-items-center ms-auto"><i class="bi bi-grip-vertical me-1"></i> Arraste para reordenar</small>
                </div>

                <div class="timeline-full" id="timelineSortable">
                    @forelse($roteiro->atrativos as $index => $atrativo)
                    <div class="timeline-full-step" id="step-card-{{ $atrativo->id }}" data-atrativo-id="{{ $atrativo->id }}" data-lat="{{ $atrativo->latitude }}" data-lng="{{ $atrativo->longitude }}">
                        <div class="step-pin step-pin-num">{{ $index + 1 }}</div>
                        <span class="drag-handle-badge" title="Clique e arraste este card para reordenar">
                            <i class="bi bi-grip-vertical fs-6"></i> Arraste
                        </span>
                        <div class="card border-0 bg-light rounded-3 p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1 pe-4">
                                <span class="badge bg-success-subtle text-success fw-bold" style="font-size:0.72rem;">
                                    ⏱️ Parada: {{ $atrativo->pivot->tempo_estimado ?? '45min' }}
                                </span>
                                @if(!empty($atrativo->niveis_acessibilidade['cadeirante']))
                                    <span class="badge bg-light text-muted border" style="font-size:0.68rem;">♿ PNE</span>
                                @endif
                            </div>
                            <h6 class="fw-bold mb-1" style="font-family:'Outfit';">
                                <a href="{{ route('portal.atrativos.show', $atrativo->slug) }}" target="_blank" class="text-dark text-decoration-none hover-emerald">
                                    {{ $atrativo->nome }}
                                </a>
                            </h6>
                            <p class="small text-muted mb-2" style="font-size:0.84rem; line-height:1.5;">
                                {{ $atrativo->descricao_curta ?? Str::limit($atrativo->descricao, 110) }}
                            </p>
                            @if($atrativo->pivot->observacao)
                                <div class="p-2 rounded-2 bg-white text-dark small mb-2" style="font-size:0.78rem; border-left:3px solid var(--pite-emerald);">
                                    <i class="bi bi-lightbulb text-warning me-1"></i> {{ $atrativo->pivot->observacao }}
                                </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                <small class="text-muted" style="font-size:0.75rem;"><i class="bi bi-pin-map text-danger me-1"></i>{{ $atrativo->endereco ?? 'Centro' }}</small>
                                <a href="{{ route('portal.atrativos.show', $atrativo->slug) }}" target="_blank" class="small text-success fw-bold text-decoration-none">
                                    Ver Ficha <i class="bi bi-arrow-up-right"></i>
                                </a>
                            </div>

                            <!-- Botões de Reordenação e Remoção no Modo Edição -->
                            <div class="btn-step-actions justify-content-end align-items-center">
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-0 btn-move-up" style="font-size:0.72rem;" title="Mover para cima">
                                    <i class="bi bi-arrow-up me-1"></i>Subir
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-0 btn-move-down" style="font-size:0.72rem;" title="Mover para baixo">
                                    <i class="bi bi-arrow-down me-1"></i>Descer
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-0 btn-remove-step ms-auto" style="font-size:0.72rem;" title="Remover parada">
                                    <i class="bi bi-trash me-1"></i>Remover
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted small">Nenhum atrativo associado a este roteiro.</p>
                    @endforelse
                </div>
            </div>

            <!-- Modal Adicionar Ponto -->
            <div class="modal fade" id="modalAdicionarPonto" tabindex="-1">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content rounded-4 border-0 shadow">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title fw-bold" style="font-family:'Outfit';"><i class="bi bi-plus-circle text-success me-2"></i>Adicionar Ponto ao Roteiro</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" class="form-control form-control-sm rounded-3 mb-3" id="buscaAddPonto" placeholder="🔍 Buscar atrativo por nome...">
                            <div id="listaAtrativosAdd" class="d-flex flex-column gap-2" style="max-height: 360px; overflow-y: auto;"></div>
                            <div id="loadingAtrativos" class="text-center py-4 text-muted">
                                <span class="spinner-border spinner-border-sm me-1"></span> Carregando atrativos...
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orientações de Segurança & Contatos de Emergência -->
            <div class="info-card mb-4" style="border-left: 4px solid #f43f5e;">
                <h5 class="fw-bold mb-2 text-danger" style="font-family:'Outfit';"><i class="bi bi-shield-exclamation me-2"></i>Orientações de Segurança</h5>
                @php $seg = $roteiro->orientacoes_seguranca ?? []; @endphp

                <ul class="list-unstyled small text-muted d-flex flex-column gap-2 mb-3">
                    <li><strong class="text-dark"><i class="bi bi-person-walking text-success me-1"></i> Vestuário:</strong> {{ $seg['vestuario'] ?? 'Roupas leves e calçados confortáveis para caminhada.' }}</li>
                    <li><strong class="text-dark"><i class="bi bi-cup-straw text-primary me-1"></i> Hidratação:</strong> {{ $seg['hidratacao'] ?? 'Leve garrafa de água e hidrate-se com frequência.' }}</li>
                    <li><strong class="text-dark"><i class="bi bi-sun text-warning me-1"></i> Proteção Solar:</strong> {{ $seg['sol'] ?? 'Utilize protetor solar, óculos e chapéu nos trechos abertos.' }}</li>
                    <li><strong class="text-dark"><i class="bi bi-clock-history text-secondary me-1"></i> Melhor Horário:</strong> {{ $seg['melhor_horario'] ?? 'Manhãs das 08h30 às 11h30 ou fins de tarde.' }}</li>
                </ul>

                <div class="p-3 bg-danger bg-opacity-10 rounded-3 text-dark small">
                    <strong class="d-block text-danger mb-2"><i class="bi bi-telephone-fill me-1"></i> Telefones Oficiais de Socorro / Emergência:</strong>
                    <div class="row g-2" style="font-size:0.8rem;">
                        <div class="col-6">🚓 <strong>Polícia Militar:</strong> 190</div>
                        <div class="col-6">🚑 <strong>SAMU:</strong> 192</div>
                        <div class="col-6">🚒 <strong>Bombeiros:</strong> 193</div>
                        <div class="col-6">🛡️ <strong>Defesa Civil:</strong> 199</div>
                        <div class="col-12 mt-1">🏛️ <strong>Secretaria de Turismo:</strong> (83) 3333-0000</div>
                    </div>
                </div>
            </div>

            <!-- Transparência de IA & Supervisão Humana -->
            <div class="p-3 bg-light rounded-4 border small text-muted">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-patch-check-fill text-success fs-5"></i>
                    <strong class="text-dark">Selo de Transparência & Dados Oficiais</strong>
                </div>
                <p class="mb-0" style="font-size:0.75rem; line-height:1.5;">
                    {{ $roteiro->resumo_ia ?? 'Roteiro estruturado e validado pelo município. O uso de inteligência artificial ocorre sob estrita supervisão humana e observância da LGPD.' }}
                </p>
            </div>
        </div>
    </div>
</div>

<div style="height: 60px;"></div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let atrativosData = @json($atrativosMapData);
    const polylineCoords = @json($roteiro->polylines_coordenadas ?? []);
    const todosAtrativosDisponiveis = @json($todosAtrativos ?? []);

    if (atrativosData.length === 0) return;

    // 1. Inicialização do Mapa Leaflet
    const defaultLat = atrativosData[0].lat || -22.7394;
    const defaultLng = atrativosData[0].lng || -45.5913;

    const map = L.map('mapa-roteiro').setView([defaultLat, defaultLng], 14);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap | System-PITE'
    }).addTo(map);

    const markersGroup = L.featureGroup().addTo(map);
    let polyline = null;

    // Função para renderizar os marcadores e a linha de rota no mapa
    function renderMapRoute(currentPoints) {
        markersGroup.clearLayers();
        if (polyline) map.removeLayer(polyline);

        const coordsArray = [];

        currentPoints.forEach((at, index) => {
            coordsArray.push([at.lat, at.lng]);
            const ordemNum = index + 1;

            const iconHtml = `
                <div style="width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg, #047857, #0d9488); border:3px solid #fff; box-shadow:0 4px 12px rgba(0,0,0,0.35); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:14px; font-family:'Outfit', sans-serif;">
                    ${ordemNum}
                </div>
            `;

            const customIcon = L.divIcon({
                className: 'numbered-pin',
                html: iconHtml,
                iconSize: [34, 34],
                iconAnchor: [17, 17],
                popupAnchor: [0, -18]
            });

            const marker = L.marker([at.lat, at.lng], { icon: customIcon });
            marker.bindPopup(`
                <div style="min-width:200px; font-family:'Inter', sans-serif;">
                    <span class="badge bg-success mb-1">Parada ${ordemNum}</span>
                    <h6 style="font-family:'Outfit'; font-weight:700; margin:4px 0;">${at.nome}</h6>
                    <p style="font-size:12px; color:#64748b; margin-bottom:8px;">${at.descricao || ''}</p>
                    ${at.tempo_estimado ? `<div style="font-size:11px; margin-bottom:6px;">⏱️ Tempo sugerido: <strong>${at.tempo_estimado}</strong></div>` : ''}
                    <a href="${at.url || '#'}" target="_blank" class="btn btn-sm btn-success w-100 py-1" style="font-size:11px;">Ver Detalhes</a>
                </div>
            `);

            markersGroup.addLayer(marker);
        });

        if (coordsArray.length > 0) {
            polyline = L.polyline(coordsArray, {
                color: '#047857',
                weight: 5,
                opacity: 0.85,
                dashArray: '8, 8',
                lineJoin: 'round'
            }).addTo(map);

            map.fitBounds(markersGroup.getBounds().pad(0.2));
        }
    }

    // Renderização Inicial do Mapa
    renderMapRoute(atrativosData);

    // 2. Drag and Drop SortableJS na Timeline
    const timelineContainer = document.getElementById('timelineSortable');
    const initialTimelineHTML = timelineContainer ? timelineContainer.innerHTML : '';
    let sortableInstance = null;

    if (timelineContainer && typeof Sortable !== 'undefined') {
        sortableInstance = new Sortable(timelineContainer, {
            animation: 250,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            filter: 'a, button, .btn, input',
            preventOnFilter: false,
            fallbackTolerance: 3,
            touchStartThreshold: 3,
            onEnd: function() {
                atualizarOrdemERota();
            }
        });
    }

    // Atualiza pins, lista interna e a rota no mapa
    function atualizarOrdemERota() {
        if (!timelineContainer) return;
        const stepElements = timelineContainer.querySelectorAll('.timeline-full-step');
        const novosPontos = [];

        stepElements.forEach((step, index) => {
            const numPin = step.querySelector('.step-pin-num');
            if (numPin) numPin.textContent = index + 1;

            const lat = parseFloat(step.dataset.lat);
            const lng = parseFloat(step.dataset.lng);
            const nomeElement = step.querySelector('h6 a');
            const nome = nomeElement ? nomeElement.textContent.trim() : 'Ponto ' + (index + 1);
            const url = nomeElement ? nomeElement.getAttribute('href') : '#';
            const descElement = step.querySelector('p');
            const descricao = descElement ? descElement.textContent.trim() : '';

            if (!isNaN(lat) && !isNaN(lng)) {
                novosPontos.push({
                    id: step.dataset.atrativoId,
                    lat: lat,
                    lng: lng,
                    nome: nome,
                    descricao: descricao,
                    url: url
                });
            }
        });

        atrativosData = novosPontos;
        renderMapRoute(novosPontos);
    }

    // Botão Alternar Modo Edição
    const btnEditar = document.getElementById('btnEditarOrdem');
    const editToolbar = document.getElementById('editToolbar');
    const ordemCard = document.getElementById('ordemVisitacaoCard');
    let modoEdicao = false;

    if (btnEditar) {
        btnEditar.addEventListener('click', function() {
            modoEdicao = !modoEdicao;
            if (modoEdicao) {
                ordemCard.classList.add('timeline-editing');
                editToolbar.classList.add('active');
                btnEditar.classList.remove('btn-outline-success');
                btnEditar.classList.add('btn-success');
                btnEditar.innerHTML = '<i class="bi bi-check-lg me-1"></i> Concluir Edição';
            } else {
                ordemCard.classList.remove('timeline-editing');
                editToolbar.classList.remove('active');
                btnEditar.classList.remove('btn-success');
                btnEditar.classList.add('btn-outline-success');
                btnEditar.innerHTML = '<i class="bi bi-pencil-square me-1"></i> Editar Ordem';
            }
        });
    }

    // Controles de Reordenação por Botões (Subir, Descer) e Remoção da timeline
    if (timelineContainer) {
        timelineContainer.addEventListener('click', function(e) {
            const moveUpBtn = e.target.closest('.btn-move-up');
            const moveDownBtn = e.target.closest('.btn-move-down');
            const removeBtn = e.target.closest('.btn-remove-step');

            if (moveUpBtn) {
                const step = moveUpBtn.closest('.timeline-full-step');
                const prevStep = step ? step.previousElementSibling : null;
                if (step && prevStep && prevStep.classList.contains('timeline-full-step')) {
                    timelineContainer.insertBefore(step, prevStep);
                    atualizarOrdemERota();
                }
            } else if (moveDownBtn) {
                const step = moveDownBtn.closest('.timeline-full-step');
                const nextStep = step ? step.nextElementSibling : null;
                if (step && nextStep && nextStep.classList.contains('timeline-full-step')) {
                    timelineContainer.insertBefore(nextStep, step);
                    atualizarOrdemERota();
                }
            } else if (removeBtn) {
                const step = removeBtn.closest('.timeline-full-step');
                if (step) {
                    step.remove();
                    atualizarOrdemERota();
                }
            }
        });
    }

    // Resetar para a Ordem Original
    const btnResetar = document.getElementById('btnResetarOrdem');
    if (btnResetar) {
        btnResetar.addEventListener('click', function() {
            if (timelineContainer && initialTimelineHTML) {
                timelineContainer.innerHTML = initialTimelineHTML;
                atualizarOrdemERota();
            }
        });
    }

    // Modal Adicionar Ponto
    const btnAdicionarPonto = document.getElementById('btnAdicionarPonto');
    const modalEl = document.getElementById('modalAdicionarPonto');
    const modalAdicionarPonto = modalEl ? new bootstrap.Modal(modalEl) : null;
    const listaAtrativosAdd = document.getElementById('listaAtrativosAdd');
    const loadingAtrativos = document.getElementById('loadingAtrativos');
    const buscaAddPonto = document.getElementById('buscaAddPonto');

    if (btnAdicionarPonto && modalAdicionarPonto) {
        btnAdicionarPonto.addEventListener('click', function() {
            modalAdicionarPonto.show();
            carregarAtrativosParaAdicionar();
        });
    }

    function carregarAtrativosParaAdicionar(filtro = '') {
        if (!listaAtrativosAdd) return;
        if (loadingAtrativos) loadingAtrativos.style.display = 'none';
        listaAtrativosAdd.innerHTML = '';

        const idsNaTimeline = Array.from(timelineContainer.querySelectorAll('.timeline-full-step'))
            .map(el => String(el.dataset.atrativoId));

        const filtrados = todosAtrativosDisponiveis.filter(at => {
            return !filtro || at.nome.toLowerCase().includes(filtro.toLowerCase()) || (at.endereco && at.endereco.toLowerCase().includes(filtro.toLowerCase()));
        });

        if (filtrados.length === 0) {
            listaAtrativosAdd.innerHTML = '<div class="text-center text-muted py-3 small">Nenhum atrativo encontrado.</div>';
            return;
        }

        filtrados.forEach(at => {
            const jaAdicionado = idsNaTimeline.includes(String(at.id));
            const div = document.createElement('div');
            div.className = 'p-3 bg-light rounded-3 border d-flex justify-content-between align-items-center';
            div.innerHTML = `
                <div>
                    <h6 class="fw-bold mb-0 text-dark" style="font-size:0.9rem;">${at.nome}</h6>
                    <small class="text-muted" style="font-size:0.78rem;">📍 ${at.endereco}</small>
                </div>
                <button class="btn btn-sm ${jaAdicionado ? 'btn-outline-secondary' : 'btn-success'} rounded-pill px-3 btn-add-this" ${jaAdicionado ? 'disabled' : ''} data-id="${at.id}">
                    ${jaAdicionado ? 'Adicionado' : '<i class="bi bi-plus"></i> Adicionar'}
                </button>
            `;

            div.querySelector('.btn-add-this')?.addEventListener('click', function() {
                adicionarAtrativoNaTimeline(at);
                this.disabled = true;
                this.textContent = 'Adicionado';
                this.className = 'btn btn-sm btn-outline-secondary rounded-pill px-3';
            });

            listaAtrativosAdd.appendChild(div);
        });
    }

    if (buscaAddPonto) {
        buscaAddPonto.addEventListener('input', function() {
            carregarAtrativosParaAdicionar(this.value.trim());
        });
    }

    function adicionarAtrativoNaTimeline(at) {
        if (!timelineContainer) return;
        const totalSteps = timelineContainer.querySelectorAll('.timeline-full-step').length + 1;
        const stepDiv = document.createElement('div');
        stepDiv.className = 'timeline-full-step';
        stepDiv.id = `step-card-${at.id}`;
        stepDiv.dataset.atrativoId = at.id;
        stepDiv.dataset.lat = at.lat;
        stepDiv.dataset.lng = at.lng;

        stepDiv.innerHTML = `
            <div class="step-pin step-pin-num">${totalSteps}</div>
            <span class="drag-handle-badge" title="Clique e arraste este card para reordenar">
                <i class="bi bi-grip-vertical fs-6"></i> Arraste
            </span>
            <div class="card border-0 bg-light rounded-3 p-3">
                <div class="d-flex justify-content-between align-items-start mb-1 pe-4">
                    <span class="badge bg-success-subtle text-success fw-bold" style="font-size:0.72rem;">
                        ⏱️ Parada: 45min
                    </span>
                    ${at.acessivel ? '<span class="badge bg-light text-muted border" style="font-size:0.68rem;">♿ PNE</span>' : ''}
                </div>
                <h6 class="fw-bold mb-1" style="font-family:'Outfit';">
                    <a href="${at.url}" target="_blank" class="text-dark text-decoration-none hover-emerald">
                        ${at.nome}
                    </a>
                </h6>
                <p class="small text-muted mb-2" style="font-size:0.84rem; line-height:1.5;">
                    ${at.descricao}
                </p>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <small class="text-muted" style="font-size:0.75rem;"><i class="bi bi-pin-map text-danger me-1"></i>${at.endereco}</small>
                    <a href="${at.url}" target="_blank" class="small text-success fw-bold text-decoration-none">
                        Ver Ficha <i class="bi bi-arrow-up-right"></i>
                    </a>
                </div>

                <!-- Botões de Reordenação e Remoção no Modo Edição -->
                <div class="btn-step-actions justify-content-end align-items-center">
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-0 btn-move-up" style="font-size:0.72rem;" title="Mover para cima">
                        <i class="bi bi-arrow-up me-1"></i>Subir
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-0 btn-move-down" style="font-size:0.72rem;" title="Mover para baixo">
                        <i class="bi bi-arrow-down me-1"></i>Descer
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-0 btn-remove-step ms-auto" style="font-size:0.72rem;" title="Remover parada">
                        <i class="bi bi-trash me-1"></i>Remover
                    </button>
                </div>
            </div>
        `;

        timelineContainer.appendChild(stepDiv);
        atualizarOrdemERota();
    }

    // 2. GPS em Tempo Real — Alta Precisão
    let userMarker = null;
    let userAccuracyCircle = null;
    let watchId = null;
    let gpsCentered = false;
    const gpsBtn = document.getElementById('btnGpsTracker');
    const gpsDistanceInfo = document.getElementById('gpsDistanceInfo');

    if (gpsBtn) {
        gpsBtn.addEventListener('click', function() {
            if (!navigator.geolocation) {
                alert('Geolocalização não suportada no seu navegador.');
                return;
            }

            if (watchId) {
                navigator.geolocation.clearWatch(watchId);
                watchId = null;
                gpsCentered = false;
                if (userMarker) { map.removeLayer(userMarker); userMarker = null; }
                if (userAccuracyCircle) { map.removeLayer(userAccuracyCircle); userAccuracyCircle = null; }
                gpsBtn.classList.remove('btn-primary');
                gpsBtn.classList.add('btn-outline-primary');
                gpsBtn.innerHTML = '<i class="bi bi-crosshair me-1"></i> Minha Posição (GPS)';
                gpsDistanceInfo.textContent = '';
                return;
            }

            gpsBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Obtendo sinal GPS...';

            watchId = navigator.geolocation.watchPosition(
                function(pos) {
                    const uLat = pos.coords.latitude;
                    const uLng = pos.coords.longitude;
                    const accuracy = pos.coords.accuracy; // metros

                    // Criar ou atualizar marcador do usuário
                    if (!userMarker) {
                        const userIcon = L.divIcon({
                            className: 'user-gps-pin',
                            html: `<div class="pulse-gps" style="width:22px; height:22px; border-radius:50%; background:#0ea5e9; border:3px solid #fff; box-shadow:0 0 12px rgba(14,165,233,0.8);"></div>`,
                            iconSize: [22, 22],
                            iconAnchor: [11, 11]
                        });
                        userMarker = L.marker([uLat, uLng], { icon: userIcon, zIndexOffset: 1000 }).addTo(map);
                        userMarker.bindTooltip('Você está aqui!', { permanent: true, direction: 'top', offset: [0, -14] });
                    } else {
                        userMarker.setLatLng([uLat, uLng]);
                    }

                    // Círculo de precisão (raio = accuracy em metros)
                    if (!userAccuracyCircle) {
                        userAccuracyCircle = L.circle([uLat, uLng], {
                            radius: accuracy,
                            color: '#0ea5e9',
                            fillColor: '#0ea5e9',
                            fillOpacity: 0.1,
                            weight: 1.5,
                            dashArray: '4,4'
                        }).addTo(map);
                    } else {
                        userAccuracyCircle.setLatLng([uLat, uLng]);
                        userAccuracyCircle.setRadius(accuracy);
                    }

                    // Centralizar mapa na primeira leitura de boa qualidade
                    if (!gpsCentered) {
                        map.setView([uLat, uLng], 16, { animate: true });
                        gpsCentered = true;
                    }

                    // Indicador de precisão no botão
                    const precIcon = accuracy <= 30 ? '🟢' : accuracy <= 100 ? '🟡' : '🟠';
                    gpsBtn.classList.remove('btn-outline-primary');
                    gpsBtn.classList.add('btn-primary');
                    gpsBtn.innerHTML = `<i class="bi bi-geo-alt-fill me-1"></i> GPS Ativo ${precIcon} ±${Math.round(accuracy)}m`;

                    // Calcular distância até a parada MAIS PRÓXIMA
                    let nearest = null;
                    let nearestDist = Infinity;
                    atrativosData.forEach(p => {
                        const d = calcularDistancia(uLat, uLng, p.lat, p.lng);
                        if (d < nearestDist) { nearestDist = d; nearest = p; }
                    });

                    if (nearest) {
                        const distTxt = nearestDist < 1
                            ? `${Math.round(nearestDist * 1000)}m`
                            : `${nearestDist.toFixed(1)} km`;
                        gpsDistanceInfo.textContent = `📍 Parada mais próxima: ${nearest.nome} (${distTxt})`;
                    }
                },
                function(err) {
                    gpsBtn.innerHTML = '<i class="bi bi-crosshair me-1"></i> Minha Posição (GPS)';
                    const msgs = {
                        1: 'Permissão de localização negada. Habilite nas configurações do navegador.',
                        2: 'Posição indisponível. Tente em local aberto ou conecte-se a uma rede Wi-Fi.',
                        3: 'Tempo esgotado ao obter localização. Tente novamente.'
                    };
                    alert(msgs[err.code] || 'Erro ao obter localização GPS.');
                },
                { enableHighAccuracy: true, timeout: 15000, maximumAge: 5000 }
            );
        });
    }

    function calcularDistancia(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLon/2) * Math.sin(dLon/2);
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    }

    // 3. Audiodescrição Text-to-Speech (Seção 6)
    const btnPlay = document.getElementById('btnPlayAudio');
    const btnPause = document.getElementById('btnPauseAudio');
    const btnStop = document.getElementById('btnStopAudio');
    const statusText = document.getElementById('audioStatusText');
    const progressBar = document.getElementById('audioProgressBar');

    let speech = null;
    let isPlaying = false;

    const textoNaracao = `Roteiro Turístico: ${@json($roteiro->titulo)}. ${@json($roteiro->descricao)}. Duração estimada: ${@json($roteiro->tempo_formatado)}. Distância total: ${@json($roteiro->distancia_formatada)}. Este roteiro possui ${atrativosData.length} paradas. ` +
        atrativosData.map(a => `Parada ${a.ordem}: ${a.nome}. ${a.descricao}. Tempo sugerido: ${a.tempo_estimado}. `).join(' ') +
        `Orientações de segurança: ${@json($roteiro->orientacoes_seguranca['vestuario'] ?? '')}. Em caso de emergência, ligue 190 para a Polícia Militar ou 192 para o SAMU. Boa viagem!`;

    if ('speechSynthesis' in window) {
        btnPlay?.addEventListener('click', function() {
            if (speechSynthesis.paused && isPlaying) {
                speechSynthesis.resume();
                statusText.textContent = '▶️ Reproduzindo audiodescrição...';
                return;
            }

            speechSynthesis.cancel();
            speech = new SpeechSynthesisUtterance(textoNaracao);
            speech.lang = 'pt-BR';
            speech.rate = 1.0;

            speech.onstart = function() {
                isPlaying = true;
                statusText.textContent = '🔊 Narrando roteiro turístico acessível...';
                progressBar.style.width = '50%';
            };

            speech.onend = function() {
                isPlaying = false;
                statusText.textContent = '✅ Audiodescrição concluída com sucesso.';
                progressBar.style.width = '100%';
                setTimeout(() => progressBar.style.width = '0%', 3000);
            };

            speechSynthesis.speak(speech);
        });

        btnPause?.addEventListener('click', function() {
            if (speechSynthesis.speaking && !speechSynthesis.paused) {
                speechSynthesis.pause();
                statusText.textContent = '⏸️ Áudio pausado.';
            }
        });

        btnStop?.addEventListener('click', function() {
            speechSynthesis.cancel();
            isPlaying = false;
            statusText.textContent = '⏹️ Narração interrompida.';
            progressBar.style.width = '0%';
        });
    }

    // 4. Salvar Roteiro Offline no LocalStorage (Seção 5)
    const btnOffline = document.getElementById('btnSalvarOffline');
    const offlineMsg = document.getElementById('offlineStatusMsg');

    if (btnOffline) {
        btnOffline.addEventListener('click', function() {
            btnOffline.disabled = true;
            btnOffline.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Salvando dados no dispositivo...';

            fetch('{{ route("api.roteiros.offline-data", $roteiro->id) }}')
                .then(r => r.json())
                .then(data => {
                    btnOffline.disabled = false;
                    btnOffline.innerHTML = '<i class="bi bi-check2-circle me-2"></i> Roteiro Salvo Offline!';
                    btnOffline.classList.remove('btn-pite');
                    btnOffline.classList.add('btn-success');

                    // Armazenar no LocalStorage
                    const offlineKey = 'system_pite_roteiro_' + {{ $roteiro->id }};
                    localStorage.setItem(offlineKey, JSON.stringify(data));

                    // Salvar na lista de roteiros baixados
                    let lista = JSON.parse(localStorage.getItem('system_pite_offline_lista') || '[]');
                    if (!lista.some(item => item.id === {{ $roteiro->id }})) {
                        lista.push({
                            id: {{ $roteiro->id }},
                            slug: '{{ $roteiro->slug }}',
                            titulo: '{{ $roteiro->titulo }}',
                            tempo: '{{ $roteiro->tempo_formatado }}',
                            distancia: '{{ $roteiro->distancia_formatada }}',
                            salvo_em: new Date().toLocaleString()
                        });
                        localStorage.setItem('system_pite_offline_lista', JSON.stringify(lista));
                    }

                    offlineMsg.innerHTML = '<span class="text-success fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Roteiro 100% pronto para uso em trilhas sem sinal!</span>';
                })
                .catch(err => {
                    btnOffline.disabled = false;
                    btnOffline.innerHTML = '<i class="bi bi-cloud-arrow-down me-2"></i> Salvar Roteiro Offline';
                    alert('Erro ao salvar roteiro para modo offline.');
                });
        });
    }
});
</script>
@endpush

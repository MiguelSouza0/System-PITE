@extends('layouts.app')
@section('title', 'Roteiros Turísticos Inteligentes — System-PITE')

@push('styles')
<style>
    .roteiros-hero {
        background: linear-gradient(160deg, #0f172a 0%, #1e1b4b 40%, #312e81 80%, #4338ca 100%);
        padding: 56px 0 36px;
        position: relative;
        overflow: hidden;
        color: #fff;
    }
    .roteiros-hero::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 550px; height: 550px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(245,158,11,0.15) 0%, transparent 70%);
        animation: float 7s ease-in-out infinite;
    }
    .roteiros-nav-pills .nav-link {
        color: #cbd5e1;
        font-weight: 600;
        font-family: 'Outfit', sans-serif;
        border-radius: 99px;
        padding: 10px 24px;
        transition: var(--pite-transition);
        border: 1px solid rgba(255,255,255,0.15);
        background: rgba(255,255,255,0.05);
    }
    .roteiros-nav-pills .nav-link.active {
        background: linear-gradient(135deg, var(--pite-emerald), var(--pite-teal));
        color: #fff;
        border-color: transparent;
        box-shadow: 0 4px 16px rgba(4,120,87,0.3);
    }
    .card-roteiro {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #f1f5f9;
        box-shadow: var(--pite-shadow);
        transition: var(--pite-transition);
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
    }
    .card-roteiro:hover {
        transform: translateY(-6px);
        box-shadow: var(--pite-shadow-lg);
        border-color: rgba(4,120,87,0.25);
    }
    .card-roteiro-header {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        padding: 20px 24px 16px;
        border-bottom: 1px solid #e2e8f0;
    }
    .card-roteiro-body {
        padding: 24px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .timeline-mini-step {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        position: relative;
        padding-bottom: 12px;
    }
    .timeline-mini-step:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 13px;
        top: 24px;
        bottom: 0;
        width: 2px;
        background: #e2e8f0;
    }
    .step-number {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: var(--pite-emerald);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.75rem;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(4,120,87,0.3);
    }
    .generator-panel {
        background: #fff;
        border-radius: 24px;
        padding: 36px;
        box-shadow: var(--pite-shadow-lg);
        border: 1px solid #e2e8f0;
    }
    .chip-choice {
        cursor: pointer;
        padding: 8px 16px;
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        font-size: 0.85rem;
        font-weight: 500;
        transition: var(--pite-transition);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        user-select: none;
    }
    .chip-choice:hover {
        border-color: var(--pite-emerald);
        background: rgba(4,120,87,0.04);
    }
    .chip-choice.active {
        border-color: var(--pite-emerald);
        background: rgba(4,120,87,0.1);
        color: var(--pite-emerald);
        font-weight: 700;
    }
    .chip-choice input[type="radio"], .chip-choice input[type="checkbox"] {
        display: none;
    }
    .filter-bar {
        background: #fff;
        border-radius: 16px;
        padding: 16px 20px;
        box-shadow: var(--pite-shadow);
        border: 1px solid #f1f5f9;
        margin-bottom: 32px;
    }
</style>
@endpush

@section('content')

<!-- ═══ HERO DOS ROTEIROS ═══ -->
<div class="roteiros-hero">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                    <span class="badge rounded-pill px-3 py-2" style="background: rgba(245,158,11,0.2); color:#fbbf24; font-weight:600;">
                        <i class="bi bi-stars me-1"></i> Módulo 5 · Roteiros Turísticos Inteligentes
                    </span>
                    <span class="badge rounded-pill px-3 py-2" style="background: rgba(16,185,129,0.2); color:#34d399; font-weight:600;">
                        <i class="bi bi-patch-check-fill me-1"></i> Base Oficial Validada
                    </span>
                </div>
                <h1 class="section-title mb-3" style="font-size: clamp(2rem, 4vw, 3rem); color:#fff;">
                    Roteiros Inteligentes & Personalizados
                </h1>
                <p style="color: rgba(255,255,255,0.8); max-width: 620px; font-size: 1.05rem; line-height: 1.6;">
                    Explore circuitos temáticos oficiais ou utilize nossa Inteligência Artificial para gerar rotas sob medida considerando seu tempo, orçamento, acessibilidade PNE e preferências — com suporte a mapas, GPS em tempo real e modo offline!
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('portal.roteiros.offline') }}" class="btn btn-outline-light rounded-pill px-4 py-2 fw-semibold">
                    <i class="bi bi-cloud-slash me-2"></i> Abrir Modo Offline
                </a>
            </div>
        </div>

        <!-- Abas de Navegação -->
        <ul class="nav roteiros-nav-pills mt-4 gap-2" id="roteirosTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="catalogo-tab" data-bs-toggle="tab" data-bs-target="#catalogo" type="button" role="tab">
                    <i class="bi bi-grid me-2"></i> Roteiros Oficiais & Predefinidos ({{ $roteirosProntos->total() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="gerador-tab" data-bs-toggle="tab" data-bs-target="#gerador" type="button" role="tab">
                    <i class="bi bi-magic me-2"></i> Gerador Personalizado com IA
                </button>
            </li>
        </ul>
    </div>
</div>

<div class="container py-4" style="margin-top: -10px;">
    <div class="tab-content" id="roteirosTabContent">

        <!-- ══════════════════════════════════════════
             ABA 1: CATÁLOGO DE ROTEIROS PREDEFINIDOS
             ══════════════════════════════════════════ -->
        <div class="tab-pane fade show active" id="catalogo" role="tabpanel">

            <!-- Barra de Filtros Multicritério -->
            <form action="{{ route('portal.roteiros') }}" method="GET" class="filter-bar">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-search me-1"></i> Palavra-chave</label>
                        <input type="text" name="busca" class="form-control form-control-sm rounded-3" placeholder="Centro histórico, cachoeira..." value="{{ request('busca') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-bookmark me-1"></i> Tema</label>
                        <select name="tema" class="form-select form-select-sm rounded-3">
                            <option value="todos">Todos os temas</option>
                            <option value="cultural" {{ request('tema') == 'cultural' ? 'selected' : '' }}>🏛️ Histórico & Cultural</option>
                            <option value="ecoturismo" {{ request('tema') == 'ecoturismo' ? 'selected' : '' }}>🌲 Ecoturismo & Natureza</option>
                            <option value="gastronomia" {{ request('tema') == 'gastronomia' ? 'selected' : '' }}>🍽️ Gastronomia</option>
                            <option value="religioso" {{ request('tema') == 'religioso' ? 'selected' : '' }}>⛪ Fé & Tradições</option>
                            <option value="aventura" {{ request('tema') == 'aventura' ? 'selected' : '' }}>🧗 Aventura & Trilhas</option>
                            <option value="misto" {{ request('tema') == 'misto' ? 'selected' : '' }}>✨ Rota Completa</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-bicycle me-1"></i> Meio de Transporte</label>
                        <select name="meio_transporte" class="form-select form-select-sm rounded-3">
                            <option value="todos">Todos os meios</option>
                            <option value="a_pe" {{ request('meio_transporte') == 'a_pe' ? 'selected' : '' }}>🚶 A Pé</option>
                            <option value="bicicleta" {{ request('meio_transporte') == 'bicicleta' ? 'selected' : '' }}>🚴 Bicicleta</option>
                            <option value="carro" {{ request('meio_transporte') == 'carro' ? 'selected' : '' }}>🚗 Carro / Moto</option>
                            <option value="misto" {{ request('meio_transporte') == 'misto' ? 'selected' : '' }}>🔀 Percurso Misto</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-speedometer2 me-1"></i> Dificuldade</label>
                        <select name="dificuldade" class="form-select form-select-sm rounded-3">
                            <option value="todas">Todas</option>
                            <option value="facil" {{ request('dificuldade') == 'facil' ? 'selected' : '' }}>🟢 Fácil (Leve)</option>
                            <option value="medio" {{ request('dificuldade') == 'medio' ? 'selected' : '' }}>🟡 Moderado</option>
                            <option value="dificil" {{ request('dificuldade') == 'dificil' ? 'selected' : '' }}>🔴 Difícil</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check mt-3 pt-1">
                            <input class="form-check-input" type="checkbox" name="acessivel" value="1" id="filterAcessivelCat" {{ request('acessivel') ? 'checked' : '' }}>
                            <label class="form-check-label small fw-semibold text-dark" for="filterAcessivelCat">
                                ♿ 100% Acessível
                            </label>
                        </div>
                    </div>
                    <div class="col-md-1 text-end">
                        <label class="form-label small d-none d-md-block mb-1">&nbsp;</label>
                        <button type="submit" class="btn btn-pite btn-sm w-100 rounded-3">
                            <i class="bi bi-funnel"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Grid de Roteiros -->
            <div class="row g-4">
                @forelse($roteirosProntos as $roteiro)
                <div class="col-md-6 col-lg-4">
                    <div class="card-roteiro">
                        <div class="card-roteiro-header">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge rounded-pill px-2 py-1 text-uppercase fw-bold" style="font-size:0.68rem; background:rgba(4,120,87,0.1); color:var(--pite-emerald);">
                                    {{ $roteiro->tema_label }}
                                </span>
                                @if($roteiro->gerado_por_ia)
                                    <span class="badge rounded-pill px-2 py-1" style="font-size:0.68rem; background:rgba(99,102,241,0.12); color:#4f46e5;">
                                        <i class="bi bi-stars me-1"></i> Gerado por IA
                                    </span>
                                @else
                                    <span class="badge rounded-pill px-2 py-1" style="font-size:0.68rem; background:rgba(16,185,129,0.12); color:#059669;">
                                        <i class="bi bi-patch-check-fill me-1"></i> Roteiro Oficial
                                    </span>
                                @endif
                            </div>
                            <h5 class="fw-bold mb-1" style="font-family:'Outfit'; font-size:1.15rem;">
                                <a href="{{ route('portal.roteiros.show', $roteiro->slug) }}" class="text-dark text-decoration-none hover-emerald">
                                    {{ $roteiro->titulo }}
                                </a>
                            </h5>
                            <div class="d-flex flex-wrap gap-2 text-muted small mt-2" style="font-size:0.78rem;">
                                <span><i class="bi bi-clock me-1 text-success"></i>{{ $roteiro->tempo_formatado }}</span>
                                <span>•</span>
                                <span><i class="bi bi-geo-alt me-1 text-primary"></i>{{ $roteiro->distancia_formatada }}</span>
                                <span>•</span>
                                <span>{{ $roteiro->meio_transporte_label }}</span>
                            </div>
                        </div>

                        <div class="card-roteiro-body">
                            <p class="small text-muted mb-3" style="line-height:1.5; min-height: 48px;">
                                {{ Str::limit($roteiro->descricao, 120) }}
                            </p>

                            <!-- Trajeto de Paradas Resumido -->
                            <div class="mb-3 p-3 bg-light rounded-3">
                                <div class="small fw-bold text-dark mb-2">
                                    <i class="bi bi-signpost-split text-success me-1"></i> Principais Paradas:
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    @forelse($roteiro->atrativos->take(3) as $idx => $at)
                                    <div class="timeline-mini-step">
                                        <div class="step-number">{{ $idx + 1 }}</div>
                                        <div class="small text-truncate" style="max-width: 220px;">
                                            <strong>{{ $at->nome }}</strong>
                                            @if($at->pivot->tempo_estimado)
                                                <span class="text-muted" style="font-size:0.72rem;">({{ $at->pivot->tempo_estimado }})</span>
                                            @endif
                                        </div>
                                    </div>
                                    @empty
                                    <div class="small text-muted">Atrativos validados pelo município.</div>
                                    @endforelse
                                    @if($roteiro->atrativos->count() > 3)
                                        <div class="small text-muted ps-4" style="font-size:0.75rem;">
                                            + {{ $roteiro->atrativos->count() - 3 }} outras atrações
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Badges de Acessibilidade e Dificuldade -->
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-auto pt-2 border-top">
                                <div>
                                    @if($roteiro->acessivel_pne)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill small" title="Acessibilidade PNE garantida">
                                            ♿ Acessível
                                        </span>
                                    @endif
                                    <span class="badge bg-light text-muted border rounded-pill small">
                                        {{ $roteiro->nivel_dificuldade_label }}
                                    </span>
                                </div>
                                <a href="{{ route('portal.roteiros.show', $roteiro->slug) }}" class="btn btn-pite btn-sm rounded-pill px-3">
                                    Ver Detalhes <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="p-4 bg-light rounded-4 d-inline-block text-muted">
                        <i class="bi bi-compass fs-1 d-block mb-2 text-success"></i>
                        <h5>Nenhum roteiro encontrado com esses filtros.</h5>
                        <p class="small mb-3">Tente ajustar seus critérios ou crie um roteiro personalizado com nossa IA!</p>
                        <button class="btn btn-pite btn-sm rounded-pill" onclick="document.getElementById('gerador-tab').click();">
                            <i class="bi bi-magic me-1"></i> Criar Roteiro Personalizado
                        </button>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Paginação -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $roteirosProntos->withQueryString()->links() }}
            </div>
        </div>

        <!-- ══════════════════════════════════════════
             ABA 2: GERADOR INTELIGENTE COM IA MULTICRITÉRIO
             ══════════════════════════════════════════ -->
        <div class="tab-pane fade" id="gerador" role="tabpanel">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="generator-panel">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px; background:linear-gradient(135deg, #6366f1, #4f46e5); color:#fff;">
                                <i class="bi bi-stars"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0" style="font-family:'Outfit';">Preferências do Passeio</h5>
                                <small class="text-muted">A IA cria uma rota otimizada para você</small>
                            </div>
                        </div>

                        <form id="formGerarIa">
                            @csrf

                            <!-- Perfil Principal -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">1. Qual é o seu perfil de interesse?</label>
                                <div class="d-flex flex-wrap gap-2">
                                    <label class="chip-choice active">
                                        <input type="radio" name="perfil" value="cultural" checked>
                                        🏛️ Histórico & Cultural
                                    </label>
                                    <label class="chip-choice">
                                        <input type="radio" name="perfil" value="ecoturismo">
                                        🌲 Ecoturismo & Natureza
                                    </label>
                                    <label class="chip-choice">
                                        <input type="radio" name="perfil" value="gastronomico">
                                        🍽️ Gastronomia
                                    </label>
                                    <label class="chip-choice">
                                        <input type="radio" name="perfil" value="aventura">
                                        🧗 Aventura
                                    </label>
                                    <label class="chip-choice">
                                        <input type="radio" name="perfil" value="religioso">
                                        ⛪ Fé & Tradições
                                    </label>
                                    <label class="chip-choice">
                                        <input type="radio" name="perfil" value="familia">
                                        👨‍👩‍👧 Família
                                    </label>
                                </div>
                            </div>

                            <!-- Duração em Horas -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label small fw-bold text-dark">2. Tempo Disponível</label>
                                    <span class="badge bg-success-subtle text-success fw-bold" id="duracaoDisplay">4 horas</span>
                                </div>
                                <input type="range" class="form-range" name="duracao_horas" id="duracaoRange" min="1" max="16" value="4" step="1">
                                <div class="d-flex justify-content-between small text-muted" style="font-size:0.75rem;">
                                    <span>1h (Rápido)</span>
                                    <span>4h (Meio dia)</span>
                                    <span>8h (Dia inteiro)</span>
                                    <span>16h (Fim de semana)</span>
                                </div>
                            </div>

                            <!-- Meio de Transporte -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">3. Meio de Transporte</label>
                                <select name="meio_transporte" class="form-select form-select-pite rounded-3">
                                    <option value="a_pe">🚶 Caminhada a Pé (Centro / Proximidades)</option>
                                    <option value="bicicleta">🚴 Bicicleta / Ciclorrota</option>
                                    <option value="carro" selected>🚗 Carro Próprio / Aplicativo</option>
                                    <option value="transporte_publico">🚌 Transporte Público / Linha Turística</option>
                                    <option value="misto">🔀 Percurso Misto</option>
                                </select>
                            </div>

                            <!-- Orçamento -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">4. Orçamento Previsto</label>
                                <select name="orcamento" class="form-select form-select-pite rounded-3">
                                    <option value="gratuito">🆓 100% Gratuito (Apenas locais com entrada franca)</option>
                                    <option value="economico">💲 Econômico (Gastos leves em lanches e ingressos)</option>
                                    <option value="moderado" selected>💲💲 Moderado (Restaurantes e atrativos com conforto)</option>
                                    <option value="premium">💲💲💲 Completo (Experiência gastronômica e passeios guiados)</option>
                                </select>
                            </div>

                            <!-- Inclusão e Acessibilidade -->
                            <div class="mb-4 p-3 bg-light rounded-3">
                                <label class="form-label small fw-bold text-dark d-block mb-2">5. Requisitos Especiais</label>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="acessivel" value="1" id="iaAcessivel" checked>
                                    <label class="form-check-label small fw-semibold" for="iaAcessivel">
                                        ♿ Exigir Acessibilidade Universal (PNE / Cadeirantes)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="criancas" value="1" id="iaCriancas">
                                    <label class="form-check-label small fw-semibold" for="iaCriancas">
                                        🧸 Adequado para Crianças / Carrinhos de Bebê
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-pite btn-lg w-100 rounded-4 shadow" id="btnGerarIa">
                                <i class="bi bi-lightning-charge-fill me-2 text-warning"></i> Gerar Roteiro Personalizado
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Painel de Resultados Dinâmico -->
                <div class="col-lg-7">
                    <div class="generator-panel" id="painelResultado">
                        <div id="resultadoPlaceholder" class="text-center py-5">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:70px; height:70px; background:rgba(4,120,87,0.08); color:var(--pite-emerald); font-size:2rem;">
                                <i class="bi bi-compass"></i>
                            </div>
                            <h5 class="fw-bold mb-2" style="font-family:'Outfit';">Pronto para criar sua jornada</h5>
                            <p class="text-muted small mb-0" style="max-width:380px; margin:0 auto;">
                                Configure suas preferências ao lado e clique em <strong>Gerar Roteiro Personalizado</strong>. Nosso algoritmo inteligente calculará a melhor ordem de visitação com base em dados oficiais!
                            </p>
                        </div>

                        <!-- Card de Resultado Gerado (oculto por padrão) -->
                        <div id="resultadoConteudo" style="display:none;">
                            <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                                <div>
                                    <span class="badge rounded-pill px-3 py-1 mb-1" style="background:rgba(99,102,241,0.12); color:#4f46e5; font-size:0.75rem;">
                                        <i class="bi bi-stars me-1"></i> Gerado por Inteligência Artificial
                                    </span>
                                    <h4 class="fw-bold mb-1" style="font-family:'Outfit';" id="resTitulo">Roteiro Inteligente</h4>
                                    <div class="d-flex flex-wrap gap-2 text-muted small" id="resKpis"></div>
                                </div>
                                <a href="#" class="btn btn-pite rounded-pill px-4 py-2" id="btnVerRoteiroCompleto">
                                    <i class="bi bi-map-fill me-1"></i> Abrir Mapa & Guia
                                </a>
                            </div>

                            <div class="p-3 bg-light rounded-3 mb-4" id="resDescricao"></div>

                            <!-- Linha do tempo das paradas -->
                            <h6 class="fw-bold mb-3" style="font-family:'Outfit';"><i class="bi bi-signpost-split text-success me-2"></i>Ordem Sugerida de Visitação</h6>
                            <div id="resTimeline" class="mb-4"></div>

                            <!-- Orientações de Segurança & Serviços -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="p-3 border rounded-3 h-100 bg-white">
                                        <h6 class="fw-bold small text-success mb-2"><i class="bi bi-shield-check me-1"></i> Orientações de Segurança</h6>
                                        <p class="small text-muted mb-0" id="resSeguranca" style="line-height:1.5;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 border rounded-3 h-100 bg-white">
                                        <h6 class="fw-bold small text-primary mb-2"><i class="bi bi-droplet me-1"></i> Serviços no Caminho</h6>
                                        <p class="small text-muted mb-0" id="resServicos" style="line-height:1.5;"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="height: 60px;"></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Slider de Duração
    const range = document.getElementById('duracaoRange');
    const display = document.getElementById('duracaoDisplay');
    if (range && display) {
        range.addEventListener('input', function() {
            display.textContent = this.value + (this.value == 1 ? ' hora' : ' horas');
        });
    }

    // Chips de Perfil
    const chips = document.querySelectorAll('.chip-choice');
    chips.forEach(chip => {
        chip.addEventListener('click', function() {
            chips.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            const radio = this.querySelector('input[type="radio"]');
            if (radio) radio.checked = true;
        });
    });

    // Submissão do Gerador IA
    const formIa = document.getElementById('formGerarIa');
    const btnGerar = document.getElementById('btnGerarIa');
    const placeholder = document.getElementById('resultadoPlaceholder');
    const conteudo = document.getElementById('resultadoConteudo');

    if (formIa) {
        formIa.addEventListener('submit', function(e) {
            e.preventDefault();

            btnGerar.disabled = true;
            btnGerar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Otimizando rota com IA...';

            const formData = new FormData(formIa);

            fetch('{{ route("portal.roteiros.gerar") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                btnGerar.disabled = false;
                btnGerar.innerHTML = '<i class="bi bi-lightning-charge-fill me-2 text-warning"></i> Gerar Novo Roteiro';

                if (data.sucesso && data.roteiro) {
                    const rot = data.roteiro;
                    const atrativos = data.atrativos || [];

                    placeholder.style.display = 'none';
                    conteudo.style.display = 'block';

                    document.getElementById('resTitulo').textContent = rot.titulo;
                    document.getElementById('btnVerRoteiroCompleto').href = data.url_detalhe;

                    // KPIs
                    document.getElementById('resKpis').innerHTML = `
                        <span><i class="bi bi-clock me-1 text-success"></i>${rot.duracao_estimada_horas}h de duração</span>
                        <span>•</span>
                        <span><i class="bi bi-geo-alt me-1 text-primary"></i>${rot.distancia_total_km || 0} km total</span>
                        <span>•</span>
                        <span><i class="bi bi-shuffle me-1 text-warning"></i>${rot.nivel_dificuldade == 'facil' ? '🟢 Fácil' : '🟡 Moderado'}</span>
                    `;

                    document.getElementById('resDescricao').textContent = rot.descricao;

                    // Timeline
                    let timelineHtml = '';
                    atrativos.forEach((at, idx) => {
                        const tempoEst = at.pivot ? at.pivot.tempo_estimado : '45min';
                        const obs = at.pivot ? at.pivot.observacao : '';
                        const acess = at.niveis_acessibilidade && at.niveis_acessibilidade.cadeirante ?
                            '<span class="badge bg-success-subtle text-success rounded-pill" style="font-size:0.65rem;">♿ Acessível</span>' : '';

                        timelineHtml += `
                            <div class="timeline-mini-step mb-3">
                                <div class="step-number">${idx + 1}</div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong class="text-dark">${at.nome}</strong>
                                        <span class="badge bg-light text-muted border">${tempoEst}</span>
                                    </div>
                                    <p class="small text-muted mb-1" style="font-size:0.82rem;">${at.descricao_curta || at.descricao}</p>
                                    <div class="d-flex align-items-center gap-2">
                                        <small class="text-muted" style="font-size:0.75rem;"><i class="bi bi-pin-map text-danger me-1"></i>${at.endereco || 'Centro'}</small>
                                        ${acess}
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    document.getElementById('resTimeline').innerHTML = timelineHtml;

                    // Segurança e Serviços
                    const seg = rot.orientacoes_seguranca || {};
                    document.getElementById('resSeguranca').textContent = seg.vestuario || 'Utilize roupas leves e calçados confortáveis. Telefones de emergência: 190 (Polícia) | 192 (SAMU).';

                    const serv = rot.servicos_disponiveis || {};
                    document.getElementById('resServicos').textContent = (serv.pontos_agua ? serv.pontos_agua.join(', ') : 'Pontos de hidratação e sanitários disponíveis nos atrativos.');
                }
            })
            .catch(err => {
                btnGerar.disabled = false;
                btnGerar.innerHTML = '<i class="bi bi-lightning-charge-fill me-2 text-warning"></i> Gerar Roteiro Personalizado';
                alert('Erro ao processar roteiro com IA. Tente novamente.');
            });
        });
    }
});
</script>
@endpush

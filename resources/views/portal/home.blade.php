@extends('layouts.app')
@section('title', 'Descubra o Turismo Municipal — System-PITE')

@push('styles')
<style>
    .hero-pite {
        position: relative;
        min-height: calc(100vh - 70px);
        display: flex;
        align-items: center;
        background: linear-gradient(160deg, #022c22 0%, #064e3b 30%, #047857 60%, #0d9488 100%);
        overflow: hidden;
        padding-top: 48px;
        padding-bottom: 64px;
        box-sizing: border-box;
    }
    .hero-pite::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 800px;
        height: 800px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(245,158,11,0.12) 0%, transparent 70%);
        animation: float 8s ease-in-out infinite;
    }
    .hero-pite::after {
        content: '';
        position: absolute;
        bottom: -20%;
        left: -15%;
        width: 600px;
        height: 600px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(14,165,233,0.08) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite reverse;
    }
    .hero-content { position: relative; z-index: 2; }
    .hero-title {
        font-size: clamp(2.8rem, 5.5vw, 4.2rem);
        line-height: 1.05;
        color: #fff;
    }
    .hero-title span {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .hero-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-top: 40px;
    }
    .hero-stat {
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        padding: 20px;
        text-align: center;
    }
    .hero-stat h3 { font-size: 2rem; color: #fbbf24; margin-bottom: 4px; }
    .hero-stat p { font-size: 0.8rem; color: rgba(255,255,255,0.7); margin: 0; }

    .search-glass {
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 24px 80px rgba(0,0,0,0.2);
        border: 1px solid rgba(255,255,255,0.3);
    }

    .category-item {
        text-decoration: none;
        color: var(--pite-text);
        transition: var(--pite-transition);
    }
    .category-card {
        background: #fff;
        border-radius: 20px;
        padding: 28px 16px;
        text-align: center;
        border: 1px solid #f1f5f9;
        transition: var(--pite-transition);
        height: 100%;
    }
    .category-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 48px rgba(4,120,87,0.12);
        border-color: var(--pite-emerald);
    }
    .category-icon {
        width: 64px; height: 64px;
        border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.6rem;
        margin: 0 auto 12px;
        transition: var(--pite-transition);
    }
    .category-card:hover .category-icon { transform: scale(1.1); }

    .atrativo-card-img {
        height: 220px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .card-premium:hover .atrativo-card-img { transform: scale(1.05); }

    .esg-banner {
        background: linear-gradient(135deg, #022c22, #064e3b);
        border-radius: 28px;
        position: relative;
        overflow: hidden;
    }
    .esg-banner::before {
        content: '';
        position: absolute;
        right: -80px;
        top: -80px;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(16,185,129,0.12);
    }

    .feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; }
    .feature-box {
        background: #fff;
        border-radius: 20px;
        padding: 32px 24px;
        border: 1px solid #f1f5f9;
        transition: var(--pite-transition);
        position: relative;
        overflow: hidden;
    }
    .feature-box::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--pite-emerald), var(--pite-teal));
        transform: scaleX(0);
        transition: transform 0.4s ease;
    }
    .feature-box:hover::after { transform: scaleX(1); }
    .feature-box:hover { transform: translateY(-4px); box-shadow: var(--pite-shadow-lg); }
</style>
@endpush

@section('content')

<!-- ═══ HERO ═══ -->
<section class="hero-pite">
    <div class="container hero-content">
        <div class="row align-items-center g-5">
            <div class="col-lg-7 animate-in">
                <div class="chip chip-gold mb-3"><i class="bi bi-stars"></i> Plataforma Inteligente de Turismo</div>
                <h1 class="hero-title section-title mb-4">
                    Descubra experiências <span>inesquecíveis</span> no nosso município
                </h1>
                <p class="text-white" style="font-size:1.1rem; opacity:0.85; line-height:1.7; max-width:520px;">
                    Roteiros personalizados por IA, pontos acessíveis e empreendedores locais validados — tudo em uma plataforma sustentável e transparente.
                </p>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="{{ route('portal.roteiros') }}" class="btn btn-pite-gold btn-lg">
                        <i class="bi bi-magic me-2"></i> Criar Meu Roteiro
                    </a>
                    <a href="{{ route('portal.mapa') }}" class="btn btn-pite-outline btn-lg">
                        <i class="bi bi-map me-2"></i> Explorar Mapa
                    </a>
                </div>
                <div class="hero-stats d-none d-md-grid">
                    <div class="hero-stat animate-in animate-delay-1">
                        <h3>150+</h3><p>Pontos Turísticos</p>
                    </div>
                    <div class="hero-stat animate-in animate-delay-2">
                        <h3>120+</h3><p>Empreendedores</p>
                    </div>
                    <div class="hero-stat animate-in animate-delay-3">
                        <h3>98%</h3><p>Satisfação</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 animate-in animate-delay-2">
                <div class="search-glass">
                    <h5 style="font-family:'Outfit'; font-weight:700; margin-bottom:20px;">
                        <i class="bi bi-search" style="color:var(--pite-emerald);"></i> Encontre seu destino
                    </h5>
                    <form action="{{ route('portal.atrativos.index') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">O que deseja explorar?</label>
                            <input type="text" name="busca" class="form-control form-control-pite" placeholder="Cachoeiras, museus, trilhas...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Categoria</label>
                            <select name="categoria" class="form-select form-select-pite">
                                <option value="">Todas as categorias</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="acessivel" value="1" id="heroAcessivel" style="border-color:var(--pite-emerald);">
                            <label class="form-check-label small" for="heroAcessivel">
                                <i class="bi bi-universal-access me-1" style="color:var(--pite-emerald);"></i>
                                Apenas locais 100% acessíveis
                            </label>
                        </div>
                        <button type="submit" class="btn btn-pite w-100 btn-lg">
                            <i class="bi bi-compass me-2"></i> Explorar Agora
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ CATEGORIAS ═══ -->
<section class="py-5" style="background:#fff;" data-animate>
    <div class="container py-4">
        <div class="text-center mb-5">
            <div class="chip chip-emerald mb-2"><i class="bi bi-grid-3x3-gap"></i> Categorias</div>
            <h2 class="section-title" style="font-size:2.2rem;">Explore por tipo de experiência</h2>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($categorias as $i => $cat)
            <div class="col-6 col-md-4 col-lg-2" data-animate>
                <a href="{{ route('portal.atrativos.index', ['categoria' => $cat->id]) }}" class="category-item d-block h-100">
                    <div class="category-card">
                        <div class="category-icon" style="background:rgba(4,120,87,0.08); color:var(--pite-emerald);">
                            <i class="bi {{ $cat->icone ?? 'bi-geo-alt' }}"></i>
                        </div>
                        <h6 style="font-family:'Outfit'; font-weight:600; font-size:0.85rem; margin:0;">{{ $cat->nome }}</h6>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ═══ ATRATIVOS EM DESTAQUE ═══ -->
<section class="py-5" data-animate>
    <div class="container py-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">
            <div>
                <div class="chip chip-emerald mb-2"><i class="bi bi-fire"></i> Destaques</div>
                <h2 class="section-title" style="font-size:2.2rem;">Atrativos mais bem avaliados</h2>
                <p class="section-subtitle">Lugares recomendados por visitantes reais com avaliações verificadas</p>
            </div>
            <a href="{{ route('portal.atrativos.index') }}" class="btn btn-pite">Ver Todos <i class="bi bi-arrow-right ms-1"></i></a>
        </div>

        <div class="row g-4">
            @forelse($atrativosDestaque as $atrativo)
            <div class="col-md-6 col-lg-4" data-animate>
                <div class="card-premium h-100">
                    <div style="overflow:hidden; border-radius:var(--pite-radius) var(--pite-radius) 0 0;">
                        <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80"
                             class="w-100 atrativo-card-img" alt="{{ $atrativo->nome }}">
                    </div>
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge-status" style="background:rgba(4,120,87,0.1); color:var(--pite-emerald);">{{ $atrativo->categoria?->nome }}</span>
                            @if(isset($atrativo->niveis_acessibilidade['cadeirante']) && $atrativo->niveis_acessibilidade['cadeirante'])
                            <span class="badge-status" style="background:rgba(16,185,129,0.1); color:#059669;">
                                <i class="bi bi-universal-access"></i> Acessível
                            </span>
                            @endif
                        </div>
                        <h5 style="font-family:'Outfit'; font-weight:700; margin-bottom:8px;">{{ $atrativo->nome }}</h5>
                        <p class="small" style="color:var(--pite-text-muted); line-height:1.6;">{{ Str::limit($atrativo->descricao_curta ?? $atrativo->descricao, 100) }}</p>
                        <div class="d-flex align-items-center justify-content-between pt-3" style="border-top:1px solid #f1f5f9;">
                            <span class="small" style="color:var(--pite-text-muted);"><i class="bi bi-clock me-1"></i> {{ $atrativo->horario_funcionamento ?? 'Consulte' }}</span>
                            <a href="{{ route('portal.atrativos.show', $atrativo->slug) }}" class="btn btn-sm btn-pite px-3 py-1" style="font-size:0.8rem;">Explorar</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="icon-box mx-auto mb-3" style="background:rgba(4,120,87,0.08); color:var(--pite-emerald); width:72px; height:72px; font-size:1.8rem;">
                    <i class="bi bi-compass"></i>
                </div>
                <h5 style="font-family:'Outfit'; font-weight:700;">Em breve novos atrativos</h5>
                <p class="text-muted">Estamos cadastrando os melhores pontos turísticos do município.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ═══ FUNCIONALIDADES ═══ -->
<section class="py-5" style="background:#fff;" data-animate>
    <div class="container py-4">
        <div class="text-center mb-5">
            <div class="chip chip-gold mb-2"><i class="bi bi-lightning-charge"></i> Funcionalidades</div>
            <h2 class="section-title" style="font-size:2.2rem;">Uma plataforma completa</h2>
            <p class="section-subtitle mx-auto">Tecnologia e sustentabilidade integradas para uma experiência turística transformadora</p>
        </div>
        <div class="feature-grid">
            <div class="feature-box" data-animate>
                <div class="icon-box mb-3" style="background:rgba(245,158,11,0.1); color:var(--pite-gold);">
                    <i class="bi bi-stars"></i>
                </div>
                <h6 style="font-family:'Outfit'; font-weight:700;">Roteiros com IA</h6>
                <p class="small text-muted mb-0">Roteiros personalizados gerados por inteligência artificial auditável e transparente.</p>
            </div>
            <div class="feature-box" data-animate>
                <div class="icon-box mb-3" style="background:rgba(4,120,87,0.1); color:var(--pite-emerald);">
                    <i class="bi bi-universal-access"></i>
                </div>
                <h6 style="font-family:'Outfit'; font-weight:700;">100% Acessível</h6>
                <p class="small text-muted mb-0">Filtros de acessibilidade PNE, alto contraste e conformidade WCAG 2.2 AA.</p>
            </div>
            <div class="feature-box" data-animate>
                <div class="icon-box mb-3" style="background:rgba(14,165,233,0.1); color:var(--pite-sky);">
                    <i class="bi bi-map"></i>
                </div>
                <h6 style="font-family:'Outfit'; font-weight:700;">Mapa Interativo</h6>
                <p class="small text-muted mb-0">Visualize todos os pontos turísticos em tempo real com geolocalização integrada.</p>
            </div>
            <div class="feature-box" data-animate>
                <div class="icon-box mb-3" style="background:rgba(124,58,237,0.1); color:var(--pite-violet);">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h6 style="font-family:'Outfit'; font-weight:700;">LGPD & ESG</h6>
                <p class="small text-muted mb-0">Conformidade total com a LGPD e painel de indicadores de sustentabilidade ESG.</p>
            </div>
        </div>
    </div>
</section>

<!-- ═══ BANNER ESG ═══ -->
<section class="py-5" data-animate>
    <div class="container">
        <div class="esg-banner p-5 text-white position-relative">
            <div class="row align-items-center" style="position:relative; z-index:2;">
                <div class="col-lg-8">
                    <div class="chip mb-3" style="background:rgba(16,185,129,0.2); color:#6ee7b7;">
                        <i class="bi bi-leaf"></i> Compromisso ESG Municipal
                    </div>
                    <h2 class="section-title" style="font-size:2rem;">Turismo Sustentável com Transparência Total</h2>
                    <p style="color:rgba(255,255,255,0.7); max-width:500px; line-height:1.7;">
                        Monitore indicadores ambientais, sociais e de governança. Nossos dados são abertos e auditáveis pela comunidade.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <a href="{{ route('portal.esg') }}" class="btn btn-pite-gold btn-lg">
                        <i class="bi bi-bar-chart me-2"></i> Ver Painel ESG
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

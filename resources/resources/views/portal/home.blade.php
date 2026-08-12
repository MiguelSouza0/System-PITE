@extends('layouts.app')

@section('title', 'Portal Turístico Municipal - System-PITE')

@section('content')

<!-- Banner Principal -->
<section class="hero-banner text-center text-md-start">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge bg-light text-primary mb-3 px-3 py-2 rounded-pill fw-semibold">
                    <i class="bi bi-stars me-1"></i> Plataforma Inteligente de Turismo Municipal
                </span>
                <h1 class="display-4 fw-bold mb-3">Descubra as Maravilhas do Nosso Município</h1>
                <p class="lead text-light mb-4">
                    Turismo sustentável, pontos acessíveis e roteiros inteligentes gerados sob medida para sua experiência única.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('portal.roteiros') }}" class="btn btn-warning btn-lg rounded-pill fw-semibold text-dark px-4 shadow">
                        <i class="bi bi-magic me-2"></i> Criar Roteiro Personalizado
                    </a>
                    <a href="{{ route('portal.atrativos.index') }}" class="btn btn-outline-light btn-lg rounded-pill px-4">
                        <i class="bi bi-compass me-2"></i> Explorar Atrativos
                    </a>
                </div>
            </div>
            <div class="col-lg-5 mt-4 mt-lg-0 text-center">
                <div class="p-4 bg-white text-dark rounded-4 shadow-lg text-start">
                    <h5 class="fw-bold mb-3"><i class="bi bi-search text-primary me-2"></i> Busca Rápida de Turismo</h5>
                    <form action="{{ route('portal.atrativos.index') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">O que você procura?</label>
                            <input type="text" name="busca" class="form-control rounded-3" placeholder="Ex: Cachoeiras, Museus, Feira local...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Categoria</label>
                            <select name="categoria" class="form-select rounded-3">
                                <option value="">Todas as Categorias</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="acessivel" value="1" id="checkAcessivel">
                            <label class="form-check-input-label small" for="checkAcessivel">
                                Apenas locais 100% Acessíveis (PNE/Cadeirantes)
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-3 fw-semibold">
                            <i class="bi bi-search me-1"></i> Buscar Atrativos
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categorias em Destaque -->
<section class="py-5 bg-white border-bottom">
    <div class="container">
        <h3 class="fw-bold mb-4 text-center">Explore por Categorias</h3>
        <div class="row g-4 justify-content-center">
            @foreach($categorias as $cat)
            <div class="col-6 col-md-4 col-lg-2 text-center">
                <a href="{{ route('portal.atrativos.index', ['categoria' => $cat->id]) }}" class="text-decoration-none text-dark">
                    <div class="p-3 bg-light rounded-4 h-100 border transition-all">
                        <div class="fs-1 text-primary mb-2">
                            <i class="bi {{ $cat->icone ?? 'bi-geo-alt' }}"></i>
                        </div>
                        <h6 class="fw-semibold mb-0 small">{{ $cat->nome }}</h6>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Atrativos em Destaque -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Atrativos em Destaque</h3>
                <p class="text-muted small mb-0">Locais mais bem avaliados por visitantes e cidadãos</p>
            </div>
            <a href="{{ route('portal.atrativos.index') }}" class="btn btn-outline-primary rounded-pill btn-sm">Ver Todos</a>
        </div>

        <div class="row g-4">
            @forelse($atrativosDestaque as $atrativo)
            <div class="col-md-6 col-lg-4">
                <div class="card card-atrativo h-100">
                    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80" class="card-img-top rounded-top-4" style="height: 200px; object-fit: cover;" alt="{{ $atrativo->nome }}">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $atrativo->categoria?->nome }}</span>
                            @if(isset($atrativo->niveis_acessibilidade['cadeirante']) && $atrativo->niveis_acessibilidade['cadeirante'])
                                <span class="badge badge-acessivel rounded-pill" title="Acessível para Cadeirantes">
                                    <i class="bi bi-universal-access me-1"></i> Acessível
                                </span>
                            @endif
                        </div>
                        <h5 class="card-title fw-bold">{{ $atrativo->nome }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($atrativo->descricao_curta ?? $atrativo->descricao, 100) }}</p>
                        
                        <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-auto">
                            <span class="small text-muted"><i class="bi bi-clock me-1"></i> {{ $atrativo->horario_funcionamento ?? 'Consulte horários' }}</span>
                            <a href="{{ route('portal.atrativos.show', $atrativo->slug) }}" class="btn btn-sm btn-primary rounded-pill px-3">Detalhes</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4">
                <p class="text-muted">Nenhum atrativo cadastrado no momento.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Seção ESG e Sustentabilidade -->
<section class="py-5 bg-dark text-white rounded-4 container my-5">
    <div class="row align-items-center p-4">
        <div class="col-lg-8">
            <span class="badge badge-esg mb-2 px-3 py-2 fw-semibold"><i class="bi bi-leaf me-1"></i> Compromisso Municipal ESG</span>
            <h2 class="fw-bold mb-3">Turismo Sustentável e Transparência Pública</h2>
            <p class="text-light-50">
                Nosso município monitora indicadores de sustentabilidade ambiental, impacto socioeconômico e governança pública. Garantimos que os recursos do turismo sejam reinvestidos na comunidade local.
            </p>
        </div>
        <div class="col-lg-4 text-center text-lg-end mt-3 mt-lg-0">
            <a href="{{ route('portal.esg') }}" class="btn btn-light btn-lg rounded-pill fw-semibold px-4">
                Ver Painel ESG Municipal
            </a>
        </div>
    </div>
</section>

@endsection

@extends('layouts.app')

@section('title', 'Atrativos & Pontos Turísticos - System-PITE')

@section('content')
<div class="bg-primary text-white py-4 mb-4">
    <div class="container">
        <h2 class="fw-bold mb-1"><i class="bi bi-compass me-2"></i> Atrativos & Experiências Turísticas</h2>
        <p class="mb-0 text-light-50">Explore a diversidade cultural, ecológica e gastronômica com dados públicos auditados</p>
    </div>
</div>

<div class="container pb-5">
    <!-- Filtros de Busca -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
        <form action="{{ route('portal.atrativos.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label small fw-semibold">Buscar por Nome ou Descrição</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                    <input type="text" name="busca" class="form-control" placeholder="Ex: Mirante, Igreja, Trilha..." value="{{ request('busca') }}">
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Categoria</label>
                <select name="categoria" class="form-select">
                    <option value="">Todas as Categorias</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>{{ $cat->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="acessivel" value="1" id="checkAcessivelIndex" {{ request('acessivel') ? 'checked' : '' }}>
                    <label class="form-check-label small" for="checkAcessivelIndex">
                        <i class="bi bi-universal-access me-1"></i> Acessível PNE
                    </label>
                </div>
                <button type="submit" class="btn btn-primary w-100 rounded-3 fw-semibold">
                    <i class="bi bi-funnel me-1"></i> Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Lista de Atrativos -->
    <div class="row g-4">
        @forelse($atrativos as $atrativo)
        <div class="col-md-6 col-lg-4">
            <div class="card card-atrativo h-100 bg-white">
                <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=600&q=80" class="card-img-top rounded-top-4" style="height: 200px; object-fit: cover;" alt="{{ $atrativo->nome }}">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $atrativo->categoria?->nome }}</span>
                        @if($atrativo->preco_medio == 0)
                            <span class="badge bg-success-subtle text-success rounded-pill px-2">Gratuito</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2">R$ {{ number_format($atrativo->preco_medio, 2, ',', '.') }}</span>
                        @endif
                    </div>
                    <h5 class="fw-bold mb-2">{{ $atrativo->nome }}</h5>
                    <p class="text-muted small flex-grow-1 mb-3">
                        {{ $atrativo->descricao_curta ?? Str::limit($atrativo->descricao, 110) }}
                    </p>
                    
                    <div class="d-flex flex-wrap gap-1 mb-3">
                        @if(isset($atrativo->niveis_acessibilidade['cadeirante']) && $atrativo->niveis_acessibilidade['cadeirante'])
                            <span class="badge badge-acessivel"><i class="bi bi-check-circle me-1"></i> PNE Acessível</span>
                        @endif
                        @if(isset($atrativo->caracteristicas_esg['sustentavel']) && $atrativo->caracteristicas_esg['sustentavel'])
                            <span class="badge badge-esg"><i class="bi bi-tree me-1"></i> ESG Validado</span>
                        @endif
                    </div>

                    <a href="{{ route('portal.atrativos.show', $atrativo->slug) }}" class="btn btn-outline-primary w-100 rounded-3 fw-semibold">
                        Ver Detalhes & Rotas <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-search text-muted display-4 mb-3"></i>
            <h5>Nenhum atrativo encontrado</h5>
            <p class="text-muted small">Tente ajustar seus termos de busca ou filtros de categoria.</p>
            <a href="{{ route('portal.atrativos.index') }}" class="btn btn-outline-primary btn-sm rounded-pill">Limpar Filtros</a>
        </div>
        @endforelse
    </div>

    <!-- Paginação -->
    <div class="d-flex justify-content-center mt-5">
        {{ $atrativos->withQueryString()->links() }}
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', $atrativo->nome . ' - System-PITE')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('portal.home') }}">Início</a></li>
            <li class="breadcrumb-item"><a href="{{ route('portal.atrativos.index') }}">Atrativos</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $atrativo->nome }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80" class="img-fluid" style="height: 380px; width: 100%; object-fit: cover;" alt="{{ $atrativo->nome }}">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">{{ $atrativo->categoria?->nome }}</span>
                        @if($atrativo->preco_medio == 0)
                            <span class="badge bg-success-subtle text-success fs-6 px-3 py-2 rounded-pill">Entrada Gratuita</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary fs-6 px-3 py-2 rounded-pill">Preço Médio: R$ {{ number_format($atrativo->preco_medio, 2, ',', '.') }}</span>
                        @endif
                    </div>

                    <h1 class="fw-bold mb-3">{{ $atrativo->nome }}</h1>
                    
                    <p class="lead text-muted mb-4">{{ $atrativo->descricao }}</p>

                    <!-- Recursos de Acessibilidade -->
                    <div class="card bg-light border-0 rounded-3 p-4 mb-4">
                        <h5 class="fw-bold text-success mb-3"><i class="bi bi-universal-access me-2"></i> Infraestrutura de Acessibilidade (PNE)</h5>
                        <div class="row g-2">
                            <div class="col-6 col-md-4">
                                <div class="d-flex align-items-center"><i class="bi bi-check-circle-fill text-success me-2"></i> Rampas de Acesso</div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="d-flex align-items-center"><i class="bi bi-check-circle-fill text-success me-2"></i> Banheiro Adaptado</div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="d-flex align-items-center"><i class="bi bi-check-circle-fill text-success me-2"></i> Piso Tátil Direcional</div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="d-flex align-items-center"><i class="bi bi-check-circle-fill text-success me-2"></i> Áudio-Guia Integrado</div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="d-flex align-items-center"><i class="bi bi-check-circle-fill text-success me-2"></i> Vagas Preferenciais</div>
                            </div>
                        </div>
                    </div>

                    <!-- Avaliações Verificadas (Zero Avaliações Falsas) -->
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="fw-bold mb-0"><i class="bi bi-shield-check text-primary me-2"></i> Avaliações com Visita Validada</h4>
                            <span class="badge bg-primary-subtle text-primary">Conformidade LGPD</span>
                        </div>
                        <p class="small text-muted mb-4">Todas as avaliações no System-PITE exigem comprovação de visita ou geolocalização auditada para eliminar avaliações fraudulentas.</p>

                        @forelse($atrativo->avaliacoes ?? [] as $avaliacao)
                            <div class="border rounded-3 p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>{{ $avaliacao->usuario?->name ?? 'Turista Anônimo (LGPD)' }}</strong>
                                    <div class="text-warning">
                                        @for($i=1; $i<=5; $i++)
                                            <i class="bi {{ $i <= $avaliacao->nota ? 'bi-star-fill' : 'bi-star' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="small text-muted mb-0">{{ $avaliacao->comentario }}</p>
                            </div>
                        @empty
                            <div class="p-3 bg-light rounded-3 text-center small text-muted">
                                Seja o primeiro visitante a enviar uma avaliação verificada!
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Informações Práticas -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-info-circle text-primary me-2"></i> Informações do Local</h5>
                
                <ul class="list-unstyled mb-4">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-geo-alt text-primary fs-5 me-3"></i>
                        <div>
                            <strong>Endereço</strong>
                            <p class="text-muted small mb-0">{{ $atrativo->endereco ?? 'Centro Turístico Municipal' }}</p>
                        </div>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-clock text-primary fs-5 me-3"></i>
                        <div>
                            <strong>Horário de Funcionamento</strong>
                            <p class="text-muted small mb-0">{{ $atrativo->horario_funcionamento ?? 'Terça a Domingo: 08h às 18h' }}</p>
                        </div>
                    </li>
                    <li class="d-flex align-items-start">
                        <i class="bi bi-tree text-success fs-5 me-3"></i>
                        <div>
                            <strong>Impacto ESG</strong>
                            <p class="text-muted small mb-0">Gestão 100% sustentável e coleta seletiva.</p>
                        </div>
                    </li>
                </ul>

                <a href="{{ route('portal.roteiros') }}" class="btn btn-warning w-100 rounded-3 fw-bold mb-2">
                    <i class="bi bi-magic me-1"></i> Incluir no Meu Roteiro IA
                </a>
                <a href="{{ route('portal.mapa') }}" class="btn btn-outline-primary w-100 rounded-3 fw-semibold">
                    <i class="bi bi-map me-1"></i> Ver no Mapa Interativo
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

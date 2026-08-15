@extends('layouts.app')
@section('title', $evento->titulo . ' — System-PITE')

@section('content')
<div class="bg-dark text-white py-5">
    <div class="container">
        <a href="{{ route('portal.eventos.index') }}" class="text-white-50 text-decoration-none small mb-3 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i> Voltar à agenda
        </a>
        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
            @if($evento->gratuito)
                <span class="badge bg-success px-3 py-2 rounded-pill">Gratuito</span>
            @else
                <span class="badge bg-primary px-3 py-2 rounded-pill">Ingresso: R$ {{ number_format($evento->preco_ingresso, 2, ',', '.') }}</span>
            @endif
        </div>
        <h1 class="fw-bold display-5 mb-3" style="font-family:'Outfit';">{{ $evento->titulo }}</h1>
        <p class="lead text-white-50 mb-0"><i class="bi bi-building me-2"></i> Organizado por: {{ $evento->organizador ?? 'Prefeitura Municipal' }}</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h4 class="fw-bold mb-3" style="font-family:'Outfit';">Sobre o Evento</h4>
                <p style="line-height:1.8; color:var(--pite-text);">{{ $evento->descricao }}</p>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top:90px;">
                <h5 class="fw-bold mb-3" style="font-family:'Outfit';"><i class="bi bi-info-circle text-success me-2"></i> Informações Práticas</h5>

                <div class="mb-3">
                    <small class="text-muted d-block fw-semibold text-uppercase" style="font-size:0.75rem;">Data e Hora</small>
                    <span class="fw-semibold text-dark">
                        <i class="bi bi-calendar3 me-1 text-success"></i>
                        {{ $evento->data_inicio ? $evento->data_inicio->translatedFormat('d \d\e F \d\e Y') : 'A definir' }}
                    </span>
                    @if($evento->data_inicio)
                        <span class="d-block small text-muted">Das {{ $evento->data_inicio->format('H:i') }} às {{ $evento->data_fim ? $evento->data_fim->format('H:i') : '' }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block fw-semibold text-uppercase" style="font-size:0.75rem;">Localização</small>
                    <span class="fw-semibold text-dark"><i class="bi bi-geo-alt me-1 text-danger"></i> {{ $evento->local }}</span>
                </div>

                @if($evento->atrativo)
                <div class="mb-3 p-3 bg-light rounded-3">
                    <small class="text-muted d-block mb-1 fw-semibold">Local vinculado:</small>
                    <a href="{{ route('portal.atrativos.show', $evento->atrativo->slug) }}" class="text-success fw-bold text-decoration-none">
                        {{ $evento->atrativo->nome }} <i class="bi bi-arrow-up-right-square ms-1"></i>
                    </a>
                </div>
                @endif

                <hr>

                <div class="d-grid gap-2">
                    @if($evento->atrativo && $evento->atrativo->latitude && $evento->atrativo->longitude)
                        <a href="{{ route('portal.mapa', ['lat' => $evento->atrativo->latitude, 'lng' => $evento->atrativo->longitude, 'evento' => $evento->id]) }}" class="btn btn-pite rounded-pill">
                            <i class="bi bi-map me-1"></i> Ver no Mapa Interativo
                        </a>
                    @else
                        <a href="{{ route('portal.mapa') }}" class="btn btn-pite rounded-pill">
                            <i class="bi bi-map me-1"></i> Ver no Mapa Interativo
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

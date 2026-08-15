@extends('layouts.app')
@section('title', 'Agenda de Eventos — System-PITE')

@push('styles')
<style>
    .eventos-hero {
        background: linear-gradient(160deg, #022c22 0%, #064e3b 40%, #047857 100%);
        padding: 56px 0 28px;
        color: #fff;
    }
    .evento-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #f1f5f9;
        overflow: hidden;
        transition: var(--pite-transition);
    }
    .evento-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--pite-shadow-lg);
    }
    .date-badge {
        background: var(--pite-surface);
        color: var(--pite-emerald);
        border-radius: 12px;
        padding: 10px 16px;
        text-align: center;
        font-weight: 700;
        font-family: 'Outfit';
    }
</style>
@endpush

@section('content')
<div class="eventos-hero mb-4">
    <div class="container">
        <div class="chip chip-gold mb-2"><i class="bi bi-calendar-event"></i> Programação Oficial</div>
        <h2 class="section-title mb-2" style="font-size:2.2rem;">Agenda Cultural & Eventos</h2>
        <p style="color:rgba(255,255,255,0.7); max-width:520px;">
            Acompanhe festivais, feiras, circuitos esportivos e celebrações comunitárias em todo o município.
        </p>
    </div>
</div>

<div class="container pb-5">
    {{-- FILTROS DE BUSCA --}}
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
        <form action="{{ route('portal.eventos.index') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-md-6">
                <input type="text" name="busca" class="form-control form-control-pite" placeholder="Buscar por festival, feira, show ou local..." value="{{ request('busca') }}">
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="gratuito" value="1" id="gratuitoCheck" {{ request('gratuito') ? 'checked' : '' }}>
                    <label class="form-check-label small fw-semibold" for="gratuitoCheck">🎟️ Apenas Gratuitos</label>
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-pite w-100"><i class="bi bi-search me-1"></i> Buscar Eventos</button>
            </div>
        </form>
    </div>

    {{-- LISTA DE EVENTOS --}}
    <div class="row g-4">
        @forelse($eventos as $evento)
        <div class="col-md-6 col-lg-4">
            <div class="evento-card h-100 p-4 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="date-badge">
                            <span class="d-block text-uppercase small" style="font-size:0.75rem;">{{ $evento->data_inicio ? $evento->data_inicio->translatedFormat('M') : 'AGENDA' }}</span>
                            <span class="fs-4">{{ $evento->data_inicio ? $evento->data_inicio->format('d') : '—' }}</span>
                        </div>
                        @if($evento->gratuito)
                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-semibold" style="font-size:0.75rem;"><i class="bi bi-ticket-perforated me-1"></i> Gratuito</span>
                        @else
                            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-semibold" style="font-size:0.75rem;">R$ {{ number_format($evento->preco_ingresso, 2, ',', '.') }}</span>
                        @endif
                    </div>
                    <h5 class="fw-bold mb-2" style="font-family:'Outfit';">{{ $evento->titulo }}</h5>
                    <p class="text-muted small mb-3">{{ Str::limit($evento->descricao, 110) }}</p>
                </div>

                <div>
                    <div class="pt-3 border-top d-flex flex-column gap-1 mb-3">
                        <small class="text-muted"><i class="bi bi-geo-alt text-danger me-1"></i> {{ $evento->local }}</small>
                        <small class="text-muted"><i class="bi bi-clock me-1"></i> {{ $evento->data_inicio ? $evento->data_inicio->format('H:i') : '' }} - {{ $evento->data_fim ? $evento->data_fim->format('H:i') : '' }}</small>
                        <small class="text-muted"><i class="bi bi-building me-1"></i> {{ $evento->organizador ?? 'Prefeitura Municipal' }}</small>
                    </div>
                    <a href="{{ route('portal.eventos.show', $evento->slug) }}" class="btn btn-outline-success w-100 rounded-pill btn-sm fw-semibold">
                        Ver Detalhes do Evento <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="icon-box mx-auto mb-3" style="background:rgba(4,120,87,0.08); color:var(--pite-emerald); width:72px; height:72px; font-size:1.8rem; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                <i class="bi bi-calendar-x"></i>
            </div>
            <h5 class="fw-bold">Nenhum evento encontrado</h5>
            <p class="text-muted">Tente ajustar seus termos de busca ou navegue pelos eventos programados.</p>
        </div>
        @endforelse
    </div>

    @if($eventos->hasPages())
    <div class="mt-4">
        {{ $eventos->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection

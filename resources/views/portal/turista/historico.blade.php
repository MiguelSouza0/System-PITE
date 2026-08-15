@extends('layouts.app')
@section('title', 'Meu Histórico — System-PITE')

@push('styles')
<style>
    .historico-header {
        background: linear-gradient(135deg, #022c22 0%, #064e3b 50%, #047857 100%);
        padding: 40px 0;
    }
    .timeline {
        position: relative;
        padding-left: 36px;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, var(--pite-emerald), var(--pite-teal), #e2e8f0);
        border-radius: 99px;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 24px;
    }
    .timeline-dot {
        position: absolute;
        left: -28px;
        top: 18px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 0 0 2px var(--pite-emerald);
        z-index: 2;
    }
    .timeline-dot.visita { background: var(--pite-emerald); }
    .timeline-dot.avaliacao { background: var(--pite-gold); box-shadow: 0 0 0 2px var(--pite-gold); }
    .timeline-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: var(--pite-shadow);
        transition: var(--pite-transition);
    }
    .timeline-card:hover {
        box-shadow: var(--pite-shadow-lg);
        transform: translateX(4px);
    }
    .timeline-date {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--pite-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 4px;
    }
    .avaliacao-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: var(--pite-shadow);
        transition: var(--pite-transition);
    }
    .avaliacao-card:hover {
        box-shadow: var(--pite-shadow-lg);
    }
    .resumo-card {
        text-align: center;
        padding: 24px;
        background: #fff;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: var(--pite-shadow);
    }
</style>
@endpush

@section('content')
<div class="historico-header">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb" style="--bs-breadcrumb-divider-color: rgba(255,255,255,0.4);">
                <li class="breadcrumb-item"><a href="{{ route('turista.dashboard') }}" style="color: rgba(255,255,255,0.7);"><i class="bi bi-house"></i> Meu Painel</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Histórico</li>
            </ol>
        </nav>
        <h2 class="section-title text-white" style="font-size: 1.8rem;"><i class="bi bi-clock-history me-2"></i> Minha Jornada</h2>
        <p style="color: rgba(255,255,255,0.7);">Histórico completo de visitas e avaliações</p>
    </div>
</div>

<div class="container py-4">
    @if(session('sucesso'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4">
        <i class="bi bi-check-circle me-1"></i> {{ session('sucesso') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4">
        {{-- Coluna Principal: Timeline --}}
        <div class="col-lg-8">
            <h5 class="section-title mb-4" style="font-size: 1.3rem;">
                <i class="bi bi-geo-alt me-1" style="color: var(--pite-emerald);"></i> Lugares Visitados
            </h5>

            @if($visitas->count() > 0)
            <div class="timeline">
                @foreach($visitas as $visita)
                <div class="timeline-item">
                    <div class="timeline-dot visita"></div>
                    <div class="timeline-card">
                        <div class="timeline-date">
                            <i class="bi bi-calendar3 me-1"></i> {{ $visita->visitado_em->translatedFormat('d \d\e F \d\e Y') }}
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-box" style="background: rgba(4,120,87,0.08); color: var(--pite-emerald); width: 48px; height: 48px; flex-shrink: 0;">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1" style="font-family: 'Outfit'; font-weight: 700; font-size: 0.95rem;">
                                    {{ $visita->atrativo?->nome ?? 'Atrativo' }}
                                </h6>
                                <span class="small text-muted">
                                    {{ $visita->atrativo?->categoria?->nome }}
                                    @if($visita->tempo_permanencia_min)
                                        · <i class="bi bi-clock me-1"></i>{{ $visita->tempo_permanencia_min }} min
                                    @endif
                                </span>
                                @if($visita->notas_pessoais)
                                    <p class="small text-muted mt-2 mb-0" style="line-height: 1.5;">
                                        <i class="bi bi-journal-text me-1"></i> {{ $visita->notas_pessoais }}
                                    </p>
                                @endif
                            </div>
                            <a href="{{ route('portal.atrativos.show', $visita->atrativo?->slug ?? '#') }}" class="btn btn-sm" style="background: rgba(4,120,87,0.06); color: var(--pite-emerald); border-radius: 10px; white-space: nowrap;">
                                Ver <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Paginação --}}
            @if($visitas->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $visitas->links() }}
            </div>
            @endif
            @else
            <div class="text-center py-5" style="background: #fff; border-radius: 20px; border: 1px solid rgba(0,0,0,0.04);">
                <div class="icon-box mx-auto mb-3" style="background: rgba(4,120,87,0.08); color: var(--pite-emerald); width: 72px; height: 72px; font-size: 1.8rem;">
                    <i class="bi bi-geo-alt"></i>
                </div>
                <h5 style="font-family: 'Outfit'; font-weight: 700;">Nenhuma visita registrada</h5>
                <p class="text-muted mb-3">Visite atrativos e registre sua presença para construir seu histórico!</p>
                <a href="{{ route('portal.atrativos.index') }}" class="btn btn-pite">
                    <i class="bi bi-compass me-1"></i> Explorar Atrativos
                </a>
            </div>
            @endif
        </div>

        {{-- Sidebar: Avaliações --}}
        <div class="col-lg-4">
            {{-- Resumo --}}
            <div class="row g-3 mb-4">
                <div class="col-6">
                    <div class="resumo-card">
                        <div class="stat-number" style="color: var(--pite-emerald); font-family: 'Outfit'; font-weight: 800; font-size: 2rem;">{{ $visitas->total() }}</div>
                        <div class="small text-muted fw-medium">Lugares Visitados</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="resumo-card">
                        <div class="stat-number" style="color: var(--pite-gold); font-family: 'Outfit'; font-weight: 800; font-size: 2rem;">{{ $avaliacoes->count() }}</div>
                        <div class="small text-muted fw-medium">Avaliações</div>
                    </div>
                </div>
            </div>

            {{-- Minhas Avaliações --}}
            <h5 class="section-title mb-3" style="font-size: 1.2rem;">
                <i class="bi bi-star me-1" style="color: var(--pite-gold);"></i> Minhas Avaliações
            </h5>

            @forelse($avaliacoes as $avaliacao)
            <div class="avaliacao-card mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0" style="font-family: 'Outfit'; font-weight: 600; font-size: 0.88rem;">
                        {{ $avaliacao->atrativo?->nome ?? 'Atrativo' }}
                    </h6>
                    <div class="text-warning">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi {{ $i <= $avaliacao->nota ? 'bi-star-fill' : 'bi-star' }}" style="font-size: 0.8rem;"></i>
                        @endfor
                    </div>
                </div>
                <p class="small text-muted mb-1" style="line-height: 1.5;">{{ Str::limit($avaliacao->comentario, 120) }}</p>
                <span class="small" style="color: var(--pite-text-muted); font-size: 0.7rem;">
                    <i class="bi bi-calendar3 me-1"></i> {{ $avaliacao->created_at->translatedFormat('d M Y') }}
                    · <span class="badge-status" style="background: rgba(16,185,129,0.08); color: #059669; font-size: 0.65rem;">{{ ucfirst($avaliacao->status_verificacao) }}</span>
                </span>
            </div>
            @empty
            <div class="text-center py-4" style="background: #fff; border-radius: 16px; border: 1px solid rgba(0,0,0,0.04);">
                <p class="small text-muted mb-0">Nenhuma avaliação publicada ainda.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

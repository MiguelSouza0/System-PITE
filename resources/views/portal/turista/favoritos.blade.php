@extends('layouts.app')
@section('title', 'Meus Favoritos — System-PITE')

@push('styles')
<style>
    .favoritos-header {
        background: linear-gradient(135deg, #022c22 0%, #064e3b 50%, #047857 100%);
        padding: 40px 0;
    }
    .filter-tabs {
        display: flex;
        gap: 8px;
        background: #fff;
        padding: 6px;
        border-radius: 14px;
        box-shadow: var(--pite-shadow);
        display: inline-flex;
    }
    .filter-tab {
        padding: 8px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        color: var(--pite-text-muted);
        transition: var(--pite-transition);
    }
    .filter-tab.active {
        background: linear-gradient(135deg, var(--pite-emerald), var(--pite-teal));
        color: #fff;
        box-shadow: 0 4px 12px rgba(4,120,87,0.25);
    }
    .filter-tab:hover:not(.active) {
        color: var(--pite-emerald);
        background: rgba(4,120,87,0.04);
    }
    .fav-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: var(--pite-shadow);
        overflow: hidden;
        transition: var(--pite-transition);
        position: relative;
    }
    .fav-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--pite-shadow-lg);
    }
    .fav-card img {
        height: 180px;
        width: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .fav-card:hover img { transform: scale(1.05); }
    .btn-unfav {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(8px);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--pite-coral);
        font-size: 1.1rem;
        cursor: pointer;
        transition: var(--pite-transition);
        z-index: 2;
    }
    .btn-unfav:hover {
        background: var(--pite-coral);
        color: #fff;
        transform: scale(1.1);
    }
</style>
@endpush

@section('content')
<div class="favoritos-header">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb" style="--bs-breadcrumb-divider-color: rgba(255,255,255,0.4);">
                <li class="breadcrumb-item"><a href="{{ route('turista.dashboard') }}" style="color: rgba(255,255,255,0.7);"><i class="bi bi-house"></i> Meu Painel</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Favoritos</li>
            </ol>
        </nav>
        <h2 class="section-title text-white" style="font-size: 1.8rem;"><i class="bi bi-heart-fill text-danger me-2"></i> Meus Favoritos</h2>
        <p style="color: rgba(255,255,255,0.7);">Atrativos e eventos salvos para visitar</p>
    </div>
</div>

<div class="container py-4">
    @if(session('sucesso'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4">
        <i class="bi bi-check-circle me-1"></i> {{ session('sucesso') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Filtros --}}
    <div class="mb-4">
        <div class="filter-tabs">
            <a href="{{ route('turista.favoritos') }}" class="filter-tab {{ $tipo === 'todos' ? 'active' : '' }}">
                <i class="bi bi-grid me-1"></i> Todos
            </a>
            <a href="{{ route('turista.favoritos', ['tipo' => 'atrativos']) }}" class="filter-tab {{ $tipo === 'atrativos' ? 'active' : '' }}">
                <i class="bi bi-compass me-1"></i> Atrativos
            </a>
            <a href="{{ route('turista.favoritos', ['tipo' => 'eventos']) }}" class="filter-tab {{ $tipo === 'eventos' ? 'active' : '' }}">
                <i class="bi bi-calendar-event me-1"></i> Eventos
            </a>
        </div>
    </div>

    {{-- Lista de Favoritos --}}
    <div class="row g-4">
        @forelse($favoritos as $favorito)
        @php $item = $favorito->favoritavel; @endphp
        @if($item)
        <div class="col-md-6 col-lg-4">
            <div class="fav-card h-100">
                {{-- Botão Desfavoritar --}}
                <form method="POST" action="{{ route('turista.favoritos.toggle') }}" class="d-inline">
                    @csrf
                    <input type="hidden" name="favoritavel_id" value="{{ $item->id }}">
                    <input type="hidden" name="favoritavel_type" value="{{ $favorito->favoritavel_type === 'App\\Models\\Atrativo' ? 'atrativo' : 'evento' }}">
                    <button type="submit" class="btn-unfav" title="Remover dos Favoritos">
                        <i class="bi bi-heart-fill"></i>
                    </button>
                </form>

                <div style="overflow: hidden;">
                    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80" alt="{{ $item->nome ?? $item->titulo }}">
                </div>
                <div class="p-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        @if($favorito->favoritavel_type === 'App\\Models\\Atrativo')
                            <span class="badge-status" style="background: rgba(4,120,87,0.08); color: var(--pite-emerald);">
                                <i class="bi bi-compass me-1"></i> Atrativo
                            </span>
                            @if($item->categoria)
                                <span class="badge-status" style="background: rgba(14,165,233,0.08); color: var(--pite-sky);">{{ $item->categoria->nome }}</span>
                            @endif
                        @else
                            <span class="badge-status" style="background: rgba(124,58,237,0.08); color: var(--pite-violet);">
                                <i class="bi bi-calendar-event me-1"></i> Evento
                            </span>
                            @if($item->gratuito)
                                <span class="badge-status" style="background: rgba(16,185,129,0.08); color: #059669;">Gratuito</span>
                            @endif
                        @endif
                    </div>

                    <h6 style="font-family: 'Outfit'; font-weight: 700;">{{ $item->nome ?? $item->titulo }}</h6>
                    <p class="small text-muted mb-3" style="line-height: 1.5;">
                        {{ Str::limit($item->descricao_curta ?? $item->descricao, 100) }}
                    </p>

                    @if($favorito->favoritavel_type === 'App\\Models\\Atrativo')
                        <a href="{{ route('portal.atrativos.show', $item->slug) }}" class="btn btn-sm btn-pite px-3">Explorar <i class="bi bi-arrow-right ms-1"></i></a>
                    @else
                        <a href="{{ route('portal.eventos.show', $item->slug) }}" class="btn btn-sm btn-pite px-3">Ver Evento <i class="bi bi-arrow-right ms-1"></i></a>
                    @endif
                </div>
            </div>
        </div>
        @endif
        @empty
        <div class="col-12">
            <div class="text-center py-5" style="background: #fff; border-radius: 20px; border: 1px solid rgba(0,0,0,0.04);">
                <div class="icon-box mx-auto mb-3" style="background: rgba(244,63,94,0.08); color: var(--pite-coral); width: 72px; height: 72px; font-size: 1.8rem;">
                    <i class="bi bi-heart"></i>
                </div>
                <h5 style="font-family: 'Outfit'; font-weight: 700;">Nenhum favorito ainda</h5>
                <p class="text-muted mb-3">Explore nossos atrativos e eventos e salve seus favoritos!</p>
                <a href="{{ route('portal.atrativos.index') }}" class="btn btn-pite">
                    <i class="bi bi-compass me-1"></i> Explorar Atrativos
                </a>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Paginação --}}
    @if($favoritos->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $favoritos->appends(['tipo' => $tipo])->links() }}
    </div>
    @endif
</div>
@endsection

@extends('layouts.app')
@section('title', 'Minha Jornada Turística — System-PITE')

@push('styles')
<style>
    .turista-header {
        background: linear-gradient(135deg, #022c22 0%, #064e3b 50%, #047857 100%);
        padding: 40px 0 80px;
        position: relative;
        overflow: hidden;
    }
    .turista-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 500px;
        height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(245,158,11,0.08) 0%, transparent 70%);
    }
    .avatar-turista {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--pite-gold), var(--pite-gold-warm));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: #fff;
        font-family: 'Outfit', sans-serif;
        font-weight: 800;
        box-shadow: 0 8px 24px rgba(245,158,11,0.3);
    }
    .stat-card {
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: var(--pite-shadow);
        transition: var(--pite-transition);
        text-align: center;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--pite-shadow-lg);
    }
    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        margin: 0 auto 12px;
    }
    .stat-number {
        font-family: 'Outfit', sans-serif;
        font-weight: 800;
        font-size: 2rem;
        line-height: 1;
        margin-bottom: 4px;
    }
    .jornada-progress {
        display: flex;
        align-items: center;
        gap: 0;
        background: #fff;
        border-radius: 20px;
        padding: 24px 32px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: var(--pite-shadow);
        margin-top: -50px;
        position: relative;
        z-index: 5;
    }
    .jornada-step {
        flex: 1;
        text-align: center;
        position: relative;
    }
    .jornada-step-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        font-size: 1.2rem;
        transition: var(--pite-transition);
    }
    .jornada-step-icon.done {
        background: linear-gradient(135deg, var(--pite-emerald), var(--pite-teal));
        color: #fff;
        box-shadow: 0 4px 16px rgba(4,120,87,0.25);
    }
    .jornada-step-icon.current {
        background: linear-gradient(135deg, var(--pite-gold), var(--pite-gold-warm));
        color: #fff;
        box-shadow: 0 4px 16px rgba(245,158,11,0.3);
        animation: pulse-glow 2s infinite;
    }
    .jornada-step-icon.pending {
        background: #f1f5f9;
        color: #94a3b8;
    }
    .jornada-connector {
        height: 3px;
        flex: 0.5;
        border-radius: 99px;
    }
    .jornada-connector.done { background: var(--pite-emerald); }
    .jornada-connector.pending { background: #e2e8f0; }

    .recomendacao-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: var(--pite-shadow);
        transition: var(--pite-transition);
    }
    .recomendacao-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--pite-shadow-lg);
    }
    .recomendacao-card img {
        height: 160px;
        width: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .recomendacao-card:hover img { transform: scale(1.05); }

    .evento-mini {
        display: flex;
        gap: 16px;
        padding: 16px;
        background: #fff;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.04);
        transition: var(--pite-transition);
    }
    .evento-mini:hover {
        box-shadow: var(--pite-shadow);
        transform: translateX(4px);
    }
    .evento-date-box {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: rgba(4,120,87,0.08);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .evento-date-box .dia {
        font-family: 'Outfit', sans-serif;
        font-weight: 800;
        font-size: 1.3rem;
        line-height: 1;
        color: var(--pite-emerald);
    }
    .evento-date-box .mes {
        font-size: 0.65rem;
        text-transform: uppercase;
        font-weight: 600;
        color: var(--pite-text-muted);
        letter-spacing: 0.05em;
    }
</style>
@endpush

@section('content')
{{-- Header do Turista --}}
<div class="turista-header">
    <div class="container" style="position: relative; z-index: 2;">
        <div class="d-flex align-items-center gap-4 text-white">
            <div class="avatar-turista">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="section-title mb-1" style="font-size: 1.8rem;">
                    Olá, {{ explode(' ', $user->name)[0] }}! 👋
                </h2>
                <p class="mb-0" style="color: rgba(255,255,255,0.7); font-size: 0.95rem;">
                    @if($user->cidade_origem)
                        <i class="bi bi-geo-alt me-1"></i> {{ $user->cidade_origem }}{{ $user->estado_origem ? ', ' . $user->estado_origem : '' }}
                        <span class="mx-2">·</span>
                    @endif
                    <i class="bi bi-calendar3 me-1"></i> Membro desde {{ $user->created_at->translatedFormat('M Y') }}
                </p>
            </div>
            <div class="ms-auto d-none d-md-flex gap-2">
                <a href="{{ route('turista.perfil') }}" class="btn btn-pite-outline btn-sm" style="padding: 8px 20px; font-size: 0.85rem;">
                    <i class="bi bi-pencil-square me-1"></i> Editar Perfil
                </a>
                <a href="{{ route('portal.roteiros') }}" class="btn btn-pite-gold btn-sm" style="padding: 8px 20px; font-size: 0.85rem;">
                    <i class="bi bi-magic me-1"></i> Criar Roteiro IA
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-top: -50px; position: relative; z-index: 5;">
    {{-- Alerta de boas-vindas --}}
    @if(session('bemVindo'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" style="background: rgba(4,120,87,0.08); border: 1px solid rgba(4,120,87,0.2); color: var(--pite-emerald);">
        <i class="bi bi-rocket-takeoff me-2"></i> <strong>{{ session('bemVindo') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('sucesso'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4">
        <i class="bi bi-check-circle me-1"></i> {{ session('sucesso') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Progresso da Jornada --}}
    <div class="jornada-progress mb-4">
        @php
            $etapaAtual = 1;
            if (!empty($user->interesses)) $etapaAtual = 2;
            if ($totalFavoritos > 0) $etapaAtual = 3;
            if ($totalVisitas > 0) $etapaAtual = 4;
            if ($totalAvaliacoes > 0) $etapaAtual = 5;
        @endphp

        <div class="jornada-step">
            <div class="jornada-step-icon {{ $etapaAtual >= 1 ? 'done' : 'pending' }}">
                <i class="bi bi-person-check"></i>
            </div>
            <div class="small fw-semibold">Cadastro</div>
        </div>
        <div class="jornada-connector {{ $etapaAtual >= 2 ? 'done' : 'pending' }}"></div>
        <div class="jornada-step">
            <div class="jornada-step-icon {{ $etapaAtual >= 2 ? ($etapaAtual == 2 ? 'current' : 'done') : 'pending' }}">
                <i class="bi bi-search"></i>
            </div>
            <div class="small fw-semibold">Descoberta</div>
        </div>
        <div class="jornada-connector {{ $etapaAtual >= 3 ? 'done' : 'pending' }}"></div>
        <div class="jornada-step">
            <div class="jornada-step-icon {{ $etapaAtual >= 3 ? ($etapaAtual == 3 ? 'current' : 'done') : 'pending' }}">
                <i class="bi bi-bookmark-heart"></i>
            </div>
            <div class="small fw-semibold">Planejamento</div>
        </div>
        <div class="jornada-connector {{ $etapaAtual >= 4 ? 'done' : 'pending' }}"></div>
        <div class="jornada-step">
            <div class="jornada-step-icon {{ $etapaAtual >= 4 ? ($etapaAtual == 4 ? 'current' : 'done') : 'pending' }}">
                <i class="bi bi-geo-alt"></i>
            </div>
            <div class="small fw-semibold">Exploração</div>
        </div>
        <div class="jornada-connector {{ $etapaAtual >= 5 ? 'done' : 'pending' }}"></div>
        <div class="jornada-step">
            <div class="jornada-step-icon {{ $etapaAtual >= 5 ? 'done' : ($etapaAtual == 4 ? 'current' : 'pending') }}">
                <i class="bi bi-star"></i>
            </div>
            <div class="small fw-semibold">Avaliação</div>
        </div>
    </div>

    {{-- Cards de Estatísticas --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(4,120,87,0.08); color: var(--pite-emerald);">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>
                <div class="stat-number" style="color: var(--pite-emerald);">{{ $totalVisitas }}</div>
                <div class="small text-muted fw-medium">Visitas</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(245,158,11,0.08); color: var(--pite-gold);">
                    <i class="bi bi-star-fill"></i>
                </div>
                <div class="stat-number" style="color: var(--pite-gold);">{{ $totalAvaliacoes }}</div>
                <div class="small text-muted fw-medium">Avaliações</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(244,63,94,0.08); color: var(--pite-coral);">
                    <i class="bi bi-heart-fill"></i>
                </div>
                <div class="stat-number" style="color: var(--pite-coral);">{{ $totalFavoritos }}</div>
                <div class="small text-muted fw-medium">Favoritos</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(124,58,237,0.08); color: var(--pite-violet);">
                    <i class="bi bi-signpost-2-fill"></i>
                </div>
                <div class="stat-number" style="color: var(--pite-violet);">{{ $totalRoteiros }}</div>
                <div class="small text-muted fw-medium">Roteiros</div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        {{-- Coluna Principal --}}
        <div class="col-lg-8">
            {{-- Recomendações Personalizadas --}}
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="section-title mb-1" style="font-size: 1.3rem;">
                            <i class="bi bi-stars text-warning me-1"></i> Recomendado para Você
                        </h5>
                        <p class="small text-muted mb-0">Baseado nos seus interesses e histórico</p>
                    </div>
                    <a href="{{ route('portal.atrativos.index') }}" class="btn btn-sm btn-pite px-3">Ver Todos</a>
                </div>

                <div class="row g-3">
                    @forelse($recomendacoes->take(4) as $atrativo)
                    <div class="col-md-6">
                        <div class="recomendacao-card h-100">
                            <div style="overflow: hidden;">
                                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80" alt="{{ $atrativo->nome }}">
                            </div>
                            <div class="p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge-status" style="background: rgba(4,120,87,0.08); color: var(--pite-emerald); font-size: 0.7rem;">
                                        {{ $atrativo->categoria?->nome }}
                                    </span>
                                    @if(($atrativo->preco_medio ?? 0) == 0)
                                        <span class="small fw-semibold" style="color: var(--pite-emerald);">Gratuito</span>
                                    @endif
                                </div>
                                <h6 style="font-family: 'Outfit'; font-weight: 700; font-size: 0.95rem; margin-bottom: 4px;">{{ $atrativo->nome }}</h6>
                                <p class="small text-muted mb-2" style="line-height: 1.5;">{{ Str::limit($atrativo->descricao_curta ?? $atrativo->descricao, 80) }}</p>
                                <a href="{{ route('portal.atrativos.show', $atrativo->slug) }}" class="btn btn-sm btn-pite px-3" style="font-size: 0.78rem;">
                                    Explorar <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="text-center py-4" style="background: #fff; border-radius: 16px; border: 1px solid rgba(0,0,0,0.04);">
                            <div class="icon-box mx-auto mb-3" style="background: rgba(4,120,87,0.08); color: var(--pite-emerald);">
                                <i class="bi bi-compass"></i>
                            </div>
                            <h6 style="font-family: 'Outfit'; font-weight: 700;">Explore nossos atrativos!</h6>
                            <p class="small text-muted mb-3">Atualize seus interesses no perfil para recomendações personalizadas.</p>
                            <a href="{{ route('portal.atrativos.index') }}" class="btn btn-sm btn-pite">Explorar Atrativos</a>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Últimas Visitas --}}
            @if($ultimasVisitas->count() > 0)
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="section-title mb-0" style="font-size: 1.3rem;">
                        <i class="bi bi-clock-history me-1" style="color: var(--pite-sky);"></i> Últimas Visitas
                    </h5>
                    <a href="{{ route('turista.historico') }}" class="small fw-semibold" style="color: var(--pite-emerald);">Ver Histórico Completo</a>
                </div>
                <div class="card-premium p-0">
                    @foreach($ultimasVisitas as $visita)
                    <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="icon-box" style="background: rgba(4,120,87,0.08); color: var(--pite-emerald); width: 44px; height: 44px; font-size: 1rem; flex-shrink: 0;">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0" style="font-family: 'Outfit'; font-weight: 600; font-size: 0.9rem;">{{ $visita->atrativo?->nome ?? 'Atrativo' }}</h6>
                            <span class="small text-muted">{{ $visita->atrativo?->categoria?->nome }} · {{ $visita->visitado_em->translatedFormat('d M Y') }}</span>
                        </div>
                        <a href="{{ route('portal.atrativos.show', $visita->atrativo?->slug ?? '#') }}" class="btn btn-sm" style="background: rgba(4,120,87,0.06); color: var(--pite-emerald); border-radius: 10px; font-size: 0.78rem;">
                            Ver <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- Resumo do Perfil de Viagem --}}
            <div class="card-premium p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 style="font-family: 'Outfit'; font-weight: 700; margin-bottom: 0;">
                        <i class="bi bi-person-badge" style="color: var(--pite-emerald);"></i> Perfil do Viajante
                    </h6>
                    <a href="{{ route('turista.perfil') }}" class="small fw-semibold" style="color: var(--pite-emerald);">Editar</a>
                </div>

                <div class="d-flex flex-column gap-2 small mb-3">
                    @if($user->nacionalidade)
                        <div>
                            <span class="text-muted"><i class="bi bi-flag me-1"></i> Nacionalidade:</span>
                            <span class="fw-semibold">{{ $user->nacionalidade }}</span>
                        </div>
                    @endif
                    @if($user->cep)
                        <div>
                            <span class="text-muted"><i class="bi bi-mailbox me-1"></i> CEP:</span>
                            <span class="fw-semibold">{{ $user->cep }}</span>
                        </div>
                    @endif
                    <div>
                        <span class="text-muted"><i class="bi bi-people me-1"></i> Formato de Viagem:</span>
                        <span class="badge-status" style="background: rgba(4,120,87,0.08); color: var(--pite-emerald);">
                            @if($user->possui_conjuge && $user->possui_filhos)
                                👨‍👩‍👧‍👦 Família (Casal + {{ $user->quantidade_filhos }} {{ $user->quantidade_filhos > 1 ? 'filhos' : 'filho' }})
                            @elseif($user->possui_filhos)
                                👨‍👧 Com {{ $user->quantidade_filhos }} {{ $user->quantidade_filhos > 1 ? 'filhos' : 'filho' }}
                            @elseif($user->possui_conjuge)
                                💍 Casal / Em dupla
                            @else
                                🎒 Viajante Individual
                            @endif
                        </span>
                    </div>
                </div>

                <hr class="my-3" style="border-color: #f1f5f9;">

                <h6 style="font-family: 'Outfit'; font-weight: 700; font-size: 0.85rem; margin-bottom: 10px;">
                    <i class="bi bi-heart text-danger me-1"></i> Meus Interesses
                </h6>
                @if(!empty($user->interesses))
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($user->interessesFormatados() as $interesse)
                            <span class="badge-status" style="background: rgba(4,120,87,0.06); color: var(--pite-text); font-size: 0.75rem;">{{ $interesse }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="small text-muted mb-2">Nenhum interesse selecionado ainda.</p>
                    <a href="{{ route('turista.perfil') }}" class="btn btn-sm btn-pite">Selecionar Interesses</a>
                @endif
            </div>

            {{-- Próximos Eventos --}}
            <div class="card-premium p-4 mb-4">
                <h6 style="font-family: 'Outfit'; font-weight: 700; margin-bottom: 16px;">
                    <i class="bi bi-calendar-event me-1" style="color: var(--pite-violet);"></i> Próximos Eventos
                </h6>
                @forelse($proximosEventos as $evento)
                <a href="{{ route('portal.eventos.show', $evento->slug) }}" class="text-decoration-none d-block mb-3">
                    <div class="evento-mini">
                        <div class="evento-date-box">
                            <span class="dia">{{ $evento->data_inicio->format('d') }}</span>
                            <span class="mes">{{ $evento->data_inicio->translatedFormat('M') }}</span>
                        </div>
                        <div>
                            <h6 class="mb-1" style="font-family: 'Outfit'; font-weight: 600; font-size: 0.88rem; color: var(--pite-text);">{{ Str::limit($evento->titulo, 35) }}</h6>
                            <span class="small text-muted"><i class="bi bi-geo-alt me-1"></i>{{ Str::limit($evento->local, 25) }}</span>
                        </div>
                    </div>
                </a>
                @empty
                <p class="small text-muted text-center py-3 mb-0">Nenhum evento próximo no momento.</p>
                @endforelse

                <a href="{{ route('portal.eventos.index') }}" class="btn btn-sm w-100 mt-2" style="background: rgba(124,58,237,0.06); color: var(--pite-violet); border-radius: 12px; font-weight: 600;">
                    Ver Agenda Completa <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            {{-- Ações Rápidas --}}
            <div class="card-premium p-4">
                <h6 style="font-family: 'Outfit'; font-weight: 700; margin-bottom: 16px;">
                    <i class="bi bi-lightning me-1" style="color: var(--pite-gold);"></i> Ações Rápidas
                </h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('portal.atrativos.index') }}" class="btn text-start" style="background: rgba(4,120,87,0.04); border-radius: 12px; padding: 12px 16px;">
                        <i class="bi bi-compass me-2" style="color: var(--pite-emerald);"></i>
                        <span class="small fw-semibold">Explorar Atrativos</span>
                    </a>
                    <a href="{{ route('turista.favoritos') }}" class="btn text-start" style="background: rgba(244,63,94,0.04); border-radius: 12px; padding: 12px 16px;">
                        <i class="bi bi-heart me-2" style="color: var(--pite-coral);"></i>
                        <span class="small fw-semibold">Meus Favoritos</span>
                    </a>
                    <a href="{{ route('portal.mapa') }}" class="btn text-start" style="background: rgba(14,165,233,0.04); border-radius: 12px; padding: 12px 16px;">
                        <i class="bi bi-map me-2" style="color: var(--pite-sky);"></i>
                        <span class="small fw-semibold">Mapa Interativo</span>
                    </a>
                    <a href="{{ route('portal.roteiros') }}" class="btn text-start" style="background: rgba(124,58,237,0.04); border-radius: 12px; padding: 12px 16px;">
                        <i class="bi bi-stars me-2" style="color: var(--pite-violet);"></i>
                        <span class="small fw-semibold">Criar Roteiro com IA</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

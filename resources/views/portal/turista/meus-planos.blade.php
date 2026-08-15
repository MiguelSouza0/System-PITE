@extends('layouts.app')
@section('title', 'Meus Planos de Turismo IA — System-PITE')

@push('styles')
<style>
    .planos-header {
        background: linear-gradient(135deg, #022c22 0%, #064e3b 50%, #047857 100%);
        padding: 40px 0 60px;
        position: relative;
        overflow: hidden;
    }
    .planos-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 500px;
        height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(245,158,11,0.08) 0%, transparent 70%);
    }
    .plano-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: var(--pite-shadow);
        overflow: hidden;
        transition: var(--pite-transition);
        position: relative;
    }
    .plano-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--pite-shadow-lg);
    }
    .plano-card-header {
        background: linear-gradient(135deg, rgba(2,44,34,0.03) 0%, rgba(4,120,87,0.06) 100%);
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 20px 24px;
    }
    .badge-dias {
        background: linear-gradient(135deg, var(--pite-gold), var(--pite-gold-warm));
        color: #fff;
        font-weight: 700;
        border-radius: 30px;
        padding: 6px 14px;
        font-size: 0.8rem;
    }
    .dia-timeline {
        border-left: 2px dashed rgba(4,120,87,0.2);
        margin-left: 12px;
        padding-left: 20px;
        position: relative;
    }
    .dia-dot {
        position: absolute;
        left: -9px;
        top: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--pite-emerald);
        border: 3px solid #fff;
        box-shadow: 0 0 0 2px rgba(4,120,87,0.2);
    }
    .btn-delete-plano {
        color: #ef4444;
        background: rgba(239, 68, 68, 0.08);
        border: none;
        border-radius: 10px;
        padding: 6px 12px;
        font-size: 0.82rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-delete-plano:hover {
        background: #ef4444;
        color: #fff;
    }
</style>
@endpush

@section('content')
<div class="planos-header">
    <div class="container" style="position: relative; z-index: 2;">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb" style="--bs-breadcrumb-divider-color: rgba(255,255,255,0.4);">
                <li class="breadcrumb-item"><a href="{{ route('turista.dashboard') }}" style="color: rgba(255,255,255,0.7);"><i class="bi bi-house"></i> Meu Painel</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Planos IA</li>
            </ol>
        </nav>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h2 class="section-title text-white mb-1" style="font-size: 1.8rem;">
                    <i class="bi bi-map-fill text-warning me-2"></i> Meus Planos de Turismo IA
                </h2>
                <p class="mb-0" style="color: rgba(255,255,255,0.75);">
                    Seus roteiros personalizados salvos e organizados pelo Guia PITE IA
                </p>
            </div>
            <div>
                <button type="button" class="btn btn-pite-gold" onclick="abrirIaAssistant();">
                    <i class="bi bi-magic me-1"></i> Gerar Novo Roteiro
                </button>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    @if(session('sucesso'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4">
        <i class="bi bi-check-circle me-1"></i> {{ session('sucesso') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4" id="listaPlanosContainer">
        @forelse($planos as $plano)
        <div class="col-12 col-lg-6" id="plano-card-{{ $plano->id }}">
            <div class="plano-card h-100">
                <div class="plano-card-header d-flex justify-content-between align-items-start gap-2">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge-dias">
                                <i class="bi bi-calendar3 me-1"></i> {{ $plano->dias }} {{ $plano->dias == 1 ? 'Dia' : 'Dias' }}
                            </span>
                            @if($plano->orcamento_estimado)
                            <span class="badge" style="background: rgba(4,120,87,0.1); color: var(--pite-emerald); font-weight: 600;">
                                <i class="bi bi-wallet2 me-1"></i> R$ {{ number_format($plano->orcamento_estimado, 2, ',', '.') }}
                            </span>
                            @endif
                            <span class="badge" style="background: rgba(14,165,233,0.1); color: var(--pite-sky); font-weight: 600;">
                                {{ ucfirst($plano->status ?? 'ativo') }}
                            </span>
                        </div>
                        <h5 class="mb-0 fw-bold" style="font-family: 'Outfit', sans-serif; color: var(--pite-text);">
                            {{ $plano->titulo }}
                        </h5>
                    </div>
                    <button type="button" class="btn-delete-plano" onclick="excluirPlano({{ $plano->id }})" title="Excluir Plano">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>

                <div class="p-4">
                    {{-- Itens do Roteiro organizados por Dia --}}
                    @php $itensPorDia = $plano->itensPorDia(); @endphp
                    @if(!empty($itensPorDia))
                    <div class="accordion accordion-flush mb-3" id="accordionPlano{{ $plano->id }}">
                        @foreach($itensPorDia as $numDia => $itensDia)
                        <div class="accordion-item border-0 mb-2 rounded-3 overflow-hidden" style="background: #f8fafc;">
                            <h2 class="accordion-header" id="heading{{ $plano->id }}Dia{{ $numDia }}">
                                <button class="accordion-button collapsed fw-semibold text-dark py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $plano->id }}Dia{{ $numDia }}" style="font-size: 0.9rem; background: #f1f5f9;">
                                    <i class="bi bi-calendar-event text-success me-2"></i> Dia {{ $numDia }} ({{ count($itensDia) }} atividades)
                                </button>
                            </h2>
                            <div id="collapse{{ $plano->id }}Dia{{ $numDia }}" class="accordion-collapse collapse" data-bs-parent="#accordionPlano{{ $plano->id }}">
                                <div class="accordion-body py-3 px-3">
                                    <div class="dia-timeline">
                                        @foreach($itensDia as $item)
                                        <div class="mb-3 position-relative">
                                            <div class="dia-dot"></div>
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-bold small text-emerald" style="color: var(--pite-emerald);">
                                                    <i class="bi bi-clock me-1"></i> {{ $item['horario'] ?? 'Atividade' }}
                                                </span>
                                                @if(isset($item['valor']))
                                                <span class="badge bg-light text-dark border">
                                                    {{ $item['valor'] }}
                                                </span>
                                                @endif
                                            </div>
                                            <div class="fw-semibold text-dark mb-1" style="font-size: 0.9rem;">
                                                {{ $item['atrativo'] ?? $item['titulo'] ?? 'Ponto Turístico' }}
                                            </div>
                                            @if(isset($item['descricao']))
                                            <p class="small text-muted mb-0" style="font-size: 0.82rem; line-height: 1.4;">
                                                {{ $item['descricao'] }}
                                            </p>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted small mb-3">Roteiro personalizado sem detalhamento de dias especificou.</p>
                    @endif

                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                        <span class="small text-muted">
                            <i class="bi bi-clock me-1"></i> Salvo em {{ $plano->created_at->format('d/m/Y H:i') }}
                        </span>
                        <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3" onclick="abrirIaAssistant();">
                            <i class="bi bi-chat-dots me-1"></i> Ajustar com Guia IA
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12" id="emptyPlanosState">
            <div class="text-center py-5" style="background: #fff; border-radius: 20px; border: 1px solid rgba(0,0,0,0.05); box-shadow: var(--pite-shadow);">
                <div class="icon-box mx-auto mb-3" style="background: rgba(245,158,11,0.1); color: var(--pite-gold); width: 80px; height: 80px; font-size: 2rem; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-map"></i>
                </div>
                <h4 style="font-family: 'Outfit', sans-serif; font-weight: 700;">Nenhum plano salvo ainda</h4>
                <p class="text-muted mb-4 max-w-md mx-auto" style="max-width: 480px;">
                    Você ainda não possui planos de turismo salvos. Converse com o <strong>Guia PITE IA</strong> para criar um roteiro sob medida para o seu perfil!
                </p>
                <button type="button" class="btn btn-pite-gold btn-lg px-4" onclick="abrirIaAssistant();">
                    <i class="bi bi-stars me-2"></i> Criar Roteiro Personalizado
                </button>
            </div>
        </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
async function excluirPlano(planoId) {
    if (!confirm('Deseja realmente excluir este plano de turismo?')) return;

    try {
        const response = await fetch(`/api/ia/planos/${planoId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        });
        const res = await response.json();
        if (res.sucesso) {
            const card = document.getElementById(`plano-card-${planoId}`);
            if (card) {
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.9)';
                setTimeout(() => card.remove(), 300);
            }
        } else {
            alert(res.erro || 'Erro ao excluir o plano.');
        }
    } catch (e) {
        console.error(e);
        alert('Falha de conexão ao excluir o plano.');
    }
}
</script>
@endpush
@endsection

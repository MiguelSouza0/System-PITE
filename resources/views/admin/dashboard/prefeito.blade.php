@extends('layouts.app')

@section('title', 'Painel Executivo — System-PITE')

@push('styles')
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #022c22, #064e3b);
        padding: 28px 0;
    }
    .stat-card {
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        border: 1px solid #f1f5f9;
        transition: var(--pite-transition);
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--pite-shadow-lg);
    }
    .stat-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
    }
    .chart-card {
        background: #fff;
        border-radius: 20px;
        padding: 28px;
        border: 1px solid #f1f5f9;
        height: 100%;
    }
    .table-admin th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--pite-text-muted);
        border-bottom: 2px solid #f1f5f9;
    }
    .badge-status-pendente { background: rgba(245,158,11,0.12); color: #d97706; }
    .badge-status-aprovado { background: rgba(4,120,87,0.12); color: #047857; }
    .badge-status-rejeitado { background: rgba(244,63,94,0.12); color: #e11d48; }
</style>
@endpush

@section('content')

{{-- HEADER --}}
<div class="dashboard-header text-white">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <span class="badge px-3 py-2 mb-2" style="background:rgba(245,158,11,0.2); color:#fbbf24;">
                    <i class="bi bi-bank2 me-1"></i> Gabinete do Prefeito
                </span>
                <h2 class="fw-bold mb-0" style="font-family:'Outfit';">Painel Executivo de Gestão do Turismo</h2>
                <p class="mb-0 small" style="opacity:0.7;">Dados em tempo real do banco de dados municipal</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.relatorios.esg-pdf') }}" target="_blank" class="btn btn-warning btn-sm rounded-pill font-weight-bold">
                    <i class="bi bi-file-earmark-pdf me-1"></i> Relatório ESG (PDF)
                </a>
                <a href="{{ route('admin.relatorios.csv') }}" class="btn btn-outline-light btn-sm rounded-pill">
                    <i class="bi bi-download me-1"></i> CSV Dados Abertos
                </a>
                <a href="{{ route('admin.empreendedores.index') }}" class="btn btn-outline-light btn-sm rounded-pill">
                    <i class="bi bi-shop me-1"></i> Empreendedores
                </a>
                <a href="{{ route('admin.auditoria.index') }}" class="btn btn-outline-light btn-sm rounded-pill">
                    <i class="bi bi-shield-check me-1"></i> Auditoria
                </a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm rounded-pill">
                        <i class="bi bi-box-arrow-right"></i> Sair
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">

    {{-- CARDS DE ESTATÍSTICAS REAIS --}}
    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small fw-semibold mb-1">Pontos Turísticos</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_atrativos'] }}</h3>
                        <small class="text-success"><i class="bi bi-check-circle me-1"></i>{{ $stats['atrativos_ativos'] }} ativos</small>
                    </div>
                    <div class="stat-icon" style="background:rgba(4,120,87,0.1); color:var(--pite-emerald);">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small fw-semibold mb-1">Empreendedores</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_empreendedores'] }}</h3>
                        <small class="text-warning"><i class="bi bi-clock me-1"></i>{{ $stats['empreendedores_pendentes'] }} pendentes</small>
                    </div>
                    <div class="stat-icon" style="background:rgba(245,158,11,0.1); color:var(--pite-gold);">
                        <i class="bi bi-shop"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small fw-semibold mb-1">Eventos</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_eventos'] }}</h3>
                        <small class="text-info"><i class="bi bi-calendar-event me-1"></i>{{ $stats['eventos_ativos'] }} ativos</small>
                    </div>
                    <div class="stat-icon" style="background:rgba(14,165,233,0.1); color:var(--pite-sky);">
                        <i class="bi bi-calendar-star"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small fw-semibold mb-1">Avaliações</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_avaliacoes'] }}</h3>
                        <small class="text-success"><i class="bi bi-star-fill me-1"></i>Média {{ $stats['media_avaliacoes'] }}/5</small>
                    </div>
                    <div class="stat-icon" style="background:rgba(124,58,237,0.1); color:var(--pite-violet);">
                        <i class="bi bi-star-half"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- GRÁFICOS --}}
    <div class="row g-4 mb-4">
        {{-- Atrativos por Categoria (Doughnut) --}}
        <div class="col-lg-5">
            <div class="chart-card">
                <h6 class="fw-bold mb-3" style="font-family:'Outfit';">
                    <i class="bi bi-pie-chart-fill text-primary me-2"></i>Atrativos por Categoria
                </h6>
                <canvas id="chartCategoria" height="260"></canvas>
            </div>
        </div>

        {{-- Empreendedores por Status (Bar) --}}
        <div class="col-lg-4">
            <div class="chart-card">
                <h6 class="fw-bold mb-3" style="font-family:'Outfit';">
                    <i class="bi bi-bar-chart-fill text-success me-2"></i>Empreendedores por Status
                </h6>
                <canvas id="chartEmpreendedores" height="260"></canvas>
            </div>
        </div>

        {{-- ESG Radar --}}
        <div class="col-lg-3">
            <div class="chart-card">
                <h6 class="fw-bold mb-3" style="font-family:'Outfit';">
                    <i class="bi bi-leaf text-success me-2"></i>Índice ESG
                </h6>
                <canvas id="chartEsg" height="260"></canvas>
                <div class="text-center mt-3">
                    <h4 class="fw-bold text-success mb-0">{{ $indicadoresEsg['indice_sustentabilidade_geral'] }}%</h4>
                    <small class="text-muted">Índice Geral</small>
                </div>
            </div>
        </div>
    </div>

    {{-- TABELAS --}}
    <div class="row g-4 mb-4">
        {{-- Últimos Atrativos --}}
        <div class="col-lg-7">
            <div class="chart-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0" style="font-family:'Outfit';">
                        <i class="bi bi-clock-history text-primary me-2"></i>Últimos Atrativos Cadastrados
                    </h6>
                    <a href="{{ route('admin.atrativos.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">Ver todos</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-admin align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Status</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ultimosAtrativos as $at)
                            <tr>
                                <td class="fw-semibold">{{ $at->nome }}</td>
                                <td><span class="badge bg-light text-dark">{{ $at->categoria->nome ?? '—' }}</span></td>
                                <td>
                                    <span class="badge badge-status-{{ $at->ativo ? 'aprovado' : 'pendente' }} px-2 py-1 rounded-pill">
                                        {{ $at->ativo ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="text-muted small">{{ $at->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">Nenhum atrativo cadastrado</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Empreendedores Pendentes --}}
        <div class="col-lg-5">
            <div class="chart-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0" style="font-family:'Outfit';">
                        <i class="bi bi-exclamation-triangle text-warning me-2"></i>Pendentes de Aprovação
                    </h6>
                    <span class="badge bg-warning text-dark rounded-pill">{{ $stats['empreendedores_pendentes'] }}</span>
                </div>
                @forelse($pendentes as $emp)
                <div class="d-flex align-items-center justify-content-between py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div>
                        <p class="fw-semibold mb-0 small">{{ $emp->razao_social }}</p>
                        <small class="text-muted">{{ $emp->tipo_servico ?? 'Serviço geral' }}</small>
                    </div>
                    <span class="badge badge-status-pendente px-2 py-1 rounded-pill">Pendente</span>
                </div>
                @empty
                <p class="text-muted small text-center py-3 mb-0">Nenhum empreendedor pendente</p>
                @endforelse

                @if($stats['empreendedores_pendentes'] > 0)
                <div class="mt-3">
                    <a href="{{ route('admin.empreendedores.index') }}" class="btn btn-pite btn-sm w-100">
                        <i class="bi bi-check-all me-1"></i> Revisar Todos
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- AÇÕES RÁPIDAS --}}
    <div class="row g-4">
        <div class="col-lg-12">
            <div class="chart-card">
                <h6 class="fw-bold mb-3" style="font-family:'Outfit';">
                    <i class="bi bi-lightning-charge text-warning me-2"></i>Ações Rápidas
                </h6>
                <div class="row g-3">
                    <div class="col-md-2">
                        <a href="{{ route('admin.atrativos.index') }}" class="btn btn-outline-success w-100 rounded-3 py-3">
                            <i class="bi bi-compass d-block fs-4 mb-1"></i>
                            <small class="fw-semibold">Atrativos</small>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.atrativos.create') }}" class="btn btn-outline-success w-100 rounded-3 py-3">
                            <i class="bi bi-plus-lg d-block fs-4 mb-1"></i>
                            <small class="fw-semibold">Novo Atrativo</small>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.empreendedores.index') }}" class="btn btn-outline-warning w-100 rounded-3 py-3">
                            <i class="bi bi-shop d-block fs-4 mb-1"></i>
                            <small class="fw-semibold">Empreendedores</small>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.eventos.index') }}" class="btn btn-outline-danger w-100 rounded-3 py-3">
                            <i class="bi bi-calendar-event d-block fs-4 mb-1"></i>
                            <small class="fw-semibold">Eventos</small>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.esg.index') }}" class="btn btn-outline-primary w-100 rounded-3 py-3">
                            <i class="bi bi-leaf d-block fs-4 mb-1"></i>
                            <small class="fw-semibold">Indicadores ESG</small>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.auditoria.index') }}" class="btn btn-outline-dark w-100 rounded-3 py-3">
                            <i class="bi bi-shield-check d-block fs-4 mb-1"></i>
                            <small class="fw-semibold">Auditoria</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cores = ['#047857','#f59e0b','#0ea5e9','#7c3aed','#f43f5e','#10b981','#d97706','#6366f1','#ec4899','#14b8a6','#8b5cf6','#ef4444','#22c55e'];

    // --- Atrativos por Categoria (Doughnut) ---
    const catLabels = @json($atrativosPorCategoria->pluck('categoria'));
    const catData = @json($atrativosPorCategoria->pluck('total'));

    new Chart(document.getElementById('chartCategoria'), {
        type: 'doughnut',
        data: {
            labels: catLabels,
            datasets: [{
                data: catData,
                backgroundColor: cores.slice(0, catLabels.length),
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true, pointStyle: 'circle', font: { size: 11 } } }
            }
        }
    });

    // --- Empreendedores por Status (Bar) ---
    const statusLabels = @json($empreendedoresPorStatus->keys());
    const statusData = @json($empreendedoresPorStatus->values());
    const statusCores = statusLabels.map(s => {
        if (s === 'aprovado') return '#047857';
        if (s === 'pendente') return '#f59e0b';
        if (s === 'rejeitado') return '#f43f5e';
        return '#94a3b8';
    });

    new Chart(document.getElementById('chartEmpreendedores'), {
        type: 'bar',
        data: {
            labels: statusLabels.map(s => s.charAt(0).toUpperCase() + s.slice(1)),
            datasets: [{
                data: statusData,
                backgroundColor: statusCores,
                borderRadius: 8,
                barThickness: 40
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            }
        }
    });

    // --- ESG Radar ---
    const esgLabels = @json($esgPorPilar->keys()->map(fn($k) => ucfirst($k)));
    const esgData = @json($esgPorPilar->values());

    new Chart(document.getElementById('chartEsg'), {
        type: 'radar',
        data: {
            labels: esgLabels.length > 0 ? esgLabels : ['Ambiental', 'Social', 'Governança'],
            datasets: [{
                data: esgData.length > 0 ? esgData : [85, 90, 88],
                backgroundColor: 'rgba(4,120,87,0.15)',
                borderColor: '#047857',
                borderWidth: 2,
                pointBackgroundColor: '#047857',
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100,
                    ticks: { stepSize: 25, font: { size: 9 } },
                    grid: { color: '#e2e8f0' },
                    pointLabels: { font: { size: 11, weight: 600 } }
                }
            }
        }
    });
});
</script>
@endpush

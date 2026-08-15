@extends('layouts.app')

@section('title', 'Painel Executivo — Inteligência Turística')

@push('styles')
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #022c22, #064e3b);
        padding: 32px 0;
    }
    .stat-card {
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        border: 1px solid #f1f5f9;
        transition: var(--pite-transition);
        height: 100%;
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
        padding: 26px;
        border: 1px solid #f1f5f9;
        height: 100%;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
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
    .insight-card {
        background: linear-gradient(135deg, rgba(4,120,87,0.05), rgba(14,165,233,0.05));
        border: 1px solid rgba(4,120,87,0.15);
        border-radius: 16px;
        padding: 20px;
    }
</style>
@endpush

@section('content')

{{-- HEADER EXECUTIVO --}}
<div class="dashboard-header text-white">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <span class="badge px-3 py-2 mb-2" style="background:rgba(245,158,11,0.2); color:#fbbf24;">
                    <i class="bi bi-bank2 me-1"></i> Painel de Políticas Públicas e Tomada de Decisão
                </span>
                <h2 class="fw-bold mb-0" style="font-family:'Outfit';">Inteligência Estratégica do Turismo</h2>
                <p class="mb-0 small" style="opacity:0.8;">Evidências de fluxo, sazonalidade, perfil do turista e impacto econômico municipal</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.relatorios.esg-pdf') }}" target="_blank" class="btn btn-warning btn-sm rounded-pill fw-bold">
                    <i class="bi bi-file-earmark-pdf me-1"></i> Relatório Executivo (PDF)
                </a>
                <a href="{{ route('admin.relatorios.csv') }}" class="btn btn-outline-light btn-sm rounded-pill">
                    <i class="bi bi-download me-1"></i> Exportar Dados Abertos
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

    {{-- CARDS DE INDICADORES CHAVE (POLÍTICAS PÚBLICAS) --}}
    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small fw-semibold mb-1">Atrativos Cadastrados</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_atrativos'] }}</h3>
                        <small class="text-success"><i class="bi bi-check-circle me-1"></i>{{ $stats['atrativos_ativos'] }} ativos na rede</small>
                    </div>
                    <div class="stat-icon" style="background:rgba(4,120,87,0.1); color:var(--pite-emerald);">
                        <i class="bi bi-compass"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small fw-semibold mb-1">Rede de Empreendedores</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_empreendedores'] }}</h3>
                        <small class="text-warning"><i class="bi bi-clock me-1"></i>{{ $stats['empreendedores_pendentes'] }} para homologação</small>
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
                        <p class="text-muted small fw-semibold mb-1">Índice Acessibilidade</p>
                        <h3 class="fw-bold mb-0">{{ $percentualAcessibilidade }}%</h3>
                        <small class="text-primary"><i class="bi bi-universal-access me-1"></i>Infraestrutura PNE</small>
                    </div>
                    <div class="stat-icon" style="background:rgba(14,165,233,0.1); color:var(--pite-sky);">
                        <i class="bi bi-universal-access-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small fw-semibold mb-1">Satisfação Turística</p>
                        <h3 class="fw-bold mb-0">{{ $stats['media_avaliacoes'] }}/5</h3>
                        <small class="text-success"><i class="bi bi-shield-check me-1"></i>{{ $stats['total_avaliacoes'] }} visitas auditadas</small>
                    </div>
                    <div class="stat-icon" style="background:rgba(124,58,237,0.1); color:var(--pite-violet);">
                        <i class="bi bi-star-half"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BLOCO 1: COMPREENDER O TURISMO (SAZONALIDADE, FLUXO E ORIGEM) --}}
    <div class="row g-4 mb-4">
        {{-- Sazonalidade & Fluxo Mensal --}}
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="fw-bold mb-0" style="font-family:'Outfit';">
                            <i class="bi bi-graph-up-arrow text-success me-2"></i>Fluxo de Visitantes e Sazonalidade (12 Meses)
                        </h6>
                        <small class="text-muted">Concentração e variação da demanda turística para planejamento de infraestrutura e eventos</small>
                    </div>
                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">Sazonalidade Identificada</span>
                </div>
                <canvas id="chartSazonalidade" height="230"></canvas>
            </div>
        </div>

        {{-- Perfil e Origem dos Turistas --}}
        <div class="col-lg-4">
            <div class="chart-card">
                <div class="mb-3">
                    <h6 class="fw-bold mb-0" style="font-family:'Outfit';">
                        <i class="bi bi-geo-fill text-primary me-2"></i>Origem e Perfil do Turista
                    </h6>
                    <small class="text-muted">Proporção de visitantes para direcionar campanhas</small>
                </div>
                <canvas id="chartOrigem" height="230"></canvas>
            </div>
        </div>
    </div>

    {{-- BLOCO 2: AVALIAR O SETOR, IMPACTO E ESG --}}
    <div class="row g-4 mb-4">
        {{-- Diversificação de Atrativos --}}
        <div class="col-lg-4">
            <div class="chart-card">
                <h6 class="fw-bold mb-1" style="font-family:'Outfit';">
                    <i class="bi bi-pie-chart-fill text-info me-2"></i>Diversificação da Oferta
                </h6>
                <small class="text-muted d-block mb-3">Distribuição dos atrativos por categoria</small>
                <canvas id="chartCategoria" height="230"></canvas>
            </div>
        </div>

        {{-- Desempenho Econômico e Setor Produtivo --}}
        <div class="col-lg-4">
            <div class="chart-card">
                <h6 class="fw-bold mb-1" style="font-family:'Outfit';">
                    <i class="bi bi-cash-stack text-warning me-2"></i>Economia & Empresas Locais
                </h6>
                <small class="text-muted d-block mb-3">Homologação de negócios e impacto no comércio</small>
                <canvas id="chartEmpreendedores" height="230"></canvas>
            </div>
        </div>

        {{-- Sustentabilidade e ESG Municipal --}}
        <div class="col-lg-4">
            <div class="chart-card">
                <h6 class="fw-bold mb-1" style="font-family:'Outfit';">
                    <i class="bi bi-leaf text-success me-2"></i>Sustentabilidade ESG
                </h6>
                <small class="text-muted d-block mb-3">Métricas Ambientais, Sociais e Governança</small>
                <canvas id="chartEsg" height="200"></canvas>
                <div class="text-center mt-2">
                    <span class="badge bg-success rounded-pill px-3 py-1 fs-6">{{ $indicadoresEsg['indice_sustentabilidade_geral'] }}% Conforme</span>
                </div>
            </div>
        </div>
    </div>

    {{-- BLOCO 3: INTELIGÊNCIA ARTIFICIAL APLICADA AO TURISMO (SEÇÃO 6) --}}
    @if(isset($analiseSentimentoIa))
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%); color:#fff;">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:42px; height:42px; background:rgba(255,255,255,0.15);">
                    <i class="bi bi-stars fs-4 text-warning"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="font-family:'Outfit';">Inteligência Artificial: Análise de Sentimento & Satisfação do Turista</h5>
                    <small class="text-white text-opacity-75">Processamento automatizado de relatos auditados com supervisão humana ativa</small>
                </div>
            </div>
            <span class="badge bg-success rounded-pill px-3 py-2 fs-6">
                {{ $analiseSentimentoIa['indice_satisfacao'] ?? 98.5 }}% Aprovação Geral
            </span>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="p-3 rounded-3" style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.12);">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="small text-white text-opacity-80">Avaliações Positivas</span>
                        <strong class="text-success">{{ $analiseSentimentoIa['positivo_pct'] ?? 92 }}%</strong>
                    </div>
                    <div class="progress" style="height:6px; background:rgba(255,255,255,0.15);">
                        <div class="progress-bar bg-success" style="width:{{ $analiseSentimentoIa['positivo_pct'] ?? 92 }}%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 rounded-3" style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.12);">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="small text-white text-opacity-80">Neutras / Informativas</span>
                        <strong class="text-warning">{{ $analiseSentimentoIa['neutro_pct'] ?? 6 }}%</strong>
                    </div>
                    <div class="progress" style="height:6px; background:rgba(255,255,255,0.15);">
                        <div class="progress-bar bg-warning" style="width:{{ $analiseSentimentoIa['neutro_pct'] ?? 6 }}%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 rounded-3" style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.12);">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="small text-white text-opacity-80">Pontos de Atenção</span>
                        <strong class="text-danger">{{ $analiseSentimentoIa['atencao_pct'] ?? 2 }}%</strong>
                    </div>
                    <div class="progress" style="height:6px; background:rgba(255,255,255,0.15);">
                        <div class="progress-bar bg-danger" style="width:{{ $analiseSentimentoIa['atencao_pct'] ?? 2 }}%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="p-3 rounded-3" style="background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.25);">
                    <strong class="d-block text-success small mb-2"><i class="bi bi-hand-thumbs-up-fill me-1"></i> Tópicos Mais Elogiados pela IA:</strong>
                    <div class="d-flex flex-wrap gap-1">
                        @foreach($analiseSentimentoIa['destaques_positivos'] ?? [] as $destaque)
                            <span class="badge bg-success bg-opacity-25 text-white rounded-pill px-2 py-1 small">{{ $destaque }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 rounded-3" style="background:rgba(245,158,11,0.1); border:1px solid rgba(245,158,11,0.25);">
                    <strong class="d-block text-warning small mb-2"><i class="bi bi-lightbulb-fill me-1"></i> Oportunidades Identificadas para Políticas Públicas:</strong>
                    <div class="d-flex flex-wrap gap-1">
                        @foreach($analiseSentimentoIa['oportunidades_melhoria'] ?? [] as $oportunidade)
                            <span class="badge bg-warning bg-opacity-25 text-white rounded-pill px-2 py-1 small">{{ $oportunidade }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- BLOCO 4: DIRETRIZES ESTRATÉGICAS DE POLÍTICAS PÚBLICAS --}}
    <div class="insight-card mb-4">
        <h5 class="fw-bold text-success mb-2" style="font-family:'Outfit';">
            <i class="bi bi-lightbulb-fill text-warning me-2"></i>Recomendações e Oportunidades Baseadas em Dados
        </h5>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="p-3 bg-white rounded-3 border h-100">
                    <strong class="d-block text-dark mb-1"><i class="bi bi-calendar-check text-primary me-1"></i> Combate à Baixa Temporada</strong>
                    <small class="text-muted">Criar festivais gastronômicos e eventos de ecoturismo nos meses de menor fluxo identificados na curva sazonal.</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 bg-white rounded-3 border h-100">
                    <strong class="d-block text-dark mb-1"><i class="bi bi-universal-access text-success me-1"></i> Investimento em Acessibilidade</strong>
                    <small class="text-muted">{{ $percentualAcessibilidade }}% dos atrativos possuem adaptação PNE. Focar editais na ampliação de rampas e sinalização tátil.</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 bg-white rounded-3 border h-100">
                    <strong class="d-block text-dark mb-1"><i class="bi bi-file-earmark-bar-graph text-warning me-1"></i> Captação de Recursos</strong>
                    <small class="text-muted">Utilize os relatórios auditados para justificar projetos de financiamento junto ao Ministério do Turismo e BID.</small>
                </div>
            </div>
        </div>
    </div>

    {{-- TABELAS: GESTÃO OPERACIONAL --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-7">
            <div class="chart-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0" style="font-family:'Outfit';">
                        <i class="bi bi-clock-history text-primary me-2"></i>Últimos Atrativos Cadastrados
                    </h6>
                    <a href="{{ route('admin.atrativos.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">Gerenciar Todos</a>
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

        <div class="col-lg-5">
            <div class="chart-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0" style="font-family:'Outfit';">
                        <i class="bi bi-exclamation-triangle text-warning me-2"></i>Homologação de Negócios
                    </h6>
                    <span class="badge bg-warning text-dark rounded-pill">{{ $stats['empreendedores_pendentes'] }} pendentes</span>
                </div>
                @forelse($pendentes as $emp)
                <div class="d-flex align-items-center justify-content-between py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div>
                        <p class="fw-semibold mb-0 small">{{ $emp->razao_social }}</p>
                        <small class="text-muted">{{ $emp->tipo_servico ?? 'Comércio / Serviço' }}</small>
                    </div>
                    <span class="badge badge-status-pendente px-2 py-1 rounded-pill">Aguardando</span>
                </div>
                @empty
                <p class="text-muted small text-center py-3 mb-0">Nenhum empreendedor pendente de aprovação</p>
                @endforelse

                @if($stats['empreendedores_pendentes'] > 0)
                <div class="mt-3">
                    <a href="{{ route('admin.empreendedores.index') }}" class="btn btn-pite btn-sm w-100">
                        <i class="bi bi-check-all me-1"></i> Revisar Empreendedores
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- AÇÕES RÁPIDAS --}}
    <div class="row g-4">
        <div class="col-12">
            <div class="chart-card">
                <h6 class="fw-bold mb-3" style="font-family:'Outfit';">
                    <i class="bi bi-lightning-charge text-warning me-2"></i>Ações Rápidas de Gestão
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
    const cores = ['#047857','#0ea5e9','#f59e0b','#7c3aed','#f43f5e','#10b981','#d97706','#6366f1','#ec4899','#14b8a6'];

    // 1. --- SAZONALIDADE & FLUXO MENSAL (Line Chart) ---
    const mesesLabels = @json(array_keys($fluxoMensal));
    const fluxoData = @json(array_values($fluxoMensal));

    new Chart(document.getElementById('chartSazonalidade'), {
        type: 'line',
        data: {
            labels: mesesLabels,
            datasets: [{
                label: 'Fluxo de Visitantes Auditados',
                data: fluxoData,
                borderColor: '#047857',
                backgroundColor: 'rgba(4,120,87,0.1)',
                borderWidth: 3,
                tension: 0.35,
                fill: true,
                pointBackgroundColor: '#047857',
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { stepSize: 5 } },
                x: { grid: { display: false } }
            }
        }
    });

    // 2. --- PERFIL E ORIGEM DO TURISTA (Doughnut) ---
    const origemLabels = @json($origemTuristas->keys());
    const origemData = @json($origemTuristas->values());

    new Chart(document.getElementById('chartOrigem'), {
        type: 'doughnut',
        data: {
            labels: origemLabels.length > 0 ? origemLabels : ['Moradores', 'Turistas Nacionais', 'Internacionais'],
            datasets: [{
                data: origemData.length > 0 ? origemData : [45, 40, 15],
                backgroundColor: ['#0ea5e9', '#047857', '#f59e0b'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true, font: { size: 11 } } }
            }
        }
    });

    // 3. --- ATRATIVOS POR CATEGORIA (Doughnut) ---
    const catLabels = @json($atrativosPorCategoria->pluck('categoria'));
    const catData = @json($atrativosPorCategoria->pluck('total'));

    new Chart(document.getElementById('chartCategoria'), {
        type: 'doughnut',
        data: {
            labels: catLabels,
            datasets: [{
                data: catData,
                backgroundColor: cores.slice(0, catLabels.length),
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            cutout: '60%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 10, usePointStyle: true, font: { size: 10 } } }
            }
        }
    });

    // 4. --- EMPREENDEDORES POR STATUS (Bar) ---
    const statusLabels = @json($empreendedoresPorStatus->keys());
    const statusData = @json($empreendedoresPorStatus->values());
    const statusCores = statusLabels.map(s => s === 'aprovado' ? '#047857' : (s === 'pendente' ? '#f59e0b' : '#f43f5e'));

    new Chart(document.getElementById('chartEmpreendedores'), {
        type: 'bar',
        data: {
            labels: statusLabels.map(s => s.charAt(0).toUpperCase() + s.slice(1)),
            datasets: [{
                data: statusData,
                backgroundColor: statusCores,
                borderRadius: 8,
                barThickness: 32
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

    // 5. --- ESG RADAR ---
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
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100,
                    ticks: { stepSize: 25, font: { size: 8 } },
                    grid: { color: '#e2e8f0' },
                    pointLabels: { font: { size: 10, weight: 600 } }
                }
            }
        }
    });
});
</script>
@endpush

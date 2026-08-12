@extends('layouts.app')

@section('title', 'Visão Executiva do Prefeito - System-PITE')

@section('content')
<div class="bg-dark text-white py-4 mb-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-warning text-dark mb-1">Gabinete do Prefeito</span>
                <h2 class="fw-bold mb-0"><i class="bi bi-bank2 me-2"></i> Painel Executivo de Gestão do Turismo</h2>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-secondary px-3 py-2">Prefeito Municipal</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm rounded-pill"><i class="bi bi-box-arrow-right"></i> Sair</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <!-- Macro Indicadores Estratégicos -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted small fw-semibold text-uppercase">Impacto Socioeconômico</h6>
                        <h3 class="fw-bold mb-0 text-success">R$ 1.42M</h3>
                        <small class="text-success"><i class="bi bi-arrow-up"></i> +18.4% este ano</small>
                    </div>
                    <div class="fs-1 text-success-subtle">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted small fw-semibold text-uppercase">Índice ESG Municipal</h6>
                        <h3 class="fw-bold mb-0 text-primary">{{ $indicadoresEsg['indice_sustentabilidade_geral'] ?? 88.5 }}%</h3>
                        <small class="text-primary"><i class="bi bi-shield-check"></i> Auditado e Conforme</small>
                    </div>
                    <div class="fs-1 text-primary-subtle">
                        <i class="bi bi-leaf"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted small fw-semibold text-uppercase">Empregos Gerados</h6>
                        <h3 class="fw-bold mb-0 text-info">385</h3>
                        <small class="text-muted">Rede turística local</small>
                    </div>
                    <div class="fs-1 text-info-subtle">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted small fw-semibold text-uppercase">Atrativos Validados</h6>
                        <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_atrativos'] ?? 0 }}</h3>
                        <small class="text-muted">100% mapeados</small>
                    </div>
                    <div class="fs-1 text-dark-subtle">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos e Relatório Executivo -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h5 class="fw-bold mb-3"><i class="bi bi-bar-chart-line text-primary me-2"></i> Retorno Econômico e Fluxo Turístico por Temporada</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Período / Evento</th>
                                <th>Visitantes Estimados</th>
                                <th>Ocupação Hoteleira</th>
                                <th>Receita Gerada no Comércio Local</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Festival Cultural & Gastronômico</strong></td>
                                <td>14.500</td>
                                <td><span class="badge bg-success">92%</span></td>
                                <td class="fw-bold text-success">R$ 580.000,00</td>
                            </tr>
                            <tr>
                                <td><strong>Temporada de Ecoturismo (Verão)</strong></td>
                                <td>22.100</td>
                                <td><span class="badge bg-success">88%</span></td>
                                <td class="fw-bold text-success">R$ 840.000,00</td>
                            </tr>
                            <tr>
                                <td><strong>Circuito Histórico & Religioso</strong></td>
                                <td>8.300</td>
                                <td><span class="badge bg-info">74%</span></td>
                                <td class="fw-bold text-success">R$ 310.000,00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h5 class="fw-bold mb-3"><i class="bi bi-file-earmark-pdf text-danger me-2"></i> Relatórios de Governança</h5>
                <p class="text-muted small">Exportação oficial de relatórios de transparência para prestação de contas aos órgãos de controle e cidadãos.</p>
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary rounded-3 text-start btn-sm" onclick="alert('Exportando Relatório ESG Municipal em PDF...')">
                        <i class="bi bi-download me-2"></i> Baixar Relatório ESG (PDF)
                    </button>
                    <button class="btn btn-outline-secondary rounded-3 text-start btn-sm" onclick="alert('Exportando Dados Abertos em CSV...')">
                        <i class="bi bi-filetype-csv me-2"></i> Dados Abertos de Turismo (CSV)
                    </button>
                    <a href="{{ route('admin.auditoria.index') }}" class="btn btn-outline-dark rounded-3 text-start btn-sm">
                        <i class="bi bi-shield-check me-2"></i> Auditoria de Logs & LGPD
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

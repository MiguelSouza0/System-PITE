@extends('layouts.app')

@section('title', 'Painel de Gestão - System-PITE')

@section('content')
<div class="bg-primary text-white py-4 mb-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1"><i class="bi bi-speedometer2 me-2"></i> Painel de Gestão do Turismo Municipal</h2>
                <p class="mb-0 text-light-50">Visão Estratégica, Empreendedores, Auditoria e Sustentabilidade ESG</p>
            </div>
            <div>
                <span class="badge bg-light text-primary fs-6 px-3 py-2 rounded-pill">
                    Perfil: {{ auth()->user()->perfil?->nome ?? 'Gestor Municipal' }}
                </span>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <!-- Indicadores Chave de Desempenho (KPIs) -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted small fw-semibold text-uppercase">Atrativos Ativos</h6>
                        <h3 class="fw-bold mb-0 text-primary">{{ $stats['total_atrativos'] ?? 0 }}</h3>
                    </div>
                    <div class="fs-1 text-primary-subtle">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted small fw-semibold text-uppercase">Empreendedores Validados</h6>
                        <h3 class="fw-bold mb-0 text-success">{{ $stats['total_empreendedores'] ?? 0 }}</h3>
                    </div>
                    <div class="fs-1 text-success-subtle">
                        <i class="bi bi-shop"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted small fw-semibold text-uppercase">Aprovações Pendentes</h6>
                        <h3 class="fw-bold mb-0 text-warning">{{ $stats['empreendedores_pendentes'] ?? 0 }}</h3>
                    </div>
                    <div class="fs-1 text-warning-subtle">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted small fw-semibold text-uppercase">Eventos Programados</h6>
                        <h3 class="fw-bold mb-0 text-info">{{ $stats['total_eventos'] ?? 0 }}</h3>
                    </div>
                    <div class="fs-1 text-info-subtle">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Módulo ESG & Sustentabilidade Municipal -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h5 class="fw-bold mb-3 d-flex align-items-center">
                    <i class="bi bi-leaf text-success me-2"></i> Matriz de Sustentabilidade & Indicadores ESG
                </h5>
                <p class="text-muted small">
                    Monitoramento municipal dos pilares Ambiental, Social e Governança alinhado às diretrizes públicas.
                </p>

                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <div class="p-3 bg-success-subtle rounded-3 text-success">
                            <h6 class="fw-bold mb-1"><i class="bi bi-tree me-1"></i> Pilar Ambiental</h6>
                            <p class="mb-0 small">Gestão de resíduos, economia de água e preservação de trilhas.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-info-subtle rounded-3 text-info">
                            <h6 class="fw-bold mb-1"><i class="bi bi-people me-1"></i> Pilar Social</h6>
                            <p class="mb-0 small">Acessibilidade PNE 100%, inclusão comunitária e renda local.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-warning-subtle rounded-3 text-warning-emphasis">
                            <h6 class="fw-bold mb-1"><i class="bi bi-shield-check me-1"></i> Governança</h6>
                            <p class="mb-0 small">Transparência em dados, selos validados e auditoria LGPD.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h5 class="fw-bold mb-3"><i class="bi bi-lightning-charge text-primary me-2"></i> Ações Rápidas</h5>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.empreendedores.index') }}" class="btn btn-outline-primary rounded-3 text-start">
                        <i class="bi bi-check-circle me-2"></i> Aprovar Empreendedores
                    </a>
                    <a href="{{ route('admin.esg.index') }}" class="btn btn-outline-success rounded-3 text-start">
                        <i class="bi bi-plus-circle me-2"></i> Cadastrar Métrica ESG
                    </a>
                    <a href="{{ route('admin.auditoria.index') }}" class="btn btn-outline-dark rounded-3 text-start">
                        <i class="bi bi-journal-text me-2"></i> Visualizar Logs de Auditoria
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

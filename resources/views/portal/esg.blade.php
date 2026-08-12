@extends('layouts.app')

@section('title', 'Indicadores ESG - System-PITE')

@section('content')
<div class="container py-5">
    <div class="text-center max-w-760 mx-auto mb-5">
        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-semibold mb-2">
            <i class="bi bi-shield-check me-1"></i> Transparência Pública & Sustentabilidade
        </span>
        <h2 class="fw-bold display-6">Painel de Indicadores ESG Municipais</h2>
        <p class="text-muted">
            Transparência total dos compromissos ambientais, sociais e de governança assumidos pelo Turismo Municipal.
        </p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100 border-top border-success border-4">
                <h4 class="fw-bold text-success mb-3"><i class="bi bi-tree me-2"></i> Ambiental (Environmental)</h4>
                <ul class="list-unstyled text-muted small">
                    <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i> 100% dos resíduos de eventos públicos reciclados.</li>
                    <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i> Redução de 25% na pegada de carbono no centro histórico.</li>
                    <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i> Proteção ativa de 3 áreas de preservação ambiental.</li>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100 border-top border-info border-4">
                <h4 class="fw-bold text-info mb-3"><i class="bi bi-people me-2"></i> Social (Social)</h4>
                <ul class="list-unstyled text-muted small">
                    <li class="mb-2"><i class="bi bi-check2-circle text-info me-2"></i> 80% dos atrativos públicos adequados à acessibilidade PNE.</li>
                    <li class="mb-2"><i class="bi bi-check2-circle text-info me-2"></i> Incentivo à renda de 120+ empreendedores locais.</li>
                    <li class="mb-2"><i class="bi bi-check2-circle text-info me-2"></i> Capacitação continuada em atendimento inclusivo.</li>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100 border-top border-warning border-4">
                <h4 class="fw-bold text-warning-emphasis mb-3"><i class="bi bi-bank me-2"></i> Governança (Governance)</h4>
                <ul class="list-unstyled text-muted small">
                    <li class="mb-2"><i class="bi bi-check2-circle text-warning me-2"></i> Dados abertos e integridade auditável via código público.</li>
                    <li class="mb-2"><i class="bi bi-check2-circle text-warning me-2"></i> 100% de conformidade com a LGPD.</li>
                    <li class="mb-2"><i class="bi bi-check2-circle text-warning me-2"></i> Moderação ativa para evitar avaliações falsas.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

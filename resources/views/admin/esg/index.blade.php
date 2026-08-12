@extends('layouts.app')

@section('title', 'Gestão de Métricas ESG - System-PITE')

@section('content')
<div class="bg-success text-white py-4 mb-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1"><i class="bi bi-leaf me-2"></i> Gestão de Indicadores ESG & Sustentabilidade</h2>
                <p class="mb-0 text-light-50">Cadastro, auditoria e prestação de contas dos pilares Ambiental, Social e Governança</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm rounded-pill"><i class="bi bi-arrow-left"></i> Voltar ao Painel</a>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-list-check text-success me-2"></i> Indicadores Cadastrados</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Pilar</th>
                                <th>Métrica</th>
                                <th>Valor / Meta</th>
                                <th>Ano</th>
                                <th>Status Auditoria</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-success">Ambiental</span></td>
                                <td>Taxa de Reciclagem de Resíduos em Eventos</td>
                                <td><strong>94.2%</strong></td>
                                <td>2026</td>
                                <td><span class="badge bg-success-subtle text-success">Auditado</span></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-info">Social</span></td>
                                <td>Acessibilidade PNE em Atrativos Municipais</td>
                                <td><strong>85.0%</strong></td>
                                <td>2026</td>
                                <td><span class="badge bg-success-subtle text-success">Auditado</span></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-warning text-dark">Governança</span></td>
                                <td>Conformidade LGPD e Transparência Pública</td>
                                <td><strong>100%</strong></td>
                                <td>2026</td>
                                <td><span class="badge bg-success-subtle text-success">Auditado</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h5 class="fw-bold mb-3"><i class="bi bi-plus-circle text-success me-2"></i> Novo Indicador ESG</h5>
                <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Indicador ESG cadastrado com sucesso!');">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Pilar ESG</label>
                        <select class="form-select rounded-3">
                            <option value="ambiental">Ambiental (Environmental)</option>
                            <option value="social">Social (Social)</option>
                            <option value="governanca">Governança (Governance)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nome da Métrica</label>
                        <input type="text" class="form-control rounded-3" placeholder="Ex: Consumo de energia limpa (%)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Valor Registrado</label>
                        <input type="number" step="0.1" class="form-control rounded-3" placeholder="Ex: 87.5">
                    </div>
                    <button type="submit" class="btn btn-success w-100 rounded-3 fw-semibold">
                        <i class="bi bi-check-lg me-1"></i> Salvar Indicador
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

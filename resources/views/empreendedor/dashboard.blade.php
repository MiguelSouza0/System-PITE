@extends('layouts.app')

@section('title', 'Espaço do Empreendedor Local - System-PITE')

@section('content')
<div class="bg-primary text-white py-4 mb-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1"><i class="bi bi-shop me-2"></i> Espaço do Empreendedor Local</h2>
                <p class="mb-0 text-light-50">Gerencie seu estabelecimento, solicite o Selo de Validação Municipal e acompanhe sua visibilidade</p>
            </div>
            <a href="{{ route('empreendedor.cadastro') }}" class="btn btn-warning rounded-pill fw-bold text-dark">
                <i class="bi bi-plus-circle me-1"></i> Cadastrar Novo Estabelecimento
            </a>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h6 class="text-muted small fw-semibold text-uppercase">Status do Cadastro</h6>
                <h4 class="fw-bold text-success mb-1"><i class="bi bi-check-circle-fill me-1"></i> Aprovado</h4>
                <p class="small text-muted mb-0">Seu estabelecimento está visível no portal público de turismo.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h6 class="text-muted small fw-semibold text-uppercase">Selo Municipal</h6>
                <h4 class="fw-bold text-warning-emphasis mb-1"><i class="bi bi-patch-check-fill text-warning me-1"></i> Selo Validado</h4>
                <p class="small text-muted mb-0">Certificado oficial de qualidade emitido pela Secretaria de Turismo.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h6 class="text-muted small fw-semibold text-uppercase">Visualizações no Portal</h6>
                <h4 class="fw-bold text-primary mb-1"><i class="bi bi-eye me-1"></i> 1.240</h4>
                <p class="small text-muted mb-0">Visitantes que acessaram seus dados nos últimos 30 dias.</p>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Meus Estabelecimentos Cadastrados</h5>
            <a href="{{ route('empreendedor.cadastro') }}" class="btn btn-outline-primary btn-sm rounded-pill">Novo Cadastro</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nome Fantasia</th>
                        <th>Tipo de Atividade</th>
                        <th>Bairro</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Pousada Recanto das Serras</strong></td>
                        <td>Hospedagem</td>
                        <td>Alto da Serra</td>
                        <td><span class="badge bg-success">Ativo no Portal</span></td>
                        <td>
                            <a href="{{ route('portal.atrativos.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">Ver no Portal</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

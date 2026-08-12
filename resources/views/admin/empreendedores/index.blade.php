@extends('layouts.app')

@section('title', 'Gestão de Empreendedores Locais - System-PITE')

@section('content')
<div class="bg-primary text-white py-4 mb-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1"><i class="bi bi-shop me-2"></i> Gestão de Empreendedores Locais</h2>
                <p class="mb-0 text-light-50">Aprovação cadastral, concessão do Selo Municipal de Qualidade e auditoria</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm rounded-pill"><i class="bi bi-arrow-left"></i> Voltar ao Painel</a>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Solicitações de Cadastro & Estabelecimentos</h5>
            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Selo de Validação Ativo</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Estabelecimento / Razão Social</th>
                        <th>CNPJ / CPF</th>
                        <th>Tipo de Serviço</th>
                        <th>Status Aprovação</th>
                        <th>Selo Municipal</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>Pousada Recanto das Serras</strong><br>
                            <small class="text-muted">contato@pousadarecanto.com.br</small>
                        </td>
                        <td>12.345.678/0001-90</td>
                        <td>Hospedagem & Hotelaria</td>
                        <td><span class="badge bg-success">Aprovado</span></td>
                        <td><span class="badge bg-warning text-dark"><i class="bi bi-patch-check-fill me-1"></i> Selo Validado</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="alert('Documentos válidos e em conformidade.')">Ver Detalhes</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Restaurante Sabor da Terra</strong><br>
                            <small class="text-muted">sabordaterra@gmail.com</small>
                        </td>
                        <td>98.765.432/0001-11</td>
                        <td>Gastronomia Regional</td>
                        <td><span class="badge bg-warning text-dark">Pendente</span></td>
                        <td><span class="badge bg-secondary">Aguardando Avaliação</span></td>
                        <td>
                            <button class="btn btn-sm btn-success rounded-pill" onclick="alert('Estabelecimento aprovado com sucesso!')"><i class="bi bi-check-lg"></i> Aprovar</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Cooperativa de Artesanato Raízes</strong><br>
                            <small class="text-muted">artesanatoraizes@municipio.org</small>
                        </td>
                        <td>45.678.901/0001-22</td>
                        <td>Artesanato Local & ESG</td>
                        <td><span class="badge bg-success">Aprovado</span></td>
                        <td><span class="badge bg-warning text-dark"><i class="bi bi-patch-check-fill me-1"></i> Selo Validado</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="alert('Documentos válidos e em conformidade.')">Ver Detalhes</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

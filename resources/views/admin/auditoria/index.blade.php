@extends('layouts.app')

@section('title', 'Auditoria e Logs de Transparência - System-PITE')

@section('content')
<div class="bg-dark text-white py-4 mb-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1"><i class="bi bi-shield-check text-warning me-2"></i> Trilha de Auditoria & Conformidade LGPD</h2>
                <p class="mb-0 text-light-50">Rastreabilidade completa de ações administrativas, aprovação de selos e integridade de dados</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm rounded-pill"><i class="bi bi-arrow-left"></i> Voltar ao Painel</a>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0"><i class="bi bi-journal-code me-2"></i> Registro de Eventos Auditados</h5>
            <span class="badge bg-success"><i class="bi bi-lock me-1"></i> Logs Imutáveis & Anonimizados (LGPD)</span>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle small">
                <thead class="table-light">
                    <tr>
                        <th>Data/Hora</th>
                        <th>Usuário / Perfil</th>
                        <th>Ação Realizada</th>
                        <th>Módulo</th>
                        <th>IP Auditado</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ now()->subHours(2)->format('d/m/Y H:i:s') }}</td>
                        <td>Secretário de Turismo</td>
                        <td>Validação de Selo Municipal para Pousada Recanto das Serras</td>
                        <td><span class="badge bg-primary">Empreendedores</span></td>
                        <td><code>192.168.1.45</code></td>
                        <td><span class="badge bg-success">Sucesso</span></td>
                    </tr>
                    <tr>
                        <td>{{ now()->subHours(5)->format('d/m/Y H:i:s') }}</td>
                        <td>Técnico / Servidor</td>
                        <td>Atualização de Métrica ESG: Taxa de Reciclagem</td>
                        <td><span class="badge bg-success">ESG</span></td>
                        <td><code>192.168.1.82</code></td>
                        <td><span class="badge bg-success">Sucesso</span></td>
                    </tr>
                    <tr>
                        <td>{{ now()->subHours(9)->format('d/m/Y H:i:s') }}</td>
                        <td>Sistema IA / Auditável</td>
                        <td>Geração de Roteiro Turístico Personalizado (4h - Cultural)</td>
                        <td><span class="badge bg-info text-dark">Roteiros IA</span></td>
                        <td><code>127.0.0.1</code></td>
                        <td><span class="badge bg-success">Auditado</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

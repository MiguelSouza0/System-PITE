@extends('layouts.app')

@section('title', 'Espaço do Empreendedor Local - System-PITE')

@section('content')
<div class="bg-primary text-white py-4 mb-4" style="background: linear-gradient(135deg, #064e3b, #047857) !important;">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <span class="badge bg-warning text-dark px-3 py-1 rounded-pill mb-2">Rede de Negócios Turísticos</span>
                <h2 class="fw-bold mb-1" style="font-family:'Outfit';"><i class="bi bi-shop me-2"></i> Espaço do Empreendedor Local</h2>
                <p class="mb-0 text-white text-opacity-80 small">Gerencie seu estabelecimento, acompanhe a homologação da Secretaria de Turismo e consulte seu Selo Municipal</p>
            </div>
            <a href="{{ route('empreendedor.cadastro') }}" class="btn btn-warning rounded-pill fw-bold text-dark px-4 shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Cadastrar Novo Estabelecimento
            </a>
        </div>
    </div>
</div>

<div class="container pb-5">

    {{-- Flash messages --}}
    @if(session('sucesso'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 p-3 shadow-sm border-0 mb-4" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                <div class="small fw-semibold">{{ session('sucesso') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Cards de Status e Métricas -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h6 class="text-muted small fw-semibold text-uppercase mb-1" style="font-size:0.72rem;">Total Cadastrados</h6>
                <h3 class="fw-bold text-dark mb-0">{{ $stats['total'] ?? 0 }}</h3>
                <small class="text-muted" style="font-size:0.75rem;">Negócios registrados por você</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h6 class="text-muted small fw-semibold text-uppercase mb-1" style="font-size:0.72rem;">Aprovados</h6>
                <h3 class="fw-bold text-success mb-0">{{ $stats['aprovados'] ?? 0 }}</h3>
                <small class="text-success" style="font-size:0.75rem;"><i class="bi bi-check-circle me-1"></i>Visíveis no portal público</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h6 class="text-muted small fw-semibold text-uppercase mb-1" style="font-size:0.72rem;">Aguardando Secretaria</h6>
                <h3 class="fw-bold text-warning mb-0">{{ $stats['pendentes'] ?? 0 }}</h3>
                <small class="text-warning-emphasis" style="font-size:0.75rem;"><i class="bi bi-hourglass-split me-1"></i>Em moderação oficial</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h6 class="text-muted small fw-semibold text-uppercase mb-1" style="font-size:0.72rem;">Selos Municipais</h6>
                <h3 class="fw-bold mb-0" style="color:var(--pite-gold);">{{ $stats['selos_ativos'] ?? 0 }}</h3>
                <small class="text-muted" style="font-size:0.75rem;">Certificados de qualidade ativos</small>
            </div>
        </div>
    </div>

    <!-- Informações do Fluxo de Homologação Obrigatória -->
    <div class="p-4 rounded-4 bg-light border mb-4">
        <div class="d-flex align-items-start gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:40px; height:40px; background:rgba(4,120,87,0.1); color:var(--pite-emerald);">
                <i class="bi bi-shield-check fs-5"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-1" style="font-family:'Outfit';">Como funciona a homologação pela Secretaria de Turismo?</h6>
                <p class="small text-muted mb-0" style="line-height:1.5;">
                    Para garantir a qualidade, segurança e conformidade da rede turística do município, cada novo estabelecimento passa por uma análise documental e vistoria técnica realizada pelos fiscais da Secretaria Municipal de Turismo. Uma vez aprovado, seu negócio recebe o <strong>Selo de Validação Municipal</strong> e é integrado automaticamente ao Mapa Interativo, aos Roteiros e ao Guia PITE IA.
                </p>
            </div>
        </div>
    </div>

    <!-- Tabela dos Estabelecimentos Cadastrados -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h5 class="fw-bold mb-0" style="font-family:'Outfit';">Meus Estabelecimentos & Prestadores</h5>
            <a href="{{ route('empreendedor.cadastro') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                <i class="bi bi-plus-lg me-1"></i> Novo Cadastro
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Estabelecimento / Nome Fantasia</th>
                        <th>Tipo de Atividade</th>
                        <th>Bairro / Local</th>
                        <th>Status na Secretaria</th>
                        <th>Selo Municipal</th>
                        <th>Data do Envio</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($estabelecimentos as $emp)
                    <tr>
                        <td>
                            <strong class="d-block text-dark">{{ $emp->nome_fantasia ?? $emp->razao_social }}</strong>
                            <small class="text-muted">{{ $emp->cnpj_cpf }}</small>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ ucfirst($emp->tipo_servico) }}</span>
                        </td>
                        <td>
                            <small class="text-muted">{{ $emp->bairro ?? $emp->endereco ?? 'Centro' }}</small>
                        </td>
                        <td>
                            @switch($emp->status_aprovacao)
                                @case('aprovado')
                                    <span class="badge bg-success rounded-pill px-3 py-1">
                                        <i class="bi bi-check-circle-fill me-1"></i> Aprovado
                                    </span>
                                    @break
                                @case('pendente')
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-1">
                                        <i class="bi bi-clock me-1"></i> Em Análise da Secretaria
                                    </span>
                                    @break
                                @case('rejeitado')
                                    <span class="badge bg-danger rounded-pill px-3 py-1" title="{{ $emp->observacoes_admin }}">
                                        <i class="bi bi-x-circle me-1"></i> Rejeitado
                                    </span>
                                    @if($emp->observacoes_admin)
                                        <small class="d-block text-danger mt-1" style="font-size:0.72rem;">Motivo: {{ $emp->observacoes_admin }}</small>
                                    @endif
                                    @break
                                @case('suspenso')
                                    <span class="badge bg-secondary rounded-pill px-3 py-1">
                                        <i class="bi bi-pause-circle me-1"></i> Suspenso
                                    </span>
                                    @break
                                @default
                                    <span class="badge bg-light text-dark rounded-pill px-3 py-1">{{ $emp->status_aprovacao }}</span>
                            @endswitch
                        </td>
                        <td>
                            @if($emp->selo_validado)
                                <span class="badge px-3 py-1 rounded-pill" style="background:rgba(245,158,11,0.15); color:#d97706;">
                                    <i class="bi bi-patch-check-fill me-1"></i> Selo Concedido
                                </span>
                            @else
                                <span class="badge bg-light text-muted border px-2 py-1 rounded-pill">Aguardando Validação</span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">{{ $emp->created_at ? $emp->created_at->format('d/m/Y') : '-' }}</small>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-shop fs-1 d-block mb-2 text-secondary"></i>
                            <h6>Você ainda não possui estabelecimentos cadastrados.</h6>
                            <p class="small mb-3">Cadastre seu negócio para receber o Selo Municipal de Qualidade e ser divulgado para milhares de turistas.</p>
                            <a href="{{ route('empreendedor.cadastro') }}" class="btn btn-pite btn-sm rounded-pill px-4">
                                <i class="bi bi-plus-circle me-1"></i> Cadastrar Meu Primeiro Estabelecimento
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

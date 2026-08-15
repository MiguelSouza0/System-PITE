@extends('layouts.app')

@section('title', 'Gestão de Empreendedores Locais - System-PITE')

@section('content')
<div style="background: linear-gradient(135deg, var(--pite-emerald), var(--pite-teal));" class="text-white py-4 mb-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1"><i class="bi bi-shop me-2"></i> Gestão de Empreendedores Locais</h2>
                <p class="mb-0" style="opacity:.75">Aprovação cadastral, concessão do Selo Municipal de Qualidade e auditoria</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm rounded-pill"><i class="bi bi-arrow-left"></i> Voltar ao Painel</a>
        </div>
    </div>
</div>

<div class="container pb-5">

    {{-- Flash Messages --}}
    @if(session('sucesso'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('sucesso') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Contadores --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 text-center">
                <div class="fs-3 fw-bold text-primary">{{ $contadores['total'] }}</div>
                <small class="text-muted">Total Cadastrados</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 text-center">
                <div class="fs-3 fw-bold text-warning">{{ $contadores['pendentes'] }}</div>
                <small class="text-muted">Pendentes</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 text-center">
                <div class="fs-3 fw-bold text-success">{{ $contadores['aprovados'] }}</div>
                <small class="text-muted">Aprovados</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 text-center">
                <div class="fs-3 fw-bold text-danger">{{ $contadores['rejeitados'] }}</div>
                <small class="text-muted">Rejeitados</small>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
        <form method="GET" action="{{ route('admin.empreendedores.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Buscar</label>
                <input type="text" name="busca" value="{{ request('busca') }}" class="form-control form-control-sm rounded-3" placeholder="Nome, CNPJ...">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Status</label>
                <select name="status" class="form-select form-select-sm rounded-3">
                    <option value="">Todos</option>
                    <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="aprovado" {{ request('status') == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                    <option value="rejeitado" {{ request('status') == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                    <option value="suspenso" {{ request('status') == 'suspenso' ? 'selected' : '' }}>Suspenso</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Tipo de Serviço</label>
                <select name="tipo" class="form-select form-select-sm rounded-3">
                    <option value="">Todos</option>
                    <option value="hospedagem" {{ request('tipo') == 'hospedagem' ? 'selected' : '' }}>Hospedagem</option>
                    <option value="gastronomia" {{ request('tipo') == 'gastronomia' ? 'selected' : '' }}>Gastronomia</option>
                    <option value="guia" {{ request('tipo') == 'guia' ? 'selected' : '' }}>Guia Turístico</option>
                    <option value="artesanato" {{ request('tipo') == 'artesanato' ? 'selected' : '' }}>Artesanato</option>
                    <option value="transporte" {{ request('tipo') == 'transporte' ? 'selected' : '' }}>Transporte</option>
                    <option value="agencia" {{ request('tipo') == 'agencia' ? 'selected' : '' }}>Agência</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm w-100 rounded-3"><i class="bi bi-funnel"></i> Filtrar</button>
            </div>
        </form>
    </div>

    {{-- Tabela --}}
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Solicitações de Cadastro & Estabelecimentos</h5>
            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Selo de Validação Ativo</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle" id="tabelaEmpreendedores">
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
                    @forelse($empreendedores as $emp)
                    <tr>
                        <td>
                            <strong>{{ $emp->nome_fantasia ?? $emp->razao_social }}</strong><br>
                            <small class="text-muted">{{ $emp->email ?? 'Sem e-mail' }}</small>
                        </td>
                        <td>{{ $emp->cnpj_cpf }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ ucfirst($emp->tipo_servico) }}</span>
                        </td>
                        <td>
                            @switch($emp->status_aprovacao)
                                @case('aprovado')
                                    <span class="badge bg-success">Aprovado</span>
                                    @break
                                @case('pendente')
                                    <span class="badge bg-warning text-dark">Pendente</span>
                                    @break
                                @case('rejeitado')
                                    <span class="badge bg-danger">Rejeitado</span>
                                    @break
                                @case('suspenso')
                                    <span class="badge bg-secondary">Suspenso</span>
                                    @break
                                @default
                                    <span class="badge bg-light text-dark">{{ $emp->status_aprovacao }}</span>
                            @endswitch
                        </td>
                        <td>
                            @if($emp->selo_validado)
                                <span class="badge bg-warning text-dark"><i class="bi bi-patch-check-fill me-1"></i> Selo Validado</span>
                            @else
                                <span class="badge bg-secondary">Sem Selo</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap">
                                @if($emp->status_aprovacao === 'pendente')
                                    {{-- Aprovar --}}
                                    <form method="POST" action="{{ route('admin.empreendedores.aprovar', $emp) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill" title="Aprovar e conceder Selo">
                                            <i class="bi bi-check-lg"></i> Aprovar
                                        </button>
                                    </form>
                                    {{-- Rejeitar (modal) --}}
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#modalRejeitar{{ $emp->id }}" title="Rejeitar cadastro">
                                        <i class="bi bi-x-lg"></i> Rejeitar
                                    </button>
                                @elseif($emp->status_aprovacao === 'aprovado' && $emp->selo_validado)
                                    <form id="formRevogarSelo{{ $emp->id }}" method="POST" action="{{ route('admin.empreendedores.revogar', $emp) }}" class="d-inline">
                                        @csrf
                                        <button type="button" class="btn btn-sm btn-outline-warning rounded-pill" onclick="confirmarAcao('Tem certeza que deseja revogar o Selo Municipal deste estabelecimento?', () => document.getElementById('formRevogarSelo{{ $emp->id }}').submit(), 'Revogar Selo')" title="Revogar Selo Municipal">
                                            <i class="bi bi-shield-x"></i> Revogar Selo
                                        </button>
                                    </form>
                                @elseif($emp->status_aprovacao === 'rejeitado' || $emp->status_aprovacao === 'suspenso')
                                    {{-- Re-aprovar --}}
                                    <form method="POST" action="{{ route('admin.empreendedores.aprovar', $emp) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success rounded-pill" title="Re-aprovar">
                                            <i class="bi bi-arrow-counterclockwise"></i> Re-aprovar
                                        </button>
                                    </form>
                                @endif
                            </div>

                            {{-- Modal de Rejeição --}}
                            <div class="modal fade" id="modalRejeitar{{ $emp->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content rounded-4">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-bold"><i class="bi bi-x-circle text-danger me-2"></i>Rejeitar Cadastro</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('admin.empreendedores.rejeitar', $emp) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <p>Rejeitando: <strong>{{ $emp->razao_social }}</strong></p>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Motivo da Rejeição <span class="text-danger">*</span></label>
                                                    <textarea name="motivo" class="form-control rounded-3" rows="3" required placeholder="Informe o motivo da rejeição..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger rounded-pill"><i class="bi bi-x-lg me-1"></i> Confirmar Rejeição</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Nenhum empreendedor cadastrado.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $empreendedores->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection

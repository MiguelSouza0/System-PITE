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

    {{-- Filtros --}}
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
        <h6 class="fw-bold mb-3"><i class="bi bi-funnel me-1"></i> Filtrar Registros</h6>
        <form method="GET" action="{{ route('admin.auditoria.index') }}" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Ação</label>
                <select name="acao" class="form-select form-select-sm rounded-3">
                    <option value="">Todas</option>
                    @foreach($acoes as $acao)
                        <option value="{{ $acao }}" {{ request('acao') == $acao ? 'selected' : '' }}>{{ ucfirst($acao) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Módulo / Tabela</label>
                <select name="tabela" class="form-select form-select-sm rounded-3">
                    <option value="">Todos</option>
                    @foreach($tabelas as $tabela)
                        <option value="{{ $tabela }}" {{ request('tabela') == $tabela ? 'selected' : '' }}>{{ ucfirst($tabela) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Usuário</label>
                <input type="text" name="usuario" value="{{ request('usuario') }}" class="form-control form-control-sm rounded-3" placeholder="Nome...">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Data Início</label>
                <input type="date" name="data_inicio" value="{{ request('data_inicio') }}" class="form-control form-control-sm rounded-3">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Data Fim</label>
                <input type="date" name="data_fim" value="{{ request('data_fim') }}" class="form-control form-control-sm rounded-3">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary btn-sm w-100 rounded-3"><i class="bi bi-search"></i></button>
            </div>
            <div class="col-md-1">
                <a href="{{ route('admin.auditoria.index') }}" class="btn btn-outline-secondary btn-sm w-100 rounded-3"><i class="bi bi-x-lg"></i></a>
            </div>
        </form>
    </div>

    {{-- Tabela de Logs --}}
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
                        <th>Registro</th>
                        <th>IP Auditado</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>
                            <span class="text-nowrap">{{ $log->created_at->format('d/m/Y') }}</span><br>
                            <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                        </td>
                        <td>
                            @if($log->usuario)
                                <strong>{{ $log->usuario->name }}</strong><br>
                                <small class="text-muted">{{ $log->usuario->perfil->nome ?? 'Sem perfil' }}</small>
                            @else
                                <span class="text-muted">Sistema</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $acaoClasses = [
                                    'criou'        => 'bg-success',
                                    'editou'       => 'bg-info text-dark',
                                    'desativou'    => 'bg-warning text-dark',
                                    'aprovou'      => 'bg-success',
                                    'rejeitou'     => 'bg-danger',
                                    'revogou_selo' => 'bg-danger',
                                ];
                            @endphp
                            <span class="badge {{ $acaoClasses[$log->acao] ?? 'bg-secondary' }}">{{ ucfirst(str_replace('_', ' ', $log->acao)) }}</span>
                        </td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary">{{ ucfirst($log->tabela) }}</span>
                        </td>
                        <td><code>#{{ $log->registro_id }}</code></td>
                        <td><code>{{ $log->ip ?? 'N/A' }}</code></td>
                        <td>
                            @if($log->dados_antes || $log->dados_depois)
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalLog{{ $log->id }}" title="Ver dados antes/depois">
                                    <i class="bi bi-eye"></i>
                                </button>

                                {{-- Modal de Detalhes --}}
                                <div class="modal fade" id="modalLog{{ $log->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content rounded-4">
                                            <div class="modal-header border-0">
                                                <h5 class="modal-title fw-bold">
                                                    <i class="bi bi-journal-code text-primary me-2"></i>
                                                    Detalhes da Auditoria #{{ $log->id }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row g-3">
                                                    @if($log->dados_antes)
                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold text-danger"><i class="bi bi-arrow-left-circle me-1"></i> Dados Antes</h6>
                                                        <pre class="bg-light p-3 rounded-3 small" style="max-height:300px;overflow-y:auto;">{{ json_encode($log->dados_antes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                    </div>
                                                    @endif
                                                    @if($log->dados_depois)
                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold text-success"><i class="bi bi-arrow-right-circle me-1"></i> Dados Depois</h6>
                                                        <pre class="bg-light p-3 rounded-3 small" style="max-height:300px;overflow-y:auto;">{{ json_encode($log->dados_depois, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                    </div>
                                                    @endif
                                                </div>
                                                <hr>
                                                <small class="text-muted">
                                                    <strong>User Agent:</strong> {{ $log->user_agent ?? 'N/A' }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-journal-x fs-3 d-block mb-2"></i>
                            Nenhum registro de auditoria encontrado.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $logs->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection

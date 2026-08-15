@extends('layouts.app')

@section('title', 'Atrativos Turísticos — System-PITE')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1" style="font-family:'Outfit';">
                <i class="bi bi-geo-alt-fill text-success me-2"></i>
                @if(auth()->user()->isServidor())
                    Gestão de Atrativos Turísticos
                @else
                    Consulta de Atrativos Turísticos
                @endif
            </h2>
            <p class="text-muted mb-0">
                @if(auth()->user()->isServidor())
                    Inclusão, edição e atualização de pontos turísticos do município
                @else
                    Acompanhamento executivo e histórico dos atrativos cadastrados
                @endif
            </p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            @if(auth()->user()->isServidor())
                <a href="{{ route('admin.atrativos.create') }}" class="btn btn-pite">
                    <i class="bi bi-plus-lg me-1"></i> Novo Atrativo
                </a>
            @elseif(auth()->user()->isPrefeito() || auth()->user()->isSecretario())
                <a href="{{ route('admin.aprovacao.pendentes') }}" class="btn btn-warning rounded-pill fw-semibold">
                    <i class="bi bi-clipboard-check me-1"></i> Fila de Aprovações
                </a>
            @endif
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Painel
            </a>
        </div>
    </div>

    @if(session('sucesso'))
    <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
        <i class="bi bi-check-circle me-1"></i> {{ session('sucesso') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- CONTADORES RÁPIDOS --}}
    @if(isset($contadores))
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                <div class="fs-4 fw-bold text-dark">{{ $contadores['total'] }}</div>
                <small class="text-muted text-uppercase" style="font-size:0.7rem; font-weight:600;">Total</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                <div class="fs-4 fw-bold text-success">{{ $contadores['aprovados'] }}</div>
                <small class="text-muted text-uppercase" style="font-size:0.7rem; font-weight:600;">Aprovados (Ativos)</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                <div class="fs-4 fw-bold text-warning">{{ $contadores['pendentes'] }}</div>
                <small class="text-muted text-uppercase" style="font-size:0.7rem; font-weight:600;">Pendentes</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                <div class="fs-4 fw-bold text-purple" style="color:#7c3aed;">{{ $contadores['suspensos'] }}</div>
                <small class="text-muted text-uppercase" style="font-size:0.7rem; font-weight:600;">Suspensos</small>
            </div>
        </div>
    </div>
    @endif

    {{-- FILTROS --}}
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
        <form action="{{ route('admin.atrativos.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Buscar</label>
                <input type="text" name="busca" class="form-control rounded-3" placeholder="Nome do atrativo..." value="{{ request('busca') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Categoria</label>
                <select name="categoria" class="form-select rounded-3">
                    <option value="">Todas</option>
                    @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>{{ $cat->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Status de Aprovação</label>
                <select name="status" class="form-select rounded-3">
                    <option value="">Todos os status</option>
                    <option value="aprovado" {{ request('status') == 'aprovado' ? 'selected' : '' }}>Aprovados</option>
                    <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendentes</option>
                    <option value="suspenso" {{ request('status') == 'suspenso' ? 'selected' : '' }}>Suspensos</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-pite flex-grow-1"><i class="bi bi-search me-1"></i> Filtrar</button>
                <a href="{{ route('admin.atrativos.index') }}" class="btn btn-light"><i class="bi bi-x-lg"></i></a>
            </div>
        </form>
    </div>

    {{-- TABELA --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">Nome</th>
                        <th style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">Categoria</th>
                        <th style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">Status de Aprovação</th>
                        <th style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">Acessível</th>
                        <th style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">Criado em</th>
                        <th style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;" class="text-end">Ações / Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($atrativos as $at)
                    <tr>
                        <td class="fw-semibold">
                            {{ $at->nome }}
                            @if($at->endereco)
                                <br><small class="text-muted" style="font-size:0.78rem;">{{ Str::limit($at->endereco, 35) }}</small>
                            @endif
                        </td>
                        <td><span class="badge bg-light text-dark rounded-pill border">{{ $at->categoria->nome ?? '—' }}</span></td>
                        <td>
                            @if($at->status_aprovacao === 'aprovado')
                                <span class="badge px-3 py-1 rounded-pill" style="background:rgba(4,120,87,0.12); color:#047857;">
                                    <i class="bi bi-check-circle me-1"></i> Aprovado
                                </span>
                            @elseif($at->status_aprovacao === 'pendente')
                                <span class="badge px-3 py-1 rounded-pill" style="background:rgba(245,158,11,0.15); color:#d97706;">
                                    <i class="bi bi-hourglass-split me-1"></i> Pendente
                                </span>
                            @elseif($at->status_aprovacao === 'suspenso')
                                <span class="badge px-3 py-1 rounded-pill" style="background:rgba(99,102,241,0.15); color:#6366f1;">
                                    <i class="bi bi-pause-circle me-1"></i> Suspenso
                                </span>
                            @else
                                <span class="badge bg-secondary rounded-pill">{{ $at->status_aprovacao ?? 'Indefinido' }}</span>
                            @endif
                        </td>
                        <td>
                            @if(isset($at->niveis_acessibilidade['cadeirante']) && $at->niveis_acessibilidade['cadeirante'])
                            <i class="bi bi-universal-access text-success fs-5" title="Acessível para PNE"></i>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $at->created_at->format('d/m/Y') }}</td>
                        <td class="text-end">
                            @if(auth()->user()->isServidor())
                                {{-- Ações para o Servidor Técnico --}}
                                <a href="{{ route('admin.atrativos.edit', $at) }}" class="btn btn-sm btn-outline-primary rounded-pill me-1" title="Editar dados">
                                    <i class="bi bi-pencil me-1"></i> Editar
                                </a>
                                <form id="formDeleteAtrativo{{ $at->id }}" action="{{ route('admin.atrativos.destroy', $at) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill" onclick="confirmarAcao('Deseja realmente desativar este atrativo turístico?', () => document.getElementById('formDeleteAtrativo{{ $at->id }}').submit(), 'Desativar Atrativo')" title="Desativar">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            @else
                                {{-- Visualização / Atalho para Prefeito e Secretário --}}
                                @if($at->status_aprovacao === 'pendente' || $at->status_aprovacao === 'suspenso')
                                    <a href="{{ route('admin.aprovacao.pendentes') }}" class="btn btn-sm btn-warning rounded-pill">
                                        <i class="bi bi-clipboard-check me-1"></i> Avaliar
                                    </a>
                                @else
                                    <span class="text-muted small"><i class="bi bi-check-all text-success me-1"></i> Homologado</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                            Nenhum atrativo encontrado.
                            @if(auth()->user()->isServidor())
                                <br><a href="{{ route('admin.atrativos.create') }}" class="btn btn-sm btn-pite mt-2">Cadastrar Novo Atrativo</a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($atrativos->hasPages())
        <div class="p-3 border-top">
            {{ $atrativos->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

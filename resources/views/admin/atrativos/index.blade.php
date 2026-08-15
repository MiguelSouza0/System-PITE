@extends('layouts.app')

@section('title', 'Gestão de Atrativos — System-PITE')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1" style="font-family:'Outfit';"><i class="bi bi-geo-alt-fill text-success me-2"></i>Gestão de Atrativos</h2>
            <p class="text-muted mb-0">CRUD completo com trilha de auditoria e exclusão lógica</p>
        </div>
        <a href="{{ route('admin.atrativos.create') }}" class="btn btn-pite">
            <i class="bi bi-plus-lg me-1"></i> Novo Atrativo
        </a>
    </div>

    @if(session('sucesso'))
    <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
        <i class="bi bi-check-circle me-1"></i> {{ session('sucesso') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
                <label class="form-label small fw-semibold">Status</label>
                <select name="status" class="form-select rounded-3">
                    <option value="">Todos</option>
                    <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                    <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-pite w-100"><i class="bi bi-search me-1"></i> Filtrar</button>
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
                        <th style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">Status</th>
                        <th style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">Acessível</th>
                        <th style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">Criado em</th>
                        <th style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;" class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($atrativos as $at)
                    <tr>
                        <td class="fw-semibold">{{ $at->nome }}</td>
                        <td><span class="badge bg-light text-dark rounded-pill">{{ $at->categoria->nome ?? '—' }}</span></td>
                        <td>
                            @if($at->ativo)
                                <span class="badge bg-success rounded-pill">Ativo</span>
                            @else
                                <span class="badge bg-danger rounded-pill">Inativo</span>
                            @endif
                        </td>
                        <td>
                            @if(isset($at->niveis_acessibilidade['cadeirante']) && $at->niveis_acessibilidade['cadeirante'])
                            <i class="bi bi-universal-access text-success" title="Acessível"></i>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $at->created_at->format('d/m/Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.atrativos.edit', $at) }}" class="btn btn-sm btn-outline-primary rounded-pill me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form id="formDeleteAtrativo{{ $at->id }}" action="{{ route('admin.atrativos.destroy', $at) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill" onclick="confirmarAcao('Deseja realmente desativar este atrativo turístico?', () => document.getElementById('formDeleteAtrativo{{ $at->id }}').submit(), 'Desativar Atrativo')">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Nenhum atrativo encontrado
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($atrativos->hasPages())
        <div class="p-3">
            {{ $atrativos->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

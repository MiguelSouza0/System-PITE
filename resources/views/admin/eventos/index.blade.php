@extends('layouts.app')

@section('title', 'Gestão de Eventos - System-PITE')

@section('content')
<div style="background: linear-gradient(135deg, var(--pite-emerald), var(--pite-teal));" class="text-white py-4 mb-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1"><i class="bi bi-calendar-event me-2"></i> Gestão de Eventos</h2>
                <p class="mb-0" style="opacity:.75">Criar, editar e gerenciar eventos turísticos municipais</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.eventos.create') }}" class="btn btn-warning btn-sm rounded-pill fw-semibold"><i class="bi bi-plus-lg me-1"></i> Novo Evento</a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm rounded-pill"><i class="bi bi-arrow-left"></i> Voltar ao Painel</a>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">

    @if(session('sucesso'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('sucesso') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filtros --}}
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
        <form method="GET" action="{{ route('admin.eventos.index') }}" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label small fw-semibold">Buscar por título</label>
                <input type="text" name="busca" value="{{ request('busca') }}" class="form-control form-control-sm rounded-3" placeholder="Nome do evento...">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Status</label>
                <select name="status" class="form-select form-select-sm rounded-3">
                    <option value="">Todos</option>
                    <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                    <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm w-100 rounded-3"><i class="bi bi-funnel"></i> Filtrar</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.eventos.index') }}" class="btn btn-outline-secondary btn-sm w-100 rounded-3">Limpar</a>
            </div>
        </form>
    </div>

    {{-- Tabela --}}
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <h5 class="fw-bold mb-4"><i class="bi bi-list-ul me-2"></i> Eventos Cadastrados</h5>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Título</th>
                        <th>Data Início</th>
                        <th>Data Fim</th>
                        <th>Local</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($eventos as $evento)
                    <tr>
                        <td>
                            <strong>{{ $evento->titulo }}</strong>
                            @if($evento->organizador)
                                <br><small class="text-muted">{{ $evento->organizador }}</small>
                            @endif
                        </td>
                        <td>{{ $evento->data_inicio->format('d/m/Y H:i') }}</td>
                        <td>{{ $evento->data_fim->format('d/m/Y H:i') }}</td>
                        <td>{{ Str::limit($evento->local, 30) }}</td>
                        <td>
                            @if($evento->gratuito)
                                <span class="badge bg-success-subtle text-success">Gratuito</span>
                            @else
                                R$ {{ number_format($evento->preco_ingresso, 2, ',', '.') }}
                            @endif
                        </td>
                        <td>
                            @if($evento->ativo)
                                <span class="badge bg-success">Ativo</span>
                            @else
                                <span class="badge bg-secondary">Inativo</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.eventos.edit', $evento) }}" class="btn btn-sm btn-outline-primary rounded-pill" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form id="formDeleteEvento{{ $evento->id }}" method="POST" action="{{ route('admin.eventos.destroy', $evento) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill" onclick="confirmarAcao('Deseja realmente desativar este evento?', () => document.getElementById('formDeleteEvento{{ $evento->id }}').submit(), 'Desativar Evento')" title="Desativar">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>
                            Nenhum evento cadastrado. <a href="{{ route('admin.eventos.create') }}">Criar o primeiro</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $eventos->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection

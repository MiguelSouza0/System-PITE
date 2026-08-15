@extends('layouts.app')

@section('title', 'Eventos Municipais — System-PITE')

@section('content')
<div style="background: linear-gradient(135deg, var(--pite-emerald), var(--pite-teal));" class="text-white py-4 mb-4">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-calendar-event me-2"></i>
                    @if(auth()->user()->isServidor())
                        Gestão de Eventos Municipais
                    @else
                        Consulta de Eventos Municipais
                    @endif
                </h2>
                <p class="mb-0" style="opacity:.75">
                    @if(auth()->user()->isServidor())
                        Cadastro, edição e publicação de eventos turísticos, shows e festivais
                    @else
                        Acompanhamento do calendário de eventos e programações turísticas
                    @endif
                </p>
            </div>
            <div class="d-flex gap-2">
                @if(auth()->user()->isServidor())
                    <a href="{{ route('admin.eventos.create') }}" class="btn btn-warning btn-sm rounded-pill fw-semibold">
                        <i class="bi bi-plus-lg me-1"></i> Novo Evento
                    </a>
                @elseif(auth()->user()->isPrefeito() || auth()->user()->isSecretario())
                    <a href="{{ route('admin.aprovacao.pendentes') }}" class="btn btn-warning btn-sm rounded-pill fw-semibold">
                        <i class="bi bi-clipboard-check me-1"></i> Fila de Aprovações
                    </a>
                @endif
                <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i> Voltar ao Painel
                </a>
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

    {{-- Contadores Rápidos --}}
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

    {{-- Filtros --}}
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
        <form method="GET" action="{{ route('admin.eventos.index') }}" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label small fw-semibold">Buscar por título</label>
                <input type="text" name="busca" value="{{ request('busca') }}" class="form-control form-control-sm rounded-3" placeholder="Nome do evento...">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Status de Aprovação</label>
                <select name="status" class="form-select form-select-sm rounded-3">
                    <option value="">Todos</option>
                    <option value="aprovado" {{ request('status') == 'aprovado' ? 'selected' : '' }}>Aprovados</option>
                    <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendentes</option>
                    <option value="suspenso" {{ request('status') == 'suspenso' ? 'selected' : '' }}>Suspensos</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm w-100 rounded-3"><i class="bi bi-funnel me-1"></i> Filtrar</button>
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
                        <th>Período</th>
                        <th>Local</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th class="text-end">Ações / Detalhes</th>
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
                        <td>
                            <span class="small">
                                {{ $evento->data_inicio?->format('d/m/Y H:i') }}<br>
                                até {{ $evento->data_fim?->format('d/m/Y H:i') }}
                            </span>
                        </td>
                        <td>{{ Str::limit($evento->local, 30) }}</td>
                        <td>
                            @if($evento->gratuito)
                                <span class="badge bg-success-subtle text-success">Gratuito</span>
                            @else
                                R$ {{ number_format($evento->preco_ingresso, 2, ',', '.') }}
                            @endif
                        </td>
                        <td>
                            @if($evento->status_aprovacao === 'aprovado')
                                <span class="badge px-3 py-1 rounded-pill" style="background:rgba(4,120,87,0.12); color:#047857;">
                                    <i class="bi bi-check-circle me-1"></i> Aprovado
                                </span>
                            @elseif($evento->status_aprovacao === 'pendente')
                                <span class="badge px-3 py-1 rounded-pill" style="background:rgba(245,158,11,0.15); color:#d97706;">
                                    <i class="bi bi-hourglass-split me-1"></i> Pendente
                                </span>
                            @elseif($evento->status_aprovacao === 'suspenso')
                                <span class="badge px-3 py-1 rounded-pill" style="background:rgba(99,102,241,0.15); color:#6366f1;">
                                    <i class="bi bi-pause-circle me-1"></i> Suspenso
                                </span>
                            @else
                                <span class="badge bg-secondary rounded-pill">{{ $evento->status_aprovacao ?? 'Indefinido' }}</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if(auth()->user()->isServidor())
                                {{-- Ações para o Servidor Técnico --}}
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="{{ route('admin.eventos.edit', $evento) }}" class="btn btn-sm btn-outline-primary rounded-pill" title="Editar Evento">
                                        <i class="bi bi-pencil me-1"></i> Editar
                                    </a>
                                    <form id="formDeleteEvento{{ $evento->id }}" method="POST" action="{{ route('admin.eventos.destroy', $evento) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill" onclick="confirmarAcao('Deseja realmente desativar este evento?', () => document.getElementById('formDeleteEvento{{ $evento->id }}').submit(), 'Desativar Evento')" title="Desativar">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                {{-- Prefeito e Secretário --}}
                                @if($evento->status_aprovacao === 'pendente' || $evento->status_aprovacao === 'suspenso')
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
                            <i class="bi bi-calendar-x fs-1 d-block mb-2 text-secondary"></i>
                            Nenhum evento encontrado.
                            @if(auth()->user()->isServidor())
                                <br><a href="{{ route('admin.eventos.create') }}" class="btn btn-sm btn-pite mt-2">Criar Novo Evento</a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($eventos->hasPages())
        <div class="d-flex justify-content-center mt-3 border-top pt-3">
            {{ $eventos->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

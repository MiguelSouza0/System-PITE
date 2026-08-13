@extends('layouts.app')

@section('title', 'Editar Evento - System-PITE')

@section('content')
<div style="background: linear-gradient(135deg, var(--pite-emerald), var(--pite-teal));" class="text-white py-4 mb-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1"><i class="bi bi-pencil-square me-2"></i> Editar Evento</h2>
                <p class="mb-0" style="opacity:.75">{{ $evento->titulo }}</p>
            </div>
            <a href="{{ route('admin.eventos.index') }}" class="btn btn-light btn-sm rounded-pill"><i class="bi bi-arrow-left"></i> Voltar</a>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">

                @if($errors->any())
                    <div class="alert alert-danger rounded-3">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.eventos.update', $evento) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Título do Evento <span class="text-danger">*</span></label>
                        <input type="text" name="titulo" value="{{ old('titulo', $evento->titulo) }}" class="form-control rounded-3" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Descrição <span class="text-danger">*</span></label>
                        <textarea name="descricao" class="form-control rounded-3" rows="4" required>{{ old('descricao', $evento->descricao) }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Data e Hora de Início <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="data_inicio" value="{{ old('data_inicio', $evento->data_inicio->format('Y-m-d\TH:i')) }}" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Data e Hora de Fim <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="data_fim" value="{{ old('data_fim', $evento->data_fim->format('Y-m-d\TH:i')) }}" class="form-control rounded-3" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Local <span class="text-danger">*</span></label>
                        <input type="text" name="local" value="{{ old('local', $evento->local) }}" class="form-control rounded-3" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ponto Turístico Vinculado</label>
                            <select name="atrativo_id" class="form-select rounded-3">
                                <option value="">Nenhum</option>
                                @foreach($atrativos as $atrativo)
                                    <option value="{{ $atrativo->id }}" {{ old('atrativo_id', $evento->atrativo_id) == $atrativo->id ? 'selected' : '' }}>{{ $atrativo->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Organizador</label>
                            <input type="text" name="organizador" value="{{ old('organizador', $evento->organizador) }}" class="form-control rounded-3">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Preço do Ingresso (R$)</label>
                            <input type="number" name="preco_ingresso" value="{{ old('preco_ingresso', $evento->preco_ingresso) }}" class="form-control rounded-3" step="0.01" min="0">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="gratuito" id="gratuito" value="1" {{ old('gratuito', $evento->gratuito) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="gratuito">Gratuito</label>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="ativo" id="ativo" value="1" {{ old('ativo', $evento->ativo) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="ativo">Evento Ativo</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.eventos.index') }}" class="btn btn-light rounded-pill px-4">Cancelar</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="bi bi-check-lg me-1"></i> Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

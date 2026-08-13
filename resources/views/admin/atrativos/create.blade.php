@extends('layouts.app')

@section('title', isset($atrativo) ? 'Editar Atrativo — System-PITE' : 'Novo Atrativo — System-PITE')

@section('content')
<div class="container py-4" style="max-width: 900px;">
    <div class="mb-4">
        <a href="{{ route('admin.atrativos.index') }}" class="text-muted text-decoration-none small">
            <i class="bi bi-arrow-left me-1"></i> Voltar à lista
        </a>
        <h2 class="fw-bold mt-2" style="font-family:'Outfit';">
            <i class="bi bi-{{ isset($atrativo) ? 'pencil-square' : 'plus-circle' }} text-success me-2"></i>
            {{ isset($atrativo) ? 'Editar Atrativo' : 'Cadastrar Novo Atrativo' }}
        </h2>
    </div>

    @if($errors->any())
    <div class="alert alert-danger rounded-4">
        <i class="bi bi-exclamation-triangle me-1"></i>
        <strong>Corrija os erros abaixo:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ isset($atrativo) ? route('admin.atrativos.update', $atrativo) : route('admin.atrativos.store') }}"
          method="POST" class="card border-0 shadow-sm rounded-4 p-4">
        @csrf
        @if(isset($atrativo)) @method('PUT') @endif

        {{-- Informações Básicas --}}
        <h6 class="fw-bold mb-3" style="font-family:'Outfit';"><i class="bi bi-info-circle text-primary me-2"></i>Informações Básicas</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-8">
                <label class="form-label small fw-semibold">Nome do Atrativo *</label>
                <input type="text" name="nome" class="form-control rounded-3" required
                       value="{{ old('nome', $atrativo->nome ?? '') }}" placeholder="Ex: Cachoeira do Vale Encantado">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Categoria *</label>
                <select name="categoria_id" class="form-select rounded-3" required>
                    <option value="">Selecione...</option>
                    @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ old('categoria_id', $atrativo->categoria_id ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nome }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label small fw-semibold">Descrição *</label>
                <textarea name="descricao" class="form-control rounded-3" rows="4" required
                          placeholder="Descrição detalhada do atrativo, incluindo contexto histórico...">{{ old('descricao', $atrativo->descricao ?? '') }}</textarea>
            </div>
        </div>

        {{-- Localização --}}
        <h6 class="fw-bold mb-3" style="font-family:'Outfit';"><i class="bi bi-geo-alt text-danger me-2"></i>Localização</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Endereço</label>
                <input type="text" name="endereco" class="form-control rounded-3"
                       value="{{ old('endereco', $atrativo->endereco ?? '') }}" placeholder="Rua, número, bairro">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Latitude</label>
                <input type="number" step="any" name="latitude" class="form-control rounded-3"
                       value="{{ old('latitude', $atrativo->latitude ?? '') }}" placeholder="-7.1195">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Longitude</label>
                <input type="number" step="any" name="longitude" class="form-control rounded-3"
                       value="{{ old('longitude', $atrativo->longitude ?? '') }}" placeholder="-34.8450">
            </div>
        </div>

        {{-- Detalhes --}}
        <h6 class="fw-bold mb-3" style="font-family:'Outfit';"><i class="bi bi-clock text-info me-2"></i>Detalhes</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Horário de Funcionamento</label>
                <input type="text" name="horario_funcionamento" class="form-control rounded-3"
                       value="{{ old('horario_funcionamento', $atrativo->horario_funcionamento ?? '') }}" placeholder="Seg-Sex: 8h-17h">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Valor de Entrada (R$)</label>
                <input type="number" step="0.01" name="valor_entrada" class="form-control rounded-3"
                       value="{{ old('valor_entrada', $atrativo->valor_entrada ?? '') }}" placeholder="0.00 = gratuito">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Tempo Médio de Visita</label>
                <input type="text" name="tempo_medio_visita" class="form-control rounded-3"
                       value="{{ old('tempo_medio_visita', $atrativo->tempo_medio_visita ?? '') }}" placeholder="Ex: 2 horas">
            </div>
        </div>

        {{-- Contato --}}
        <h6 class="fw-bold mb-3" style="font-family:'Outfit';"><i class="bi bi-telephone text-success me-2"></i>Contato</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Telefone</label>
                <input type="text" name="contato_telefone" class="form-control rounded-3"
                       value="{{ old('contato_telefone', $atrativo->contato_telefone ?? '') }}" placeholder="(83) 99999-0000">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">E-mail</label>
                <input type="email" name="contato_email" class="form-control rounded-3"
                       value="{{ old('contato_email', $atrativo->contato_email ?? '') }}" placeholder="contato@atrativo.com">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Website</label>
                <input type="url" name="website" class="form-control rounded-3"
                       value="{{ old('website', $atrativo->website ?? '') }}" placeholder="https://...">
            </div>
        </div>

        {{-- Acessibilidade --}}
        <h6 class="fw-bold mb-3" style="font-family:'Outfit';"><i class="bi bi-universal-access text-primary me-2"></i>Acessibilidade (PNE)</h6>
        <div class="row g-3 mb-4">
            @php $acess = $atrativo->niveis_acessibilidade ?? []; @endphp
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="acess_cadeirante" value="1" id="acessCadeirante"
                           {{ old('acess_cadeirante', $acess['cadeirante'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label small" for="acessCadeirante">♿ Cadeirante</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="acess_visual" value="1" id="acessVisual"
                           {{ old('acess_visual', $acess['visual'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label small" for="acessVisual">👁️ Visual</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="acess_auditiva" value="1" id="acessAuditiva"
                           {{ old('acess_auditiva', $acess['auditiva'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label small" for="acessAuditiva">🦻 Auditiva</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="acess_piso_tatil" value="1" id="acessPiso"
                           {{ old('acess_piso_tatil', $acess['piso_tatil'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label small" for="acessPiso">🟡 Piso Tátil</label>
                </div>
            </div>
        </div>

        {{-- Status (apenas na edição) --}}
        @if(isset($atrativo))
        <h6 class="fw-bold mb-3" style="font-family:'Outfit';"><i class="bi bi-toggle-on text-warning me-2"></i>Status</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="ativo" id="ativo" value="1" {{ $atrativo->ativo ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="ativo">Atrativo Ativo</label>
                </div>
            </div>
        </div>
        @endif

        {{-- Botões --}}
        <div class="d-flex justify-content-between pt-3 border-top">
            <a href="{{ route('admin.atrativos.index') }}" class="btn btn-outline-secondary rounded-3">Cancelar</a>
            <button type="submit" class="btn btn-pite btn-lg px-5">
                <i class="bi bi-check-lg me-1"></i>
                {{ isset($atrativo) ? 'Salvar Alterações' : 'Cadastrar Atrativo' }}
            </button>
        </div>
    </form>
</div>
@endsection

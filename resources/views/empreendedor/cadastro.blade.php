@extends('layouts.app')

@section('title', 'Cadastro de Estabelecimento - System-PITE')

@section('content')
<div class="bg-primary text-white py-4 mb-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1"><i class="bi bi-shop me-2"></i> Autocadastro de Empreendedor Local</h2>
                <p class="mb-0 text-light-50">Integre seu negócio à rede turística oficial do município</p>
            </div>
            <a href="{{ route('empreendedor.dashboard') }}" class="btn btn-light btn-sm rounded-pill"><i class="bi bi-arrow-left"></i> Voltar</a>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-warning text-dark px-3 py-1 rounded-pill">Homologação Municipal Obrigatória</span>
                </div>
                <h4 class="fw-bold mb-2" style="font-family:'Outfit';"><i class="bi bi-building-check text-primary me-2"></i> Informações do Estabelecimento</h4>
                <p class="text-muted small mb-4">
                    Todo cadastro é submetido à análise da <strong>Secretaria Municipal de Turismo</strong>. Somente após a aprovação oficial, seu negócio receberá o <strong>Selo de Validação Municipal</strong> e ficará visível para turistas no portal e nas rotas inteligentes.
                </p>

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 small">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('empreendedor.cadastro.store') }}" method="POST">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label small fw-semibold">Razão Social / Nome Oficial *</label>
                            <input type="text" name="razao_social" value="{{ old('razao_social') }}" class="form-control rounded-3" required placeholder="Ex: Maria das Dores Artesanatos ME">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">CNPJ ou CPF *</label>
                            <input type="text" name="cnpj_cpf" value="{{ old('cnpj_cpf') }}" class="form-control rounded-3" required placeholder="00.000.000/0001-00">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Nome Fantasia (Como o turista conhece)</label>
                            <input type="text" name="nome_fantasia" value="{{ old('nome_fantasia') }}" class="form-control rounded-3" placeholder="Ex: Ateliê & Sabores das Rendas">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Tipo de Atividade / Ramo *</label>
                            <select name="tipo_servico" class="form-select rounded-3" required>
                                <option value="gastronomia" {{ old('tipo_servico') == 'gastronomia' ? 'selected' : '' }}>Gastronomia & Restaurantes</option>
                                <option value="hospedagem" {{ old('tipo_servico') == 'hospedagem' ? 'selected' : '' }}>Pousada, Hotel & Hospedagem</option>
                                <option value="artesanato" {{ old('tipo_servico') == 'artesanato' ? 'selected' : '' }}>Artesanato & Produtos Típicos</option>
                                <option value="guia" {{ old('tipo_servico') == 'guia' ? 'selected' : '' }}>Guia de Turismo Credenciado</option>
                                <option value="transporte" {{ old('tipo_servico') == 'transporte' ? 'selected' : '' }}>Transporte Turístico / Receptivo</option>
                                <option value="agencia" {{ old('tipo_servico') == 'agencia' ? 'selected' : '' }}>Agência de Turismo</option>
                                <option value="experiencia" {{ old('tipo_servico') == 'experiencia' ? 'selected' : '' }}>Ecoturismo & Experiências</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Descrição dos Produtos / Serviços</label>
                        <textarea name="descricao" class="form-control rounded-3" rows="3" placeholder="Descreva brevemente sua infraestrutura, produtos artesanais ou pratos típicos...">{{ old('descricao') }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Endereço Completo</label>
                            <input type="text" name="endereco" value="{{ old('endereco') }}" class="form-control rounded-3" placeholder="Rua, Av, Número...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Bairro / Região</label>
                            <input type="text" name="bairro" value="{{ old('bairro') }}" class="form-control rounded-3" placeholder="Centro, Zona Rural...">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Telefone / WhatsApp</label>
                            <input type="text" id="telefoneEmp" name="telefone" value="{{ old('telefone') }}" class="form-control rounded-3" placeholder="(00) 90000-0000" maxlength="15">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">E-mail Comercial</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control rounded-3" placeholder="contato@negocio.com">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Instagram (@)</label>
                            <input type="text" name="instagram" value="{{ old('instagram') }}" class="form-control rounded-3" placeholder="@seunegociolocal">
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-4 border">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkLgpd" required checked>
                            <label class="form-check-label small text-muted" for="checkLgpd">
                                Declaro ciência e autorizo a análise documental pela <strong>Secretaria Municipal de Turismo</strong> e o tratamento de dados de divulgação turística em conformidade com a <strong>LGPD (Lei nº 13.709/2018)</strong>.
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-pite w-100 rounded-3 py-2 fw-bold">
                        <i class="bi bi-send-check me-1"></i> Enviar Cadastro para Validação da Secretaria
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const telInput = document.getElementById('telefoneEmp');
    if (telInput) {
        telInput.addEventListener('input', function() {
            let v = this.value.replace(/\D/g, '');
            if (v.length > 11) v = v.substring(0, 11);

            if (v.length > 10) {
                v = v.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
            } else if (v.length > 6) {
                v = v.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
            } else if (v.length > 2) {
                v = v.replace(/^(\d{2})(\d{0,5})$/, '($1) $2');
            } else if (v.length > 0) {
                v = v.replace(/^(\d*)$/, '($1');
            }
            this.value = v;
        });
    }
});
</script>
@endpush

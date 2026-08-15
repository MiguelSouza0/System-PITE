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
                <h5 class="fw-bold mb-3"><i class="bi bi-building-check text-primary me-2"></i> Informações do Negócio</h5>
                <p class="text-muted small mb-4">Após o preenchimento, os dados serão analisados pela Secretaria Municipal de Turismo para validação do Selo Municipal.</p>

                <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Solicitação de cadastro enviada à Secretaria de Turismo para moderação!');">
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label small fw-semibold">Razão Social / Nome Completo</label>
                            <input type="text" class="form-control rounded-3" required placeholder="Ex: Maria das Dores Artesanatos ME">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">CNPJ ou CPF</label>
                            <input type="text" class="form-control rounded-3" required placeholder="00.000.000/0001-00">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Nome Fantasia</label>
                            <input type="text" class="form-control rounded-3" placeholder="Ex: Ateliê das Rendas">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Ramo de Atividade</label>
                            <select class="form-select rounded-3">
                                <option value="artesanato">Artesanato & Produtos Locais</option>
                                <option value="gastronomia">Gastronomia & Restaurantes</option>
                                <option value="hospedagem">Pousada & Hospedagem</option>
                                <option value="guia">Guia de Turismo Credenciado</option>
                                <option value="experiencia">Ecoturismo e Passeios</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Descrição dos Serviços Oferecidos</label>
                        <textarea class="form-control rounded-3" rows="3" placeholder="Descreva brevemente seus produtos ou serviços..."></textarea>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Telefone / WhatsApp</label>
                            <input type="text" class="form-control rounded-3" placeholder="(00) 90000-0000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Instagram (@)</label>
                            <input type="text" class="form-control rounded-3" placeholder="@seunegociolocal">
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-4 border">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkLgpd" required checked>
                            <label class="form-check-label small" for="checkLgpd">
                                Declaro ciência e autorizo o tratamento de dados de divulgação turística em conformidade com a <strong>LGPD (Lei nº 13.709/2018)</strong>.
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-bold">
                        <i class="bi bi-send-check me-1"></i> Enviar Cadastro para Validação
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

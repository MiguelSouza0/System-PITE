@extends('layouts.app')
@section('title', 'Cadastro de Empreendedor Local — System-PITE')

@push('styles')
<style>
    .registro-hero {
        min-height: calc(100vh - 70px);
        display: flex;
        align-items: center;
        background: linear-gradient(160deg, #0f172a 0%, #1e293b 30%, #064e3b 70%, #047857 100%);
        position: relative;
        overflow: hidden;
        padding: 48px 0;
    }
    .registro-hero::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -20%;
        width: 700px;
        height: 700px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(245,158,11,0.15) 0%, transparent 70%);
        animation: float 8s ease-in-out infinite;
    }
    .registro-card {
        background: rgba(255,255,255,0.98);
        backdrop-filter: blur(20px);
        border-radius: 28px;
        padding: 40px;
        box-shadow: 0 32px 80px rgba(0,0,0,0.25);
        position: relative;
        z-index: 2;
    }
    .beneficio-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        color: rgba(255,255,255,0.9);
        font-size: 0.95rem;
    }
    .beneficio-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: rgba(255,255,255,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #f59e0b;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
</style>
@endpush

@section('content')
<section class="registro-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            {{-- Lado Esquerdo: Benefícios para o Empreendedor --}}
            <div class="col-lg-5 d-none d-lg-block animate-in">
                <div class="chip chip-gold mb-3"><i class="bi bi-shop"></i> Espaço do Empreendedor</div>
                <h1 class="section-title text-white mb-3" style="font-size: 2.6rem;">
                    Conecte seu negócio à <span style="background: linear-gradient(135deg, #fbbf24, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">rede turística oficial</span>
                </h1>
                <p style="color: rgba(255,255,255,0.75); line-height: 1.7; font-size: 1.05rem;">
                    Integre sua pousada, restaurante, artesanato, agência ou serviço de guia turístico ao ecossistema digital municipal.
                </p>

                <div class="mt-4">
                    <div class="beneficio-item">
                        <div class="beneficio-icon"><i class="bi bi-patch-check-fill"></i></div>
                        <span><strong>Selo Municipal de Validação</strong> emitido pela Secretaria de Turismo</span>
                    </div>
                    <div class="beneficio-item">
                        <div class="beneficio-icon"><i class="bi bi-stars"></i></div>
                        <span>Recomendação automática em <strong>Roteiros Inteligentes por IA</strong></span>
                    </div>
                    <div class="beneficio-item">
                        <div class="beneficio-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <span>Presença destacada no <strong>Mapa Turístico Interativo</strong></span>
                    </div>
                    <div class="beneficio-item">
                        <div class="beneficio-icon"><i class="bi bi-graph-up-arrow"></i></div>
                        <span>Painel exclusivo de <strong>desempenho, acessos e avaliações</strong></span>
                    </div>
                </div>

                <div class="mt-4 p-3 rounded-4" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-success text-white px-2 py-1 small fw-bold">🎒 É Turista ou Visitante?</span>
                    </div>
                    <p class="small text-white text-opacity-90 mb-2">Deseja apenas explorar roteiros e pontos turísticos?</p>
                    <a href="{{ route('turista.registro') }}" class="btn btn-light btn-sm rounded-pill fw-bold text-dark w-100">
                        <i class="bi bi-person-heart text-success me-1"></i> Criar Conta como Turista
                    </a>
                </div>
            </div>

            {{-- Lado Direito: Formulário de Autocadastro --}}
            <div class="col-lg-7 animate-in animate-delay-2">
                <div class="registro-card">
                    {{-- Alternância de Perfil (Turista vs Empreendedor) --}}
                    <div class="d-flex p-1 mb-4 rounded-4" style="background: #f1f5f9;">
                        <a href="{{ route('turista.registro') }}" class="btn w-50 rounded-4 py-2 small fw-bold d-flex align-items-center justify-content-center gap-2 text-muted" style="background: transparent;">
                            <i class="bi bi-person-heart text-success"></i> Sou Turista / Cidadão
                        </a>
                        <a href="{{ route('empreendedor.registro') }}" class="btn w-50 rounded-4 py-2 small fw-bold d-flex align-items-center justify-content-center gap-2 shadow-sm" style="background: #fff; color: #d97706;">
                            <i class="bi bi-shop text-warning"></i> Sou Empreendedor Local
                        </a>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold">Homologação Municipal Obrigatória</span>
                    </div>
                    <h4 class="fw-bold mb-1" style="font-family:'Outfit';">Cadastre seu Estabelecimento</h4>
                    <p class="text-muted small mb-4">Preencha os dados de acesso e as informações do seu negócio local.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 small py-2 mb-3">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('empreendedor.registro.store') }}" method="POST">
                        @csrf

                        {{-- SEÇÃO 1: Dados do Responsável / Usuário --}}
                        <div class="p-3 rounded-4 mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <h6 class="fw-bold text-dark mb-2" style="font-family:'Outfit';">
                                <i class="bi bi-person-badge text-warning me-1"></i> Dados de Acesso (Responsável)
                            </h6>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold mb-1">Nome do Responsável *</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control form-control-pite" placeholder="Seu nome completo" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold mb-1">E-mail de Login *</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-pite" placeholder="contato@empresa.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold mb-1">Senha de Acesso *</label>
                                    <input type="password" name="password" class="form-control form-control-pite" placeholder="Mínimo 6 caracteres" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold mb-1">Confirmar Senha *</label>
                                    <input type="password" name="password_confirmation" class="form-control form-control-pite" placeholder="Repita a senha" required>
                                </div>
                            </div>
                        </div>

                        {{-- SEÇÃO 2: Informações do Negócio --}}
                        <div class="p-3 rounded-4 mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <h6 class="fw-bold text-dark mb-2" style="font-family:'Outfit';">
                                <i class="bi bi-building-check text-primary me-1"></i> Informações do Estabelecimento
                            </h6>
                            <div class="row g-2 mb-2">
                                <div class="col-md-8">
                                    <label class="form-label small fw-semibold mb-1">Razão Social / Nome Oficial *</label>
                                    <input type="text" name="razao_social" value="{{ old('razao_social') }}" class="form-control form-control-pite" placeholder="Ex: Pousada Recanto dos Ipês ME" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold mb-1">CNPJ ou CPF *</label>
                                    <input type="text" name="cnpj_cpf" value="{{ old('cnpj_cpf') }}" class="form-control form-control-pite" placeholder="00.000.000/0001-00" required>
                                </div>
                            </div>

                            <div class="row g-2 mb-2">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold mb-1">Nome Fantasia (Como o turista conhece)</label>
                                    <input type="text" name="nome_fantasia" value="{{ old('nome_fantasia') }}" class="form-control form-control-pite" placeholder="Ex: Pousada Recanto dos Ipês">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold mb-1">Ramo de Atividade *</label>
                                    <select name="tipo_servico" class="form-select form-select-pite" required>
                                        <option value="gastronomia" {{ old('tipo_servico') == 'gastronomia' ? 'selected' : '' }}>🍴 Gastronomia & Restaurantes</option>
                                        <option value="hospedagem" {{ old('tipo_servico') == 'hospedagem' ? 'selected' : '' }}>🏨 Pousada, Hotel & Hospedagem</option>
                                        <option value="artesanato" {{ old('tipo_servico') == 'artesanato' ? 'selected' : '' }}>🎨 Artesanato & Produtos Locais</option>
                                        <option value="guia" {{ old('tipo_servico') == 'guia' ? 'selected' : '' }}>🧭 Guia de Turismo Credenciado</option>
                                        <option value="transporte" {{ old('tipo_servico') == 'transporte' ? 'selected' : '' }}>🚐 Transporte Turístico / Receptivo</option>
                                        <option value="agencia" {{ old('tipo_servico') == 'agencia' ? 'selected' : '' }}>🎫 Agência de Turismo</option>
                                        <option value="experiencia" {{ old('tipo_servico') == 'experiencia' ? 'selected' : '' }}>🌿 Ecoturismo & Experiências</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label small fw-semibold mb-1">Descrição dos Serviços e Infraestrutura</label>
                                <textarea name="descricao" class="form-control form-control-pite" rows="2" placeholder="Descreva especialidades, pratos típicos, comodidades...">{{ old('descricao') }}</textarea>
                            </div>
                        </div>

                        {{-- SEÇÃO 3: Localização e Contatos --}}
                        <div class="p-3 rounded-4 mb-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <h6 class="fw-bold text-dark mb-2" style="font-family:'Outfit';">
                                <i class="bi bi-geo-alt text-danger me-1"></i> Endereço e Contatos
                            </h6>
                            <div class="row g-2 mb-2">
                                <div class="col-md-7">
                                    <label class="form-label small fw-semibold mb-1">Endereço Completo</label>
                                    <input type="text" name="endereco" value="{{ old('endereco') }}" class="form-control form-control-pite" placeholder="Rua, Av, Número...">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label small fw-semibold mb-1">Bairro / Região</label>
                                    <input type="text" name="bairro" value="{{ old('bairro') }}" class="form-control form-control-pite" placeholder="Centro, Zona Rural...">
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold mb-1">Telefone / WhatsApp</label>
                                    <input type="text" name="telefone" value="{{ old('telefone') }}" class="form-control form-control-pite" placeholder="(00) 90000-0000">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold mb-1">Instagram (@)</label>
                                    <input type="text" name="instagram" value="{{ old('instagram') }}" class="form-control form-control-pite" placeholder="@seunegociolocal">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-pite-gold w-100 btn-lg shadow-sm">
                            <i class="bi bi-send-check me-2"></i> Concluir Cadastro e Enviar para Homologação
                        </button>

                        <div class="text-center mt-3">
                            <span class="small text-muted">Já possui conta no sistema?</span>
                            <a href="{{ route('turista.login') }}" class="small fw-semibold text-decoration-none" style="color: var(--pite-emerald);">Fazer Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

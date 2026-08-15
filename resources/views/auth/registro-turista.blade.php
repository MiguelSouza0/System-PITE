@extends('layouts.app')
@section('title', 'Crie sua Conta de Turista — System-PITE')

@push('styles')
<style>
    .registro-hero {
        min-height: calc(100vh - 70px);
        display: flex;
        align-items: center;
        background: linear-gradient(160deg, #022c22 0%, #064e3b 30%, #047857 60%, #0d9488 100%);
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
        background: radial-gradient(circle, rgba(245,158,11,0.1) 0%, transparent 70%);
        animation: float 8s ease-in-out infinite;
    }
    .registro-card {
        background: rgba(255,255,255,0.97);
        backdrop-filter: blur(20px);
        border-radius: 28px;
        padding: 40px;
        box-shadow: 0 32px 80px rgba(0,0,0,0.2);
        position: relative;
        z-index: 2;
    }
    .interesse-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        cursor: pointer;
        transition: var(--pite-transition);
        background: #fff;
        font-size: 0.88rem;
        font-weight: 500;
        user-select: none;
    }
    .interesse-chip:hover {
        border-color: var(--pite-emerald);
        background: rgba(4,120,87,0.04);
    }
    .interesse-chip.selected {
        border-color: var(--pite-emerald);
        background: rgba(4,120,87,0.08);
        color: var(--pite-emerald);
        box-shadow: 0 0 0 3px rgba(4,120,87,0.12);
    }
    .interesse-chip input[type="checkbox"] { display: none; }
    .interesse-emoji { font-size: 1.2rem; }
    .step-indicator {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 32px;
    }
    .step-dot {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        transition: var(--pite-transition);
    }
    .step-dot.active {
        background: linear-gradient(135deg, var(--pite-emerald), var(--pite-teal));
        color: #fff;
        box-shadow: 0 4px 16px rgba(4,120,87,0.3);
    }
    .step-dot.inactive {
        background: #f1f5f9;
        color: #94a3b8;
    }
    .step-line {
        flex: 1;
        height: 2px;
        background: #e2e8f0;
    }
    .beneficio-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        color: rgba(255,255,255,0.85);
        font-size: 0.95rem;
    }
    .beneficio-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fbbf24;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
</style>
@endpush

@section('content')
<section class="registro-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            {{-- Lado Esquerdo: Benefícios --}}
            <div class="col-lg-5 d-none d-lg-block animate-in">
                <div class="chip chip-gold mb-3"><i class="bi bi-person-badge"></i> Cadastro Gratuito</div>
                <h1 class="section-title text-white mb-3" style="font-size: 2.6rem;">
                    Sua jornada turística <span style="background: linear-gradient(135deg, #fbbf24, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">personalizada</span>
                </h1>
                <p style="color: rgba(255,255,255,0.7); line-height: 1.7; font-size: 1.05rem;">
                    Crie sua conta e desbloqueie recursos exclusivos para uma experiência turística completa.
                </p>

                <div class="mt-4">
                    <div class="beneficio-item">
                        <div class="beneficio-icon"><i class="bi bi-stars"></i></div>
                        <span>Roteiros personalizados por IA baseados nos seus interesses</span>
                    </div>
                    <div class="beneficio-item">
                        <div class="beneficio-icon"><i class="bi bi-heart"></i></div>
                        <span>Salve atrativos e eventos favoritos para visitar depois</span>
                    </div>
                    <div class="beneficio-item">
                        <div class="beneficio-icon"><i class="bi bi-map"></i></div>
                        <span>Mapa pessoal com todos os lugares que você visitou</span>
                    </div>
                    <div class="beneficio-item">
                        <div class="beneficio-icon"><i class="bi bi-star"></i></div>
                        <span>Avalie experiências e contribua para o turismo local</span>
                    </div>
                    <div class="beneficio-item">
                        <div class="beneficio-icon"><i class="bi bi-clock-history"></i></div>
                        <span>Histórico completo da sua jornada turística</span>
                    </div>
                </div>

                {{-- Card de Destaque para Empreendedores Locais --}}
                <div class="mt-4 p-3 rounded-4" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2);">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-warning text-dark px-2 py-1 small fw-bold">🏪 Espaço do Empreendedor</span>
                    </div>
                    <p class="small text-white text-opacity-90 mb-2">Possui pousada, restaurante, artesanato ou atua como guia?</p>
                    <a href="{{ route('empreendedor.registro') }}" class="btn btn-warning btn-sm rounded-pill fw-bold text-dark w-100">
                        <i class="bi bi-shop me-1"></i> Cadastrar Meu Estabelecimento
                    </a>
                </div>
            </div>

            {{-- Lado Direito: Formulário --}}
            <div class="col-lg-7 animate-in animate-delay-2">
                <div class="registro-card">
                    {{-- Alternância de Perfil (Turista vs Empreendedor) --}}
                    <div class="d-flex p-1 mb-4 rounded-4" style="background: #f1f5f9;">
                        <a href="{{ route('turista.registro') }}" class="btn w-50 rounded-4 py-2 small fw-bold d-flex align-items-center justify-content-center gap-2 shadow-sm" style="background: #fff; color: var(--pite-emerald);">
                            <i class="bi bi-person-heart text-success"></i> Sou Turista / Cidadão
                        </a>
                        <a href="{{ route('empreendedor.registro') }}" class="btn w-50 rounded-4 py-2 small fw-bold d-flex align-items-center justify-content-center gap-2 text-muted" style="background: transparent;">
                            <i class="bi bi-shop text-warning"></i> Sou Empreendedor Local
                        </a>
                    </div>

                    {{-- Step Indicator --}}
                    <div class="step-indicator">
                        <div class="step-dot active" id="stepDot1">1</div>
                        <div class="step-line"></div>
                        <div class="step-dot inactive" id="stepDot2">2</div>
                        <div class="step-line"></div>
                        <div class="step-dot inactive" id="stepDot3">3</div>
                    </div>

                    <form method="POST" action="{{ route('turista.registro') }}" id="formRegistro">
                        @csrf

                        {{-- STEP 1: Dados Pessoais --}}
                        <div id="step1">
                            <h4 style="font-family:'Outfit'; font-weight:700; margin-bottom: 4px;">
                                <i class="bi bi-person" style="color:var(--pite-emerald);"></i> Dados Pessoais
                            </h4>
                            <p class="small text-muted mb-4">Informações básicas para criar sua conta</p>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Nome Completo *</label>
                                <input type="text" name="name" class="form-control form-control-pite @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Seu nome completo" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">E-mail *</label>
                                <input type="email" name="email" class="form-control form-control-pite @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="seuemail@exemplo.com" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Senha *</label>
                                    <input type="password" name="password" class="form-control form-control-pite @error('password') is-invalid @enderror" placeholder="Mínimo 6 caracteres" required>
                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Confirmar Senha *</label>
                                    <input type="password" name="password_confirmation" class="form-control form-control-pite" placeholder="Repita a senha" required>
                                </div>
                            </div>

                            <button type="button" class="btn btn-pite w-100 btn-lg mt-2" onclick="goToStep(2)">
                                Próximo <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>

                        {{-- STEP 2: Origem e Família --}}
                        <div id="step2" style="display:none;">
                            <h4 style="font-family:'Outfit'; font-weight:700; margin-bottom: 4px;">
                                <i class="bi bi-geo-alt" style="color:var(--pite-emerald);"></i> De onde você vem?
                            </h4>
                            <p class="small text-muted mb-4">Informações de origem e perfil para personalizar sua experiência</p>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Nacionalidade</label>
                                    <div class="position-relative">
                                        <input type="text" name="nacionalidade" id="nacionalidadeInput" list="listaPaises" class="form-control form-control-pite" value="{{ old('nacionalidade', 'Brasileira') }}" placeholder="Digite para buscar seu país..." autocomplete="off">
                                        <datalist id="listaPaises">
                                            <option value="Brasileira (Brasil)">🇧🇷 Brasil</option>
                                            <option value="Afegã (Afeganistão)">🇦🇫 Afeganistão</option>
                                            <option value="Sul-Africana (África do Sul)">🇿🇦 África do Sul</option>
                                            <option value="Albanesa (Albânia)">🇦🇱 Albânia</option>
                                            <option value="Alemã (Alemanha)">🇩🇪 Alemanha</option>
                                            <option value="Andorrana (Andorra)">🇦🇩 Andorra</option>
                                            <option value="Angolana (Angola)">🇦🇴 Angola</option>
                                            <option value="Antiguana (Antígua e Barbuda)">🇦🇬 Antígua e Barbuda</option>
                                            <option value="Saudita (Arábia Saudita)">🇸🇦 Arábia Saudita</option>
                                            <option value="Argelina (Argélia)">🇩🇿 Argélia</option>
                                            <option value="Argentina (Argentina)">🇦🇷 Argentina</option>
                                            <option value="Armênia (Armênia)">🇦🇲 Armênia</option>
                                            <option value="Australiana (Austrália)">🇦🇺 Austrália</option>
                                            <option value="Austríaca (Áustria)">🇦🇹 Áustria</option>
                                            <option value="Azerbaijana (Azerbaijão)">🇦🇿 Azerbaijão</option>
                                            <option value="Bahamense (Bahamas)">🇧🇸 Bahamas</option>
                                            <option value="Bengali (Bangladesh)">🇧🇩 Bangladesh</option>
                                            <option value="Barbadiana (Barbados)">🇧🇧 Barbados</option>
                                            <option value="Barenita (Bahrein)">🇧🇭 Bahrein</option>
                                            <option value="Belga (Bélgica)">🇧🇪 Bélgica</option>
                                            <option value="Belizenha (Belize)">🇧🇿 Belize</option>
                                            <option value="Beninense (Benin)">🇧🇯 Benin</option>
                                            <option value="Bielorrussa (Bielorrússia)">🇧🇾 Bielorrússia</option>
                                            <option value="Boliviana (Bolívia)">🇧🇴 Bolívia</option>
                                            <option value="Bósnia (Bósnia e Herzegovina)">🇧🇦 Bósnia e Herzegovina</option>
                                            <option value="Botsuanesa (Botsuana)">🇧🇼 Botsuana</option>
                                            <option value="Búlgara (Bulgária)">🇧🇬 Bulgária</option>
                                            <option value="Burquinesa (Burkina Faso)">🇧🇫 Burkina Faso</option>
                                            <option value="Burundinesa (Burundi)">🇧🇮 Burundi</option>
                                            <option value="Butanesa (Butão)">🇧🇹 Butão</option>
                                            <option value="Cabo-Verdiana (Cabo Verde)">🇨🇻 Cabo Verde</option>
                                            <option value="Camaronesa (Camarões)">🇨🇲 Camarões</option>
                                            <option value="Camboajana (Camboja)">🇰🇭 Camboja</option>
                                            <option value="Canadense (Canadá)">🇨🇦 Canadá</option>
                                            <option value="Catariana (Catar)">🇶🇦 Catar</option>
                                            <option value="Cazaque (Cazaquistão)">🇰🇿 Cazaquistão</option>
                                            <option value="Chadiana (Chade)">🇹🇩 Chade</option>
                                            <option value="Chilena (Chile)">🇨🇱 Chile</option>
                                            <option value="Chinesa (China)">🇨🇳 China</option>
                                            <option value="Chipriota (Chipre)">🇨🇾 Chipre</option>
                                            <option value="Colombiana (Colômbia)">🇨🇴 Colômbia</option>
                                            <option value="Comorense (Comores)">🇰🇲 Comores</option>
                                            <option value="Norte-Coreana (Coreia do Norte)">🇰🇵 Coreia do Norte</option>
                                            <option value="Sul-Coreana (Coreia do Sul)">🇰🇷 Coreia do Sul</option>
                                            <option value="Costa-Marfinense (Costa do Marfim)">🇨🇮 Costa do Marfim</option>
                                            <option value="Costarriquenha (Costa Rica)">🇨🇷 Costa Rica</option>
                                            <option value="Croata (Croácia)">🇭🇷 Croácia</option>
                                            <option value="Cubana (Cuba)">🇨🇺 Cuba</option>
                                            <option value="Dinamarquesa (Dinamarca)">🇩🇰 Dinamarca</option>
                                            <option value="Djibutiana (Djibuti)">🇩🇯 Djibuti</option>
                                            <option value="Dominicana (República Dominicana)">🇩🇴 República Dominicana</option>
                                            <option value="Egípcia (Egito)">🇪🇬 Egito</option>
                                            <option value="Salvadorenha (El Salvador)">🇸🇻 El Salvador</option>
                                            <option value="Emiradense (Emirados Árabes Unidos)">🇦🇪 Emirados Árabes Unidos</option>
                                            <option value="Equatoriana (Equador)">🇪🇨 Equador</option>
                                            <option value="Eritreia (Eritreia)">🇪🇷 Eritreia</option>
                                            <option value="Eslovaca (Eslováquia)">🇸🇰 Eslováquia</option>
                                            <option value="Eslovena (Eslovênia)">🇸🇮 Eslovênia</option>
                                            <option value="Espanhola (Espanha)">🇪🇸 Espanha</option>
                                            <option value="Americana (Estados Unidos)">🇺🇸 Estados Unidos</option>
                                            <option value="Estoniana (Estônia)">🇪🇪 Estônia</option>
                                            <option value="Etíope (Etiópia)">🇪🇹 Etiópia</option>
                                            <option value="Fijiana (Fiji)">🇫🇯 Fiji</option>
                                            <option value="Filipina (Filipinas)">🇵🇭 Filipinas</option>
                                            <option value="Finlandesa (Finlândia)">🇫🇮 Finlândia</option>
                                            <option value="Francesa (França)">🇫🇷 França</option>
                                            <option value="Gabonesa (Gabão)">🇬🇦 Gabão</option>
                                            <option value="Gambiana (Gâmbia)">🇬🇲 Gâmbia</option>
                                            <option value="Ganesa (Gana)">🇬🇭 Gana</option>
                                            <option value="Georgiana (Geórgia)">🇬🇪 Geórgia</option>
                                            <option value="Granadina (Granada)">🇬🇩 Granada</option>
                                            <option value="Grega (Grécia)">🇬🇷 Grécia</option>
                                            <option value="Guatemalteca (Guatemala)">🇬🇹 Guatemala</option>
                                            <option value="Guineense (Guiné)">🇬🇳 Guiné</option>
                                            <option value="Bissau-Guineense (Guiné-Bissau)">🇬🇼 Guiné-Bissau</option>
                                            <option value="Equato-Guineense (Guiné Equatorial)">🇬🇶 Guiné Equatorial</option>
                                            <option value="Guianense (Guiana)">🇬🇾 Guiana</option>
                                            <option value="Haitiana (Haiti)">🇭🇹 Haiti</option>
                                            <option value="Holandesa (Holanda / Países Baixos)">🇳🇱 Holanda</option>
                                            <option value="Hondurenha (Honduras)">🇭🇳 Honduras</option>
                                            <option value="Húngara (Hungria)">🇭🇺 Hungria</option>
                                            <option value="Iemenita (Iêmen)">🇾🇪 Iêmen</option>
                                            <option value="Indiana (Índia)">🇮🇳 Índia</option>
                                            <option value="Indonésia (Indonésia)">🇮🇩 Indonésia</option>
                                            <option value="Iraniana (Irã)">🇮🇷 Irã</option>
                                            <option value="Iraquiana (Iraque)">🇮🇶 Iraque</option>
                                            <option value="Irlandesa (Irlanda)">🇮🇪 Irlanda</option>
                                            <option value="Islandesa (Islândia)">🇮🇸 Islândia</option>
                                            <option value="Israelense (Israel)">🇮🇱 Israel</option>
                                            <option value="Italiana (Itália)">🇮🇹 Itália</option>
                                            <option value="Jamaicana (Jamaica)">🇯🇲 Jamaica</option>
                                            <option value="Japonesa (Japão)">🇯🇵 Japão</option>
                                            <option value="Jordaniana (Jordânia)">🇯🇴 Jordânia</option>
                                            <option value="Kuwaitiana (Kuwait)">🇰🇼 Kuwait</option>
                                            <option value="Laosiana (Laos)">🇱🇦 Laos</option>
                                            <option value="Lesotiana (Lesoto)">🇱🇸 Lesoto</option>
                                            <option value="Letã (Letônia)">🇱🇻 Letônia</option>
                                            <option value="Libanesa (Líbano)">🇱🇧 Líbano</option>
                                            <option value="Liberiana (Libéria)">🇱🇷 Libéria</option>
                                            <option value="Líbia (Líbia)">🇱🇾 Líbia</option>
                                            <option value="Liechtensteinense (Liechtenstein)">🇱🇮 Liechtenstein</option>
                                            <option value="Lituana (Lituânia)">🇱🇹 Lituânia</option>
                                            <option value="Luxemburguesa (Luxemburgo)">🇱🇺 Luxemburgo</option>
                                            <option value="Macedônia (Macedônia do Norte)">🇲🇰 Macedônia do Norte</option>
                                            <option value="Madagascarense (Madagascar)">🇲🇬 Madagascar</option>
                                            <option value="Malaia (Malásia)">🇲🇾 Malásia</option>
                                            <option value="Malauiana (Malaui)">🇲🇼 Malaui</option>
                                            <option value="Maldiva (Maldivas)">🇲🇻 Maldivas</option>
                                            <option value="Maliana (Mali)">🇲🇱 Mali</option>
                                            <option value="Maltesa (Malta)">🇲🇹 Malta</option>
                                            <option value="Marroquina (Marrocos)">🇲🇦 Marrocos</option>
                                            <option value="Mauriciana (Maurício)">🇲🇺 Maurício</option>
                                            <option value="Mauritana (Mauritânia)">🇲🇷 Mauritânia</option>
                                            <option value="Mexicana (México)">🇲🇽 México</option>
                                            <option value="Mianmarense (Mianmar)">🇲🇲 Mianmar</option>
                                            <option value="Micronésia (Micronésia)">🇫🇲 Micronésia</option>
                                            <option value="Moçambicana (Moçambique)">🇲🇿 Moçambique</option>
                                            <option value="Moldávia (Moldávia)">🇲🇩 Moldávia</option>
                                            <option value="Monegasca (Mônaco)">🇲🇨 Mônaco</option>
                                            <option value="Mongol (Mongólia)">🇲🇳 Mongólia</option>
                                            <option value="Montenegrina (Montenegro)">🇲🇪 Montenegro</option>
                                            <option value="Namibiana (Namíbia)">🇳🇦 Namíbia</option>
                                            <option value="Nauruana (Nauru)">🇳🇷 Nauru</option>
                                            <option value="Nepalesa (Nepal)">🇳🇵 Nepal</option>
                                            <option value="Nicaraguense (Nicarágua)">🇳🇮 Nicarágua</option>
                                            <option value="Nigerina (Níger)">🇳🇪 Níger</option>
                                            <option value="Nigeriana (Nigéria)">🇳🇬 Nigéria</option>
                                            <option value="Norueguesa (Noruega)">🇳🇴 Noruega</option>
                                            <option value="Neozelandesa (Nova Zelândia)">🇳🇿 Nova Zelândia</option>
                                            <option value="Omanense (Omã)">🇴🇲 Omã</option>
                                            <option value="Panamenha (Panamá)">🇵🇦 Panamá</option>
                                            <option value="Papua (Papua-Nova Guiné)">🇵🇬 Papua-Nova Guiné</option>
                                            <option value="Paquistanesa (Paquistão)">🇵🇰 Paquistão</option>
                                            <option value="Paraguaia (Paraguai)">🇵🇾 Paraguai</option>
                                            <option value="Peruana (Peru)">🇵🇪 Peru</option>
                                            <option value="Polonesa (Polônia)">🇵🇱 Polônia</option>
                                            <option value="Portuguesa (Portugal)">🇵🇹 Portugal</option>
                                            <option value="Queniana (Quênia)">🇰🇪 Quênia</option>
                                            <option value="Quirguiz (Quirguistão)">🇰🇬 Quirguistão</option>
                                            <option value="Britânica (Reino Unido)">🇬🇧 Reino Unido</option>
                                            <option value="Centro-Africana (República Centro-Africana)">🇨🇫 República Centro-Africana</option>
                                            <option value="Tcheca (República Tcheca)">🇨🇿 República Tcheca</option>
                                            <option value="Romena (Romênia)">🇷🇴 Romênia</option>
                                            <option value="Ruandesa (Ruanda)">🇷🇼 Ruanda</option>
                                            <option value="Russa (Rússia)">🇷🇺 Rússia</option>
                                            <option value="Salomônica (Ilhas Salomão)">🇸🇧 Ilhas Salomão</option>
                                            <option value="Samoana (Samoa)">🇼🇸 Samoa</option>
                                            <option value="San-Marinense (San Marino)">🇸🇲 San Marino</option>
                                            <option value="Santa-Lucense (Santa Lúcia)">🇱🇨 Santa Lúcia</option>
                                            <option value="São-Tomense (São Tomé e Príncipe)">🇸🇹 São Tomé e Príncipe</option>
                                            <option value="Senegalesa (Senegal)">🇸🇳 Senegal</option>
                                            <option value="Sérvia (Sérvia)">🇷🇸 Sérvia</option>
                                            <option value="Seichelense (Seicheles)">🇸🇨 Seicheles</option>
                                            <option value="Serra-Leonesa (Serra Leoa)">🇸🇱 Serra Leoa</option>
                                            <option value="Singapurense (Singapura)">🇸🇬 Singapura</option>
                                            <option value="Síria (Síria)">🇸🇾 Síria</option>
                                            <option value="Somali (Somália)">🇸🇴 Somália</option>
                                            <option value="Sri-Lankesa (Sri Lanka)">🇱🇰 Sri Lanka</option>
                                            <option value="Suazi (Essuatíni / Suazilândia)">🇸🇿 Essuatíni</option>
                                            <option value="Sudanesa (Sudão)">🇸🇩 Sudão</option>
                                            <option value="Sul-Sudanesa (Sudão do Sul)">🇸🇸 Sudão do Sul</option>
                                            <option value="Sueca (Suécia)">🇸🇪 Suécia</option>
                                            <option value="Suíça (Suíça)">🇨🇭 Suíça</option>
                                            <option value="Surinamesa (Suriname)">🇸🇷 Suriname</option>
                                            <option value="Tailandesa (Tailândia)">🇹🇭 Tailândia</option>
                                            <option value="Tadjique (Tadjiquistão)">🇹🇯 Tadjiquistão</option>
                                            <option value="Tanzaniana (Tanzânia)">🇹🇿 Tanzânia</option>
                                            <option value="Timorense (Timor-Leste)">🇹🇱 Timor-Leste</option>
                                            <option value="Togolesa (Togo)">🇹🇬 Togo</option>
                                            <option value="Tonganesa (Tonga)">🇹🇴 Tonga</option>
                                            <option value="Trinitária (Trinidad e Tobago)">🇹🇹 Trinidad e Tobago</option>
                                            <option value="Tunisiana (Tunísia)">🇹🇳 Tunísia</option>
                                            <option value="Turcomena (Turcomenistão)">🇹🇲 Turcomenistão</option>
                                            <option value="Turca (Turquia)">🇹🇷 Turquia</option>
                                            <option value="Tuvaluana (Tuvalu)">🇹🇻 Tuvalu</option>
                                            <option value="Ucraniana (Ucrânia)">🇺🇦 Ucrânia</option>
                                            <option value="Ugandense (Uganda)">🇺🇬 Uganda</option>
                                            <option value="Uruguaia (Uruguai)">🇺🇾 Uruguay</option>
                                            <option value="Uzbeque (Uzbequistão)">🇺🇿 Uzbequistão</option>
                                            <option value="Vanuatuense (Vanuatu)">🇻🇺 Vanuatu</option>
                                            <option value="Vaticana (Vaticano)">🇻🇦 Vaticano</option>
                                            <option value="Venezuelana (Venezuela)">🇻🇪 Venezuela</option>
                                            <option value="Vietnamita (Vietnã)">🇻🇳 Vietnã</option>
                                            <option value="Zambiana (Zâmbia)">🇿🇲 Zâmbia</option>
                                            <option value="Zimbabuense (Zimbábue)">🇿🇼 Zimbábue</option>
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">CEP</label>
                                    <div class="input-group">
                                        <input type="text" name="cep" id="registroCep" class="form-control form-control-pite" value="{{ old('cep') }}" placeholder="00000-000" maxlength="9">
                                        <button type="button" class="btn btn-outline-secondary" id="btnBuscarCepTurista" title="Buscar Cidade e Estado pelo CEP" style="border-color:#e2e8f0; border-radius: 0 12px 12px 0;">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                    <small id="cepTuristaStatus" class="text-muted" style="font-size: 0.75rem;"></small>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Cidade de Residência</label>
                                    <input type="text" name="cidade_origem" id="registroCidade" class="form-control form-control-pite" value="{{ old('cidade_origem') }}" placeholder="Sua cidade">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Estado</label>
                                    <input type="text" name="estado_origem" id="registroEstado" class="form-control form-control-pite" value="{{ old('estado_origem') }}" placeholder="Seu estado (ex: PB, SP, RJ)">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-semibold">País</label>
                                <input type="text" name="pais_origem" id="registroPais" list="listaPaises" class="form-control form-control-pite" value="{{ old('pais_origem', 'Brasil') }}" placeholder="Seu país...">
                            </div>

                            {{-- Perfil Familiar (Opcional) --}}
                            <div class="mb-4 p-3 rounded-4" style="background: rgba(4,120,87,0.03); border: 1px solid rgba(4,120,87,0.1);">
                                <label class="form-label small fw-bold mb-2 text-dark">
                                    <i class="bi bi-people me-1" style="color:var(--pite-emerald);"></i> Perfil Familiar (Opcional)
                                </label>
                                <p class="small text-muted mb-3" style="font-size: 0.82rem;">Nos ajuda a sugerir roteiros para casais, famílias ou passeios individuais.</p>

                                <div class="row g-2 align-items-center">
                                    <div class="col-sm-6">
                                        <div class="form-check form-switch p-2 bg-white rounded-3 border">
                                            <input class="form-check-input ms-0 me-2" type="checkbox" name="possui_conjuge" value="1" id="switchConjuge" {{ old('possui_conjuge') ? 'checked' : '' }} style="border-color:var(--pite-emerald);">
                                            <label class="form-check-label small fw-semibold" for="switchConjuge">
                                                💍 Possui cônjuge
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check form-switch p-2 bg-white rounded-3 border">
                                            <input class="form-check-input ms-0 me-2" type="checkbox" name="possui_filhos" value="1" id="switchFilhos" onchange="toggleFilhosInput(this.checked)" {{ old('possui_filhos') ? 'checked' : '' }} style="border-color:var(--pite-emerald);">
                                            <label class="form-check-label small fw-semibold" for="switchFilhos">
                                                👶 Possui filhos
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div id="boxQtdFilhos" class="mt-2 p-2 bg-white rounded-3 border {{ old('possui_filhos') ? 'd-flex' : 'd-none' }} align-items-center justify-content-between">
                                    <span class="small fw-semibold text-muted"><i class="bi bi-person-arms-up text-success me-1"></i> Quantidade de filhos:</span>
                                    <input type="number" name="quantidade_filhos" class="form-control form-control-sm text-center" style="max-width: 90px; border-radius: 8px;" value="{{ old('quantidade_filhos', 1) }}" min="1" max="20">
                                </div>
                            </div>

                            {{-- Necessidades especiais --}}
                            <div class="mb-4">
                                <label class="form-label small fw-semibold"><i class="bi bi-universal-access me-1 text-success"></i> Necessidades de Acessibilidade</label>
                                <div class="d-flex flex-wrap gap-2">
                                    <label class="interesse-chip">
                                        <input type="checkbox" name="necessidades_especiais[]" value="cadeirante">
                                        <span class="interesse-emoji">♿</span> Cadeirante
                                    </label>
                                    <label class="interesse-chip">
                                        <input type="checkbox" name="necessidades_especiais[]" value="visual">
                                        <span class="interesse-emoji">👁️</span> Visual
                                    </label>
                                    <label class="interesse-chip">
                                        <input type="checkbox" name="necessidades_especiais[]" value="auditiva">
                                        <span class="interesse-emoji">👂</span> Auditiva
                                    </label>
                                    <label class="interesse-chip">
                                        <input type="checkbox" name="necessidades_especiais[]" value="mobilidade">
                                        <span class="interesse-emoji">🦯</span> Mobilidade Reduzida
                                    </label>
                                    <label class="interesse-chip">
                                        <input type="checkbox" name="necessidades_especiais[]" value="idoso">
                                        <span class="interesse-emoji">👴</span> Idoso
                                    </label>
                                    <label class="interesse-chip">
                                        <input type="checkbox" name="necessidades_especiais[]" value="crianca">
                                        <span class="interesse-emoji">👶</span> Com Criança
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-pite-outline w-50 btn-lg" style="border-color:#e2e8f0; color:var(--pite-text);" onclick="goToStep(1)">
                                    <i class="bi bi-arrow-left me-1"></i> Voltar
                                </button>
                                <button type="button" class="btn btn-pite w-50 btn-lg" onclick="goToStep(3)">
                                    Próximo <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        {{-- STEP 3: Interesses --}}
                        <div id="step3" style="display:none;">
                            <h4 style="font-family:'Outfit'; font-weight:700; margin-bottom: 4px;">
                                <i class="bi bi-heart" style="color:var(--pite-coral);"></i> Seus Interesses
                            </h4>
                            <p class="small text-muted mb-4">Selecione o que mais te atrai para personalizar sua experiência</p>

                            <div class="d-flex flex-wrap gap-2 mb-4">
                                <label class="interesse-chip">
                                    <input type="checkbox" name="interesses[]" value="natureza">
                                    <span class="interesse-emoji">🌿</span> Natureza & Ecoturismo
                                </label>
                                <label class="interesse-chip">
                                    <input type="checkbox" name="interesses[]" value="historia">
                                    <span class="interesse-emoji">🏛️</span> História & Patrimônio
                                </label>
                                <label class="interesse-chip">
                                    <input type="checkbox" name="interesses[]" value="gastronomia">
                                    <span class="interesse-emoji">🍽️</span> Gastronomia
                                </label>
                                <label class="interesse-chip">
                                    <input type="checkbox" name="interesses[]" value="aventura">
                                    <span class="interesse-emoji">🧗</span> Aventura & Esporte
                                </label>
                                <label class="interesse-chip">
                                    <input type="checkbox" name="interesses[]" value="cultural">
                                    <span class="interesse-emoji">🎭</span> Cultural & Artístico
                                </label>
                                <label class="interesse-chip">
                                    <input type="checkbox" name="interesses[]" value="religioso">
                                    <span class="interesse-emoji">⛪</span> Religioso
                                </label>
                                <label class="interesse-chip">
                                    <input type="checkbox" name="interesses[]" value="rural">
                                    <span class="interesse-emoji">🌾</span> Rural & Agroturismo
                                </label>
                                <label class="interesse-chip">
                                    <input type="checkbox" name="interesses[]" value="negocios">
                                    <span class="interesse-emoji">💼</span> Negócios & Eventos
                                </label>
                                <label class="interesse-chip">
                                    <input type="checkbox" name="interesses[]" value="saude">
                                    <span class="interesse-emoji">💆</span> Saúde & Bem-estar
                                </label>
                                <label class="interesse-chip">
                                    <input type="checkbox" name="interesses[]" value="nautico">
                                    <span class="interesse-emoji">⛵</span> Náutico
                                </label>
                                <label class="interesse-chip">
                                    <input type="checkbox" name="interesses[]" value="compras">
                                    <span class="interesse-emoji">🛍️</span> Compras & Artesanato
                                </label>
                                <label class="interesse-chip">
                                    <input type="checkbox" name="interesses[]" value="familia">
                                    <span class="interesse-emoji">👨‍👩‍👧‍👦</span> Família & Lazer
                                </label>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-pite-outline w-50 btn-lg" style="border-color:#e2e8f0; color:var(--pite-text);" onclick="goToStep(2)">
                                    <i class="bi bi-arrow-left me-1"></i> Voltar
                                </button>
                                <button type="submit" class="btn btn-pite-gold w-50 btn-lg">
                                    <i class="bi bi-rocket-takeoff me-2"></i> Criar Minha Conta
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="text-center mt-4 pt-3" style="border-top: 1px solid #f1f5f9;">
                        <span class="small text-muted">Já tem uma conta?</span>
                        <a href="{{ route('turista.login') }}" class="small fw-semibold" style="color:var(--pite-emerald);">Entrar agora</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function goToStep(step) {
        document.querySelectorAll('[id^="step"]').forEach(el => {
            if (el.id.match(/^step\d$/)) el.style.display = 'none';
        });
        document.getElementById('step' + step).style.display = 'block';

        for (let i = 1; i <= 3; i++) {
            const dot = document.getElementById('stepDot' + i);
            dot.classList.toggle('active', i <= step);
            dot.classList.toggle('inactive', i > step);
        }
    }

    function toggleFilhosInput(show) {
        const box = document.getElementById('boxQtdFilhos');
        if (box) {
            if (show) {
                box.classList.remove('d-none');
            } else {
                box.classList.add('d-none');
            }
        }
    }

    // Toggle visual para chips de interesse
    document.querySelectorAll('.interesse-chip').forEach(chip => {
        chip.addEventListener('click', function() {
            const cb = this.querySelector('input[type="checkbox"]');
            setTimeout(() => {
                this.classList.toggle('selected', cb.checked);
            }, 10);
        });
    });

    // Máscara e Autopreenchimento de CEP no Registro do Turista
    document.addEventListener('DOMContentLoaded', function() {
        const cepInput = document.getElementById('registroCep');
        const btnBuscar = document.getElementById('btnBuscarCepTurista');
        const cidadeInput = document.getElementById('registroCidade');
        const estadoInput = document.getElementById('registroEstado');
        const statusText = document.getElementById('cepTuristaStatus');
        const nacionalidadeSelect = document.getElementById('nacionalidadeSelect');
        const paisSelect = document.getElementById('registroPais');

        if (cepInput) {
            cepInput.addEventListener('input', function() {
                let v = this.value.replace(/\D/g, '');
                if (v.length > 5) v = v.substring(0, 5) + '-' + v.substring(5, 8);
                this.value = v;
            });

            cepInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    buscarCepTurista();
                }
            });

            cepInput.addEventListener('blur', function() {
                if (this.value.replace(/\D/g, '').length === 8) {
                    buscarCepTurista();
                }
            });
        }

        if (btnBuscar) {
            btnBuscar.addEventListener('click', buscarCepTurista);
        }

        function buscarCepTurista() {
            if (!cepInput) return;
            const cep = cepInput.value.replace(/\D/g, '');
            if (cep.length !== 8) {
                if (statusText) {
                    statusText.textContent = '⚠️ CEP deve ter 8 dígitos.';
                    statusText.className = 'text-danger';
                }
                return;
            }

            if (statusText) {
                statusText.textContent = '🔍 Buscando cidade e estado...';
                statusText.className = 'text-info';
            }

            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(r => r.json())
                .then(data => {
                    if (data.erro) {
                        if (statusText) {
                            statusText.textContent = '❌ CEP não encontrado.';
                            statusText.className = 'text-danger';
                        }
                        return;
                    }

                    if (cidadeInput) cidadeInput.value = data.localidade || '';
                    if (estadoInput) estadoInput.value = data.uf || '';
                    if (paisSelect) paisSelect.value = 'Brasil';

                    if (statusText) {
                        statusText.textContent = '✅ Cidade e estado preenchidos automaticamente!';
                        statusText.className = 'text-success';
                    }
                })
                .catch(() => {
                    if (statusText) {
                        statusText.textContent = '❌ Erro ao consultar CEP.';
                        statusText.className = 'text-danger';
                    }
                });
        }
    });
</script>
@endpush

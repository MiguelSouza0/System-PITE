@extends('layouts.app')
@section('title', 'Meu Perfil — System-PITE')

@push('styles')
<style>
    .perfil-header {
        background: linear-gradient(135deg, #022c22 0%, #064e3b 50%, #047857 100%);
        padding: 40px 0;
        position: relative;
    }
    .interesse-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 12px;
    }
    .interesse-option {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        cursor: pointer;
        transition: var(--pite-transition);
        background: #fff;
        user-select: none;
    }
    .interesse-option:hover {
        border-color: var(--pite-emerald);
        background: rgba(4,120,87,0.02);
    }
    .interesse-option.selected {
        border-color: var(--pite-emerald);
        background: rgba(4,120,87,0.06);
    }
    .interesse-option input[type="checkbox"] { display: none; }
    .interesse-option .emoji { font-size: 1.4rem; }
    .interesse-option .nome { font-weight: 600; font-size: 0.88rem; }
</style>
@endpush

@section('content')
<div class="perfil-header">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb" style="--bs-breadcrumb-divider-color: rgba(255,255,255,0.4);">
                <li class="breadcrumb-item"><a href="{{ route('turista.dashboard') }}" style="color: rgba(255,255,255,0.7);"><i class="bi bi-house"></i> Meu Painel</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Editar Perfil</li>
            </ol>
        </nav>
        <h2 class="section-title text-white" style="font-size: 1.8rem;"><i class="bi bi-person-gear me-2"></i> Meu Perfil</h2>
        <p style="color: rgba(255,255,255,0.7);">Atualize suas informações e interesses para recomendações personalizadas</p>
    </div>
</div>

<div class="container py-4">
    @if(session('sucesso'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4">
        <i class="bi bi-check-circle me-1"></i> {{ session('sucesso') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form method="POST" action="{{ route('turista.perfil.update') }}">
        @csrf
        @method('PUT')

        <div class="row g-4">
            {{-- Dados Pessoais & Família --}}
            <div class="col-lg-6">
                <div class="card-premium p-4 h-100">
                    <h5 style="font-family: 'Outfit'; font-weight: 700; margin-bottom: 20px;">
                        <i class="bi bi-person" style="color: var(--pite-emerald);"></i> Dados Pessoais
                    </h5>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nome Completo</label>
                        <input type="text" name="name" class="form-control form-control-pite" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">E-mail</label>
                        <input type="email" class="form-control form-control-pite" value="{{ $user->email }}" disabled>
                        <div class="form-text small">O e-mail não pode ser alterado.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nacionalidade</label>
                        <input type="text" name="nacionalidade" list="listaPaisesPerfil" class="form-control form-control-pite" value="{{ old('nacionalidade', $user->nacionalidade ?? 'Brasileira') }}" placeholder="Digite para buscar seu país..." autocomplete="off">
                        <datalist id="listaPaisesPerfil">
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

                    {{-- Perfil Familiar --}}
                    <div class="p-3 rounded-4 mt-4" style="background: rgba(4,120,87,0.03); border: 1px solid rgba(4,120,87,0.1);">
                        <label class="form-label small fw-bold mb-2 text-dark">
                            <i class="bi bi-people me-1" style="color:var(--pite-emerald);"></i> Perfil Familiar (Opcional)
                        </label>
                        
                        <div class="row g-2 align-items-center mb-2">
                            <div class="col-sm-6">
                                <div class="form-check form-switch p-2 bg-white rounded-3 border">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="possui_conjuge" value="1" id="perfilSwitchConjuge" {{ old('possui_conjuge', $user->possui_conjuge) ? 'checked' : '' }} style="border-color:var(--pite-emerald);">
                                    <label class="form-check-label small fw-semibold" for="perfilSwitchConjuge">
                                        💍 Possui cônjuge
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check form-switch p-2 bg-white rounded-3 border">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="possui_filhos" value="1" id="perfilSwitchFilhos" onchange="togglePerfilFilhos(this.checked)" {{ old('possui_filhos', $user->possui_filhos) ? 'checked' : '' }} style="border-color:var(--pite-emerald);">
                                    <label class="form-check-label small fw-semibold" for="perfilSwitchFilhos">
                                        👶 Possui filhos
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="boxPerfilQtdFilhos" class="mt-2 p-2 bg-white rounded-3 border {{ old('possui_filhos', $user->possui_filhos) ? 'd-flex' : 'd-none' }} align-items-center justify-content-between">
                            <span class="small fw-semibold text-muted"><i class="bi bi-person-arms-up text-success me-1"></i> Quantidade de filhos:</span>
                            <input type="number" name="quantidade_filhos" class="form-control form-control-sm text-center" style="max-width: 90px; border-radius: 8px;" value="{{ old('quantidade_filhos', $user->quantidade_filhos ?? 1) }}" min="1" max="20">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Origem e Endereço --}}
            <div class="col-lg-6">
                <div class="card-premium p-4 h-100">
                    <h5 style="font-family: 'Outfit'; font-weight: 700; margin-bottom: 20px;">
                        <i class="bi bi-geo-alt" style="color: var(--pite-sky);"></i> Origem & Endereço
                    </h5>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">CEP</label>
                        <div class="input-group">
                            <input type="text" name="cep" id="perfilCep" class="form-control form-control-pite" value="{{ old('cep', $user->cep) }}" placeholder="00000-000" maxlength="9">
                            <button type="button" class="btn btn-outline-secondary" id="btnBuscarCepPerfil" title="Buscar Cidade e Estado" style="border-color:#e2e8f0; border-radius: 0 12px 12px 0;">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <small id="cepPerfilStatus" class="text-muted" style="font-size: 0.75rem;"></small>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Cidade de Residência</label>
                            <input type="text" name="cidade_origem" id="perfilCidade" class="form-control form-control-pite" value="{{ old('cidade_origem', $user->cidade_origem) }}" placeholder="Sua cidade">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Estado</label>
                            <input type="text" name="estado_origem" id="perfilEstado" class="form-control form-control-pite" value="{{ old('estado_origem', $user->estado_origem) }}" placeholder="Seu estado (ex: PB, SP, RJ)">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">País</label>
                            <select name="pais_origem" id="perfilPais" class="form-select form-select-pite">
                                @foreach(['Brasil','Argentina','Uruguai','Paraguai','Chile','Colômbia','EUA','Portugal','Espanha','França','Alemanha','Itália','Outro'] as $pais)
                                    <option value="{{ $pais }}" {{ old('pais_origem', $user->pais_origem) == $pais ? 'selected' : '' }}>{{ $pais }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Interesses --}}
            <div class="col-12">
                <div class="card-premium p-4">
                    <h5 style="font-family: 'Outfit'; font-weight: 700; margin-bottom: 8px;">
                        <i class="bi bi-heart" style="color: var(--pite-coral);"></i> Meus Interesses Turísticos
                    </h5>
                    <p class="small text-muted mb-4">Selecione os tipos de experiência que mais te interessam</p>

                    @php
                        $interessesAtuais = $user->interesses ?? [];
                        $opcoes = [
                            'natureza' => ['emoji' => '🌿', 'nome' => 'Natureza & Ecoturismo'],
                            'historia' => ['emoji' => '🏛️', 'nome' => 'História & Patrimônio'],
                            'gastronomia' => ['emoji' => '🍽️', 'nome' => 'Gastronomia'],
                            'aventura' => ['emoji' => '🧗', 'nome' => 'Aventura & Esporte'],
                            'cultural' => ['emoji' => '🎭', 'nome' => 'Cultural & Artístico'],
                            'religioso' => ['emoji' => '⛪', 'nome' => 'Religioso'],
                            'rural' => ['emoji' => '🌾', 'nome' => 'Rural & Agroturismo'],
                            'negocios' => ['emoji' => '💼', 'nome' => 'Negócios & Eventos'],
                            'saude' => ['emoji' => '💆', 'nome' => 'Saúde & Bem-estar'],
                            'nautico' => ['emoji' => '⛵', 'nome' => 'Náutico'],
                            'compras' => ['emoji' => '🛍️', 'nome' => 'Compras & Artesanato'],
                            'familia' => ['emoji' => '👨‍👩‍👧‍👦', 'nome' => 'Família & Lazer'],
                        ];
                    @endphp

                    <div class="interesse-grid">
                        @foreach($opcoes as $key => $opcao)
                        <label class="interesse-option {{ in_array($key, $interessesAtuais) ? 'selected' : '' }}">
                            <input type="checkbox" name="interesses[]" value="{{ $key }}" {{ in_array($key, $interessesAtuais) ? 'checked' : '' }}>
                            <span class="emoji">{{ $opcao['emoji'] }}</span>
                            <span class="nome">{{ $opcao['nome'] }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Acessibilidade --}}
            <div class="col-12">
                <div class="card-premium p-4">
                    <h5 style="font-family: 'Outfit'; font-weight: 700; margin-bottom: 8px;">
                        <i class="bi bi-universal-access" style="color: var(--pite-emerald);"></i> Necessidades de Acessibilidade
                    </h5>
                    <p class="small text-muted mb-4">Informe suas necessidades para filtrar automaticamente locais acessíveis</p>

                    @php
                        $necessidades = $user->necessidades_especiais ?? [];
                        $acessOpcoes = [
                            'cadeirante' => ['emoji' => '♿', 'nome' => 'Cadeirante'],
                            'visual' => ['emoji' => '👁️', 'nome' => 'Deficiência Visual'],
                            'auditiva' => ['emoji' => '👂', 'nome' => 'Deficiência Auditiva'],
                            'mobilidade' => ['emoji' => '🦯', 'nome' => 'Mobilidade Reduzida'],
                            'idoso' => ['emoji' => '👴', 'nome' => 'Idoso'],
                            'crianca' => ['emoji' => '👶', 'nome' => 'Com Criança'],
                        ];
                    @endphp

                    <div class="d-flex flex-wrap gap-3">
                        @foreach($acessOpcoes as $key => $opcao)
                        <label class="interesse-option {{ in_array($key, $necessidades) ? 'selected' : '' }}">
                            <input type="checkbox" name="necessidades_especiais[]" value="{{ $key }}" {{ in_array($key, $necessidades) ? 'checked' : '' }}>
                            <span class="emoji">{{ $opcao['emoji'] }}</span>
                            <span class="nome">{{ $opcao['nome'] }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Salvar --}}
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('turista.dashboard') }}" class="btn" style="color: var(--pite-text-muted);">
                        <i class="bi bi-arrow-left me-1"></i> Voltar ao Painel
                    </a>
                    <button type="submit" class="btn btn-pite btn-lg px-5">
                        <i class="bi bi-check-lg me-2"></i> Salvar Alterações
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function togglePerfilFilhos(show) {
        const box = document.getElementById('boxPerfilQtdFilhos');
        if (box) {
            if (show) {
                box.classList.remove('d-none');
            } else {
                box.classList.add('d-none');
            }
        }
    }

    document.querySelectorAll('.interesse-option').forEach(option => {
        option.addEventListener('click', function() {
            const cb = this.querySelector('input[type="checkbox"]');
            setTimeout(() => {
                this.classList.toggle('selected', cb.checked);
            }, 10);
        });
    });

    // Máscara e Autopreenchimento de CEP no Perfil
    document.addEventListener('DOMContentLoaded', function() {
        const cepInput = document.getElementById('perfilCep');
        const btnBuscar = document.getElementById('btnBuscarCepPerfil');
        const cidadeInput = document.getElementById('perfilCidade');
        const estadoInput = document.getElementById('perfilEstado');
        const statusText = document.getElementById('cepPerfilStatus');
        const paisSelect = document.getElementById('perfilPais');

        if (cepInput) {
            cepInput.addEventListener('input', function() {
                let v = this.value.replace(/\D/g, '');
                if (v.length > 5) v = v.substring(0, 5) + '-' + v.substring(5, 8);
                this.value = v;
            });

            cepInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    buscarCepPerfil();
                }
            });

            cepInput.addEventListener('blur', function() {
                if (this.value.replace(/\D/g, '').length === 8) {
                    buscarCepPerfil();
                }
            });
        }

        if (btnBuscar) {
            btnBuscar.addEventListener('click', buscarCepPerfil);
        }

        function buscarCepPerfil() {
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
                statusText.textContent = '🔍 Buscando...';
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
                        statusText.textContent = '✅ Cidade e estado atualizados!';
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

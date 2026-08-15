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
                        <label class="form-label small fw-semibold">Nacionalidade de Nascimento</label>
                        <input type="text" name="nacionalidade" class="form-control form-control-pite" value="{{ old('nacionalidade', $user->nacionalidade ?? 'Brasileira') }}" placeholder="Ex: Brasileira, Argentina...">
                    </div>

                    {{-- Perfil Familiar --}}
                    <div class="p-3 rounded-4 mt-4" style="background: rgba(4,120,87,0.03); border: 1px solid rgba(4,120,87,0.1);">
                        <label class="form-label small fw-bold mb-2 text-dark">
                            <i class="bi bi-people me-1" style="color:var(--pite-emerald);"></i> Perfil Familiar (Opcional)
                        </label>
                        
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="possui_conjuge" value="1" id="perfilSwitchConjuge" {{ old('possui_conjuge', $user->possui_conjuge) ? 'checked' : '' }} style="border-color:var(--pite-emerald);">
                            <label class="form-check-label small fw-semibold" for="perfilSwitchConjuge">
                                💍 Possui cônjuge / companheiro(a)
                            </label>
                        </div>

                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="possui_filhos" value="1" id="perfilSwitchFilhos" onchange="togglePerfilFilhos(this.checked)" {{ old('possui_filhos', $user->possui_filhos) ? 'checked' : '' }} style="border-color:var(--pite-emerald);">
                            <label class="form-check-label small fw-semibold" for="perfilSwitchFilhos">
                                👶 Possui filhos
                            </label>
                        </div>

                        <div id="boxPerfilQtdFilhos" class="mt-2" style="display: {{ old('possui_filhos', $user->possui_filhos) ? 'block' : 'none' }};">
                            <label class="form-label small fw-semibold text-muted">Quantos filhos?</label>
                            <div class="input-group" style="max-width: 180px;">
                                <span class="input-group-text bg-white border-end-0" style="border-color:#e2e8f0; border-radius: 12px 0 0 12px;">
                                    <i class="bi bi-person-arms-up" style="color:var(--pite-emerald);"></i>
                                </span>
                                <input type="number" name="quantidade_filhos" class="form-control form-control-pite border-start-0" style="border-radius: 0 12px 12px 0;" value="{{ old('quantidade_filhos', $user->quantidade_filhos ?? 1) }}" min="1" max="20">
                            </div>
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
                        <input type="text" name="cep" class="form-control form-control-pite" value="{{ old('cep', $user->cep) }}" placeholder="00000-000">
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Cidade</label>
                            <input type="text" name="cidade_origem" class="form-control form-control-pite" value="{{ old('cidade_origem', $user->cidade_origem) }}" placeholder="Sua cidade">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Estado</label>
                            <input type="text" name="estado_origem" class="form-control form-control-pite" value="{{ old('estado_origem', $user->estado_origem) }}" placeholder="Seu estado">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">País</label>
                            <select name="pais_origem" class="form-select form-select-pite">
                                @foreach(['Brasil','Argentina','Uruguai','Paraguai','Chile','Colômbia','EUA','Portugal','Espanha','Outro'] as $pais)
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
            box.style.display = show ? 'block' : 'none';
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
</script>
@endpush

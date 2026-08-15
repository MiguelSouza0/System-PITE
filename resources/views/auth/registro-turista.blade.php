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
            </div>

            {{-- Lado Direito: Formulário --}}
            <div class="col-lg-7 animate-in animate-delay-2">
                <div class="registro-card">
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
                                    <label class="form-label small fw-semibold">Nacionalidade de Nascimento</label>
                                    <input type="text" name="nacionalidade" class="form-control form-control-pite" value="{{ old('nacionalidade', 'Brasileira') }}" placeholder="Ex: Brasileira, Argentina...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">CEP</label>
                                    <input type="text" name="cep" id="registroCep" class="form-control form-control-pite" value="{{ old('cep') }}" placeholder="00000-000">
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Cidade de Residência</label>
                                    <input type="text" name="cidade_origem" class="form-control form-control-pite" value="{{ old('cidade_origem') }}" placeholder="Sua cidade">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Estado</label>
                                    <input type="text" name="estado_origem" class="form-control form-control-pite" value="{{ old('estado_origem') }}" placeholder="Seu estado (ex: SP, MG)">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-semibold">País</label>
                                <select name="pais_origem" class="form-select form-select-pite">
                                    <option value="Brasil" selected>🇧🇷 Brasil</option>
                                    <option value="Argentina">🇦🇷 Argentina</option>
                                    <option value="Uruguai">🇺🇾 Uruguai</option>
                                    <option value="Paraguai">🇵🇾 Paraguai</option>
                                    <option value="Chile">🇨🇱 Chile</option>
                                    <option value="Colômbia">🇨🇴 Colômbia</option>
                                    <option value="EUA">🇺🇸 Estados Unidos</option>
                                    <option value="Portugal">🇵🇹 Portugal</option>
                                    <option value="Espanha">🇪🇸 Espanha</option>
                                    <option value="Outro">🌍 Outro</option>
                                </select>
                            </div>

                            {{-- Perfil Familiar (Opcional) --}}
                            <div class="mb-4 p-3 rounded-4" style="background: rgba(4,120,87,0.03); border: 1px solid rgba(4,120,87,0.1);">
                                <label class="form-label small fw-bold mb-2 text-dark">
                                    <i class="bi bi-people me-1" style="color:var(--pite-emerald);"></i> Perfil Familiar (Opcional)
                                </label>
                                <p class="small text-muted mb-3" style="font-size: 0.82rem;">Nos ajuda a sugerir roteiros para casais, famílias ou passeios individuais.</p>

                                <div class="row g-3 align-items-center">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="possui_conjuge" value="1" id="switchConjuge" {{ old('possui_conjuge') ? 'checked' : '' }} style="border-color:var(--pite-emerald);">
                                            <label class="form-check-label small fw-semibold" for="switchConjuge">
                                                💍 Possui cônjuge / companheiro(a)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="possui_filhos" value="1" id="switchFilhos" onchange="toggleFilhosInput(this.checked)" {{ old('possui_filhos') ? 'checked' : '' }} style="border-color:var(--pite-emerald);">
                                            <label class="form-check-label small fw-semibold" for="switchFilhos">
                                                👶 Possui filhos
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div id="boxQtdFilhos" class="mt-3" style="display: {{ old('possui_filhos') ? 'block' : 'none' }};">
                                    <label class="form-label small fw-semibold text-muted">Quantos filhos?</label>
                                    <div class="input-group" style="max-width: 200px;">
                                        <span class="input-group-text bg-white border-end-0" style="border-color:#e2e8f0; border-radius: 12px 0 0 12px;">
                                            <i class="bi bi-person-arms-up" style="color:var(--pite-emerald);"></i>
                                        </span>
                                        <input type="number" name="quantidade_filhos" class="form-control form-control-pite border-start-0" style="border-radius: 0 12px 12px 0;" value="{{ old('quantidade_filhos', 1) }}" min="1" max="20" placeholder="Ex: 2">
                                    </div>
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
            box.style.display = show ? 'block' : 'none';
        }
    }

    // Toggle visual para chips de interesse
    document.querySelectorAll('.interesse-chip').forEach(chip => {
        chip.addEventListener('click', function() {
            const cb = this.querySelector('input[type="checkbox"]');
            // O checkbox já muda automaticamente com o label
            setTimeout(() => {
                this.classList.toggle('selected', cb.checked);
            }, 10);
        });
    });
</script>
@endpush

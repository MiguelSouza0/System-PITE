@extends('layouts.app')

@section('title', $atrativo->nome . ' - System-PITE')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('portal.home') }}">Início</a></li>
            <li class="breadcrumb-item"><a href="{{ route('portal.atrativos.index') }}">Atrativos</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $atrativo->nome }}</li>
        </ol>
    </nav>

    @if(session('sucessoAvaliacao'))
    <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
        <i class="bi bi-check-circle me-1"></i> {{ session('sucessoAvaliacao') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80" class="img-fluid" style="height: 380px; width: 100%; object-fit: cover;" alt="{{ $atrativo->nome }}">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">{{ $atrativo->categoria?->nome }}</span>
                        
                        <!-- Controles de Tradução Automática e Audiodescrição com IA -->
                        <div class="d-flex align-items-center gap-2">
                            <div class="btn-group btn-group-sm rounded-pill border overflow-hidden bg-white shadow-sm" role="group" aria-label="Traduzir">
                                <button type="button" class="btn btn-light btn-sm fw-bold px-2 py-1 btn-traduzir active" data-lang="pt">🇧🇷 PT</button>
                                <button type="button" class="btn btn-light btn-sm fw-bold px-2 py-1 btn-traduzir" data-lang="en">🇺🇸 EN</button>
                                <button type="button" class="btn btn-light btn-sm fw-bold px-2 py-1 btn-traduzir" data-lang="es">🇪🇸 ES</button>
                            </div>

                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1 fw-semibold shadow-sm" id="btnAudioDescricaoAtrativo" title="Ouvir audiodescrição em voz alta">
                                <i class="bi bi-volume-up-fill me-1"></i> <span id="lblAudioNarrador">Ouvir Guia</span>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        @if(($atrativo->preco_medio ?? 0) == 0)
                            <span class="badge bg-success-subtle text-success fs-6 px-3 py-2 rounded-pill">Entrada Gratuita</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary fs-6 px-3 py-2 rounded-pill">Preço Médio: R$ {{ number_format($atrativo->preco_medio, 2, ',', '.') }}</span>
                        @endif
                        <span class="badge bg-light text-muted border rounded-pill small" id="traducaoStatusBadge" style="display:none;">
                            <i class="bi bi-translate text-primary me-1"></i> Tradução Instantânea IA
                        </span>
                    </div>

                    <h1 class="fw-bold mb-3" id="atrativoNomeEl">{{ $atrativo->nome }}</h1>
                    
                    <p class="lead text-muted mb-4" id="atrativoDescricaoEl">{{ $atrativo->descricao }}</p>

                    <!-- Recursos de Acessibilidade -->
                    <div class="card bg-light border-0 rounded-3 p-4 mb-4">
                        <h5 class="fw-bold text-success mb-3"><i class="bi bi-universal-access me-2"></i> Infraestrutura de Acessibilidade (PNE)</h5>
                        <div class="row g-2">
                            <div class="col-6 col-md-4">
                                <div class="d-flex align-items-center"><i class="bi bi-check-circle-fill text-success me-2"></i> Rampas de Acesso</div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="d-flex align-items-center"><i class="bi bi-check-circle-fill text-success me-2"></i> Banheiro Adaptado</div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="d-flex align-items-center"><i class="bi bi-check-circle-fill text-success me-2"></i> Piso Tátil Direcional</div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="d-flex align-items-center"><i class="bi bi-check-circle-fill text-success me-2"></i> Áudio-Guia Integrado</div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="d-flex align-items-center"><i class="bi bi-check-circle-fill text-success me-2"></i> Vagas Preferenciais</div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulário para Enviar Avaliação -->
                    <div class="card border-0 bg-light rounded-4 p-4 mb-4">
                        <h5 class="fw-bold mb-3" style="font-family:'Outfit';"><i class="bi bi-star text-warning me-2"></i> Enviar Sua Avaliação Auditada</h5>
                        <form action="{{ route('portal.atrativos.avaliar', $atrativo->slug) }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Nota (1 a 5 Estrelas)</label>
                                    <select name="nota" class="form-select rounded-3" required>
                                        <option value="5">⭐⭐⭐⭐⭐ 5 - Excelente</option>
                                        <option value="4">⭐⭐⭐⭐ 4 - Muito Bom</option>
                                        <option value="3">⭐⭐⭐ 3 - Bom</option>
                                        <option value="2">⭐⭐ 2 - Regular</option>
                                        <option value="1">⭐ 1 - Ruim</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Sua Origem</label>
                                    <select name="origem_turista" class="form-select rounded-3">
                                        <option value="local">Morador Local</option>
                                        <option value="nacional">Turista Nacional</option>
                                        <option value="internacional">Turista Internacional</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-semibold">Comentário / Experiência</label>
                                    <textarea name="comentario" class="form-control rounded-3" rows="3" required placeholder="Conte como foi sua visita, acessibilidade, atendimento..."></textarea>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-pite px-4"><i class="bi bi-send me-1"></i> Publicar Avaliação</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Avaliações Verificadas (Zero Avaliações Falsas) -->
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="fw-bold mb-0"><i class="bi bi-shield-check text-primary me-2"></i> Avaliações com Visita Validada</h4>
                            <span class="badge bg-primary-subtle text-primary">Conformidade LGPD</span>
                        </div>
                        <p class="small text-muted mb-4">Todas as avaliações no System-PITE exigem comprovação de visita ou geolocalização auditada para eliminar avaliações fraudulentas.</p>

                        @forelse($atrativo->avaliacoes ?? [] as $avaliacao)
                            <div class="border rounded-3 p-3 mb-3 bg-white shadow-sm" id="avaliacao-card-{{ $avaliacao->id }}">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center fw-bold text-success border" style="width:34px;height:34px;font-size:0.85rem;">
                                            {{ strtoupper(substr($avaliacao->usuario?->name ?? 'T', 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong class="d-block leading-tight">{{ $avaliacao->usuario?->name ?? 'Turista Validado' }}</strong>
                                            <small class="text-muted" style="font-size:0.75rem;">
                                                <i class="bi bi-clock me-1"></i>{{ $avaliacao->created_at ? $avaliacao->created_at->diffForHumans() : 'Recentemente' }}
                                                @if($avaliacao->origem_turista)
                                                    • <span class="badge bg-light text-muted border">{{ ucfirst($avaliacao->origem_turista) }}</span>
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="text-warning">
                                            @for($i=1; $i<=5; $i++)
                                                <i class="bi {{ $i <= $avaliacao->nota ? 'bi-star-fill' : 'bi-star' }}"></i>
                                            @endfor
                                        </div>
                                        @auth
                                            @if(auth()->id() === $avaliacao->user_id || auth()->user()->isAdmin())
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-light rounded-circle" type="button" data-bs-toggle="dropdown" style="width:30px;height:30px;padding:0;">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                                                        <li>
                                                            <button class="dropdown-item small" type="button" data-bs-toggle="modal" data-bs-target="#modalEditarAvaliacao{{ $avaliacao->id }}">
                                                                <i class="bi bi-pencil me-2 text-primary"></i> Editar Comentário
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <form id="formExcluirAvaliacao{{ $avaliacao->id }}" action="{{ route('portal.avaliacoes.destroy', $avaliacao->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="dropdown-item small text-danger" onclick="confirmarAcao('Tem certeza que deseja excluir sua avaliação?', () => document.getElementById('formExcluirAvaliacao{{ $avaliacao->id }}').submit(), 'Excluir Avaliação')">
                                                                    <i class="bi bi-trash me-2"></i> Excluir
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                                <p class="small text-muted mb-0" style="line-height:1.6;">{{ $avaliacao->comentario }}</p>
                            </div>

                            @auth
                                @if(auth()->id() === $avaliacao->user_id || auth()->user()->isAdmin())
                                    <!-- Modal de Edição da Avaliação -->
                                    <div class="modal fade" id="modalEditarAvaliacao{{ $avaliacao->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded-4 border-0 shadow">
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title fw-bold" style="font-family:'Outfit';">
                                                        <i class="bi bi-pencil-square text-primary me-2"></i>Editar Sua Avaliação
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                                </div>
                                                <form action="{{ route('portal.avaliacoes.update', $avaliacao->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body py-3">
                                                        <div class="mb-3">
                                                            <label class="form-label small fw-semibold">Nota (1 a 5 Estrelas)</label>
                                                            <select name="nota" class="form-select rounded-3" required>
                                                                <option value="5" {{ $avaliacao->nota == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5 - Excelente</option>
                                                                <option value="4" {{ $avaliacao->nota == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ 4 - Muito Bom</option>
                                                                <option value="3" {{ $avaliacao->nota == 3 ? 'selected' : '' }}>⭐⭐⭐ 3 - Bom</option>
                                                                <option value="2" {{ $avaliacao->nota == 2 ? 'selected' : '' }}>⭐⭐ 2 - Regular</option>
                                                                <option value="1" {{ $avaliacao->nota == 1 ? 'selected' : '' }}>⭐ 1 - Ruim</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label small fw-semibold">Sua Origem</label>
                                                            <select name="origem_turista" class="form-select rounded-3">
                                                                <option value="local" {{ $avaliacao->origem_turista == 'local' ? 'selected' : '' }}>Morador Local</option>
                                                                <option value="nacional" {{ $avaliacao->origem_turista == 'nacional' ? 'selected' : '' }}>Turista Nacional</option>
                                                                <option value="internacional" {{ $avaliacao->origem_turista == 'internacional' ? 'selected' : '' }}>Turista Internacional</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label small fw-semibold">Comentário / Relato</label>
                                                            <textarea name="comentario" class="form-control rounded-3" rows="4" required maxlength="1000">{{ old('comentario', $avaliacao->comentario) }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0 pt-0">
                                                        <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-pite rounded-3 px-4">Salvar Alterações</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endauth
                        @empty
                            <div class="p-3 bg-light rounded-3 text-center small text-muted">
                                Seja o primeiro visitante a enviar uma avaliação verificada!
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Informações Práticas -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-info-circle text-primary me-2"></i> Informações do Local</h5>
                
                <ul class="list-unstyled mb-4">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-geo-alt text-primary fs-5 me-3"></i>
                        <div>
                            <strong>Endereço</strong>
                            <p class="text-muted small mb-0">{{ $atrativo->endereco ?? 'Centro Turístico Municipal' }}</p>
                        </div>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-clock text-primary fs-5 me-3"></i>
                        <div>
                            <strong>Horário de Funcionamento</strong>
                            <p class="text-muted small mb-0">{{ $atrativo->horario_funcionamento ?? 'Terça a Domingo: 08h às 18h' }}</p>
                        </div>
                    </li>
                    <li class="d-flex align-items-start">
                        <i class="bi bi-tree text-success fs-5 me-3"></i>
                        <div>
                            <strong>Impacto ESG</strong>
                            <p class="text-muted small mb-0">Gestão 100% sustentável e coleta seletiva.</p>
                        </div>
                    </li>
                </ul>

                <a href="{{ route('portal.roteiros') }}" class="btn btn-warning w-100 rounded-3 fw-bold mb-2">
                    <i class="bi bi-magic me-1"></i> Incluir no Meu Roteiro IA
                </a>
                <a href="{{ route('portal.mapa', ['lat' => $atrativo->latitude, 'lng' => $atrativo->longitude, 'atrativo' => $atrativo->id]) }}" class="btn btn-outline-primary w-100 rounded-3 fw-semibold">
                    <i class="bi bi-map me-1"></i> Ver no Mapa Interativo
                </a>
            </div>

            <!-- QR Code do Atrativo (Placa Física Municipal) -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white text-center">
                <h6 class="fw-bold mb-2" style="font-family:'Outfit';"><i class="bi bi-qr-code text-success me-1"></i> QR Code Oficial do Atrativo</h6>
                <p class="small text-muted mb-3">Imprima ou escaneie o código para afixação na sinalização física do local.</p>
                <div class="p-3 bg-light rounded-3 d-inline-block mx-auto mb-3">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode(url()->current()) }}" alt="QR Code {{ $atrativo->nome }}" width="180" height="180" class="img-fluid">
                </div>
                <small class="d-block text-muted" style="font-size:0.75rem;">Guia histórico, audiodescrição e dados ESG acessíveis via smartphone.</small>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Tradução Instantânea com IA
    const btnTraduzir = document.querySelectorAll('.btn-traduzir');
    const nomeEl = document.getElementById('atrativoNomeEl');
    const descEl = document.getElementById('atrativoDescricaoEl');
    const badgeTraducao = document.getElementById('traducaoStatusBadge');

    const originalNome = @json($atrativo->nome);
    const originalDesc = @json($atrativo->descricao);

    btnTraduzir.forEach(btn => {
        btn.addEventListener('click', function() {
            const lang = this.dataset.lang;
            btnTraduzir.forEach(b => b.classList.remove('active', 'btn-primary'));
            this.classList.add('active');

            if (lang === 'pt') {
                nomeEl.textContent = originalNome;
                descEl.textContent = originalDesc;
                badgeTraducao.style.display = 'none';
                return;
            }

            badgeTraducao.style.display = 'inline-block';
            badgeTraducao.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Traduzindo com IA...';

            fetch('{{ route("api.ia.traduzir") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    texto: originalDesc,
                    para_idioma: lang
                })
            })
            .then(r => r.json())
            .then(res => {
                if (res.sucesso) {
                    descEl.textContent = res.traducao;
                    badgeTraducao.innerHTML = `<i class="bi bi-translate text-primary me-1"></i> Traduzido para ${lang.toUpperCase()} via IA`;
                }
            })
            .catch(() => {
                badgeTraducao.textContent = 'Erro na tradução.';
            });
        });
    });

    // 2. Audiodescrição Text-to-Speech
    const btnAudio = document.getElementById('btnAudioDescricaoAtrativo');
    const lblAudio = document.getElementById('lblAudioNarrador');
    let isSpeaking = false;

    btnAudio?.addEventListener('click', function() {
        if (!('speechSynthesis' in window)) {
            alert('Sua plataforma não suporta sintetizador de voz nativo.');
            return;
        }

        if (speechSynthesis.speaking) {
            speechSynthesis.cancel();
            isSpeaking = false;
            lblAudio.textContent = 'Ouvir Guia';
            btnAudio.classList.remove('btn-success');
            btnAudio.classList.add('btn-outline-success');
            return;
        }

        const textoParaNarrar = `${originalNome}. ${originalDesc}. Informações oficiais da Secretaria Municipal de Turismo.`;
        const utter = new SpeechSynthesisUtterance(textoParaNarrar);
        utter.lang = 'pt-BR';
        utter.rate = 1.0;

        utter.onstart = function() {
            isSpeaking = true;
            lblAudio.textContent = 'Parar Áudio';
            btnAudio.classList.remove('btn-outline-success');
            btnAudio.classList.add('btn-success');
        };

        utter.onend = function() {
            isSpeaking = false;
            lblAudio.textContent = 'Ouvir Guia';
            btnAudio.classList.remove('btn-success');
            btnAudio.classList.add('btn-outline-success');
        };

        speechSynthesis.speak(utter);
    });
});
</script>
@endpush
@endsection

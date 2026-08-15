{{-- Partial do formulário de atrativos — usado por create.blade.php e edit.blade.php --}}
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
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label small fw-semibold mb-0">Descrição *</label>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fw-semibold" id="btnGerarDescricaoIa">
                        <i class="bi bi-stars text-warning me-1"></i> Assistente IA: Gerar Descrição Turística
                    </button>
                </div>
                <textarea id="descricaoAtrativo" name="descricao" class="form-control rounded-3" rows="4" required
                          placeholder="Descrição detalhada do atrativo, incluindo contexto histórico...">{{ old('descricao', $atrativo->descricao ?? '') }}</textarea>
                <small class="text-muted" id="iaDescricaoStatus"></small>
            </div>
        </div>

        {{-- Localização com Busca por CEP --}}
        <h6 class="fw-bold mb-3" style="font-family:'Outfit';"><i class="bi bi-geo-alt text-danger me-2"></i>Localização</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label small fw-semibold">CEP</label>
                <div class="input-group">
                    <input type="text" id="cep" name="cep" class="form-control rounded-start-3"
                           value="{{ old('cep', $atrativo->cep ?? '') }}" placeholder="00000-000"
                           maxlength="9">
                    <button type="button" class="btn btn-outline-success rounded-end-3" id="btnBuscarCep" title="Buscar endereço pelo CEP">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                <small class="text-muted" id="cepStatus"></small>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Endereço (Rua)</label>
                <input type="text" id="endereco" name="endereco" class="form-control rounded-3"
                       value="{{ old('endereco', $atrativo->endereco ?? '') }}" placeholder="Preenchido automaticamente pelo CEP">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Número</label>
                <input type="text" id="numero" name="numero" class="form-control rounded-3"
                       value="{{ old('numero', $atrativo->numero ?? '') }}" placeholder="Nº">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Bairro</label>
                <input type="text" id="bairro" name="bairro" class="form-control rounded-3"
                       value="{{ old('bairro', $atrativo->bairro ?? '') }}" placeholder="Preenchido automaticamente">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Cidade</label>
                <input type="text" id="cidade" name="cidade" class="form-control rounded-3"
                       value="{{ old('cidade', $atrativo->cidade ?? '') }}" placeholder="Preenchido automaticamente">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">UF</label>
                <input type="text" id="uf" name="uf" class="form-control rounded-3" maxlength="2"
                       value="{{ old('uf', $atrativo->uf ?? '') }}" placeholder="UF">
            </div>

            {{-- Latitude e Longitude (auto-preenchidos, colapsáveis) --}}
            <div class="col-12">
                <a class="small text-muted text-decoration-none" data-bs-toggle="collapse" href="#coordenadasManuais" role="button">
                    <i class="bi bi-chevron-down me-1"></i> Coordenadas (preenchidas automaticamente)
                </a>
                <div class="collapse {{ (old('latitude', $atrativo->latitude ?? '') && !old('cep', $atrativo->cep ?? '')) ? 'show' : '' }}" id="coordenadasManuais">
                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Latitude</label>
                            <input type="number" step="any" id="latitude" name="latitude" class="form-control rounded-3"
                                   value="{{ old('latitude', $atrativo->latitude ?? '') }}" placeholder="-22.7394">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Longitude</label>
                            <input type="number" step="any" id="longitude" name="longitude" class="form-control rounded-3"
                                   value="{{ old('longitude', $atrativo->longitude ?? '') }}" placeholder="-45.5913">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mini-mapa de preview com ajuste fino interativo --}}
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small fw-semibold text-muted"><i class="bi bi-pin-map text-danger me-1"></i>Ajuste Fino no Mapa:</span>
                    <span class="badge bg-light text-muted border small"><i class="bi bi-arrows-move me-1"></i>Arraste o alfinete ou clique no mapa para posicionar no local exato</span>
                </div>
                <div id="miniMapaPreview" style="height: 260px; border-radius: 12px; display: none; border: 2px solid #cbd5e1; box-shadow: 0 4px 12px rgba(0,0,0,0.05);"></div>
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
                <input type="text" id="telefone" name="contato_telefone" class="form-control rounded-3"
                       value="{{ old('contato_telefone', $atrativo->contato_telefone ?? '') }}" placeholder="(83) 99999-0000" maxlength="15">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cepInput = document.getElementById('cep');
    const btnBuscar = document.getElementById('btnBuscarCep');
    const cepStatus = document.getElementById('cepStatus');
    const enderecoInput = document.getElementById('endereco');
    const bairroInput = document.getElementById('bairro');
    const cidadeInput = document.getElementById('cidade');
    const ufInput = document.getElementById('uf');
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const numeroInput = document.getElementById('numero');
    const miniMapaDiv = document.getElementById('miniMapaPreview');
    let miniMapa = null;
    let miniMarker = null;

    // Máscara simples de CEP (00000-000)
    if (cepInput) {
        cepInput.addEventListener('input', function() {
            let v = this.value.replace(/\D/g, '');
            if (v.length > 5) v = v.substring(0, 5) + '-' + v.substring(5, 8);
            this.value = v;
        });
    }

    // Máscara dinâmica de Telefone: (00) 0000-0000 ou (00) 00000-0000
    const telefoneInput = document.getElementById('telefone');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function() {
            let v = this.value.replace(/\D/g, '');
            if (v.length > 11) v = v.substring(0, 11);

            if (v.length > 10) {
                // (00) 00000-0000
                v = v.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
            } else if (v.length > 6) {
                // (00) 0000-0000
                v = v.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
            } else if (v.length > 2) {
                // (00) 000...
                v = v.replace(/^(\d{2})(\d{0,5})$/, '($1) $2');
            } else if (v.length > 0) {
                // (00...
                v = v.replace(/^(\d*)$/, '($1');
            }
            this.value = v;
        });
    }

    // Buscar CEP
    if (btnBuscar) {
        btnBuscar.addEventListener('click', buscarCep);
    }
    if (cepInput) {
        cepInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') { e.preventDefault(); buscarCep(); }
        });
    }

    function buscarCep() {
        const cep = cepInput.value.replace(/\D/g, '');
        if (cep.length !== 8) {
            cepStatus.textContent = '⚠️ CEP deve ter 8 dígitos.';
            cepStatus.className = 'text-danger small';
            return;
        }

        cepStatus.textContent = '🔍 Buscando...';
        cepStatus.className = 'text-info small';
        btnBuscar.disabled = true;

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(r => r.json())
            .then(data => {
                if (data.erro) {
                    cepStatus.textContent = '❌ CEP não encontrado.';
                    cepStatus.className = 'text-danger small';
                    btnBuscar.disabled = false;
                    return;
                }

                enderecoInput.value = data.logradouro || '';
                bairroInput.value = data.bairro || '';
                cidadeInput.value = data.localidade || '';
                ufInput.value = data.uf || '';

                cepStatus.textContent = '✅ Endereço encontrado! Preencha o número.';
                cepStatus.className = 'text-success small';
                btnBuscar.disabled = false;

                // Focar no campo número
                if (numeroInput) numeroInput.focus();

                // Geocodificar o endereço para obter lat/lng
                geocodificarEndereco();
            })
            .catch(() => {
                cepStatus.textContent = '❌ Erro ao buscar CEP. Tente novamente.';
                cepStatus.className = 'text-danger small';
                btnBuscar.disabled = false;
            });
    }

    // Geocodificar via Nominatim (OpenStreetMap) com estratégia em cascata para máxima precisão
    function geocodificarEndereco() {
        const rua = enderecoInput.value.trim();
        const numero = numeroInput.value.trim();
        const bairro = bairroInput.value.trim();
        const cidade = cidadeInput.value.trim();
        const uf = ufInput.value.trim();
        const cep = cepInput.value.replace(/\D/g, '');

        if (!cidade && !cep) return;

        cepStatus.textContent = '📍 Determinando coordenadas precisas...';
        cepStatus.className = 'text-info small';

        // 1ª tentativa: Rua + Número + Bairro + Cidade + UF
        const query1 = [rua, numero, bairro, cidade, uf, 'Brasil'].filter(Boolean).join(', ');
        // 2ª tentativa: Rua + Cidade + UF
        const query2 = [rua, cidade, uf, 'Brasil'].filter(Boolean).join(', ');
        // 3ª tentativa: CEP + Brasil
        const query3 = cep ? `${cep}, Brasil` : null;

        function buscarNominatim(query, fallbackFn) {
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`, {
                headers: { 'Accept-Language': 'pt-BR' }
            })
            .then(r => r.json())
            .then(results => {
                if (results && results.length > 0) {
                    const lat = parseFloat(results[0].lat);
                    const lng = parseFloat(results[0].lon);
                    latInput.value = lat.toFixed(8);
                    lngInput.value = lng.toFixed(8);
                    atualizarMiniMapa(lat, lng);
                    cepStatus.textContent = '✅ Localização mapeada com sucesso!';
                    cepStatus.className = 'text-success small';
                } else if (fallbackFn) {
                    fallbackFn();
                } else {
                    cepStatus.textContent = '⚠️ Não foi possível georreferenciar exatamente. Ajuste no mapa se necessário.';
                    cepStatus.className = 'text-warning small';
                }
            })
            .catch(() => {
                if (fallbackFn) fallbackFn();
            });
        }

        buscarNominatim(query1, () => {
            buscarNominatim(query2, () => {
                if (query3) {
                    buscarNominatim(query3, null);
                }
            });
        });
    }

    // Recalcular coordenadas quando o número mudar
    if (numeroInput) {
        let debounce;
        numeroInput.addEventListener('input', function() {
            clearTimeout(debounce);
            debounce = setTimeout(geocodificarEndereco, 800);
        });
    }

    // Mini-mapa de preview com suporte a arrastar e clicar para ajuste fino
    function atualizarMiniMapa(lat, lng) {
        miniMapaDiv.style.display = 'block';

        if (!miniMapa) {
            miniMapa = L.map('miniMapaPreview').setView([lat, lng], 17);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(miniMapa);

            // Clique no mapa move o alfinete para a posição exata
            miniMapa.on('click', function(e) {
                const clickLat = e.latlng.lat;
                const clickLng = e.latlng.lng;
                latInput.value = clickLat.toFixed(8);
                lngInput.value = clickLng.toFixed(8);
                if (miniMarker) {
                    miniMarker.setLatLng([clickLat, clickLng]);
                }
                cepStatus.textContent = '🎯 Posição exata ajustada manualmente pelo mapa!';
                cepStatus.className = 'text-primary small';
            });
        } else {
            miniMapa.setView([lat, lng], 17);
        }

        if (miniMarker) {
            miniMarker.setLatLng([lat, lng]);
        } else {
            miniMarker = L.marker([lat, lng], { draggable: true }).addTo(miniMapa);

            // Ao arrastar e soltar o marcador
            miniMarker.on('dragend', function(event) {
                const pos = event.target.getLatLng();
                latInput.value = pos.lat.toFixed(8);
                lngInput.value = pos.lng.toFixed(8);
                cepStatus.textContent = '🎯 Posição exata ajustada manualmente pelo alfinete!';
                cepStatus.className = 'text-primary small';
            });
        }

        // Forçar resize após a exibição
        setTimeout(() => miniMapa.invalidateSize(), 200);
    }

    // Se já tem lat/lng preenchidos, mostrar mini-mapa ao carregar
    const latInicial = parseFloat(latInput.value);
    const lngInicial = parseFloat(lngInput.value);
    if (!isNaN(latInicial) && !isNaN(lngInicial) && latInicial !== 0 && lngInicial !== 0) {
        atualizarMiniMapa(latInicial, lngInicial);
    }

    // ═══ GERADOR DE DESCRIÇÃO TURÍSTICA COM IA (SEÇÃO 6) ═══
    const btnGerarDesc = document.getElementById('btnGerarDescricaoIa');
    const descField = document.getElementById('descricaoAtrativo');
    const nomeInput = document.querySelector('input[name="nome"]');
    const catSelect = document.querySelector('select[name="categoria_id"]');
    const acessCheck = document.getElementById('acessCadeirante');
    const statusIa = document.getElementById('iaDescricaoStatus');

    btnGerarDesc?.addEventListener('click', function() {
        const nome = nomeInput?.value.trim();
        if (!nome) {
            alert('Por favor, informe o Nome do Atrativo primeiro para a IA gerar o texto.');
            nomeInput?.focus();
            return;
        }

        btnGerarDesc.disabled = true;
        btnGerarDesc.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Redigindo com IA...';
        statusIa.textContent = '✨ O motor de IA está redigindo uma descrição turística institucional...';
        statusIa.className = 'text-primary small';

        fetch('{{ route("api.ia.gerar-descricao") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                nome: nome,
                categoria_id: catSelect?.value || null,
                endereco: enderecoInput?.value || null,
                acessivel: acessCheck?.checked || false
            })
        })
        .then(r => r.json())
        .then(res => {
            btnGerarDesc.disabled = false;
            btnGerarDesc.innerHTML = '<i class="bi bi-stars text-warning me-1"></i> Assistente IA: Gerar Descrição Turística';

            if (res.sucesso && res.descricao) {
                descField.value = res.descricao;
                statusIa.textContent = '✅ Descrição sugerida com IA gerada com sucesso! Você pode revisar ou editar o texto.';
                statusIa.className = 'text-success small';
            }
        })
        .catch(() => {
            btnGerarDesc.disabled = false;
            btnGerarDesc.innerHTML = '<i class="bi bi-stars text-warning me-1"></i> Assistente IA: Gerar Descrição Turística';
            statusIa.textContent = 'Erro ao gerar texto com IA. Tente novamente.';
            statusIa.className = 'text-danger small';
        });
    });
});
</script>
@endpush

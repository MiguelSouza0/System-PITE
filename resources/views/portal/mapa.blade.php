@extends('layouts.app')
@section('title', 'Mapa Interativo — System-PITE')

@push('styles')
<style>
    .map-hero {
        background: linear-gradient(135deg, #022c22, #064e3b);
        padding: 48px 0 24px;
        color: #fff;
    }
    .map-wrapper {
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        border: 3px solid rgba(4,120,87,0.2);
    }
    .map-legend {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: var(--pite-shadow);
    }
    .legend-item {
        display: flex; align-items: center; gap: 10px;
        padding: 8px 0;
        font-size: 0.85rem;
        color: var(--pite-text-muted);
    }
    .legend-dot {
        width: 12px; height: 12px;
        flex-shrink: 0;
    }
    .legend-dot.circle { border-radius: 50%; }
    .legend-dot.diamond { transform: rotate(45deg); border-radius: 3px; }
    .marker-count {
        background: var(--pite-emerald);
        color: #fff;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    /* Modal de preview */
    .mapa-modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
        z-index: 10000;
        justify-content: center;
        align-items: center;
    }
    .mapa-modal-overlay.active { display: flex; }
    .mapa-modal {
        background: #fff;
        border-radius: 24px;
        max-width: 480px;
        width: 90%;
        padding: 0;
        overflow: hidden;
        box-shadow: 0 32px 80px rgba(0,0,0,0.3);
        animation: modalIn 0.3s ease-out;
    }
    @keyframes modalIn {
        from { transform: translateY(30px) scale(0.95); opacity: 0; }
        to { transform: translateY(0) scale(1); opacity: 1; }
    }
    .mapa-modal-header {
        padding: 24px 28px 16px;
        border-bottom: 1px solid #f1f5f9;
    }
    .mapa-modal-body { padding: 20px 28px 28px; }
    .mapa-modal .info-row {
        display: flex; align-items: flex-start; gap: 12px;
        padding: 10px 0;
        font-size: 0.88rem;
        color: #475569;
    }
    .mapa-modal .info-row i { color: var(--pite-emerald); font-size: 1.1rem; flex-shrink: 0; margin-top: 2px; }
    .tipo-badge-atrativo { background: linear-gradient(135deg, #047857, #059669); color: #fff; }
    .tipo-badge-evento { background: linear-gradient(135deg, #7c3aed, #8b5cf6); color: #fff; }

    /* Animação pulse para marcador em foco */
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.3); }
    }
</style>
@endpush

@section('content')
<div class="map-hero">
    <div class="container">
        <div class="chip chip-gold mb-3"><i class="bi bi-pin-map"></i> Geolocalização</div>
        <h2 class="section-title" style="font-size:2.2rem;">Mapa Interativo do Turismo</h2>
        <p style="color:rgba(255,255,255,0.7); max-width:500px;">
            Explore atrativos turísticos e eventos em tempo real com geolocalização integrada ao banco de dados.
        </p>
    </div>
</div>

<div class="container" style="margin-top:-20px; position:relative; z-index:2;">
    <div class="row g-4">
        <div class="col-lg-9">
            <div class="map-wrapper">
                <div id="mapa-turismo" style="height:580px; width:100%;"></div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="map-legend mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 style="font-family:'Outfit'; font-weight:700; margin-bottom:0;">
                        <i class="bi bi-geo-alt-fill me-1" style="color:var(--pite-emerald);"></i> Pontos
                    </h6>
                    <span class="marker-count" id="totalMarkers">0</span>
                </div>
                <div id="legendaCategorias">
                    <p class="text-muted small">Carregando...</p>
                </div>
            </div>
            <div class="card-premium p-4 mb-4">
                <h6 style="font-family:'Outfit'; font-weight:700; margin-bottom:12px;">
                    <i class="bi bi-funnel me-1" style="color:var(--pite-emerald);"></i> Filtros
                </h6>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Tipo</label>
                    <select class="form-select form-select-sm rounded-3" id="filterTipo">
                        <option value="">Todos</option>
                        <option value="atrativo">🟢 Atrativos</option>
                        <option value="evento">🟣 Eventos</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Categoria</label>
                    <select class="form-select form-select-sm rounded-3" id="filterCategoria">
                        <option value="">Todas</option>
                        @foreach($categorias as $cat)
                        <option value="{{ $cat->nome }}">{{ $cat->nome }}</option>
                        @endforeach
                        <option value="Evento">📅 Eventos</option>
                    </select>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="filterAcessivel">
                    <label class="form-check-label small" for="filterAcessivel">♿ Apenas acessíveis</label>
                </div>
            </div>
            <div class="card-premium p-4">
                <h6 style="font-family:'Outfit'; font-weight:700; margin-bottom:8px;">
                    <i class="bi bi-info-circle me-1" style="color:var(--pite-sky);"></i> Legenda
                </h6>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div style="width:20px;height:20px;border-radius:50%;background:#047857;border:2px solid #fff;box-shadow:0 1px 4px rgba(0,0,0,0.2);"></div>
                    <span class="small text-muted">Atrativo Turístico</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div style="width:16px;height:16px;transform:rotate(45deg);border-radius:4px;background:#7c3aed;border:2px solid #fff;box-shadow:0 1px 4px rgba(0,0,0,0.2);"></div>
                    <span class="small text-muted">Evento</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Preview -->
<div class="mapa-modal-overlay" id="mapaModal">
    <div class="mapa-modal">
        <div class="mapa-modal-header">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="badge rounded-pill px-3 py-2 mb-2" id="modalTipoBadge"></span>
                    <h5 class="fw-bold mb-0" style="font-family:'Outfit';" id="modalNome"></h5>
                </div>
                <button type="button" class="btn btn-sm btn-light rounded-circle" id="modalClose" style="width:36px;height:36px;">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>
        <div class="mapa-modal-body">
            <p class="text-muted small mb-3" id="modalDescricao"></p>

            <div id="modalInfoRows"></div>

            <a href="#" class="btn btn-pite w-100 rounded-3 py-2 fw-semibold mt-3" id="modalLink">
                <i class="bi bi-eye me-1"></i> Ver Detalhes Completos
            </a>
        </div>
    </div>
</div>

<div style="height:80px;"></div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // === Query params ===
    const urlParams = new URLSearchParams(window.location.search);
    const focusLat = parseFloat(urlParams.get('lat'));
    const focusLng = parseFloat(urlParams.get('lng'));
    const focusAtrativoId = urlParams.get('atrativo') ? parseInt(urlParams.get('atrativo')) : null;
    const focusEventoId = urlParams.get('evento') ? parseInt(urlParams.get('evento')) : null;
    const hasFocus = !isNaN(focusLat) && !isNaN(focusLng);

    const initialLat = hasFocus ? focusLat : -7.115;
    const initialLng = hasFocus ? focusLng : -34.845;
    const initialZoom = hasFocus ? 17 : 13;

    const map = L.map('mapa-turismo').setView([initialLat, initialLng], initialZoom);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap | System-PITE'
    }).addTo(map);

    let allItems = [];
    let layerGroup = L.layerGroup().addTo(map);

    const coresCat = { 'Evento': '#7c3aed' };
    const paletaCores = ['#047857','#0ea5e9','#f59e0b','#f43f5e','#10b981','#d97706','#6366f1','#ec4899','#14b8a6','#0891b2'];
    let corIndex = 0;

    function getCorCategoria(cat) {
        if (!coresCat[cat]) {
            coresCat[cat] = paletaCores[corIndex % paletaCores.length];
            corIndex++;
        }
        return coresCat[cat];
    }

    // === Marcadores diferentes por tipo ===
    function criarIconeAtrativo(cor, destaque) {
        const size = destaque ? 36 : 28;
        const borda = destaque ? '4px solid #fbbf24' : '3px solid #fff';
        const sombra = destaque ? '0 0 16px rgba(245,158,11,0.6), 0 2px 8px rgba(0,0,0,0.3)' : '0 2px 8px rgba(0,0,0,0.3)';
        const anim = destaque ? 'animation:pulse 1.5s ease-in-out infinite;' : '';
        return L.divIcon({
            className: 'custom-marker',
            html: `<div style="width:${size}px;height:${size}px;border-radius:50%;background:${cor};border:${borda};box-shadow:${sombra};display:flex;align-items:center;justify-content:center;${anim}">
                <i class="bi bi-geo-alt-fill" style="color:#fff;font-size:${size*0.45}px;"></i>
            </div>`,
            iconSize: [size, size],
            iconAnchor: [size/2, size/2],
            popupAnchor: [0, -(size/2 + 4)]
        });
    }

    function criarIconeEvento(cor, destaque) {
        const size = destaque ? 38 : 30;
        const borda = destaque ? '3px solid #fbbf24' : '3px solid #fff';
        const sombra = destaque ? '0 0 16px rgba(124,58,237,0.5), 0 2px 8px rgba(0,0,0,0.3)' : '0 2px 8px rgba(0,0,0,0.3)';
        const anim = destaque ? 'animation:pulse 1.5s ease-in-out infinite;' : '';
        return L.divIcon({
            className: 'custom-marker',
            html: `<div style="width:${size}px;height:${size}px;transform:rotate(45deg);border-radius:6px;background:${cor};border:${borda};box-shadow:${sombra};display:flex;align-items:center;justify-content:center;${anim}">
                <i class="bi bi-calendar-event-fill" style="color:#fff;font-size:${size*0.38}px;transform:rotate(-45deg);"></i>
            </div>`,
            iconSize: [size, size],
            iconAnchor: [size/2, size/2],
            popupAnchor: [0, -(size/2 + 6)]
        });
    }

    // === Modal ===
    const modal = document.getElementById('mapaModal');
    const modalNome = document.getElementById('modalNome');
    const modalDescricao = document.getElementById('modalDescricao');
    const modalTipoBadge = document.getElementById('modalTipoBadge');
    const modalInfoRows = document.getElementById('modalInfoRows');
    const modalLink = document.getElementById('modalLink');

    document.getElementById('modalClose').addEventListener('click', () => modal.classList.remove('active'));
    modal.addEventListener('click', (e) => { if (e.target === modal) modal.classList.remove('active'); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') modal.classList.remove('active'); });

    function abrirModal(item) {
        modalNome.textContent = item.nome;
        modalDescricao.textContent = item.descricao;
        modalLink.href = item.url;

        if (item.tipo === 'evento') {
            modalTipoBadge.className = 'badge rounded-pill px-3 py-2 mb-2 tipo-badge-evento';
            modalTipoBadge.innerHTML = '<i class="bi bi-calendar-event me-1"></i> Evento';
        } else {
            modalTipoBadge.className = 'badge rounded-pill px-3 py-2 mb-2 tipo-badge-atrativo';
            modalTipoBadge.innerHTML = '<i class="bi bi-geo-alt me-1"></i> Atrativo';
        }

        let infoHtml = '';
        if (item.endereco) {
            infoHtml += `<div class="info-row"><i class="bi bi-pin-map"></i><span>${item.endereco}</span></div>`;
        }
        if (item.horario) {
            infoHtml += `<div class="info-row"><i class="bi bi-clock"></i><span>${item.horario}</span></div>`;
        }
        if (item.preco) {
            infoHtml += `<div class="info-row"><i class="bi bi-tag"></i><span>${item.preco}</span></div>`;
        }
        if (item.organizador) {
            infoHtml += `<div class="info-row"><i class="bi bi-person-badge"></i><span>${item.organizador}</span></div>`;
        }
        if (item.acessivel) {
            infoHtml += `<div class="info-row"><i class="bi bi-universal-access text-success"></i><span>Acessível para PNE</span></div>`;
        }
        if (item.categoria && item.categoria !== 'Evento') {
            infoHtml += `<div class="info-row"><i class="bi bi-bookmark"></i><span>${item.categoria}</span></div>`;
        }
        modalInfoRows.innerHTML = infoHtml;

        modal.classList.add('active');
    }

    // === Renderizar Marcadores ===
    let focusMarker = null;

    function renderMarkers(filtroTipo, filtroCategoria, filtroAcessivel) {
        layerGroup.clearLayers();
        let count = 0;
        focusMarker = null;

        allItems.forEach(item => {
            // Filtros
            if (filtroTipo && item.tipo !== filtroTipo) return;
            if (filtroCategoria && item.categoria !== filtroCategoria) return;
            if (filtroAcessivel && !item.acessivel) return;

            const isTarget = (focusAtrativoId && item.tipo === 'atrativo' && item.id === focusAtrativoId) ||
                             (focusEventoId && item.tipo === 'evento' && item.id === focusEventoId);
            const cor = getCorCategoria(item.categoria);
            const icone = item.tipo === 'evento' ? criarIconeEvento(cor, isTarget) : criarIconeAtrativo(cor, isTarget);
            const marker = L.marker([item.lat, item.lng], { icon: icone });

            // Tooltip rápido ao passar mouse
            marker.bindTooltip(item.nome, {
                direction: 'top',
                offset: [0, -20],
                className: 'leaflet-tooltip-pite'
            });

            // Clique abre o modal
            marker.on('click', () => {
                abrirModal(item);
                map.setView([item.lat, item.lng], Math.max(map.getZoom(), 15), { animate: true });
            });

            layerGroup.addLayer(marker);
            count++;

            if (isTarget) focusMarker = marker;
        });

        document.getElementById('totalMarkers').textContent = count;

        if (focusMarker) {
            map.setView(focusMarker.getLatLng(), 17);
            setTimeout(() => {
                const item = allItems.find(i => 
                    (focusAtrativoId && i.tipo === 'atrativo' && i.id === focusAtrativoId) ||
                    (focusEventoId && i.tipo === 'evento' && i.id === focusEventoId)
                );
                if (item) abrirModal(item);
            }, 500);
        } else if (count > 0 && !hasFocus) {
            const group = new L.featureGroup(layerGroup.getLayers());
            map.fitBounds(group.getBounds().pad(0.1));
        }
    }

    // === Legenda dinâmica ===
    function renderLegenda() {
        const container = document.getElementById('legendaCategorias');
        const categorias = [...new Set(allItems.map(m => m.categoria))];
        container.innerHTML = categorias.map(cat => {
            const cor = getCorCategoria(cat);
            const count = allItems.filter(m => m.categoria === cat).length;
            const isEvento = cat === 'Evento';
            const dotClass = isEvento ? 'diamond' : 'circle';
            return `<div class="legend-item">
                <div class="legend-dot ${dotClass}" style="background:${cor};"></div>
                ${cat} <small class="text-muted">(${count})</small>
            </div>`;
        }).join('');
    }

    // === Carregar dados ===
    Promise.all([
        fetch('{{ route("api.atrativos.mapa") }}').then(r => r.json()),
        fetch('{{ route("api.eventos.mapa") }}').then(r => r.json())
    ])
    .then(([atrativos, eventos]) => {
        allItems = [...atrativos, ...eventos];
        renderMarkers(null, null, false);
        renderLegenda();
    })
    .catch(() => {
        document.getElementById('totalMarkers').textContent = '!';
    });

    // === Filtros interativos ===
    function aplicarFiltros() {
        const tipo = document.getElementById('filterTipo').value || null;
        const categoria = document.getElementById('filterCategoria').value || null;
        const acessivel = document.getElementById('filterAcessivel').checked;
        renderMarkers(tipo, categoria, acessivel);
    }

    document.getElementById('filterTipo').addEventListener('change', aplicarFiltros);
    document.getElementById('filterCategoria').addEventListener('change', aplicarFiltros);
    document.getElementById('filterAcessivel').addEventListener('change', aplicarFiltros);
});
</script>
@endpush

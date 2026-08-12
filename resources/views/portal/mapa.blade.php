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
        border-radius: 50%;
        flex-shrink: 0;
    }
    .marker-count {
        background: var(--pite-emerald);
        color: #fff;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.85rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="map-hero">
    <div class="container">
        <div class="chip chip-gold mb-3"><i class="bi bi-pin-map"></i> Geolocalização</div>
        <h2 class="section-title" style="font-size:2.2rem;">Mapa Interativo do Turismo</h2>
        <p style="color:rgba(255,255,255,0.7); max-width:500px;">
            Explore todos os atrativos turísticos em tempo real com geolocalização integrada ao banco de dados.
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
                    <p class="text-muted small">Carregando categorias...</p>
                </div>
            </div>
            <div class="card-premium p-4 mb-4">
                <h6 style="font-family:'Outfit'; font-weight:700; margin-bottom:12px;">
                    <i class="bi bi-funnel me-1" style="color:var(--pite-emerald);"></i> Filtros
                </h6>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Categoria</label>
                    <select class="form-select form-select-sm rounded-3" id="filterCategoria">
                        <option value="">Todas</option>
                        @foreach($categorias as $cat)
                        <option value="{{ $cat->nome }}">{{ $cat->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="filterAcessivel">
                    <label class="form-check-label small" for="filterAcessivel">♿ Apenas acessíveis</label>
                </div>
            </div>
            <div class="card-premium p-4">
                <h6 style="font-family:'Outfit'; font-weight:700; margin-bottom:8px;">
                    <i class="bi bi-info-circle me-1" style="color:var(--pite-sky);"></i> Dados Reais
                </h6>
                <p class="text-muted small mb-0">
                    Os marcadores são carregados diretamente do banco de dados PostgreSQL. Atrativos sem coordenadas não aparecem no mapa.
                </p>
            </div>
        </div>
    </div>
</div>
<div style="height:80px;"></div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const map = L.map('mapa-turismo').setView([-7.12, -34.84], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap | System-PITE'
    }).addTo(map);

    let allMarkers = [];
    let layerGroup = L.layerGroup().addTo(map);

    const coresCat = {};
    const paletaCores = ['#047857','#0ea5e9','#f59e0b','#f43f5e','#7c3aed','#10b981','#d97706','#6366f1','#ec4899','#14b8a6'];
    let corIndex = 0;

    function getCorCategoria(cat) {
        if (!coresCat[cat]) {
            coresCat[cat] = paletaCores[corIndex % paletaCores.length];
            corIndex++;
        }
        return coresCat[cat];
    }

    function criarIcone(cor) {
        return L.divIcon({
            className: 'custom-marker',
            html: `<div style="width:28px;height:28px;border-radius:50%;background:${cor};border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.3);"></div>`,
            iconSize: [28, 28],
            iconAnchor: [14, 14],
            popupAnchor: [0, -16]
        });
    }

    function renderMarkers(filtroCategoria, filtroAcessivel) {
        layerGroup.clearLayers();
        let count = 0;

        allMarkers.forEach(at => {
            if (filtroCategoria && at.categoria !== filtroCategoria) return;
            if (filtroAcessivel && !at.acessivel) return;

            const cor = getCorCategoria(at.categoria);
            const marker = L.marker([at.lat, at.lng], { icon: criarIcone(cor) });

            marker.bindPopup(`
                <div style="min-width:200px;">
                    <h6 style="font-family:'Outfit';font-weight:700;margin-bottom:4px;">${at.nome}</h6>
                    <span class="badge" style="background:${cor};color:#fff;font-size:0.7rem;margin-bottom:8px;display:inline-block;">${at.categoria}</span>
                    ${at.acessivel ? '<span class="badge bg-success ms-1" style="font-size:0.7rem;">♿ Acessível</span>' : ''}
                    <p style="font-size:0.8rem;color:#64748b;margin:8px 0;">${at.descricao}</p>
                    ${at.horario ? '<p style="font-size:0.75rem;color:#94a3b8;margin:0;"><i class="bi bi-clock"></i> ' + at.horario + '</p>' : ''}
                    <a href="${at.url}" class="btn btn-sm w-100 mt-2" style="background:#047857;color:#fff;border-radius:8px;">Ver Detalhes</a>
                </div>
            `);

            layerGroup.addLayer(marker);
            count++;
        });

        document.getElementById('totalMarkers').textContent = count;

        // Ajustar zoom se há markers
        if (count > 0) {
            const group = new L.featureGroup(layerGroup.getLayers());
            map.fitBounds(group.getBounds().pad(0.1));
        }
    }

    function renderLegenda() {
        const container = document.getElementById('legendaCategorias');
        const categorias = [...new Set(allMarkers.map(m => m.categoria))];
        container.innerHTML = categorias.map(cat => {
            const cor = getCorCategoria(cat);
            const count = allMarkers.filter(m => m.categoria === cat).length;
            return `<div class="legend-item"><div class="legend-dot" style="background:${cor};"></div>${cat} <small class="text-muted">(${count})</small></div>`;
        }).join('');
    }

    // Carregar atrativos do banco via API
    fetch('{{ route("api.atrativos.mapa") }}')
        .then(r => r.json())
        .then(data => {
            allMarkers = data;
            renderMarkers(null, false);
            renderLegenda();
        })
        .catch(() => {
            document.getElementById('totalMarkers').textContent = '!';
        });

    // Filtros interativos
    document.getElementById('filterCategoria').addEventListener('change', function() {
        const acessivel = document.getElementById('filterAcessivel').checked;
        renderMarkers(this.value || null, acessivel);
    });

    document.getElementById('filterAcessivel').addEventListener('change', function() {
        const categoria = document.getElementById('filterCategoria').value || null;
        renderMarkers(categoria, this.checked);
    });
});
</script>
@endpush

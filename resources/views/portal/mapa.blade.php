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
</style>
@endpush

@section('content')
<div class="map-hero">
    <div class="container">
        <div class="chip chip-gold mb-3"><i class="bi bi-pin-map"></i> Geolocalização</div>
        <h2 class="section-title" style="font-size:2.2rem;">Mapa Interativo do Turismo</h2>
        <p style="color:rgba(255,255,255,0.7); max-width:500px;">
            Explore todos os atrativos, hospedagens, restaurantes e pontos com acessibilidade garantida.
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
                <h6 style="font-family:'Outfit'; font-weight:700; margin-bottom:16px;">
                    <i class="bi bi-layers me-1" style="color:var(--pite-emerald);"></i> Legenda
                </h6>
                <div class="legend-item"><div class="legend-dot" style="background:var(--pite-emerald);"></div> Patrimônio Cultural</div>
                <div class="legend-item"><div class="legend-dot" style="background:var(--pite-sky);"></div> Ecoturismo</div>
                <div class="legend-item"><div class="legend-dot" style="background:var(--pite-gold);"></div> Gastronomia</div>
                <div class="legend-item"><div class="legend-dot" style="background:var(--pite-coral);"></div> Hospedagem</div>
                <div class="legend-item"><div class="legend-dot" style="background:var(--pite-violet);"></div> Artesanato</div>
            </div>
            <div class="card-premium p-4">
                <h6 style="font-family:'Outfit'; font-weight:700; margin-bottom:12px;">
                    <i class="bi bi-universal-access me-1" style="color:var(--pite-emerald);"></i> Filtros
                </h6>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="filterAcessivel" checked>
                    <label class="form-check-label small" for="filterAcessivel">Locais Acessíveis</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="filterAberto" checked>
                    <label class="form-check-label small" for="filterAberto">Abertos Agora</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="filterGratuito">
                    <label class="form-check-label small" for="filterGratuito">Entrada Gratuita</label>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="height:80px;"></div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    var map = L.map('mapa-turismo').setView([-22.7394, -45.5913], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap | System-PITE'
    }).addTo(map);
    L.marker([-22.7394, -45.5913]).addTo(map).bindPopup("<b>Centro Histórico</b><br>Patrimônio Cultural · Acessível ♿");
    L.marker([-22.7450, -45.5850]).addTo(map).bindPopup("<b>Parque Ecológico</b><br>Trilhas Guiadas · ESG ♻️");
    L.marker([-22.7320, -45.5970]).addTo(map).bindPopup("<b>Mercado de Artesanato</b><br>Empreendedores Locais 🏪");
});
</script>
@endpush

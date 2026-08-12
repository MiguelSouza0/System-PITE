@extends('layouts.app')

@section('title', 'Mapa Interativo de Turismo - System-PITE')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-3"><i class="bi bi-map text-primary me-2"></i> Mapa Interativo de Pontos Turísticos e Serviços</h2>
    <p class="text-muted">Explore atrativos, hospedagens, restaurantes e pontos com acessibilidade garantida.</p>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div id="mapa-turismo" style="height: 550px; width: 100%;"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Inicializar mapa centrado no município (coordenadas exemplo de Gramado/Campos do Jordão/Turístico)
        var map = L.map('mapa-turismo').setView([-22.7394, -45.5913], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors | System-PITE Turismo'
        }).addTo(map);

        // Adicionar marcadores demonstrativos
        var atrativo1 = L.marker([-22.7394, -45.5913]).addTo(map);
        atrativo1.bindPopup("<b>Centro Histórico Municipal</b><br>Patrimônio Cultural & Acessível PNE.");

        var atrativo2 = L.marker([-22.7450, -45.5850]).addTo(map);
        atrativo2.bindPopup("<b>Parque Ecológico das Cachoeiras</b><br>Trilha Guiada & Sustentabilidade ESG.");
    });
</script>
@endpush

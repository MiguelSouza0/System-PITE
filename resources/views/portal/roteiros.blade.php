@extends('layouts.app')

@section('title', 'Roteiros Inteligentes (IA) - System-PITE')

@section('content')
<div class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-lg-8">
            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-semibold mb-2">
                <i class="bi bi-magic me-1"></i> Inteligência Artificial Auditável
            </span>
            <h2 class="fw-bold display-6">Gerador de Roteiros Turísticos Inteligentes</h2>
            <p class="text-muted">
                Monte seu roteiro personalizado em poucos segundos. Nossa inteligência artificial considera seu tempo disponível, nível de acessibilidade necessário e suas preferências de passeio.
            </p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h5 class="fw-bold mb-3"><i class="bi bi-sliders text-primary me-2"></i> Preferências do Roteiro</h5>
                <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Roteiro inteligente gerado com sucesso!');">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Perfil de Passeio</label>
                        <select class="form-select rounded-3">
                            <option value="familia">Família com Crianças</option>
                            <option value="aventura">Ecoturismo e Aventura</option>
                            <option value="cultural">Histórico e Cultural</option>
                            <option value="gastronomico">Gastronomia Local</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Tempo Disponível (Horas)</label>
                        <input type="number" class="form-control rounded-3" value="4" min="1" max="24">
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="acessivelCheck" checked>
                        <label class="form-check-label small" for="acessivelCheck">
                            Requerer 100% de Acessibilidade (Cadeirante/PNE)
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-3 fw-semibold">
                        <i class="bi bi-lightning-charge me-1"></i> Gerar Roteiro Personalizado
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h5 class="fw-bold mb-3 d-flex align-items-center">
                    <i class="bi bi-card-checklist text-success me-2"></i> Sugestão de Roteiro Gerado
                </h5>
                <div class="border-start border-primary border-4 ps-3 mb-4">
                    <h6 class="fw-bold mb-1">Roteiro Cultural & Acessível (4 Horas)</h6>
                    <p class="text-muted small mb-0">Gerado com base em atrativos oficiais validados pelo município.</p>
                </div>

                <div class="timeline">
                    <div class="p-3 bg-light rounded-3 mb-3 border">
                        <span class="badge bg-primary mb-1">09:00 - 10:30</span>
                        <h6 class="fw-semibold mb-1">Centro Histórico & Feira de Artesanato</h6>
                        <p class="small text-muted mb-0">Rampa de acesso, banheiros adaptados, piso tátil.</p>
                    </div>
                    <div class="p-3 bg-light rounded-3 mb-3 border">
                        <span class="badge bg-primary mb-1">11:00 - 12:30</span>
                        <h6 class="fw-semibold mb-1">Almoço no Restaurante Típico Municipal</h6>
                        <p class="small text-muted mb-0">Selo de Alimento Seguro e Apoio ao Empreendedor Local.</p>
                    </div>
                    <div class="p-3 bg-light rounded-3 border">
                        <span class="badge bg-primary mb-1">13:00 - 14:00</span>
                        <h6 class="fw-semibold mb-1">Visita ao Parque Botânico Acessível</h6>
                        <p class="small text-muted mb-0">Trilha plana em alvenaria e audio-guia acessível.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

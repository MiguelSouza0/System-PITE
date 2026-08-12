<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'System-PITE - Plataforma Inteligente de Turismo Municipal')</title>
    
    <!-- Meta SEO & Open Graph -->
    <meta name="description" content="Plataforma de gestão pública orientada a dados para o turismo municipal, conectando turistas, empreendedores e a gestão pública com transparência, acessibilidade e ESG.">
    <meta name="keywords" content="Turismo Municipal, Smart Tourism, ESG, Acessibilidade, Gestão Pública, Laravel">
    <meta name="author" content="Prefeitura Municipal - System-PITE">

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Leaflet CSS (Mapas Interativos) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <!-- Google Fonts (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #212529;
        }

        .navbar-brand-custom {
            font-weight: 700;
            color: #0d6efd;
            letter-spacing: -0.5px;
        }

        .hero-banner {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            padding: 80px 0;
            border-radius: 0 0 24px 24px;
        }

        .card-atrativo {
            border: none;
            border-radius: 16px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .card-atrativo:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
        }

        .badge-acessivel {
            background-color: #198754;
            color: white;
            font-size: 0.75rem;
        }

        .badge-esg {
            background-color: #0dcaf0;
            color: #000;
            font-size: 0.75rem;
        }

        footer {
            background-color: #1e293b;
            color: #94a3b8;
            padding: 40px 0;
            margin-top: 80px;
        }

        /* Barra de Acessibilidade */
        .accessibility-bar {
            background-color: #0f172a;
            color: #e2e8f0;
            font-size: 0.85rem;
            padding: 6px 0;
        }
        .accessibility-bar a {
            color: #cbd5e1;
            text-decoration: none;
            margin-left: 12px;
        }
        .accessibility-bar a:hover {
            color: #ffffff;
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Barra Superior de Acessibilidade / VLibras / Contraste -->
    <div class="accessibility-bar">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-universal-access me-1"></i> Acessibilidade:
                <a href="#" onclick="toggleHighContrast(); return false;"><i class="bi bi-circle-half me-1"></i> Alto Contraste</a>
                <a href="#" onclick="changeFontSize(1); return false;"><i class="bi bi-plus-circle me-1"></i> Aumentar Fonte</a>
                <a href="#" onclick="changeFontSize(-1); return false;"><i class="bi bi-dash-circle me-1"></i> Diminuir Fonte</a>
            </div>
            <div>
                <span class="badge bg-success"><i class="bi bi-shield-check me-1"></i> Dados Oficiais do Município</span>
            </div>
        </div>
    </div>

    <!-- Navegação Principal -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top py-3">
        <div class="container">
            <a class="navbar-brand navbar-brand-custom d-flex align-items-center" href="{{ route('portal.home') }}">
                <i class="bi bi-geo-alt-fill text-primary me-2 fs-4"></i> System-PITE
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ route('portal.home') }}">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ route('portal.atrativos.index') }}">Atrativos & Pontos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ route('portal.mapa') }}">Mapa Interativo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ route('portal.roteiros') }}">
                            <i class="bi bi-magic text-primary me-1"></i> Roteiros Inteligentes (IA)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ route('portal.esg') }}">Indicadores ESG</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('empreendedor.dashboard') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="bi bi-shop me-1"></i> Espaço Empreendedor
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                        <i class="bi bi-speedometer2 me-1"></i> Painel de Gestão
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <main>
        @yield('content')
    </main>

    <!-- Rodapé Municipal -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-md-5">
                    <h5 class="text-white fw-bold"><i class="bi bi-geo-alt-fill text-primary me-2"></i> System-PITE</h5>
                    <p class="small text-muted">
                        Plataforma Inteligente de Turismo Municipal. Desenvolvimento sob requisitos do Hackaton de Turismo. 
                        Solução escalável, replicável e focada na gestão pública de alto impacto.
                    </p>
                </div>
                <div class="col-md-3">
                    <h6 class="text-white fw-bold mb-3">Links Rápidos</h6>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('portal.atrativos.index') }}" class="text-muted text-decoration-none">Pontos Turísticos</a></li>
                        <li><a href="{{ route('portal.roteiros') }}" class="text-muted text-decoration-none">Gerador de Roteiros</a></li>
                        <li><a href="{{ route('portal.esg') }}" class="text-muted text-decoration-none">Portal de Transparência ESG</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Manual de Acessibilidade</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-white fw-bold mb-3">Conformidade e Transparência</h6>
                    <p class="small text-muted">
                        <i class="bi bi-shield-lock me-1"></i> Adequado à LGPD (Lei nº 13.709/2018)<br>
                        <i class="bi bi-file-earmark-check me-1"></i> Auditoria de Dados Municipais Ativa
                    </p>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="d-flex justify-content-between align-items-center small">
                <span>&copy; 2026 System-PITE - Prefeitura Municipal. Todos os direitos reservados.</span>
                <span>Laravel v11.x | PostgreSQL</span>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        function toggleHighContrast() {
            document.body.classList.toggle('bg-dark');
            document.body.classList.toggle('text-white');
        }

        let currentFontSize = 100;
        function changeFontSize(delta) {
            currentFontSize += delta * 10;
            if (currentFontSize < 80) currentFontSize = 80;
            if (currentFontSize > 140) currentFontSize = 140;
            document.body.style.fontSize = currentFontSize + '%';
        }
    </script>

    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'System-PITE — Turismo Inteligente')</title>
    <meta name="description" content="Plataforma de gestão pública orientada a dados para o turismo municipal.">
    <meta name="author" content="Prefeitura Municipal - System-PITE">

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════════
           DESIGN SYSTEM — System-PITE Premium
           ═══════════════════════════════════════════ */

        :root {
            --pite-emerald: #047857;
            --pite-emerald-light: #059669;
            --pite-teal: #0d9488;
            --pite-dark: #0c1222;
            --pite-dark-card: #111827;
            --pite-surface: #f0fdf4;
            --pite-surface-alt: #f8fafc;
            --pite-gold: #f59e0b;
            --pite-gold-warm: #d97706;
            --pite-coral: #f43f5e;
            --pite-sky: #0ea5e9;
            --pite-violet: #7c3aed;
            --pite-text: #1e293b;
            --pite-text-muted: #64748b;
            --pite-radius: 20px;
            --pite-radius-sm: 12px;
            --pite-shadow: 0 4px 24px rgba(0,0,0,0.06);
            --pite-shadow-lg: 0 20px 60px rgba(0,0,0,0.12);
            --pite-glass: rgba(255,255,255,0.72);
            --pite-glass-border: rgba(255,255,255,0.18);
            --pite-transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--pite-surface-alt);
            color: var(--pite-text);
            overflow-x: hidden;
        }

        h1,h2,h3,h4,h5,h6,.display-1,.display-2,.display-3,.display-4,.display-5 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: linear-gradient(180deg, var(--pite-emerald), var(--pite-teal)); border-radius: 99px; }

        /* ── Accessibility Bar ── */
        .a11y-bar {
            background: var(--pite-dark);
            padding: 6px 0;
            font-size: 0.78rem;
            color: #94a3b8;
        }
        .a11y-bar a { color: #cbd5e1; text-decoration: none; transition: var(--pite-transition); }
        .a11y-bar a:hover { color: #fff; }

        /* ── Navbar ── */
        .navbar-pite {
            background: var(--pite-glass);
            backdrop-filter: blur(18px) saturate(180%);
            -webkit-backdrop-filter: blur(18px) saturate(180%);
            border-bottom: 1px solid var(--pite-glass-border);
            padding: 14px 0;
            transition: var(--pite-transition);
        }
        .navbar-pite.scrolled {
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
        }
        .navbar-pite .nav-link {
            color: var(--pite-text);
            font-weight: 500;
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 10px;
            transition: var(--pite-transition);
            position: relative;
        }
        .navbar-pite .nav-link:hover,
        .navbar-pite .nav-link.active {
            color: var(--pite-emerald);
            background: rgba(4,120,87,0.06);
        }
        .brand-logo {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1.4rem;
            letter-spacing: -0.03em;
            background: linear-gradient(135deg, var(--pite-emerald), var(--pite-teal));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .brand-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--pite-emerald), var(--pite-teal));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(4,120,87,0.3);
        }
        .btn-nav-primary {
            background: linear-gradient(135deg, var(--pite-emerald), var(--pite-teal));
            color: #fff !important;
            border: none;
            border-radius: 12px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: var(--pite-transition);
            box-shadow: 0 4px 16px rgba(4,120,87,0.25);
        }
        .btn-nav-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(4,120,87,0.35);
            color: #fff;
        }
        .btn-nav-outline {
            border: 1.5px solid rgba(4,120,87,0.3);
            color: var(--pite-emerald);
            border-radius: 12px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: var(--pite-transition);
            background: transparent;
        }
        .btn-nav-outline:hover {
            background: rgba(4,120,87,0.06);
            border-color: var(--pite-emerald);
            color: var(--pite-emerald);
        }

        /* ── Profile Dropdowns & Responsive Behavior ── */
        .navbar-pite .dropdown-toggle::after {
            vertical-align: 0.15em;
            transition: transform 0.25s ease;
        }
        .navbar-pite .dropdown.show .dropdown-toggle::after {
            transform: rotate(180deg);
        }

        .navbar-pite .dropdown-menu {
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.14) !important;
            border-radius: 16px !important;
            animation: fadeInDownMenu 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1060;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.98);
            margin-top: 10px !important;
        }

        @keyframes fadeInDownMenu {
            from { opacity: 0; transform: translateY(-8px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .navbar-pite .dropdown-item {
            font-size: 0.86rem;
            font-weight: 500;
            padding: 9px 14px;
            border-radius: 10px;
            transition: var(--pite-transition);
            display: flex;
            align-items: center;
            white-space: normal;
        }

        .navbar-pite .dropdown-item:hover,
        .navbar-pite .dropdown-item:focus {
            background: rgba(4, 120, 87, 0.08);
            color: var(--pite-emerald);
            transform: translateX(4px);
        }

        .navbar-pite .dropdown-item.text-danger:hover,
        .navbar-pite .dropdown-item.text-danger:focus {
            background: rgba(244, 63, 94, 0.08);
            color: #e11d48 !important;
            transform: translateX(4px);
        }

        /* Responsividade para Telas Menores (Celulares e Tablets) */
        @media (max-width: 991.98px) {
            .navbar-pite .navbar-collapse {
                background: #ffffff;
                border-radius: var(--pite-radius-sm);
                padding: 16px;
                margin-top: 12px;
                box-shadow: var(--pite-shadow-lg);
                border: 1px solid rgba(0, 0, 0, 0.06);
            }
            .navbar-pite .nav-link {
                padding: 10px 14px;
                border-radius: 8px;
            }
        }

        /* Telas Mobile Extra Pequenas & Médias (< 576px) */
        @media (max-width: 575.98px) {
            .navbar-pite .dropdown-menu {
                position: fixed !important;
                top: 70px !important;
                right: 12px !important;
                left: 12px !important;
                width: auto !important;
                min-width: unset !important;
                max-width: none !important;
                max-height: calc(100vh - 90px);
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
                transform: none !important;
            }
            .navbar-pite .dropdown-toggle {
                padding: 4px 8px 4px 4px !important;
            }
            .navbar-pite .dropdown-toggle .badge {
                font-size: 0.6rem !important;
            }
            .brand-logo {
                font-size: 1.15rem;
            }
            .brand-icon {
                width: 32px;
                height: 32px;
                font-size: 0.95rem;
            }
        }

        /* Telas Tablets e Desktops (>= 576px) */
        @media (min-width: 576px) {
            .navbar-pite .dropdown-menu {
                min-width: 270px;
                max-width: 320px;
                right: 0 !important;
                left: auto !important;
            }
        }

        /* ── Reusable Components ── */
        .section-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1.1;
        }
        .section-subtitle {
            color: var(--pite-text-muted);
            font-size: 1.05rem;
            line-height: 1.6;
            max-width: 600px;
        }
        .chip {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 16px;
            border-radius: 99px;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }
        .chip-emerald { background: rgba(4,120,87,0.1); color: var(--pite-emerald); }
        .chip-gold { background: rgba(245,158,11,0.12); color: var(--pite-gold-warm); }
        .chip-coral { background: rgba(244,63,94,0.1); color: var(--pite-coral); }

        .card-premium {
            background: #fff;
            border: 1px solid rgba(0,0,0,0.04);
            border-radius: var(--pite-radius);
            box-shadow: var(--pite-shadow);
            transition: var(--pite-transition);
            overflow: hidden;
        }
        .card-premium:hover {
            transform: translateY(-6px);
            box-shadow: var(--pite-shadow-lg);
        }

        .glass-card {
            background: var(--pite-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--pite-glass-border);
            border-radius: var(--pite-radius);
        }

        .btn-pite {
            background: linear-gradient(135deg, var(--pite-emerald), var(--pite-teal));
            color: #fff;
            border: none;
            border-radius: var(--pite-radius-sm);
            padding: 12px 28px;
            font-weight: 600;
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem;
            transition: var(--pite-transition);
            box-shadow: 0 4px 16px rgba(4,120,87,0.25);
        }
        .btn-pite:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(4,120,87,0.35);
            color: #fff;
        }
        .btn-pite-lg { padding: 16px 36px; font-size: 1.05rem; border-radius: 16px; }

        .btn-pite-gold {
            background: linear-gradient(135deg, var(--pite-gold), var(--pite-gold-warm));
            color: #1e293b;
            border: none;
            border-radius: var(--pite-radius-sm);
            padding: 14px 32px;
            font-weight: 700;
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            transition: var(--pite-transition);
            box-shadow: 0 4px 16px rgba(245,158,11,0.3);
        }
        .btn-pite-gold:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 28px rgba(245,158,11,0.4);
            color: #1e293b;
        }

        .btn-pite-outline {
            border: 2px solid rgba(255,255,255,0.3);
            color: #fff;
            background: transparent;
            border-radius: var(--pite-radius-sm);
            padding: 14px 32px;
            font-weight: 600;
            font-family: 'Outfit', sans-serif;
            transition: var(--pite-transition);
        }
        .btn-pite-outline:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.5);
            color: #fff;
        }

        .icon-box {
            width: 56px; height: 56px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }

        /* ── Animations ── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes float {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        @keyframes pulse-glow {
            0%,100% { box-shadow: 0 0 20px rgba(4,120,87,0.2); }
            50% { box-shadow: 0 0 40px rgba(4,120,87,0.4); }
        }
        .animate-in { animation: fadeInUp 0.7s ease-out both; }
        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }
        .animate-delay-4 { animation-delay: 0.4s; }
        .animate-float { animation: float 4s ease-in-out infinite; }

        /* ── Footer ── */
        .footer-pite {
            background: var(--pite-dark);
            color: #94a3b8;
            padding: 64px 0 32px;
            margin-top: 0;
        }
        .footer-pite h6 { color: #f1f5f9; font-family: 'Outfit', sans-serif; }
        .footer-pite a { color: #94a3b8; text-decoration: none; transition: var(--pite-transition); }
        .footer-pite a:hover { color: #10b981; }
        .footer-divider { border-color: rgba(255,255,255,0.06); }

        /* ── Form Controls ── */
        .form-control-pite, .form-select-pite {
            border: 1.5px solid #e2e8f0;
            border-radius: var(--pite-radius-sm);
            padding: 12px 16px;
            font-size: 0.9rem;
            transition: var(--pite-transition);
            background: #fff;
        }
        .form-control-pite:focus, .form-select-pite:focus {
            border-color: var(--pite-emerald);
            box-shadow: 0 0 0 4px rgba(4,120,87,0.1);
        }

        /* ── Badge-status ── */
        .badge-status {
            padding: 5px 14px;
            border-radius: 99px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.03em;
        }

        /* ── Accessibility High Contrast ── */
        body.high-contrast {
            background: #000 !important;
            color: #fff !important;
        }
        body.high-contrast .navbar-pite { background: #000; border-bottom-color: #333; }
        body.high-contrast .card-premium, body.high-contrast .glass-card { background: #111; border-color: #333; }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Barra de Acessibilidade -->
    <div class="a11y-bar">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <span><i class="bi bi-universal-access"></i> Acessibilidade:</span>
                <a href="#" onclick="toggleHighContrast(); return false;"><i class="bi bi-circle-half"></i> Contraste</a>
                <a href="#" onclick="changeFontSize(1); return false;"><i class="bi bi-zoom-in"></i> A+</a>
                <a href="#" onclick="changeFontSize(-1); return false;"><i class="bi bi-zoom-out"></i> A-</a>
            </div>
            <div class="d-none d-md-block">
                <span style="color:#10b981;"><i class="bi bi-patch-check-fill me-1"></i> Dados Oficiais Verificados</span>
            </div>
        </div>
    </div>

    <!-- Navegação -->
    <nav class="navbar navbar-expand-lg navbar-pite sticky-top" id="mainNav">
        <div class="container d-flex align-items-center justify-content-between">
            <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('portal.home') }}">
                <div class="brand-icon"><i class="bi bi-compass"></i></div>
                <span class="brand-logo">System-PITE</span>
            </a>

            <!-- Ações do Topo: Perfil & Botão Hamburger (Responsivo para Celulares e Desktops) -->
            <div class="d-flex align-items-center gap-2 order-lg-3">
                    @auth
                        @php
                            $currentUser = auth()->user();
                            $initial = strtoupper(substr($currentUser->name, 0, 1));
                            $firstName = explode(' ', $currentUser->name)[0];
                        @endphp

                        @if($currentUser->isPrefeito())
                            {{-- Dropdown do Prefeito Municipal --}}
                            <div class="dropdown">
                                <button class="btn d-flex align-items-center gap-2 dropdown-toggle border-0" type="button" id="prefeitoDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background: rgba(4,120,87,0.08); border-radius: 14px; padding: 6px 14px 6px 6px; border: 1.5px solid rgba(4,120,87,0.2) !important;">
                                    <div style="width: 34px; height: 34px; border-radius: 10px; background: linear-gradient(135deg, #064e3b, #047857); display: flex; align-items: center; justify-content: center; color: #fef08a; font-weight: 800; font-size: 0.85rem; font-family: 'Outfit', sans-serif; box-shadow: 0 2px 8px rgba(4,120,87,0.3); position: relative;">
                                        {{ $initial }}
                                        <span style="position: absolute; bottom: -2px; right: -2px; width: 10px; height: 10px; background: #f59e0b; border: 2px solid #fff; border-radius: 50%;"></span>
                                    </div>
                                    <div class="text-start d-none d-md-block" style="line-height: 1.2;">
                                        <span class="fw-bold small d-block" style="color: var(--pite-text);">{{ $firstName }}</span>
                                        <span class="badge px-1 py-0 text-uppercase" style="font-size: 0.65rem; background: rgba(4,120,87,0.15); color: #047857; font-weight: 700;">Prefeito</span>
                                    </div>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2" style="min-width: 260px;">
                                    <li class="px-3 py-2 border-bottom mb-2">
                                        <div class="fw-bold small text-dark">{{ $currentUser->name }}</div>
                                        <div class="text-muted small" style="font-size: 0.72rem;"><i class="bi bi-bank me-1 text-success"></i> Gabinete do Executivo</div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2" style="color: var(--pite-emerald);"></i> Painel Executivo
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3 d-flex align-items-center" href="{{ route('admin.aprovacao.pendentes') }}">
                                            <i class="bi bi-clipboard-check me-2" style="color: var(--pite-gold-warm);"></i> Aprovações Pendentes
                                            @php
                                                $totalPendentes = \App\Models\Atrativo::pendente()->count() + \App\Models\Evento::pendente()->count();
                                            @endphp
                                            @if($totalPendentes > 0)
                                                <span class="badge rounded-pill ms-auto" style="background: rgba(245,158,11,0.15); color: #d97706; font-size: 0.7rem;">{{ $totalPendentes }}</span>
                                            @endif
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-2"></li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.atrativos.index') }}">
                                            <i class="bi bi-geo-alt me-2" style="color: var(--pite-sky);"></i> Consultar Atrativos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.eventos.index') }}">
                                            <i class="bi bi-calendar-event me-2" style="color: var(--pite-violet);"></i> Consultar Eventos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.empreendedores.index') }}">
                                            <i class="bi bi-shop me-2" style="color: var(--pite-gold-warm);"></i> Consultar Empreendedores
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-2"></li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.auditoria.index') }}">
                                            <i class="bi bi-shield-check me-2" style="color: var(--pite-sky);"></i> Trilha de Auditoria
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.relatorios.csv') }}">
                                            <i class="bi bi-file-earmark-spreadsheet me-2" style="color: var(--pite-emerald);"></i> Exportar Relatório CSV
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.relatorios.esg-pdf') }}">
                                            <i class="bi bi-file-earmark-pdf me-2" style="color: var(--pite-coral);"></i> Relatório ESG (PDF)
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-2"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item rounded-3 py-2 px-3 text-danger fw-semibold">
                                                <i class="bi bi-box-arrow-right me-2"></i> Sair do Sistema
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                        @elseif($currentUser->isSecretario())
                            {{-- Dropdown do Secretário de Turismo --}}
                            <div class="dropdown">
                                <button class="btn d-flex align-items-center gap-2 dropdown-toggle border-0" type="button" id="secretarioDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background: rgba(13,148,136,0.08); border-radius: 14px; padding: 6px 14px 6px 6px; border: 1.5px solid rgba(13,148,136,0.2) !important;">
                                    <div style="width: 34px; height: 34px; border-radius: 10px; background: linear-gradient(135deg, #0d9488, #059669); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 0.85rem; font-family: 'Outfit', sans-serif; box-shadow: 0 2px 8px rgba(13,148,136,0.3); position: relative;">
                                        {{ $initial }}
                                        <span style="position: absolute; bottom: -2px; right: -2px; width: 10px; height: 10px; background: #10b981; border: 2px solid #fff; border-radius: 50%;"></span>
                                    </div>
                                    <div class="text-start d-none d-md-block" style="line-height: 1.2;">
                                        <span class="fw-bold small d-block" style="color: var(--pite-text);">{{ $firstName }}</span>
                                        <span class="badge px-1 py-0 text-uppercase" style="font-size: 0.65rem; background: rgba(13,148,136,0.15); color: #0d9488; font-weight: 700;">Secretaria</span>
                                    </div>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2" style="min-width: 260px;">
                                    <li class="px-3 py-2 border-bottom mb-2">
                                        <div class="fw-bold small text-dark">{{ $currentUser->name }}</div>
                                        <div class="text-muted small" style="font-size: 0.72rem;"><i class="bi bi-briefcase me-1" style="color: #0d9488;"></i> Secretaria de Turismo</div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-grid-1x2 me-2" style="color: var(--pite-emerald);"></i> Painel da Secretaria
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3 d-flex align-items-center" href="{{ route('admin.aprovacao.pendentes') }}">
                                            <i class="bi bi-clipboard-check me-2" style="color: var(--pite-gold-warm);"></i> Aprovações Pendentes
                                            @php
                                                $totalPendentesSecretario = \App\Models\Atrativo::pendente()->count() + \App\Models\Evento::pendente()->count();
                                            @endphp
                                            @if($totalPendentesSecretario > 0)
                                                <span class="badge rounded-pill ms-auto" style="background: rgba(245,158,11,0.15); color: #d97706; font-size: 0.7rem;">{{ $totalPendentesSecretario }}</span>
                                            @endif
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-2"></li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.atrativos.index') }}">
                                            <i class="bi bi-geo-alt me-2" style="color: var(--pite-sky);"></i> Consultar Atrativos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.eventos.index') }}">
                                            <i class="bi bi-calendar-event me-2" style="color: var(--pite-violet);"></i> Consultar Eventos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.empreendedores.index') }}">
                                            <i class="bi bi-shop me-2" style="color: var(--pite-gold-warm);"></i> Consultar Empreendedores
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-2"></li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.auditoria.index') }}">
                                            <i class="bi bi-shield-check me-2" style="color: var(--pite-violet);"></i> Trilha de Auditoria
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.relatorios.csv') }}">
                                            <i class="bi bi-file-earmark-spreadsheet me-2" style="color: var(--pite-emerald);"></i> Exportar Relatório CSV
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.relatorios.esg-pdf') }}">
                                            <i class="bi bi-file-earmark-pdf me-2" style="color: var(--pite-coral);"></i> Relatório ESG (PDF)
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-2"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item rounded-3 py-2 px-3 text-danger fw-semibold">
                                                <i class="bi bi-box-arrow-right me-2"></i> Sair do Sistema
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                        @elseif($currentUser->isServidor())
                            {{-- Dropdown do Servidor Técnico --}}
                            <div class="dropdown">
                                <button class="btn d-flex align-items-center gap-2 dropdown-toggle border-0" type="button" id="servidorDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background: rgba(14,165,233,0.08); border-radius: 14px; padding: 6px 14px 6px 6px; border: 1.5px solid rgba(14,165,233,0.2) !important;">
                                    <div style="width: 34px; height: 34px; border-radius: 10px; background: linear-gradient(135deg, #0284c7, #2563eb); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 0.85rem; font-family: 'Outfit', sans-serif; box-shadow: 0 2px 8px rgba(14,165,233,0.3); position: relative;">
                                        {{ $initial }}
                                        <span style="position: absolute; bottom: -2px; right: -2px; width: 10px; height: 10px; background: #38bdf8; border: 2px solid #fff; border-radius: 50%;"></span>
                                    </div>
                                    <div class="text-start d-none d-md-block" style="line-height: 1.2;">
                                        <span class="fw-bold small d-block" style="color: var(--pite-text);">{{ $firstName }}</span>
                                        <span class="badge px-1 py-0 text-uppercase" style="font-size: 0.65rem; background: rgba(14,165,233,0.15); color: #0284c7; font-weight: 700;">Técnico</span>
                                    </div>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2" style="min-width: 250px;">
                                    <li class="px-3 py-2 border-bottom mb-2">
                                        <div class="fw-bold small text-dark">{{ $currentUser->name }}</div>
                                        <div class="text-muted small" style="font-size: 0.72rem;"><i class="bi bi-person-gear me-1 text-primary"></i> Servidor Técnico / Operacional</div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-speedometer me-2" style="color: var(--pite-sky);"></i> Painel Operacional
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.atrativos.index') }}">
                                            <i class="bi bi-geo-alt me-2" style="color: var(--pite-emerald);"></i> Gerenciar Atrativos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.atrativos.create') }}">
                                            <i class="bi bi-plus-circle me-2" style="color: var(--pite-emerald);"></i> Cadastrar Novo Atrativo
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.eventos.index') }}">
                                            <i class="bi bi-calendar-event me-2" style="color: var(--pite-violet);"></i> Gerenciar Eventos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.eventos.create') }}">
                                            <i class="bi bi-calendar-plus me-2" style="color: var(--pite-violet);"></i> Cadastrar Novo Evento
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.empreendedores.index') }}">
                                            <i class="bi bi-shop me-2" style="color: var(--pite-gold-warm);"></i> Empreendedores
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.auditoria.index') }}">
                                            <i class="bi bi-clock-history me-2 text-secondary"></i> Logs de Auditoria
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-2"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item rounded-3 py-2 px-3 text-danger fw-semibold">
                                                <i class="bi bi-box-arrow-right me-2"></i> Sair do Sistema
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                        @elseif($currentUser->isEmpreendedor())
                            {{-- Dropdown do Empreendedor Local --}}
                            <div class="dropdown">
                                <button class="btn d-flex align-items-center gap-2 dropdown-toggle border-0" type="button" id="empreendedorDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background: rgba(245,158,11,0.08); border-radius: 14px; padding: 6px 14px 6px 6px; border: 1.5px solid rgba(245,158,11,0.2) !important;">
                                    <div style="width: 34px; height: 34px; border-radius: 10px; background: linear-gradient(135deg, #f59e0b, #d97706); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 0.85rem; font-family: 'Outfit', sans-serif; box-shadow: 0 2px 8px rgba(245,158,11,0.3); position: relative;">
                                        {{ $initial }}
                                        <span style="position: absolute; bottom: -2px; right: -2px; width: 10px; height: 10px; background: #22c55e; border: 2px solid #fff; border-radius: 50%;"></span>
                                    </div>
                                    <div class="text-start d-none d-md-block" style="line-height: 1.2;">
                                        <span class="fw-bold small d-block" style="color: var(--pite-text);">{{ $firstName }}</span>
                                        <span class="badge px-1 py-0 text-uppercase" style="font-size: 0.65rem; background: rgba(245,158,11,0.15); color: #d97706; font-weight: 700;">Empreendedor</span>
                                    </div>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2" style="min-width: 250px;">
                                    <li class="px-3 py-2 border-bottom mb-2">
                                        <div class="fw-bold small text-dark">{{ $currentUser->name }}</div>
                                        <div class="text-muted small" style="font-size: 0.72rem;"><i class="bi bi-shop me-1 text-warning"></i> Espaço do Empreendedor</div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('empreendedor.dashboard') }}">
                                            <i class="bi bi-grid-1x2 me-2" style="color: var(--pite-gold-warm);"></i> Meu Estabelecimento
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('empreendedor.cadastro') }}">
                                            <i class="bi bi-plus-circle me-2" style="color: var(--pite-emerald);"></i> Cadastrar Estabelecimento
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('portal.atrativos.index') }}">
                                            <i class="bi bi-eye me-2" style="color: var(--pite-sky);"></i> Ver Atrativos no Portal
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-2"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item rounded-3 py-2 px-3 text-danger fw-semibold">
                                                <i class="bi bi-box-arrow-right me-2"></i> Sair do Painel
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                        @elseif($currentUser->isTurista())
                            {{-- Dropdown do Turista Logado --}}
                            <div class="dropdown">
                                <button class="btn d-flex align-items-center gap-2 dropdown-toggle border-0" type="button" id="turistaDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background: rgba(4,120,87,0.06); border-radius: 14px; padding: 6px 14px 6px 6px; border: 1.5px solid rgba(4,120,87,0.15) !important;">
                                    <div style="width: 34px; height: 34px; border-radius: 10px; background: linear-gradient(135deg, var(--pite-gold), var(--pite-coral)); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 0.85rem; font-family: 'Outfit', sans-serif; box-shadow: 0 2px 8px rgba(245,158,11,0.25); position: relative;">
                                        {{ $initial }}
                                        <span style="position: absolute; bottom: -2px; right: -2px; width: 10px; height: 10px; background: #10b981; border: 2px solid #fff; border-radius: 50%;"></span>
                                    </div>
                                    <div class="text-start d-none d-md-block" style="line-height: 1.2;">
                                        <span class="fw-bold small d-block" style="color: var(--pite-text);">{{ $firstName }}</span>
                                        <span class="badge px-1 py-0 text-uppercase" style="font-size: 0.65rem; background: rgba(244,63,94,0.12); color: #f43f5e; font-weight: 700;">Turista</span>
                                    </div>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2" style="min-width: 250px;">
                                    <li class="px-3 py-2 border-bottom mb-2">
                                        <div class="fw-bold small text-dark">{{ $currentUser->name }}</div>
                                        <div class="text-muted small" style="font-size: 0.72rem;"><i class="bi bi-person-check me-1 text-danger"></i> Turista / Cidadão</div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('turista.dashboard') }}">
                                            <i class="bi bi-grid-1x2 me-2" style="color: var(--pite-emerald);"></i> Meu Painel de Viagens
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('turista.favoritos') }}">
                                            <i class="bi bi-heart-fill me-2" style="color: var(--pite-coral);"></i> Meus Favoritos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('turista.historico') }}">
                                            <i class="bi bi-clock-history me-2" style="color: var(--pite-sky);"></i> Histórico de Visitas
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('turista.recomendacoes') }}">
                                            <i class="bi bi-stars me-2" style="color: var(--pite-gold-warm);"></i> Recomendações IA
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('turista.perfil') }}">
                                            <i class="bi bi-person-gear me-2" style="color: var(--pite-violet);"></i> Editar Perfil & Preferências
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-2"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item rounded-3 py-2 px-3 text-danger fw-semibold">
                                                <i class="bi bi-box-arrow-right me-2"></i> Sair da Conta
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                        @else
                            {{-- Fallback para Administrador Geral --}}
                            <div class="dropdown">
                                <button class="btn d-flex align-items-center gap-2 dropdown-toggle border-0" type="button" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background: rgba(124,58,237,0.08); border-radius: 14px; padding: 6px 14px 6px 6px; border: 1.5px solid rgba(124,58,237,0.2) !important;">
                                    <div style="width: 34px; height: 34px; border-radius: 10px; background: linear-gradient(135deg, #7c3aed, #4f46e5); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 0.85rem; font-family: 'Outfit', sans-serif; box-shadow: 0 2px 8px rgba(124,58,237,0.3); position: relative;">
                                        {{ $initial }}
                                        <span style="position: absolute; bottom: -2px; right: -2px; width: 10px; height: 10px; background: #8b5cf6; border: 2px solid #fff; border-radius: 50%;"></span>
                                    </div>
                                    <div class="text-start d-none d-md-block" style="line-height: 1.2;">
                                        <span class="fw-bold small d-block" style="color: var(--pite-text);">{{ $firstName }}</span>
                                        <span class="badge px-1 py-0 text-uppercase" style="font-size: 0.65rem; background: rgba(124,58,237,0.15); color: #7c3aed; font-weight: 700;">Gestão</span>
                                    </div>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2" style="min-width: 250px;">
                                    <li class="px-3 py-2 border-bottom mb-2">
                                        <div class="fw-bold small text-dark">{{ $currentUser->name }}</div>
                                        <div class="text-muted small" style="font-size: 0.72rem;"><i class="bi bi-shield-lock me-1 text-primary"></i> Painel de Administração</div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-grid-1x2 me-2" style="color: var(--pite-emerald);"></i> Painel de Gestão
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.atrativos.index') }}">
                                            <i class="bi bi-geo-alt me-2" style="color: var(--pite-emerald);"></i> Atrativos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.eventos.index') }}">
                                            <i class="bi bi-calendar-event me-2" style="color: var(--pite-sky);"></i> Eventos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.empreendedores.index') }}">
                                            <i class="bi bi-shop me-2" style="color: var(--pite-gold-warm);"></i> Empreendedores
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.esg.index') }}">
                                            <i class="bi bi-leaf me-2" style="color: var(--pite-emerald);"></i> Indicadores ESG
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('admin.auditoria.index') }}">
                                            <i class="bi bi-clock-history me-2 text-secondary"></i> Auditoria
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-2"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item rounded-3 py-2 px-3 text-danger fw-semibold">
                                                <i class="bi bi-box-arrow-right me-2"></i> Sair do Sistema
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('turista.login') }}" class="btn btn-nav-outline py-1 px-3"><i class="bi bi-person me-1"></i> Entrar</a>
                        <a href="{{ route('turista.registro') }}" class="btn btn-nav-primary d-none d-sm-inline-flex py-1 px-3"><i class="bi bi-person-plus me-1"></i> Cadastre-se</a>
                    @endauth

                    <!-- Botão Hamburger para Telas Mobile/Tablet -->
                    <button class="navbar-toggler border-0 p-2 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Alternar navegação">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <!-- Menu de Links Colapsável (Centralizado no Desktop, Menu Dropdown no Mobile) -->
                <div class="collapse navbar-collapse order-lg-2" id="navbarMain">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 py-2 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="{{ route('portal.home') }}">Início</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('portal.atrativos.index') }}">Atrativos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('portal.eventos.index') }}">Eventos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('portal.mapa') }}">Mapa</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('portal.roteiros') }}"><i class="bi bi-stars me-1"></i>Roteiros IA</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('portal.esg') }}">ESG</a></li>
                    </ul>
                </div>
            </div>
        </nav>

    <main>@yield('content')</main>

    <!-- Footer -->
    <footer class="footer-pite">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="brand-icon"><i class="bi bi-compass"></i></div>
                        <span class="brand-logo" style="-webkit-text-fill-color:#f1f5f9; background:none;">System-PITE</span>
                    </div>
                    <p class="small" style="line-height:1.7;">
                        Plataforma Inteligente de Turismo Municipal — conectando turistas, empreendedores e gestão pública com tecnologia, sustentabilidade e acessibilidade universal.
                    </p>
                </div>
                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3">Navegação</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="{{ route('portal.atrativos.index') }}"><i class="bi bi-chevron-right me-1" style="font-size:0.7rem;"></i> Pontos Turísticos</a></li>
                        <li><a href="{{ route('portal.roteiros') }}"><i class="bi bi-chevron-right me-1" style="font-size:0.7rem;"></i> Roteiros Inteligentes</a></li>
                        <li><a href="{{ route('portal.esg') }}"><i class="bi bi-chevron-right me-1" style="font-size:0.7rem;"></i> Transparência ESG</a></li>
                        <li><a href="{{ route('portal.mapa') }}"><i class="bi bi-chevron-right me-1" style="font-size:0.7rem;"></i> Mapa Interativo</a></li>
                        <li><a href="{{ route('empreendedor.dashboard') }}"><i class="bi bi-shop me-1" style="font-size:0.7rem;"></i> Espaço do Empreendedor</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold mb-3">Conformidade</h6>
                    <div class="d-flex flex-column gap-2 small">
                        <span><i class="bi bi-shield-lock-fill text-success me-2"></i> Adequado à LGPD (Lei 13.709/2018)</span>
                        <span><i class="bi bi-patch-check-fill text-success me-2"></i> Auditoria de Dados Municipal Ativa</span>
                        <span><i class="bi bi-universal-access-circle text-success me-2"></i> Acessibilidade WCAG 2.2 AA</span>
                    </div>
                </div>
            </div>
            <hr class="footer-divider my-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small" style="color:#475569;">
                <span>&copy; 2026 System-PITE — Prefeitura Municipal</span>
                <span>Laravel 11 · PostgreSQL · Bootstrap 5</span>
            </div>
        </div>
    </footer>

    <!-- Banner de Status de Conexão (Online / Offline) -->
    <div id="networkStatusBanner" style="display:none; position:fixed; bottom:20px; left:20px; z-index:10000; border-radius:14px; padding:12px 20px; box-shadow:0 8px 30px rgba(0,0,0,0.25); font-size:0.88rem; font-weight:600; transition:all 0.4s ease;"></div>

    <!-- ═══ BOTÃO FLUTUANTE DO ASSISTENTE VIRTUAL IA (GUIA PITE IA) ═══ -->
    <div id="aiFloatingBtnWrapper" style="position:fixed; bottom:24px; right:24px; z-index:9999;">
        <button id="btnOpenAiChat" class="btn border-0 shadow-lg d-flex align-items-center gap-2" style="background: linear-gradient(135deg, #4f46e5, #7c3aed); color:#fff; border-radius:99px; padding:12px 20px; font-weight:700; font-family:'Outfit', sans-serif; box-shadow: 0 10px 30px rgba(79,70,229,0.4) !important; transition:all 0.3s cubic-bezier(0.4,0,0.2,1);" title="Tire dúvidas com nosso Guia Virtual Oficial">
            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:30px; height:30px; background:rgba(255,255,255,0.2);">
                <i class="bi bi-stars"></i>
            </div>
            <span>Guia PITE IA</span>
            <span class="badge bg-warning text-dark rounded-pill px-2 py-1" style="font-size:0.65rem;">Oficial</span>
        </button>
    </div>

    <!-- ═══ CHAT DRAWER / MODAL DO GUIA PITE IA ═══ -->
    <div class="modal fade" id="modalAiChat" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden" style="background:#fff; height:600px;">
                <!-- Header do Chat -->
                <div class="p-3 text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #1e1b4b, #312e81, #4338ca);">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:38px; height:38px; background:rgba(255,255,255,0.15); border:1.5px solid rgba(255,255,255,0.3);">
                            <i class="bi bi-robot fs-5"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-1">
                                <h6 class="fw-bold mb-0" style="font-family:'Outfit';">Guia PITE IA</h6>
                                <span class="badge bg-success rounded-pill px-2 py-0" style="font-size:0.6rem;">Oficial</span>
                            </div>
                            <small class="text-white text-opacity-75" style="font-size:0.72rem;">Base Oficial Municipal · Supervisão Ativa</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <!-- Seletor de Idioma -->
                        <select id="chatLanguageSelect" class="form-select form-select-sm border-0 rounded-pill" style="font-size:0.72rem; padding:3px 24px 3px 10px; background-color:rgba(255,255,255,0.15); color:#fff;">
                            <option value="pt" class="text-dark">🇧🇷 PT</option>
                            <option value="en" class="text-dark">🇺🇸 EN</option>
                            <option value="es" class="text-dark">🇪🇸 ES</option>
                        </select>
                        <button type="button" class="btn btn-sm btn-light rounded-circle" data-bs-dismiss="modal" style="width:32px; height:32px; padding:0;">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- Corpo das Mensagens -->
                <div class="modal-body p-3 d-flex flex-column gap-3" id="chatMessagesContainer" style="background:#f8fafc; overflow-y:auto;">
                    <!-- Mensagem Inicial -->
                    <div class="d-flex gap-2">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width:32px; height:32px; font-size:0.8rem;">
                            <i class="bi bi-robot"></i>
                        </div>
                        <div class="p-3 bg-white rounded-4 shadow-sm border" style="max-width:85%;">
                            <p class="small text-dark mb-1" id="chatWelcomeText" style="line-height:1.5;">
                                Olá! Sou o <strong>Guia Virtual Oficial do System-PITE</strong>. Como posso ajudar seu passeio no município hoje?
                            </p>
                            <div class="d-flex flex-wrap gap-1 mt-2">
                                <button class="btn btn-sm btn-light border rounded-pill px-2 py-1 quick-ask-btn" style="font-size:0.72rem;" data-msg="O que fazer hoje com crianças?">
                                    👨‍👩‍👧 Passeios em Família
                                </button>
                                <button class="btn btn-sm btn-light border rounded-pill px-2 py-1 quick-ask-btn" style="font-size:0.72rem;" data-msg="Quais são os principais pontos históricos?">
                                    🏛️ Centro Histórico
                                </button>
                                <button class="btn btn-sm btn-light border rounded-pill px-2 py-1 quick-ask-btn" style="font-size:0.72rem;" data-msg="Onde comer comida típica regional?">
                                    🍽️ Gastronomia Local
                                </button>
                                <button class="btn btn-sm btn-light border rounded-pill px-2 py-1 quick-ask-btn" style="font-size:0.72rem;" data-msg="Quais atrativos são 100% acessíveis para cadeirantes?">
                                    ♿ Acessibilidade PNE
                                </button>
                                <button class="btn btn-sm btn-light border rounded-pill px-2 py-1 quick-ask-btn" style="font-size:0.72rem;" data-msg="Quais são os telefones de emergência da cidade?">
                                    🚨 Socorro & Emergência
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rodapé com Input -->
                <div class="p-3 bg-white border-top">
                    <form id="chatForm" class="d-flex gap-2">
                        <input type="text" id="chatInput" class="form-control form-control-pite rounded-pill small" placeholder="Pergunte sobre atrativos, eventos, restaurantes..." maxlength="400" required>
                        <button type="submit" class="btn btn-pite rounded-circle flex-shrink-0" style="width:42px; height:42px; padding:0;" id="btnSendChat">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </form>
                    <div class="d-flex justify-content-between align-items-center mt-2 px-1">
                        <small class="text-muted" style="font-size:0.68rem;">
                            <i class="bi bi-shield-check text-success"></i> Dados auditados pela Secretaria Municipal de Turismo
                        </small>
                        <button type="button" class="btn btn-link p-0 text-muted small" style="font-size:0.68rem; text-decoration:none;" id="btnVoiceReadLast" title="Ouvir última resposta">
                            <i class="bi bi-volume-up text-primary"></i> Ouvir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação Minimalista Global -->
    <div class="modal fade" id="modalConfirmacaoGlobal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden" style="backdrop-filter: blur(16px); background: rgba(255, 255, 255, 0.98);">
                <div class="modal-body p-4 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 52px; height: 52px; background: rgba(244, 63, 94, 0.1); color: #f43f5e; font-size: 1.5rem;">
                        <i class="bi bi-exclamation-circle-fill"></i>
                    </div>
                    <h6 class="fw-bold mb-2 text-dark" id="modalConfirmacaoTitulo" style="font-family: 'Outfit', sans-serif;">Confirmação</h6>
                    <p class="text-muted small mb-4 px-2" id="modalConfirmacaoMsg" style="line-height: 1.5;">Tem certeza que deseja prosseguir com esta ação?</p>
                    
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-light rounded-pill px-4 py-2 small fw-semibold text-muted" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="button" class="btn btn-danger rounded-pill px-4 py-2 small fw-semibold shadow-sm" id="btnConfirmarAcao">
                            Confirmar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Modal Minimalista de Confirmação
        let callbackConfirmacao = null;
        function confirmarAcao(mensagem, callback, titulo = 'Confirmar Ação') {
            document.getElementById('modalConfirmacaoMsg').textContent = mensagem;
            document.getElementById('modalConfirmacaoTitulo').textContent = titulo;
            callbackConfirmacao = callback;
            const modalEl = document.getElementById('modalConfirmacaoGlobal');
            const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
            modalInstance.show();
        }

        document.getElementById('btnConfirmarAcao')?.addEventListener('click', function() {
            const modalEl = document.getElementById('modalConfirmacaoGlobal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();
            if (typeof callbackConfirmacao === 'function') {
                callbackConfirmacao();
            }
        });

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            document.getElementById('mainNav')?.classList.toggle('scrolled', window.scrollY > 40);
        });

        // Accessibility
        function toggleHighContrast() { document.body.classList.toggle('high-contrast'); }
        let fontSize = 100;
        function changeFontSize(d) {
            fontSize = Math.max(80, Math.min(140, fontSize + d * 10));
            document.body.style.fontSize = fontSize + '%';
        }

        // Intersection Observer for animate-in
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('animate-in'); obs.unobserve(e.target); } });
        }, { threshold: 0.1 });
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-animate]').forEach(el => obs.observe(el));
        });

        // ═══════════════════════════════════════════
        // GUIA PITE IA — ASSISTENTE VIRTUAL INTELIGENTE
        // ═══════════════════════════════════════════
        const chatModalEl = document.getElementById('modalAiChat');
        const btnOpenChat = document.getElementById('btnOpenAiChat');
        const chatForm = document.getElementById('chatForm');
        const chatInput = document.getElementById('chatInput');
        const messagesBox = document.getElementById('chatMessagesContainer');
        const langSelect = document.getElementById('chatLanguageSelect');
        const btnVoiceLast = document.getElementById('btnVoiceReadLast');

        let lastBotResponse = "Bem-vindo ao System-PITE. Como posso ajudar com sua viagem?";

        btnOpenChat?.addEventListener('click', () => {
            const modal = bootstrap.Modal.getOrCreateInstance(chatModalEl);
            modal.show();
            setTimeout(() => chatInput?.focus(), 300);
        });

        document.querySelectorAll('.quick-ask-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const msg = this.dataset.msg;
                if (msg) {
                    chatInput.value = msg;
                    chatForm.dispatchEvent(new Event('submit'));
                }
            });
        });

        chatForm?.addEventListener('submit', function(e) {
            e.preventDefault();
            const text = chatInput.value.trim();
            if (!text) return;

            // Renderiza mensagem do usuário
            appendUserMessage(text);
            chatInput.value = '';

            // Indicador de digitação
            const typingId = appendTypingIndicator();

            fetch('{{ route("api.ia.chat") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    mensagem: text,
                    idioma: langSelect?.value || 'pt'
                })
            })
            .then(r => r.json())
            .then(res => {
                removeTypingIndicator(typingId);
                if (res.sucesso && res.dados) {
                    appendBotMessage(res.dados);
                    lastBotResponse = res.dados.resposta;
                }
            })
            .catch(() => {
                removeTypingIndicator(typingId);
                appendBotMessage({
                    resposta: "Desculpe, ocorreu uma instabilidade temporária na consulta. Mas você pode navegar pelos nossos atrativos e roteiros no menu principal!",
                    cards: [],
                    sugestoes: []
                });
            });
        });

        function appendUserMessage(text) {
            const div = document.createElement('div');
            div.className = 'd-flex justify-content-end mb-2';
            div.innerHTML = `
                <div class="p-3 rounded-4 shadow-sm" style="max-width:80%; background: linear-gradient(135deg, var(--pite-emerald), var(--pite-teal)); color:#fff; font-size:0.86rem; line-height:1.4;">
                    ${text}
                </div>
            `;
            messagesBox.appendChild(div);
            messagesBox.scrollTop = messagesBox.scrollHeight;
        }

        function appendTypingIndicator() {
            const id = 'typing-' + Date.now();
            const div = document.createElement('div');
            div.id = id;
            div.className = 'd-flex gap-2 mb-2';
            div.innerHTML = `
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width:30px; height:30px; font-size:0.75rem;">
                    <i class="bi bi-robot"></i>
                </div>
                <div class="p-2 bg-white rounded-3 border text-muted small">
                    <span class="spinner-grow spinner-grow-sm me-1"></span> Consultando base oficial...
                </div>
            `;
            messagesBox.appendChild(div);
            messagesBox.scrollTop = messagesBox.scrollHeight;
            return id;
        }

        function removeTypingIndicator(id) {
            const el = document.getElementById(id);
            if (el) el.remove();
        }

        function appendBotMessage(dados) {
            const div = document.createElement('div');
            div.className = 'd-flex gap-2 mb-3';

            let cardsHtml = '';
            if (dados.cards && dados.cards.length > 0) {
                cardsHtml = '<div class="d-flex flex-column gap-2 mt-2">';
                dados.cards.forEach(c => {
                    const icon = c.tipo === 'evento' ? 'bi-calendar-event text-primary' : (c.tipo === 'roteiro' ? 'bi-route text-success' : 'bi-geo-alt-fill text-danger');
                    cardsHtml += `
                        <a href="${c.url}" class="p-2 rounded-3 bg-light border text-decoration-none d-flex align-items-center gap-2 hover-emerald" style="color:var(--pite-text);">
                            <i class="bi ${icon} fs-5"></i>
                            <div class="flex-grow-1 text-truncate">
                                <strong class="d-block text-dark small text-truncate">${c.titulo}</strong>
                                <span class="text-muted" style="font-size:0.72rem;">${c.subtitulo || ''}</span>
                            </div>
                            <i class="bi bi-chevron-right text-muted small"></i>
                        </a>
                    `;
                });
                cardsHtml += '</div>';
            }

            let sugestoesHtml = '';
            if (dados.sugestoes && dados.sugestoes.length > 0) {
                sugestoesHtml = '<div class="d-flex flex-wrap gap-1 mt-2">';
                dados.sugestoes.forEach(s => {
                    sugestoesHtml += `<button class="btn btn-sm btn-light border rounded-pill px-2 py-0 quick-ask-btn" style="font-size:0.7rem;" onclick="askDirectly('${s}')">${s}</button>`;
                });
                sugestoesHtml += '</div>';
            }

            div.innerHTML = `
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width:32px; height:32px; font-size:0.8rem;">
                    <i class="bi bi-robot"></i>
                </div>
                <div class="p-3 bg-white rounded-4 shadow-sm border" style="max-width:88%;">
                    <p class="small text-dark mb-1" style="line-height:1.5; white-space:pre-line;">${dados.resposta}</p>
                    ${cardsHtml}
                    ${sugestoesHtml}
                    <div class="mt-2 pt-2 border-top d-flex justify-content-between align-items-center" style="font-size:0.65rem; color:#94a3b8;">
                        <span><i class="bi bi-patch-check-fill text-success"></i> ${dados.fonte_dados || 'Base Oficial'}</span>
                        <span class="badge bg-light text-muted border">Supervisão Humana</span>
                    </div>
                </div>
            `;
            messagesBox.appendChild(div);
            messagesBox.scrollTop = messagesBox.scrollHeight;
        }

        window.askDirectly = function(msg) {
            chatInput.value = msg;
            chatForm.dispatchEvent(new Event('submit'));
        };

        // Text to Speech da última resposta
        btnVoiceLast?.addEventListener('click', function() {
            if ('speechSynthesis' in window && lastBotResponse) {
                speechSynthesis.cancel();
                const utter = new SpeechSynthesisUtterance(lastBotResponse.replace(/<[^>]*>?/gm, ''));
                utter.lang = (langSelect?.value === 'en' ? 'en-US' : (langSelect?.value === 'es' ? 'es-ES' : 'pt-BR'));
                speechSynthesis.speak(utter);
            }
        });

        // ═══════════════════════════════════════════
        // DETECTOR DE CONEXÃO (ONLINE / OFFLINE)
        // ═══════════════════════════════════════════
        const netBanner = document.getElementById('networkStatusBanner');

        function updateOnlineStatus() {
            if (!netBanner) return;
            if (!navigator.onLine) {
                netBanner.style.display = 'block';
                netBanner.style.background = '#991b1b';
                netBanner.style.color = '#fff';
                netBanner.innerHTML = `
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-cloud-slash-fill fs-5 text-warning"></i>
                        <div>
                            <span>Você está desconectado da internet.</span>
                            <a href="{{ route('portal.roteiros.offline') }}" class="text-white text-decoration-underline ms-2 fw-bold">Acessar Modo Offline</a>
                        </div>
                    </div>
                `;
            } else {
                if (netBanner.style.display === 'block') {
                    netBanner.style.background = '#047857';
                    netBanner.style.color = '#fff';
                    netBanner.innerHTML = '<i class="bi bi-wifi me-1"></i> Conexão restabelecida!';
                    setTimeout(() => { netBanner.style.display = 'none'; }, 3000);
                }
            }
        }

        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);
        updateOnlineStatus();
    </script>
    @stack('scripts')
</body>
</html>

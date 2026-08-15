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
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('portal.home') }}">
                <div class="brand-icon"><i class="bi bi-compass"></i></div>
                <span class="brand-logo">System-PITE</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('portal.home') }}">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('portal.atrativos.index') }}">Atrativos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('portal.eventos.index') }}">Eventos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('portal.mapa') }}">Mapa</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('portal.roteiros') }}"><i class="bi bi-stars me-1"></i>Roteiros IA</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('portal.esg') }}">ESG</a></li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    @auth
                        @if(auth()->user()->isTurista())
                            {{-- Dropdown do Turista Logado --}}
                            <div class="dropdown">
                                <button class="btn d-flex align-items-center gap-2 dropdown-toggle" type="button" id="turistaDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background: rgba(4,120,87,0.06); border-radius: 14px; padding: 6px 16px 6px 6px; border: 1.5px solid rgba(4,120,87,0.15);">
                                    <div style="width: 32px; height: 32px; border-radius: 10px; background: linear-gradient(135deg, var(--pite-gold), var(--pite-gold-warm)); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 0.8rem; font-family: 'Outfit';">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <span class="fw-semibold small d-none d-md-inline" style="color: var(--pite-text);">{{ explode(' ', auth()->user()->name)[0] }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2" style="min-width: 220px;">
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('turista.dashboard') }}">
                                            <i class="bi bi-grid-1x2 me-2" style="color: var(--pite-emerald);"></i> Meu Painel
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('turista.favoritos') }}">
                                            <i class="bi bi-heart me-2" style="color: var(--pite-coral);"></i> Favoritos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('turista.historico') }}">
                                            <i class="bi bi-clock-history me-2" style="color: var(--pite-sky);"></i> Histórico
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-3 py-2 px-3" href="{{ route('turista.perfil') }}">
                                            <i class="bi bi-person-gear me-2" style="color: var(--pite-violet);"></i> Editar Perfil
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-2"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item rounded-3 py-2 px-3 text-danger">
                                                <i class="bi bi-box-arrow-right me-2"></i> Sair
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @elseif(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-nav-primary"><i class="bi bi-grid-1x2 me-1"></i> Gestão</a>
                        @elseif(auth()->user()->isEmpreendedor())
                            <a href="{{ route('empreendedor.dashboard') }}" class="btn btn-nav-outline"><i class="bi bi-shop me-1"></i> Empreendedor</a>
                        @endif
                    @else
                        <a href="{{ route('turista.login') }}" class="btn btn-nav-outline"><i class="bi bi-person me-1"></i> Entrar</a>
                        <a href="{{ route('turista.registro') }}" class="btn btn-nav-primary"><i class="bi bi-person-plus me-1"></i> Cadastre-se</a>
                    @endauth
                </div>
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
    </script>
    @stack('scripts')
</body>
</html>

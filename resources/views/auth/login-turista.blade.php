@extends('layouts.app')
@section('title', 'Entrar como Turista — System-PITE')

@push('styles')
<style>
    .login-hero {
        min-height: calc(100vh - 70px);
        display: flex;
        align-items: center;
        background: linear-gradient(160deg, #022c22 0%, #064e3b 30%, #047857 60%, #0d9488 100%);
        position: relative;
        overflow: hidden;
        padding: 48px 0;
    }
    .login-hero::before {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -20%;
        width: 600px;
        height: 600px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(14,165,233,0.08) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }
    .login-card {
        background: rgba(255,255,255,0.97);
        backdrop-filter: blur(20px);
        border-radius: 28px;
        padding: 48px 40px;
        box-shadow: 0 32px 80px rgba(0,0,0,0.2);
        max-width: 480px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }
    .login-illustration {
        width: 80px;
        height: 80px;
        border-radius: 24px;
        background: linear-gradient(135deg, var(--pite-emerald), var(--pite-teal));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #fff;
        margin: 0 auto 24px;
        box-shadow: 0 8px 32px rgba(4,120,87,0.3);
    }
    .social-divider {
        display: flex;
        align-items: center;
        gap: 16px;
        margin: 24px 0;
    }
    .social-divider::before,
    .social-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }
</style>
@endpush

@section('content')
<section class="login-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 animate-in">
                <div class="login-card">
                    <div class="login-illustration">
                        <i class="bi bi-compass"></i>
                    </div>

                    <h3 class="text-center section-title mb-1">Bem-vindo de volta!</h3>
                    <p class="text-center text-muted small mb-4">Acesse sua conta para continuar sua jornada turística</p>

                    @if($errors->any())
                    <div class="alert alert-danger rounded-3 py-2 small">
                        <i class="bi bi-exclamation-triangle me-1"></i> {{ $errors->first() }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('turista.login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">E-mail</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #e2e8f0;">
                                    <i class="bi bi-envelope text-muted"></i>
                                </span>
                                <input type="email" name="email" class="form-control form-control-pite border-start-0" style="border-radius: 0 12px 12px 0;" value="{{ old('email') }}" placeholder="seuemail@exemplo.com" required autofocus>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-radius: 12px 0 0 12px; border-color: #e2e8f0;">
                                    <i class="bi bi-lock text-muted"></i>
                                </span>
                                <input type="password" name="password" class="form-control form-control-pite border-start-0" style="border-radius: 0 12px 12px 0;" placeholder="Sua senha" required>
                            </div>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="lembrar" value="1" id="lembrarMe" style="border-color: var(--pite-emerald);">
                            <label class="form-check-label small" for="lembrarMe">Manter conectado</label>
                        </div>

                        <button type="submit" class="btn btn-pite w-100 btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Entrar
                        </button>
                    </form>

                    <div class="social-divider">
                        <span class="small text-muted">ou</span>
                    </div>

                    {{-- Quick Login para Demo --}}
                    <a href="{{ route('quick-login', 'turista') }}" class="btn w-100 mb-3" style="background: rgba(4,120,87,0.06); color: var(--pite-emerald); border: 1.5px solid rgba(4,120,87,0.2); border-radius: 14px; padding: 12px; font-weight: 600;">
                        <i class="bi bi-lightning me-1"></i> Acesso Rápido (Demonstração)
                    </a>

                    <div class="text-center mt-3">
                        <span class="small text-muted">Não tem conta?</span>
                        <a href="{{ route('turista.registro') }}" class="small fw-semibold" style="color: var(--pite-emerald);">Criar conta gratuita</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

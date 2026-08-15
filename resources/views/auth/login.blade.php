@extends('layouts.app')

@section('title', 'Acesso ao Sistema - System-PITE')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="bg-primary text-white p-4 text-center">
                    <i class="bi bi-shield-lock fs-1 mb-2"></i>
                    <h4 class="fw-bold mb-0">Acesso Restrito</h4>
                    <p class="small text-light-50 mb-0">Gestão Pública e Espaço do Empreendedor</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    @if (session('error'))
                        <div class="alert alert-danger rounded-3 small d-flex align-items-center gap-2">
                            <i class="bi bi-exclamation-triangle-fill flex-shrink-0 fs-5"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 small d-flex align-items-start gap-2">
                            <i class="bi bi-shield-x flex-shrink-0 fs-5 mt-1"></i>
                            <div>
                                <strong>Erro ao acessar:</strong>
                                <ul class="mb-0 ps-3 mt-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-semibold">E-mail Institucional</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control border-start-0" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="seu.nome@municipio.gov.br">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label small fw-semibold">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-key"></i></span>
                                <input type="password" class="form-control border-start-0" id="password" name="password" required placeholder="••••••••">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-semibold mb-4">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Entrar no Sistema
                        </button>
                    </form>

                    <div class="border-top pt-4">
                        <h6 class="fw-bold small text-muted text-uppercase text-center mb-3">
                            ⚡ Acesso Rápido para Avaliadores (Hackaton)
                        </h6>
                        <div class="d-grid gap-2">
                            <a href="{{ route('quick-login', 'prefeito') }}" class="btn btn-outline-dark btn-sm rounded-pill text-start px-3 d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-person-badge text-primary me-2"></i> Entrar como <strong>Prefeito</strong></span>
                                <span class="badge bg-dark">Dashboard Executivo</span>
                            </a>
                            <a href="{{ route('quick-login', 'secretario') }}" class="btn btn-outline-primary btn-sm rounded-pill text-start px-3 d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-briefcase text-success me-2"></i> Entrar como <strong>Secretário de Turismo</strong></span>
                                <span class="badge bg-primary">Gestão Operacional</span>
                            </a>
                            <a href="{{ route('quick-login', 'servidor') }}" class="btn btn-outline-secondary btn-sm rounded-pill text-start px-3 d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-person-gear text-info me-2"></i> Entrar como <strong>Técnico / Servidor</strong></span>
                                <span class="badge bg-secondary">Operação & Auditoria</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

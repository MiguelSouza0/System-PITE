<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portal\HomeController;
use App\Http\Controllers\Portal\AtrativoController;
use App\Http\Controllers\Portal\MapaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AtrativoAdminController;
use App\Http\Controllers\Admin\EmpreendedorAdminController;
use App\Http\Controllers\Admin\EventoAdminController;
use App\Http\Controllers\Admin\AuditoriaController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes - System-PITE (Plataforma Inteligente de Turismo Municipal)
|--------------------------------------------------------------------------
*/

// --- AUTENTICAÇÃO E ACESSO RÁPIDO ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/quick-login/{perfil}', [AuthController::class, 'quickLogin'])->name('quick-login');


// --- PORTAL PÚBLICO (TURISTAS E CIDADÃOS) ---
Route::get('/', [HomeController::class, 'index'])->name('portal.home');
use App\Http\Controllers\Portal\AvaliacaoController;

Route::get('/atrativos', [AtrativoController::class, 'index'])->name('portal.atrativos.index');
Route::get('/atrativos/{slug}', [AtrativoController::class, 'show'])->name('portal.atrativos.show');
Route::post('/atrativos/{slug}/avaliar', [AvaliacaoController::class, 'store'])->name('portal.atrativos.avaliar');
Route::put('/avaliacoes/{avaliacao}', [AvaliacaoController::class, 'update'])->name('portal.avaliacoes.update');
Route::delete('/avaliacoes/{avaliacao}', [AvaliacaoController::class, 'destroy'])->name('portal.avaliacoes.destroy');

Route::get('/mapa-interativo', [MapaController::class, 'index'])->name('portal.mapa');

use App\Http\Controllers\Portal\RoteiroController;
use App\Http\Controllers\Portal\EventoController;

Route::get('/roteiros-inteligentes', [RoteiroController::class, 'index'])->name('portal.roteiros');
Route::post('/roteiros-inteligentes/gerar', [RoteiroController::class, 'gerar'])->name('portal.roteiros.gerar');

Route::get('/eventos', [EventoController::class, 'index'])->name('portal.eventos.index');
Route::get('/eventos/{slug}', [EventoController::class, 'show'])->name('portal.eventos.show');

Route::get('/esg-transparencia', function () {
    return view('portal.esg');
})->name('portal.esg');

// --- AUTENTICAÇÃO DO TURISTA ---
use App\Http\Controllers\Portal\TuristaAuthController;
use App\Http\Controllers\Portal\TuristaDashboardController;

Route::get('/turista/registro', [TuristaAuthController::class, 'showRegistro'])->name('turista.registro');
Route::post('/turista/registro', [TuristaAuthController::class, 'registro']);
Route::get('/turista/login', [TuristaAuthController::class, 'showLogin'])->name('turista.login');
Route::post('/turista/login', [TuristaAuthController::class, 'login']);

// --- PAINEL DO TURISTA (autenticado) ---
Route::middleware(['auth', 'perfil:turista'])->prefix('turista')->name('turista.')->group(function () {
    Route::get('/dashboard', [TuristaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/perfil', [TuristaDashboardController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [TuristaDashboardController::class, 'atualizarPerfil'])->name('perfil.update');
    Route::get('/favoritos', [TuristaDashboardController::class, 'favoritos'])->name('favoritos');
    Route::post('/favoritos/toggle', [TuristaDashboardController::class, 'toggleFavorito'])->name('favoritos.toggle');
    Route::get('/historico', [TuristaDashboardController::class, 'historico'])->name('historico');
    Route::post('/visita/registrar', [TuristaDashboardController::class, 'registrarVisita'])->name('visita.registrar');
    Route::get('/recomendacoes', [TuristaDashboardController::class, 'recomendacoes'])->name('recomendacoes');
});

// --- API JSON para Mapa Interativo ---
Route::get('/api/atrativos-mapa', [MapaController::class, 'atrativosJson'])->name('api.atrativos.mapa');
Route::get('/api/eventos-mapa', [MapaController::class, 'eventosJson'])->name('api.eventos.mapa');


// --- PAINEL DO EMPREENDEDOR LOCAL ---
Route::middleware(['auth', 'perfil:empreendedor'])->prefix('empreendedor')->name('empreendedor.')->group(function () {
    Route::get('/dashboard', function () {
        return view('empreendedor.dashboard');
    })->name('dashboard');

    Route::get('/cadastro-estabelecimento', function () {
        return view('empreendedor.cadastro');
    })->name('cadastro');
});


use App\Http\Controllers\Admin\RelatorioController;

// --- PAINEL ADMINISTRATIVO (PREFEITO, SECRETÁRIO, SERVIDOR) ---
Route::middleware(['auth', 'perfil:prefeito,secretario,servidor'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Exportação de Relatórios
    Route::get('/relatorios/csv', [RelatorioController::class, 'exportarCsv'])->name('relatorios.csv');
    Route::get('/relatorios/esg-pdf', [RelatorioController::class, 'exportarEsgPdf'])->name('relatorios.esg-pdf');

    // CRUD de Atrativos
    Route::resource('atrativos', AtrativoAdminController::class)->except(['show']);

    // Gestão de Empreendedores (Aprovação / Validação de Selos)
    Route::get('/empreendedores', [EmpreendedorAdminController::class, 'index'])->name('empreendedores.index');
    Route::post('/empreendedores/{empreendedor}/aprovar', [EmpreendedorAdminController::class, 'aprovar'])->name('empreendedores.aprovar');
    Route::post('/empreendedores/{empreendedor}/rejeitar', [EmpreendedorAdminController::class, 'rejeitar'])->name('empreendedores.rejeitar');
    Route::post('/empreendedores/{empreendedor}/revogar-selo', [EmpreendedorAdminController::class, 'revogarSelo'])->name('empreendedores.revogar');

    // CRUD de Eventos
    Route::resource('eventos', EventoAdminController::class)->except(['show']);

    // Gestão ESG e Relatórios
    Route::get('/esg-indicadores', function () {
        return view('admin.esg.index');
    })->name('esg.index');

    // Trilhas de Auditoria (Transparência Municipal)
    Route::get('/auditoria-logs', [AuditoriaController::class, 'index'])->name('auditoria.index');
});

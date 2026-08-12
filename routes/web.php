<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portal\HomeController;
use App\Http\Controllers\Portal\AtrativoController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes - System-PITE (Plataforma Inteligente de Turismo Municipal)
|--------------------------------------------------------------------------
*/

// --- PORTAL PÚBLICO (TURISTAS E CIDADÃOS) ---
Route::get('/', [HomeController::class, 'index'])->name('portal.home');
Route::get('/atrativos', [AtrativoController::class, 'index'])->name('portal.atrativos.index');
Route::get('/atrativos/{slug}', [AtrativoController::class, 'show'])->name('portal.atrativos.show');

Route::get('/mapa-interativo', function () {
    return view('portal.mapa');
})->name('portal.mapa');

Route::get('/roteiros-inteligentes', function () {
    return view('portal.roteiros');
})->name('portal.roteiros');

Route::get('/esg-transparencia', function () {
    return view('portal.esg');
})->name('portal.esg');


// --- PAINEL DO EMPREENDEDOR LOCAL ---
Route::middleware(['auth'])->prefix('empreendedor')->name('empreendedor.')->group(function () {
    Route::get('/dashboard', function () {
        return view('empreendedor.dashboard');
    })->name('dashboard');
    
    Route::get('/cadastro-estabelecimento', function () {
        return view('empreendedor.cadastro');
    })->name('cadastro');
});


// --- PAINEL ADMINISTRATIVO (PREFEITO, SECRETÁRIO, SERVIDOR) ---
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Gestão de Empreendedores (Aprovação / Validação de Selos)
    Route::get('/empreendedores', function () {
        return view('admin.empreendedores.index');
    })->name('empreendedores.index');

    // Gestão ESG e Relatórios
    Route::get('/esg-indicadores', function () {
        return view('admin.esg.index');
    })->name('esg.index');
    
    // Trilhas de Auditoria (Transparência Municipal)
    Route::get('/auditoria-logs', function () {
        return view('admin.auditoria.index');
    })->name('auditoria.index');
});

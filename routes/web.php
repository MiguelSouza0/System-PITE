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
use App\Http\Controllers\Admin\AprovacaoController;
use App\Http\Controllers\Admin\RelatorioController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Empreendedor\EmpreendedorDashboardController;
use App\Http\Controllers\Portal\TuristaAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes - System-PITE (Plataforma Inteligente de Turismo Municipal)
|--------------------------------------------------------------------------
*/

// --- AUTENTICAÇÃO UNIFICADA E ACESSO RÁPIDO (TELA ÚNICA) ---
Route::get('/login', [TuristaAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [TuristaAuthController::class, 'login']);
Route::get('/turista/login', [TuristaAuthController::class, 'showLogin'])->name('turista.login');
Route::post('/turista/login', [TuristaAuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/quick-login/{perfil}', [AuthController::class, 'quickLogin'])->name('quick-login');

// --- CADASTRO DE CONTAS (TURISTA E EMPREENDEDOR) ---
Route::get('/turista/registro', [TuristaAuthController::class, 'showRegistro'])->name('turista.registro');
Route::post('/turista/registro', [TuristaAuthController::class, 'registro']);
Route::get('/empreendedor/registro', [TuristaAuthController::class, 'showRegistroEmpreendedor'])->name('empreendedor.registro');
Route::post('/empreendedor/registro', [TuristaAuthController::class, 'registroEmpreendedor'])->name('empreendedor.registro.store');
Route::get('/cadastre-se', [TuristaAuthController::class, 'showRegistro'])->name('cadastre-se');


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
use App\Http\Controllers\Portal\AiAssistantController;

Route::get('/roteiros-inteligentes', [RoteiroController::class, 'index'])->name('portal.roteiros');
Route::post('/roteiros-inteligentes/gerar', [RoteiroController::class, 'gerar'])->name('portal.roteiros.gerar');
Route::get('/roteiros/{slug}', [RoteiroController::class, 'show'])->name('portal.roteiros.show');
Route::get('/roteiro-offline/{slug?}', [RoteiroController::class, 'offline'])->name('portal.roteiros.offline');
Route::get('/api/roteiros/{id}/offline-data', [RoteiroController::class, 'offlineData'])->name('api.roteiros.offline-data');

// --- API DE INTELIGÊNCIA ARTIFICIAL (SEÇÃO 6) ---
Route::post('/api/ia/chat', [AiAssistantController::class, 'chat'])->name('api.ia.chat');
Route::post('/api/ia/traduzir', [AiAssistantController::class, 'traduzir'])->name('api.ia.traduzir');
Route::post('/api/ia/gerar-descricao', [AiAssistantController::class, 'gerarDescricao'])->name('api.ia.gerar-descricao');
Route::get('/api/ia/sentimento', [AiAssistantController::class, 'analiseSentimento'])->name('api.ia.sentimento');

Route::get('/eventos', [EventoController::class, 'index'])->name('portal.eventos.index');
Route::get('/eventos/{slug}', [EventoController::class, 'show'])->name('portal.eventos.show');

Route::get('/esg-transparencia', function () {
    return view('portal.esg');
})->name('portal.esg');

use App\Http\Controllers\Portal\TuristaDashboardController;

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
    Route::get('/dashboard', [EmpreendedorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/cadastro-estabelecimento', [EmpreendedorDashboardController::class, 'create'])->name('cadastro');
    Route::post('/cadastro-estabelecimento', [EmpreendedorDashboardController::class, 'store'])->name('cadastro.store');
});


// --- PAINEL ADMINISTRATIVO ---
// Rotas compartilhadas (leitura/dashboard): prefeito, secretário, servidor
Route::middleware(['auth', 'perfil:prefeito,secretario,servidor'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Listagem de Atrativos (somente leitura para o Prefeito)
    Route::get('/atrativos', [AtrativoAdminController::class, 'index'])->name('atrativos.index');

    // Listagem de Eventos (somente leitura para o Prefeito)
    Route::get('/eventos', [EventoAdminController::class, 'index'])->name('eventos.index');

    // Listagem de Empreendedores
    Route::get('/empreendedores', [EmpreendedorAdminController::class, 'index'])->name('empreendedores.index');

    // Exportação de Relatórios
    Route::get('/relatorios/csv', [RelatorioController::class, 'exportarCsv'])->name('relatorios.csv');
    Route::get('/relatorios/esg-pdf', [RelatorioController::class, 'exportarEsgPdf'])->name('relatorios.esg-pdf');

    // Gestão ESG e Relatórios
    Route::get('/esg-indicadores', function () {
        return view('admin.esg.index');
    })->name('esg.index');

    // Trilhas de Auditoria (Transparência Municipal)
    Route::get('/auditoria-logs', [AuditoriaController::class, 'index'])->name('auditoria.index');
});

// Rotas de CRUD (criação/edição/exclusão): apenas servidor/técnico
Route::middleware(['auth', 'perfil:servidor'])->prefix('admin')->name('admin.')->group(function () {
    // CRUD de Atrativos (exceto index que já está no grupo compartilhado)
    Route::get('/atrativos/create', [AtrativoAdminController::class, 'create'])->name('atrativos.create');
    Route::post('/atrativos', [AtrativoAdminController::class, 'store'])->name('atrativos.store');
    Route::get('/atrativos/{atrativo}/edit', [AtrativoAdminController::class, 'edit'])->name('atrativos.edit');
    Route::put('/atrativos/{atrativo}', [AtrativoAdminController::class, 'update'])->name('atrativos.update');
    Route::delete('/atrativos/{atrativo}', [AtrativoAdminController::class, 'destroy'])->name('atrativos.destroy');

    // CRUD de Eventos (exceto index)
    Route::get('/eventos/create', [EventoAdminController::class, 'create'])->name('eventos.create');
    Route::post('/eventos', [EventoAdminController::class, 'store'])->name('eventos.store');
    Route::get('/eventos/{evento}/edit', [EventoAdminController::class, 'edit'])->name('eventos.edit');
    Route::put('/eventos/{evento}', [EventoAdminController::class, 'update'])->name('eventos.update');
    Route::delete('/eventos/{evento}', [EventoAdminController::class, 'destroy'])->name('eventos.destroy');
});

// Rotas de supervisão e aprovação: Prefeito e Secretário
Route::middleware(['auth', 'perfil:prefeito,secretario'])->prefix('admin')->name('admin.')->group(function () {
    // Gestão e Homologação de Empreendedores
    Route::post('/empreendedores/{empreendedor}/aprovar', [EmpreendedorAdminController::class, 'aprovar'])->name('empreendedores.aprovar');
    Route::post('/empreendedores/{empreendedor}/rejeitar', [EmpreendedorAdminController::class, 'rejeitar'])->name('empreendedores.rejeitar');
    Route::post('/empreendedores/{empreendedor}/revogar-selo', [EmpreendedorAdminController::class, 'revogarSelo'])->name('empreendedores.revogar');

    // Aprovações de Atrativos e Eventos
    Route::prefix('aprovacao')->name('aprovacao.')->group(function () {
        Route::get('/pendentes', [AprovacaoController::class, 'pendentes'])->name('pendentes');

        // Aprovação de Atrativos
        Route::post('/atrativos/{atrativo}/aprovar', [AprovacaoController::class, 'aprovarAtrativo'])->name('atrativos.aprovar');
        Route::post('/atrativos/{atrativo}/rejeitar', [AprovacaoController::class, 'rejeitarAtrativo'])->name('atrativos.rejeitar');
        Route::post('/atrativos/{atrativo}/suspender', [AprovacaoController::class, 'suspenderAtrativo'])->name('atrativos.suspender');

        // Aprovação de Eventos
        Route::post('/eventos/{evento}/aprovar', [AprovacaoController::class, 'aprovarEvento'])->name('eventos.aprovar');
        Route::post('/eventos/{evento}/rejeitar', [AprovacaoController::class, 'rejeitarEvento'])->name('eventos.rejeitar');
        Route::post('/eventos/{evento}/suspender', [AprovacaoController::class, 'suspenderEvento'])->name('eventos.suspender');
    });
});

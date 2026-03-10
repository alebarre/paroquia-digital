<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FielController;
use App\Http\Controllers\SacramentoController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\FinancaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class , 'index'])->name('dashboard');

    // Fiéis
    Route::resource('fieis', FielController::class)->parameters(['fieis' => 'fiel']);

    // Sacramentos
    Route::resource('sacramentos', SacramentoController::class);
    Route::get('sacramentos/{sacramento}/certidao', [SacramentoController::class , 'certidao'])
        ->name('sacramentos.certidao');

    // Grupos
    Route::resource('grupos', GrupoController::class);
    Route::post('grupos/{grupo}/membros', [GrupoController::class , 'addMembro'])->name('grupos.membros.add');
    Route::delete('grupos/{grupo}/membros/{fiel}', [GrupoController::class , 'removeMembro'])->name('grupos.membros.remove');

    // Eventos
    Route::resource('eventos', EventoController::class);

    // Finanças
    Route::resource('financas', FinancaController::class);

    // Usuários (Apenas admin)
    Route::resource('usuarios', UsuarioController::class)
        ->middleware('role:admin');

    // Perfil (Breeze)
    Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
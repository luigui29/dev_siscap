<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProgramacionController;
use App\Http\Controllers\RrhhPersonalController;
use App\Livewire\ConfiguracionView;
use App\Livewire\DashboardView;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardView::class)->name('dashboard');
    Route::get('/perfiles/{pestania?}', [RrhhPersonalController::class, 'index'])->name('perfiles');
    Route::get('/programacion/{pestania?}', [ProgramacionController::class, 'index'])->name('programacion');
    Route::get('/configuracion/{pestania?}', ConfiguracionView::class)->name('configuracion');
});

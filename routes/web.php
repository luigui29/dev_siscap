<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Livewire\DashboardView;
use App\Livewire\PerfilesView;
use App\Livewire\ProgramacionView;
use App\Livewire\ConfiguracionView;

Route::get('/', function () {
     return redirect('/dashboard');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
     /*Route::get('/dashboard', DashboardView::class)->name('dashboard');*/
     Route::get('/dashboard', function() {
          return view('perfiles');
     });
     Route::get('/perfiles/{pestania?}', PerfilesView::class)->name('perfiles');
     Route::get('/programacion/{pestania?}', ProgramacionView::class)->name('programacion');
     Route::get('/configuracion/{pestania?}', ConfiguracionView::class)->name('configuracion');
});

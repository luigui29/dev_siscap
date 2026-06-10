<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\DashboardView;
use App\Livewire\PerfilesView;
use App\Livewire\ProgramacionView;
use App\Livewire\ConfiguracionView;

Route::get('/', function () {
     return redirect('/dashboard');
});

Route::get('/dashboard', DashboardView::class)->name('dashboard');
Route::get('/perfiles', PerfilesView::class)->name('perfiles');
Route::get('/programacion', ProgramacionView::class)->name('programacion');
Route::get('/configuracion', ConfiguracionView::class)->name('configuracion');

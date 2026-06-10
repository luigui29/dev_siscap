<?php

namespace App\Livewire;

use App\Models\Programacion;
use Livewire\Component;

class DashboardView extends Component
{
     public $cursos;

     public function mount()
     {
          $this->cursos = collect();
          try {
               $this->cursos = Programacion::orderBy('fecha', 'desc')->take(5)->get();
          } catch (\Exception $e) {
               // Fallback si la tabla aún no existe o da error
          }
     }

     public function render()
     {
          return view('livewire.dashboard-view')->layout('components.layouts.app');
     }
}

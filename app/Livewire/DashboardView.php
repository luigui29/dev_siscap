<?php

namespace App\Livewire;

use App\Models\Programacion;
use Livewire\Component;

class DashboardView extends Component
{
     #[\Livewire\Attributes\Url]
     public $year;
     
     #[\Livewire\Attributes\Url]
     public $month;

     public $cursos;

     public function mount()
     {
          $this->year = request()->query('year', now()->year);
          $this->month = request()->query('month', now()->month);
          $this->cursos = collect();
          try {
               $this->cursos = Programacion::orderBy('fecha', 'desc')->take(5)->get();
          } catch (\Exception $e) {
               // Fallback si la tabla aún no existe o da error
          }
     }

     #[\Livewire\Attributes\On('fecha_cambiada')]
     public function actualizarFecha($year, $month)
     {
          $this->year = $year;
          $this->month = $month;
     }

     public function render()
     {
          $totales_anio = 0;
          $ejecutados_mes = 0;
          $finales_mes = 0;
          $pre_mes = 0;

          try {
               // Cursos Totales en este Año (Año actual)
               $totales_anio = Programacion::whereRaw("EXTRACT(YEAR FROM fecha) = ?", [now()->year])->count();
               
               // Ejecutados este Mes (Mes y Año seleccionados)
               $ejecutados_mes = Programacion::whereRaw("EXTRACT(YEAR FROM fecha) = ?", [$this->year])
                                        ->whereRaw("EXTRACT(MONTH FROM fecha) = ?", [$this->month])
                                        ->where('ejecutado', true)->count();
                                        
               // Programaciones Finales este Mes
               $finales_mes = Programacion::whereRaw("EXTRACT(YEAR FROM fecha) = ?", [$this->year])
                                        ->whereRaw("EXTRACT(MONTH FROM fecha) = ?", [$this->month])
                                        ->where('aprobado', true)->whereNull('ejecutado')->count();
                                        
               // Pre-Programaciones este Mes
               $pre_mes = Programacion::whereRaw("EXTRACT(YEAR FROM fecha) = ?", [$this->year])
                                        ->whereRaw("EXTRACT(MONTH FROM fecha) = ?", [$this->month])
                                        ->whereNull('aprobado')->count();
          } catch (\Exception $e) { }

          return view('livewire.dashboard-view', [
               'totales_anio' => $totales_anio,
               'ejecutados_mes' => $ejecutados_mes,
               'finales_mes' => $finales_mes,
               'pre_mes' => $pre_mes,
          ])->layout('components.layouts.app');
     }
}

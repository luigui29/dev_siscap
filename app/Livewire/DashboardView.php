<?php

namespace App\Livewire;

use App\Models\Programacion;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

class DashboardView extends Component
{
     #[Url]
     public $year;
     
     #[Url]
     public $month;

     public $cursos;

     // Filtros
     public $filtro_area = '';
     public $filtro_actividad = '';
     public $filtro_subactividad = '';
     public $filtro_facilitador = '';
     public $filtro_institucion = '';
     public $filtro_fecha_desde = '';
     public $filtro_fecha_hasta = '';
     public $filtro_lugar = '';

     public function mount()
     {
          $this->year = request()->query('year', now()->year);
          $this->month = request()->query('month', now()->month);
          $this->cursos = collect();
     }

     public function getAreasProperty()
     {
          return \App\Models\Area::all();
     }

     public function getActividadesProperty()
     {
          return \App\Models\Actividad::all();
     }

     public function getSubactividadesProperty()
     {
          return \App\Models\Subactividad::all();
     }

     public function getFacilitadoresProperty()
     {
          return \App\Models\Facilitador::all();
     }

     public function limpiarFiltrosBusqueda()
     {
          $this->reset(['filtro_area', 'filtro_actividad', 'filtro_subactividad', 'filtro_facilitador', 'filtro_institucion', 'filtro_fecha_desde', 'filtro_fecha_hasta', 'filtro_lugar']);
     }

     #[On('fecha_cambiada')]
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
               $query = Programacion::with(['actividad.area', 'subactividad', 'facilitador']);

               if ($this->filtro_area) {
                    $query->whereHas('actividad', function ($q) {
                         $q->where('area_id', $this->filtro_area);
                    });
               }
               if ($this->filtro_actividad) {
                    $query->whereHas('actividad', function ($q) {
                         $q->where('nombre', 'ilike', '%' . $this->filtro_actividad . '%');
                    });
               }
               if ($this->filtro_subactividad) {
                    $query->whereHas('subactividad', function ($q) {
                         $q->where('nombre', 'ilike', '%' . $this->filtro_subactividad . '%');
                    });
               }
               if ($this->filtro_facilitador) {
                    $query->whereHas('facilitador', function ($q) {
                         $q->where('nombre', 'ilike', '%' . $this->filtro_facilitador . '%');
                    });
               }
               if ($this->filtro_institucion) {
                    $query->where('institucion', 'ilike', '%' . $this->filtro_institucion . '%');
               }
               if ($this->filtro_fecha_desde) {
                    $query->whereDate('fecha', '>=', $this->filtro_fecha_desde);
               }
               if ($this->filtro_fecha_hasta) {
                    $query->whereDate('fecha', '<=', $this->filtro_fecha_hasta);
               }
               if ($this->filtro_lugar) {
                    $query->where('lugar', 'ilike', '%' . $this->filtro_lugar . '%');
               }

               // Tomar 50 resultados filtrados en vez de 10 si hay filtros, o mantener 10 si no
               $this->cursos = $query->orderBy('fecha', 'desc')->take(50)->get();

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

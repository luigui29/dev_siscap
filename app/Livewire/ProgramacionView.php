<?php

namespace App\Livewire;

use App\Models\Programacion;
use App\Models\Actividad;
use App\Models\Subactividad;
use App\Models\Area;
use App\Models\RrhhPersonal;
use App\Models\User;
use App\Models\Facilitador;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;

class ProgramacionView extends Component
{
     public $pestania_activa = 'pre';
     public $notificacion = null;
     
     // Campos para rellenar
     public $id_area_seleccionada = '';
     public $actividad_input = '';
     public $subactividad_input = '';
     public $facilitador_input = '';
     public $institucion_input = 'VENPRECAR, C.A.';
     public $fecha_input = '';
     public $lugar_input = '';
     public $desde_input = '';
     public $hasta_input = '';
     public $duracion_input = 0;
     public $es_entrada_extra = false;
     public $id_propuesta_editando = null;
     public $modo = 'registro';              // 'registro' o 'busqueda'
     public $resultados_busqueda = [];     

     // Filtros para empleados
     public $filtro_ficha = '';
     public $filtro_cedula = '';
     public $filtro_nombre = '';
     public $filtro_cargo = '';
     public $filtro_gerencia = '';
     public $filtro_unidad = '';

     public $participantes_seleccionados = [];
     public $seleccionar_todos = false;
     
     public $id_ejecucion_seleccionada = null;
     public $asistentes_fichas = [];

     public function mount($pestania = null)
     {
          if ($pestania) {
               $this->pestania_activa = $pestania;
          }
     }

     // Método para cambiar de modo (registro o búsqueda)
     public function cambiarModo($modo)
     {
          $this->cancelarEdicionPropuesta();
          $this->modo = $modo;
          
          if ($modo === 'busqueda') {
               $this->participantes_seleccionados = [];
               $this->limpiarFiltrosEmpleados();
               $this->resultados_busqueda = [];
          } else {
               $this->resultados_busqueda = [];
          }
     }

     public function getAreasProperty()
     {
          return Area::all();
     }

     public function getActividadesProperty()
     {
          return Actividad::all();
     }

     public function getSubactividadesProperty()
     {
          return Subactividad::all();
     }

     public function getFacilitadoresProperty()
     {
          return Facilitador::all();
     }

     public function getPropuestasProperty()
     {
          return Programacion::orderBy('id', 'desc')->get();
     }

     public function getEmpleadosFiltradosProperty()
     {
          $query = RrhhPersonal::query();
          if ($this->filtro_ficha) {
               $query->where('ficha', 'like', "%{$this->filtro_ficha}%");
          }
          if ($this->filtro_nombre) {
               $query->where('nombre_empleado', 'ilike', "%{$this->filtro_nombre}%");
          }
          if ($this->filtro_cargo) {
               $query->where('texto_cargo', 'ilike', "%{$this->filtro_cargo}%");
          }
          if ($this->filtro_gerencia) {
               $query->where('texto_gerencia', 'ilike', "%{$this->filtro_gerencia}%");
          }
          if ($this->filtro_unidad) {
               $query->where('texto_unidad', 'ilike', "%{$this->filtro_unidad}%");
          }
          // Assuming cedula is not in RrhhPersonal, but if it is, we could add it. For now we skip filtering by cedula if it doesn't exist, or search in a user relation if needed.
          
          return $query->orderBy('nombre_empleado', 'asc')->get();
     }

     // Método para buscar programaciones según los filtros del formulario
     public function buscarPropuestas()
     {
          $query = Programacion::query();

          // Filtro por área (unimos con actividades)
          if ($this->id_area_seleccionada) {
               $query->whereHas('actividad', function ($q) {
                    $q->where('area_id', $this->id_area_seleccionada);
               });
          }

          // Filtro por nombre de actividad
          if ($this->actividad_input) {
               $query->whereHas('actividad', function ($q) {
                    $q->where('nombre', 'ilike', '%' . $this->actividad_input . '%');
               });
          }

          // Filtro por nombre de subactividad
          if ($this->subactividad_input) {
               $query->whereHas('subactividad', function ($q) {
                    $q->where('nombre', 'ilike', '%' . $this->subactividad_input . '%');
               });
          }

          // Filtro por nombre de facilitador
          if ($this->facilitador_input) {
               $query->whereHas('facilitador', function ($q) {
                    $q->where('nombre', 'ilike', '%' . $this->facilitador_input . '%');
               });
          }

          // Filtro por fecha exacta
          if ($this->fecha_input) {
               $query->whereDate('fecha', $this->fecha_input);
          }

          // Filtro por lugar (texto parcial)
          if ($this->lugar_input) {
               $query->where('lugar', 'ilike', '%' . $this->lugar_input . '%');
          }

          // Filtro por hora desde (mayor o igual)
          if ($this->desde_input) {
               $query->whereTime('desde', '>=', $this->desde_input);
          }

          // Filtro por hora hasta (menor o igual)
          if ($this->hasta_input) {
               $query->whereTime('hasta', '<=', $this->hasta_input);
          }

          $this->resultados_busqueda = $query->orderBy('id', 'desc')->get();

          if ($this->resultados_busqueda->isEmpty()) {
               $this->mostrarNotificacion('No se encontraron programaciones con esos filtros.', 'info');
          } else {
               $this->mostrarNotificacion('Se encontraron ' . $this->resultados_busqueda->count() . ' programaciones.', 'success');
          }
     }

     // Método para limpiar los filtros de búsqueda
     public function limpiarFiltrosBusqueda()
     {
          $this->id_area_seleccionada = '';
          $this->actividad_input = '';
          $this->subactividad_input = '';
          $this->facilitador_input = '';
          $this->fecha_input = '';
          $this->lugar_input = '';
          $this->desde_input = '';
          $this->hasta_input = '';
          $this->resultados_busqueda = [];
          $this->mostrarNotificacion('Filtros de búsqueda limpiados.', 'info');
     }

     public function limpiarFiltrosEmpleados()
     {
          $this->reset(['filtro_ficha', 'filtro_cedula', 'filtro_nombre', 'filtro_cargo', 'filtro_gerencia', 'filtro_unidad']);
     }

     public function limpiarNotificacion()
     {
          $this->notificacion = null;
     }

     public function updatedSeleccionarTodos($value)
     {
          $fichasVisibles = collect($this->empleadosFiltrados)->pluck('ficha')->map(fn($f) => (string) $f)->toArray();
          
          if ($value) {
               $this->participantes_seleccionados = array_values(array_unique(array_merge($this->participantes_seleccionados, $fichasVisibles)));
          } else {
               $this->participantes_seleccionados = array_values(array_diff($this->participantes_seleccionados, $fichasVisibles));
          }
     }

     public function mostrarNotificacion($mensaje, $tipo = 'success')
     {
          $this->notificacion = ['mensaje' => $mensaje, 'tipo' => $tipo];
     }

     public function updatedDesdeInput()
     {
          $this->calcularDuracion();
     }

     public function updatedHastaInput()
     {
          $this->calcularDuracion();
     }

     public function updatedIdAreaSeleccionada()
     {
          $this->actividad_input = '';
          $this->subactividad_input = '';
     }

     public function updatedActividadInput()
     {
          $this->subactividad_input = '';
     }

     public function calcularDuracion()
     {
          if ($this->desde_input && $this->hasta_input) {
               $desde = Carbon::parse($this->desde_input);
               $hasta = Carbon::parse($this->hasta_input);
               $this->duracion_input = (int) $desde->diffInHours($hasta);
          }
     }

     public function guardarPropuesta()
     {
          if ($this->modo === 'busqueda') {
               return; 
          }

          $this->validate([
               'id_area_seleccionada' => 'required',
               'actividad_input' => 'required',
               'subactividad_input' => 'required',
               'facilitador_input' => 'required',
               'institucion_input' => 'required',
               'fecha_input' => 'required',
               'lugar_input' => 'required',
               'desde_input' => 'required',
               'hasta_input' => 'required',
               'participantes_seleccionados' => 'required|array|min:1'
          ], [
               'participantes_seleccionados.required' => 'Debe seleccionar al menos un participante.',
          ]);

          $actividad = Actividad::firstOrCreate([
               'area_id' => $this->id_area_seleccionada,
               'nombre' => $this->actividad_input
          ]);

          $subactividad = Subactividad::firstOrCreate([
               'actividad_id' => $actividad->id,
               'nombre' => $this->subactividad_input
          ]);

          $facilitador = Facilitador::firstOrCreate([
               'nombre' => $this->facilitador_input
          ]);
          $facilitadorId = $facilitador->id;

          $datos = [
               'actividad_id' => $actividad->id,
               'subactividad_id' => $subactividad->id,
               'facilitador_id' => $facilitadorId,
               'institucion' => $this->institucion_input,
               'fecha' => $this->fecha_input,
               'lugar' => $this->lugar_input,
               'desde' => $this->desde_input,
               'hasta' => $this->hasta_input,
               'duracion' => $this->duracion_input,
               'extra' => $this->es_entrada_extra,
               'nombre' => $actividad->nombre,
          ];

          if ($this->id_propuesta_editando) {
               $programacion = Programacion::find($this->id_propuesta_editando);
               if ($programacion) {
                    $programacion->update($datos);
                    DB::table('pl_programaciones')->where('programacion_id', $programacion->id)->delete();
               }
          } else {
               $datos['aprobado'] = null;
               $datos['ejecutado'] = null;
               $programacion = Programacion::create($datos);
          }

          if (isset($programacion)) {
               foreach ($this->participantes_seleccionados as $ficha) {
                    DB::table('pl_programaciones')->insert([
                         'programacion_id' => $programacion->id,
                         'ficha_empleado' => $ficha,
                         'estatus' => null,
                         'causa' => null,
                         'created_at' => now(),
                         'updated_at' => now()
                    ]);
               }
          }

          $mensaje = $this->id_propuesta_editando ? 'Propuesta actualizada exitosamente.' : 'Propuesta pre-programada guardada exitosamente.';
          $this->mostrarNotificacion($mensaje);
          $this->cancelarEdicionPropuesta();
     }

     public function cargarPropuestaParaEdicion($id)
     {
          $this->modo = 'registro'; 

          $propuesta = Programacion::find($id);
          if ($propuesta) {
               $this->id_propuesta_editando = $propuesta->id;
               
               $actividad = Actividad::find($propuesta->actividad_id);
               $subactividad = Subactividad::find($propuesta->subactividad_id);
               $facilitador = Facilitador::find($propuesta->facilitador_id);
               
               $this->id_area_seleccionada = $actividad ? $actividad->area_id : '';
               $this->actividad_input = $actividad ? $actividad->nombre : '';
               $this->subactividad_input = $subactividad ? $subactividad->nombre : '';
               $this->facilitador_input = $facilitador ? $facilitador->nombre : '';
               
               $this->institucion_input = $propuesta->institucion;
               $this->fecha_input = $propuesta->fecha ? Carbon::parse($propuesta->fecha)->format('Y-m-d') : '';
               $this->lugar_input = $propuesta->lugar;
               $this->desde_input = $propuesta->desde ? Carbon::parse($propuesta->desde)->format('H:i') : '';
               $this->hasta_input = $propuesta->hasta ? Carbon::parse($propuesta->hasta)->format('H:i') : '';
               $this->duracion_input = $propuesta->duracion;
               $this->es_entrada_extra = $propuesta->extra;

               $this->participantes_seleccionados = DB::table('pl_programaciones')
                    ->where('programacion_id', $propuesta->id)
                    ->pluck('ficha_empleado')
                    ->map(fn($f) => (string) $f)
                    ->toArray();
          }
     }

     public function cancelarEdicionPropuesta()
     {
          $this->reset(['id_propuesta_editando', 'id_area_seleccionada', 'actividad_input', 'subactividad_input', 'facilitador_input', 'institucion_input', 'fecha_input', 'lugar_input', 'desde_input', 'hasta_input', 'duracion_input', 'es_entrada_extra', 'participantes_seleccionados']);
          $this->modo = 'registro';
          $this->resultados_busqueda = [];
          $this->participantes_seleccionados = [];
          $this->limpiarFiltrosEmpleados();
     }

     public function eliminarPropuesta($id)
     {
          $propuesta = Programacion::find($id);
          if ($propuesta) {
               $propuesta->delete();
               $this->mostrarNotificacion("Propuesta #$id eliminada exitosamente.");
          }
     }

     public function aprobarPropuesta($id)
     {
          $propuesta = Programacion::find($id);
          if ($propuesta) {
               $propuesta->update(['aprobado' => true]);
               $this->mostrarNotificacion("Propuesta #$id aprobada correctamente.");
          }
     }

     public function rechazarPropuesta($id)
     {
          $propuesta = Programacion::find($id);
          if ($propuesta) {
               $propuesta->update(['aprobado' => false]);
               $this->mostrarNotificacion("Propuesta #$id rechazada.", 'danger');
          }
     }

     public function iniciarEjecucion($id)
     {
          $this->id_ejecucion_seleccionada = $id;
          $this->asistentes_fichas = [];
     }

     public function alternarAsistencia($ficha)
     {
          if (in_array($ficha, $this->asistentes_fichas)) {
               $this->asistentes_fichas = array_diff($this->asistentes_fichas, [$ficha]);
          } else {
               $this->asistentes_fichas[] = $ficha;
          }
     }

     public function guardarEjecucion()
     {
          $propuesta = Programacion::find($this->id_ejecucion_seleccionada);
          if ($propuesta) {
               foreach ($this->asistentes_fichas as $ficha) {
                    DB::table('pl_programaciones')
                         ->where('programacion_id', $this->id_ejecucion_seleccionada)
                         ->where('ficha_empleado', $ficha)
                         ->update(['estatus' => true, 'updated_at' => now()]);
               }
               $propuesta->update(['ejecutado' => true]);
               $this->mostrarNotificacion('Asistencia y horas hombre registradas exitosamente.');
          }
          
          $this->id_ejecucion_seleccionada = null;
          $this->asistentes_fichas = [];
     }

     public function render()
     {
          return view('livewire.programacion-view')->layout('components.layouts.app');
     }
}

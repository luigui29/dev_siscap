<?php

namespace App\Livewire;

use App\Models\Programacion;
use App\Models\Actividad;
use App\Models\Subactividad;
use App\Models\Area;
use App\Models\RrhhPersonal;
use App\Models\PersonalProgramacion;
use App\Models\User;
use App\Models\Facilitador;
use App\Traits\GestionaFeriados;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;

class ProgramacionView extends Component
{
     use GestionaFeriados;

     public $pestania_activa = 'pre';
     public $notificacion = null;
     
     public $programacion_modal_trabajadores = [];
     public $programacion_modal_nombre = '';
     
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

     // Filtros para la búsqueda
     public $busqueda_activa = false;
     public $filtro_area = '';
     public $filtro_actividad = '';
     public $filtro_subactividad = '';
     public $filtro_facilitador = '';
     public $filtro_institucion = '';
     public $filtro_fecha_desde = '';
     public $filtro_fecha_hasta = '';
     public $filtro_lugar = '';
     public $filtro_desde = '';
     public $filtro_hasta = '';

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
     public $causas_fichas = [];

     public function mount($pestania = null)
     {
          if ($pestania) {
               $this->pestania_activa = $pestania;
          }

          if (request()->has('edit_id')) {
               $this->cargarPropuestaParaEdicion(request()->query('edit_id'));
          }

          if (request()->has('exec_id')) {
               $this->iniciarEjecucion(request()->query('exec_id'));
          }

          if (request()->has('filter_id')) {
               $this->cargarPropuestaParaFiltro(request()->query('filter_id'));
          }
     }

     public function cargarPropuestaParaFiltro($id)
     {
          $propuesta = Programacion::with(['actividad', 'subactividad', 'facilitador'])->find($id);
          if ($propuesta) {
               $this->filtro_area = $propuesta->actividad->area_id ?? '';
               $this->filtro_actividad = $propuesta->actividad->nombre ?? '';
               $this->filtro_subactividad = $propuesta->subactividad->nombre ?? '';
               $this->filtro_facilitador = $propuesta->facilitador->nombre ?? '';
               $this->filtro_institucion = $propuesta->institucion ?? '';
               $this->filtro_fecha_desde = $propuesta->fecha ? Carbon::parse($propuesta->fecha)->format('Y-m-d') : '';
               $this->filtro_fecha_hasta = $propuesta->fecha ? Carbon::parse($propuesta->fecha)->format('Y-m-d') : '';
               $this->filtro_lugar = $propuesta->lugar ?? '';
               
               $this->buscarPropuestas();
          }
     }

     // Método para cambiar de modo (registro o búsqueda)
     public function cambiarModo($modo)
     {
          $this->cancelarEdicionPropuesta();
          $this->modo = $modo;
          $this->busqueda_activa = false;
          
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
          return Programacion::with(['facilitador'])->withCount('participantes')->orderBy('id', 'desc')->get();
     }

     public function getSubactividadesOpcionesProperty()
     {
          $actividadSeleccionada = collect($this->actividades)->where('nombre', $this->actividad_input)->first();
          return $actividadSeleccionada ? $this->subactividades->where('actividad_id', $actividadSeleccionada->id) : collect([]);
     }

     public function getListaPreProperty()
     {
          return ($this->busqueda_activa) ? collect($this->resultados_busqueda)->map(fn($item) => (object) $item) : $this->propuestas->whereNull('aprobado');
     }

     public function getListaFinalProperty()
     {
          $lista = $this->busqueda_activa ? collect($this->resultados_busqueda)->map(fn($item) => (object) $item) : $this->propuestas;
          return collect($lista)->whereNull('ejecutado');
     }

     public function getListaEjecucionProperty()
     {
          $lista = $this->busqueda_activa ? collect($this->resultados_busqueda)->map(fn($item) => (object) $item) : $this->propuestas;
          return collect($lista)->where('aprobado', true);
     }

     public function getParticipantesAsistenciaProperty()
     {
          if (!$this->id_ejecucion_seleccionada) return collect([]);
          $fichas = PersonalProgramacion::where('programacion_id', $this->id_ejecucion_seleccionada)->pluck('ficha_empleado');
          return RrhhPersonal::whereIn('ficha', $fichas)->get();
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
          // Limitar los resultados a los primeros 50 para evitar errores de memoria al escribir términos cortos
          return $query->orderBy('nombre_empleado', 'asc')->take(50)->get();
     }

     // Detectar cambios en las variables de filtro y ejecutar la búsqueda dinámicamente
     public function updated($propertyName)
     {
          if (str_starts_with($propertyName, 'filtro_')) {
               if (in_array($propertyName, ['filtro_area', 'filtro_actividad', 'filtro_subactividad', 'filtro_facilitador', 'filtro_institucion', 'filtro_lugar', 'filtro_fecha_desde', 'filtro_fecha_hasta', 'filtro_desde', 'filtro_hasta'])) {
                    $this->buscarPropuestas();
               }
          }
     }

     // Método para buscar programaciones según los filtros del formulario
     public function buscarPropuestas()
     {
          // Eager load para prevenir problemas N+1 
          $query = Programacion::with(['actividad', 'subactividad', 'facilitador'])->withCount('participantes');

          // Filtro por área (unimos con actividades)
          if ($this->filtro_area) {
               $query->whereHas('actividad', function ($q) {
                    $q->where('area_id', $this->filtro_area);
               });
          }

          // Filtro por nombre de actividad
          if ($this->filtro_actividad) {
               $query->whereHas('actividad', function ($q) {
                    $q->where('nombre', 'ilike', '%' . $this->filtro_actividad . '%');
               });
          }

          // Filtro por nombre de subactividad
          if ($this->filtro_subactividad) {
               $query->whereHas('subactividad', function ($q) {
                    $q->where('nombre', 'ilike', '%' . $this->filtro_subactividad . '%');
               });
          }

          // Filtro por nombre de facilitador
          if ($this->filtro_facilitador) {
               $query->whereHas('facilitador', function ($q) {
                    $q->where('nombre', 'ilike', '%' . $this->filtro_facilitador . '%');
               });
          }
          
          // Filtro por rango de fecha
          if ($this->filtro_fecha_desde) {
               $query->whereDate('fecha', '>=', $this->filtro_fecha_desde);
          }
          if ($this->filtro_fecha_hasta) {
               $query->whereDate('fecha', '<=', $this->filtro_fecha_hasta);
          }

          // Filtro por lugar (texto parcial)
          if ($this->filtro_lugar) {
               $query->where('lugar', 'ilike', '%' . $this->filtro_lugar . '%');
          }
          
          // Filtro por institución (texto parcial)
          if ($this->filtro_institucion) {
               $query->where('institucion', 'ilike', '%' . $this->filtro_institucion . '%');
          }

          // Filtro por hora desde (mayor o igual)
          if ($this->filtro_desde) {
               $query->whereTime('desde', '>=', $this->filtro_desde);
          }

          // Filtro por hora hasta (menor o igual)
          if ($this->filtro_hasta) {
               $query->whereTime('hasta', '<=', $this->filtro_hasta);
          }

          $this->resultados_busqueda = $query->orderBy('id', 'desc')->get();
          $this->busqueda_activa = true;

          // Si todos los filtros están vacíos, desactivar búsqueda activa
          if (empty($this->filtro_area) && empty($this->filtro_actividad) && empty($this->filtro_subactividad) && empty($this->filtro_facilitador) && empty($this->filtro_institucion) && empty($this->filtro_lugar) && empty($this->filtro_fecha_desde) && empty($this->filtro_fecha_hasta) && empty($this->filtro_desde) && empty($this->filtro_hasta)) {
               $this->busqueda_activa = false;
               $this->resultados_busqueda = [];
          }

          if ($this->busqueda_activa) {
               if ($this->resultados_busqueda->isEmpty()) {
                    $this->mostrarNotificacion('No se encontraron programaciones con esos filtros.', 'info');
               } else {
                    $this->mostrarNotificacion('Se encontraron ' . $this->resultados_busqueda->count() . ' programaciones.', 'success');
               }
          }
     }

     // Método para limpiar los filtros de búsqueda
     public function limpiarFiltrosBusqueda()
     {
          $this->filtro_area = '';
          $this->filtro_actividad = '';
          $this->filtro_subactividad = '';
          $this->filtro_facilitador = '';
          $this->filtro_institucion = '';
          $this->filtro_fecha_desde = '';
          $this->filtro_fecha_hasta = '';
          $this->filtro_lugar = '';
          $this->filtro_desde = '';
          $this->filtro_hasta = '';
          $this->resultados_busqueda = [];
          $this->busqueda_activa = false;
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
     
     public function updatedFiltroArea()
     {
          $this->filtro_actividad = '';
          $this->filtro_subactividad = '';
     }

     public function updatedFiltroActividad()
     {
          $this->filtro_subactividad = '';
     }

     public function calcularDuracion()
     {
          if ($this->desde_input && $this->hasta_input) {
               $desde = Carbon::parse($this->desde_input);
               $hasta = Carbon::parse($this->hasta_input);
               $this->duracion_input = (int) $desde->diffInHours($hasta);
          }
     }

     public function updatedFechaInput()
     {
          if ($this->fecha_input) {
               $fecha = Carbon::parse($this->fecha_input);
               if ($fecha->isWeekend() || $this->esFeriado($fecha)) {
                    $this->fecha_input = '';
                    $this->mostrarNotificacion('La fecha seleccionada corresponde a un fin de semana o día feriado. Por favor, seleccione un día hábil.', 'danger');
               }
          }
     }

     public function guardarPropuesta()
     {
          if ($this->modo === 'busqueda') {
               return; 
          }

          if ($this->fecha_input) {
               $fecha = Carbon::parse($this->fecha_input);
               if ($fecha->isWeekend() || $this->esFeriado($fecha)) {
                    $this->mostrarNotificacion('La fecha seleccionada es inválida (fin de semana o feriado).', 'danger');
                    return;
               }
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

     public function nulificarPropuesta($id)
     {
          $propuesta = Programacion::find($id);
          if ($propuesta) {
               $propuesta->update(['aprobado' => null]);
               $this->mostrarNotificacion("Estatus de propuesta #$id cambiado", 'danger');
          }
     }

     public function modalProgramacionEmpleados($id)
     {
          $propuesta = Programacion::find($id);
          if ($propuesta) {
               $this->programacion_modal_nombre = $propuesta->nombre;
               $fichas = PersonalProgramacion::where('programacion_id', $propuesta->id)->pluck('ficha_empleado');
               $this->programacion_modal_trabajadores = RrhhPersonal::whereIn('ficha', $fichas)->orderBy('nombre_empleado', 'asc')->get();
               
               $this->dispatch('abrir-modal-programacion-trabajadores');
          }
     }

     public function iniciarEjecucion($id)
     {
          $this->id_ejecucion_seleccionada = $id;
          $this->asistentes_fichas = DB::table('pl_programaciones')
               ->where('programacion_id', $id)
               ->where('estatus', true)
               ->pluck('ficha_empleado')
               ->toArray();
               
          $this->causas_fichas = DB::table('pl_programaciones')
               ->where('programacion_id', $id)
               ->whereNotNull('causa')
               ->pluck('causa', 'ficha_empleado')
               ->toArray();
     }

     public function deshacerEjecucion($id)
     {
          $ejecucion = Programacion::find($id);
          if ($ejecucion) {
               DB::table('pl_programaciones')
                    ->where('programacion_id', $id)
                    ->update(['estatus' => null, 'causa' => null, 'updated_at' => now()]);

               $ejecucion->update(['ejecutado' => null]);
               $this->mostrarNotificacion("Estatus de curso #$id cambiado", 'danger');
               
               if ($this->id_ejecucion_seleccionada == $id) {
                    $this->asistentes_fichas = [];
                    $this->causas_fichas = [];
               }
          }
     }

     public function guardarEjecucion()
     {
          $propuesta = Programacion::find($this->id_ejecucion_seleccionada);
          if ($propuesta) {
               $fichas_totales = DB::table('pl_programaciones')->where('programacion_id', $this->id_ejecucion_seleccionada)->pluck('ficha_empleado');

               foreach ($fichas_totales as $ficha) {
                    $estatus = in_array($ficha, $this->asistentes_fichas) ? true : false;
                    $causa = $this->causas_fichas[$ficha] ?? null;

                    DB::table('pl_programaciones')
                         ->where('programacion_id', $this->id_ejecucion_seleccionada)
                         ->where('ficha_empleado', $ficha)
                         ->update([
                              'estatus' => $estatus,
                              'causa' => $causa ?: null,
                              'updated_at' => now()
                         ]);
               }

               $propuesta->update(['ejecutado' => true]);
               $this->mostrarNotificacion('Asistencias registradas exitosamente.');
          }
          
          $this->cancelarEjecucion();
     }

     public function cancelarEjecucion()
     {
          $this->id_ejecucion_seleccionada = null;
          $this->asistentes_fichas = [];
          $this->causas_fichas = [];
     }

     public function render()
     {
          return view('livewire.programacion-view')->layout('components.layouts.app');
     }
}

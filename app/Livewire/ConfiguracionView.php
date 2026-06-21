<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Role;
use App\Models\Area;
use App\Models\Actividad;
use App\Models\Subactividad;
use App\Models\Facilitador;
use App\Models\RrhhPersonal;
use Livewire\Component;

class ConfiguracionView extends Component
{
     public $pestania_activa = 'roles';
     public $notificacion = null;
     
     public $termino_busqueda = '';
     public $ficha_usuario_seleccionado = '';
     public $rol_objetivo = 'Analista';
     
     public $area_nombre = '';
     public $area_descripcion = '';
     public $area_estatus = true;
     public $id_area_editando = null;

     // Actividades
     public $actividad_nombre = '';
     public $actividad_objetivo = '';
     public $actividad_area_id = '';
     public $id_actividad_editando = null;

     // Subactividades
     public $subactividad_nombre = '';
     public $subactividad_objetivo = '';
     public $subactividad_actividad_id = '';
     public $id_subactividad_editando = null;

     // Facilitadores
     public $facilitador_nombre = '';
     public $facilitador_ficha_empleado = '';
     public $id_facilitador_editando = null;

     // Filtro Empleados
     public $filtro_ficha = '';
     public $filtro_cedula = '';
     public $filtro_nombre = '';
     public $filtro_cargo = '';
     public $filtro_gerencia = '';
     public $filtro_unidad = '';

     public $usuarios = [];
     public $areas = [];
     public $actividades = [];
     public $subactividades = [];
     public $facilitadores = [];

     // Filtros
     public $filtro_actividad = '';
     public $filtro_subactividad = '';
     public $filtro_facilitador = '';

     public function buscar()
     {
          // Solo para disparar el loading
     }

     public function mount($pestania = null)
     {
          if ($pestania) {
               $this->pestania_activa = $pestania;
          }
          $this->cargarDatos();
     }

     public function cargarDatos()
     {
          try {
               $this->usuarios = User::all();
               $this->areas = Area::all()->toArray();
               $this->actividades = Actividad::with('area')->get()->toArray();
               $this->subactividades = Subactividad::with('actividad')->get()->toArray();
               $this->facilitadores = Facilitador::all()->toArray();
          } catch (\Exception $excepcion) {
               $this->usuarios = collect([]);
               $this->areas = [];
               $this->actividades = [];
               $this->subactividades = [];
               $this->facilitadores = [];
          }
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
          return $query->orderBy('nombre_empleado', 'asc')->take(50)->get();
     }

     public function getEmpleadosConRolesProperty()
     {
          $plRoles = \Illuminate\Support\Facades\DB::table('pl_roles')
               ->join('roles', 'pl_roles.rol_id', '=', 'roles.id')
               ->select('pl_roles.ficha_empleado', 'roles.nombre as rol_nombre', 'pl_roles.fecha_asignado')
               ->get();

          $fichas = $plRoles->pluck('ficha_empleado');
          $empleados = RrhhPersonal::whereIn('ficha', $fichas)->get()->keyBy('ficha');

          $resultado = [];
          foreach ($plRoles as $pr) {
               if ($empleados->has($pr->ficha_empleado)) {
                    $emp = $empleados->get($pr->ficha_empleado);
                    $resultado[] = (object) [
                         'ficha' => $emp->ficha,
                         'nombre_empleado' => $emp->nombre_empleado,
                         'texto_cargo' => $emp->texto_cargo,
                         'rol_nombre' => $pr->rol_nombre,
                         'fecha_asignado' => $pr->fecha_asignado
                    ];
               }
          }
          return collect($resultado)->sortByDesc('fecha_asignado');
     }

     public function limpiarFiltrosEmpleados()
     {
          $this->reset(['filtro_ficha', 'filtro_cedula', 'filtro_nombre', 'filtro_cargo', 'filtro_gerencia', 'filtro_unidad']);
     }

     public function seleccionarEmpleadoComoFacilitador($ficha, $nombre)
     {
          $this->facilitador_ficha_empleado = $ficha;
          $this->facilitador_nombre = $nombre;
          $this->mostrarNotificacion("Empleado {$nombre} seleccionado.");
     }

     public function limpiarNotificacion()
     {
          $this->notificacion = null;
     }

     public function mostrarNotificacion($mensaje, $tipo = 'success')
     {
          $this->notificacion = ['mensaje' => $mensaje, 'tipo' => $tipo];
     }

     public function asignarRol()
     {
          $this->validate([
               'ficha_usuario_seleccionado' => 'required',
               'rol_objetivo' => 'required|string'
          ]);

          $rol = Role::where('nombre', $this->rol_objetivo)->first();
          if (!$rol) {
               $this->mostrarNotificacion('El rol seleccionado no existe.', 'danger');
               return;
          }

          \Illuminate\Support\Facades\DB::table('pl_roles')->updateOrInsert(
               ['ficha_empleado' => $this->ficha_usuario_seleccionado],
               [
                    'rol_id' => $rol->id,
                    'fecha_asignado' => now()
               ]
          );

          $this->mostrarNotificacion("Rol de {$this->rol_objetivo} asignado correctamente.");
          $this->ficha_usuario_seleccionado = '';
     }

     public function revocarRol($ficha)
     {
          \Illuminate\Support\Facades\DB::table('pl_roles')->where('ficha_empleado', $ficha)->delete();
          $this->mostrarNotificacion('Rol revocado exitosamente.');
     }

     // CRUD Áreas
     public function agregarOEditarArea()
     {
          if ($this->id_area_editando) {
               $area = Area::find($this->id_area_editando);
               if ($area) {
                    $area->update([
                         'nombre' => $this->area_nombre,
                         'descripcion' => $this->area_descripcion,
                         'estatus' => $this->area_estatus,
                    ]);
               }
          } else {
               Area::create([
                    'nombre' => $this->area_nombre,
                    'descripcion' => $this->area_descripcion,
                    'estatus' => $this->area_estatus,
               ]);
          }

          $mensaje = $this->id_area_editando ? 'Área actualizada.' : 'Nueva área agregada.';
          $this->mostrarNotificacion($mensaje);
          $this->id_area_editando = null;
          $this->area_nombre = '';
          $this->area_descripcion = '';
          $this->cargarDatos();
     }

     public function iniciarEdicionArea($id)
     {
          $area = Area::find($id);
          if ($area) {
               $this->id_area_editando = $id;
               $this->area_nombre = $area->nombre;
               $this->area_descripcion = $area->descripcion;
               $this->area_estatus = $area->estatus;
          }
     }

     public function alternarEstatusArea($id)
     {
          $area = Area::find($id);
          if ($area) {
               $area->update(['estatus' => !$area->estatus]);
               $this->mostrarNotificacion('Estatus de área modificado.');
               $this->cargarDatos();
          }
     }

     public function eliminarArea($id)
     {
          $area = Area::find($id);
          if ($area) {
               $area->delete();
               $this->mostrarNotificacion('Área eliminada del sistema.', 'danger');
               $this->cargarDatos();
          }
     }

     // CRUD Actividades
     public function agregarOEditarActividad()
     {
          $this->validate([
               'actividad_nombre' => 'required',
               'actividad_area_id' => 'required'
          ]);

          if ($this->id_actividad_editando) {
               $actividad = Actividad::find($this->id_actividad_editando);
               if ($actividad) {
                    $actividad->update([
                         'nombre' => $this->actividad_nombre,
                         'objetivo' => $this->actividad_objetivo,
                         'area_id' => $this->actividad_area_id,
                    ]);
               }
          } else {
               Actividad::create([
                    'nombre' => $this->actividad_nombre,
                    'objetivo' => $this->actividad_objetivo,
                    'area_id' => $this->actividad_area_id,
               ]);
          }

          $mensaje = $this->id_actividad_editando ? 'Actividad actualizada.' : 'Nueva actividad agregada.';
          $this->mostrarNotificacion($mensaje);
          $this->id_actividad_editando = null;
          $this->actividad_nombre = '';
          $this->actividad_objetivo = '';
          $this->actividad_area_id = '';
          $this->cargarDatos();
     }

     public function iniciarEdicionActividad($id)
     {
          $actividad = Actividad::find($id);
          if ($actividad) {
               $this->id_actividad_editando = $id;
               $this->actividad_nombre = $actividad->nombre;
               $this->actividad_objetivo = $actividad->objetivo;
               $this->actividad_area_id = $actividad->area_id;
          }
     }

     public function eliminarActividad($id)
     {
          $actividad = Actividad::find($id);
          if ($actividad) {
               $actividad->delete();
               $this->mostrarNotificacion('Actividad eliminada.', 'danger');
               $this->cargarDatos();
          }
     }

     // CRUD Subactividades
     public function agregarOEditarSubactividad()
     {
          $this->validate([
               'subactividad_nombre' => 'required',
               'subactividad_actividad_id' => 'required'
          ]);

          if ($this->id_subactividad_editando) {
               $subactividad = Subactividad::find($this->id_subactividad_editando);
               if ($subactividad) {
                    $subactividad->update([
                         'nombre' => $this->subactividad_nombre,
                         'objetivo' => $this->subactividad_objetivo,
                         'actividad_id' => $this->subactividad_actividad_id,
                    ]);
               }
          } else {
               Subactividad::create([
                    'nombre' => $this->subactividad_nombre,
                    'objetivo' => $this->subactividad_objetivo,
                    'actividad_id' => $this->subactividad_actividad_id,
               ]);
          }

          $mensaje = $this->id_subactividad_editando ? 'Subactividad actualizada.' : 'Nueva subactividad agregada.';
          $this->mostrarNotificacion($mensaje);
          $this->id_subactividad_editando = null;
          $this->subactividad_nombre = '';
          $this->subactividad_objetivo = '';
          $this->subactividad_actividad_id = '';
          $this->cargarDatos();
     }

     public function iniciarEdicionSubactividad($id)
     {
          $subactividad = Subactividad::find($id);
          if ($subactividad) {
               $this->id_subactividad_editando = $id;
               $this->subactividad_nombre = $subactividad->nombre;
               $this->subactividad_objetivo = $subactividad->objetivo;
               $this->subactividad_actividad_id = $subactividad->actividad_id;
          }
     }

     public function eliminarSubactividad($id)
     {
          $subactividad = Subactividad::find($id);
          if ($subactividad) {
               $subactividad->delete();
               $this->mostrarNotificacion('Subactividad eliminada.', 'danger');
               $this->cargarDatos();
          }
     }

     // CRUD Facilitadores
     public function agregarOEditarFacilitador()
     {
          $rules = [
               'facilitador_nombre' => 'required|unique:tbl_facilitadores,nombre,' . ($this->id_facilitador_editando ?? 'NULL'),
               'facilitador_ficha_empleado' => 'nullable|unique:tbl_facilitadores,ficha_empleado,' . ($this->id_facilitador_editando ?? 'NULL') . '|exists:pgsql_sap.tbl_rrhh_personal,ficha',
          ];
          
          $messages = [
               'facilitador_nombre.required' => 'El nombre del facilitador es obligatorio.',
               'facilitador_nombre.unique' => 'Ya existe un facilitador registrado con este nombre.',
               'facilitador_ficha_empleado.unique' => 'Ya existe un facilitador registrado con esta ficha.',
               'facilitador_ficha_empleado.exists' => 'La ficha ingresada no pertenece a ningún empleado registrado en el sistema.',
          ];

          $this->validate($rules, $messages);

          if ($this->facilitador_ficha_empleado) {
               $empleado = RrhhPersonal::where('ficha', $this->facilitador_ficha_empleado)->first();
               if ($empleado && strcasecmp(trim($empleado->nombre_empleado), trim($this->facilitador_nombre)) !== 0) {
                    $this->addError('facilitador_nombre', "El nombre debe coincidir exactamente con el registrado en el sistema para esta ficha: {$empleado->nombre_empleado}.");
                    return;
               }
          }

          if ($this->id_facilitador_editando) {
               $facilitador = Facilitador::find($this->id_facilitador_editando);
               if ($facilitador) {
                    $facilitador->update([
                         'nombre' => $this->facilitador_nombre,
                         'ficha_empleado' => $this->facilitador_ficha_empleado ?: null,
                    ]);
               }
          } else {
               Facilitador::create([
                         'nombre' => $this->facilitador_nombre,
                         'ficha_empleado' => $this->facilitador_ficha_empleado ?: null,
               ]);
          }

          $mensaje = $this->id_facilitador_editando ? 'Facilitador actualizado.' : 'Nuevo facilitador agregado.';
          $this->mostrarNotificacion($mensaje);
          $this->id_facilitador_editando = null;
          $this->facilitador_nombre = '';
          $this->facilitador_ficha_empleado = '';
          $this->cargarDatos();
     }

     public function iniciarEdicionFacilitador($id)
     {
          $facilitador = Facilitador::find($id);
          if ($facilitador) {
               $this->id_facilitador_editando = $id;
               $this->facilitador_nombre = $facilitador->nombre;
               $this->facilitador_ficha_empleado = $facilitador->ficha_empleado;
          }
     }

     public function eliminarFacilitador($id)
     {
          $facilitador = Facilitador::find($id);
          if ($facilitador) {
               $facilitador->delete();
               $this->mostrarNotificacion('Facilitador eliminado.', 'danger');
               $this->cargarDatos();
          }
     }

     public function guardarAjustesGlobales()
     {
          $this->mostrarNotificacion('Ajustes globales guardados con éxito.');
     }

     public function render()
     {
          return view('livewire.configuracion-view')->layout('components.layouts.app');
     }
}

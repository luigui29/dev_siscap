<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class PerfilesView extends Component
{
    use \App\Traits\FiltraEmpleados;

    public $pestania_activa = 'individual';
    public $notificacion = null;
    
    public $ficha_usuario_seleccionado = '';
    public $colaboradores = [];
     
     // Form fields for Education
     public $edu_nivel_educativo = 'Técnico Medio';
     public $edu_titulo = '';
     public $edu_instituto = '';
     public $educaciones = [];

     // Form fields for Experience
     public $exp_cargo = '';
     public $exp_empresa = '';
     public $exp_observacion = '';
     public $experiencias = [];

     // English Skills
     // (We will use direct DB loading in render, but for reactive checks we can keep public properties, or just let Blade handle it. But wire:click="alternarIngles" requires updating DB directly)

     // Register Colaborador
     public $nueva_ficha = '';
     public $nuevo_nombre = '';
     public $nuevo_correo = '';
     public $nuevo_rol = 'Instructor Adjunto';
     
     public $termino_busqueda = '';

     public function mount($pestania = null)
     {
          if ($pestania) {
               $this->pestania_activa = $pestania;
          }
          try {
               $this->colaboradores = \App\Models\User::all();
               
               // Cargar empleados iniciales con filtros (vacíos por defecto)
               $empleados_iniciales = $this->aplicarFiltrosEmpleados(\App\Models\RrhhPersonal::query())
                   ->orderBy('nombre_empleado', 'asc')
                   ->limit(50)
                   ->get();
                   
               if ($empleados_iniciales->isNotEmpty()) {
                    $this->ficha_usuario_seleccionado = $empleados_iniciales->first()->ficha;
               }
          } catch (\Exception $excepcion) {
               $this->colaboradores = collect([]);
          }
     }

     public function limpiarNotificacion()
     {
          $this->notificacion = null;
     }

     public function mostrarNotificacion($mensaje, $tipo = 'success')
     {
          $this->notificacion = ['mensaje' => $mensaje, 'tipo' => $tipo];
     }

     public function agregarEducacion()
     {
          if (!$this->ficha_usuario_seleccionado) {
               $this->mostrarNotificacion('Seleccione un colaborador primero.', 'danger');
               return;
          }

          \App\Models\NivelEducativo::create([
               'ficha_empleado' => $this->ficha_usuario_seleccionado,
               'nivel_educativo' => $this->edu_nivel_educativo,
               'titulo' => $this->edu_titulo,
               'instituto' => $this->edu_instituto,
               'graduado' => true,
               'fecha_culminado' => date('Y'),
          ]);
          
          $this->edu_titulo = '';
          $this->edu_instituto = '';
          $this->mostrarNotificacion('Educación registrada con éxito.');
     }

     public function eliminarEducacion($id)
     {
          \App\Models\NivelEducativo::where('id', $id)->delete();
          $this->mostrarNotificacion('Registro educativo eliminado.', 'danger');
     }

     public function agregarExperiencia()
     {
          if (!$this->ficha_usuario_seleccionado) {
               $this->mostrarNotificacion('Seleccione un colaborador primero.', 'danger');
               return;
          }

          \App\Models\ExperienciaLaboral::create([
               'ficha_empleado' => $this->ficha_usuario_seleccionado,
               'cargo_desempeñado' => $this->exp_cargo,
               'empresa' => $this->exp_empresa,
               'desde' => date('Y-m-d'),
               'hasta' => null,
               'observacion' => $this->exp_observacion
          ]);

          $this->exp_cargo = '';
          $this->exp_empresa = '';
          $this->exp_observacion = '';
          $this->mostrarNotificacion('Experiencia laboral registrada.');
     }

     public function eliminarExperiencia($id)
     {
          \App\Models\ExperienciaLaboral::where('id', $id)->delete();
          $this->mostrarNotificacion('Experiencia laboral eliminada.', 'danger');
     }

     public function alternarIngles($columna)
     {
          if (!$this->ficha_usuario_seleccionado) return;

          $registro = \App\Models\NivelIngles::firstOrCreate(
              ['ficha_empleado' => $this->ficha_usuario_seleccionado],
              ['i1' => false, 'i2' => false, 'bb' => false, 'ba' => false, 'ib' => false, 'ia' => false, 'ab' => false, 'aa' => false]
          );

          $registro->$columna = !$registro->$columna;
          $registro->save();

          $this->mostrarNotificacion('Nivel de inglés actualizado.');
     }

     public function crearColaborador()
     {
          $this->mostrarNotificacion('Colaborador registrado exitosamente.');
          $this->nueva_ficha = '';
          $this->nuevo_nombre = '';
          $this->nuevo_correo = '';
     }

     public function alternarEstado($ficha)
     {
          $this->mostrarNotificacion("Estado modificado para ficha $ficha.");
     }

     public function eliminarColaborador($ficha)
     {
          $this->mostrarNotificacion("Colaborador ficha $ficha eliminado.", 'danger');
     }

     public function render()
     {
          $empleados = collect([]);
          $educacionesDb = collect([]);
          $experienciasDb = collect([]);
          $inglesDb = null;

          if ($this->pestania_activa === 'individual') {
              $empleados = $this->aplicarFiltrosEmpleados(\App\Models\RrhhPersonal::query())
                  ->orderBy('nombre_empleado', 'asc')
                  ->limit(50)
                  ->get();
              
              if ($empleados->isNotEmpty() && !$empleados->contains('ficha', $this->ficha_usuario_seleccionado)) {
                  $this->ficha_usuario_seleccionado = $empleados->first()->ficha;
              } elseif ($empleados->isEmpty()) {
                  $this->ficha_usuario_seleccionado = null;
              }

              if ($this->ficha_usuario_seleccionado) {
                  $educacionesDb = \App\Models\NivelEducativo::where('ficha_empleado', $this->ficha_usuario_seleccionado)->orderBy('created_at', 'desc')->get();
                  $experienciasDb = \App\Models\ExperienciaLaboral::where('ficha_empleado', $this->ficha_usuario_seleccionado)->orderBy('desde', 'desc')->get();
                  $inglesDb = \App\Models\NivelIngles::where('ficha_empleado', $this->ficha_usuario_seleccionado)->first();
              }
          }

          return view('livewire.perfiles-view', [
              'empleados' => $empleados,
              'educacionesDb' => $educacionesDb,
              'experienciasDb' => $experienciasDb,
              'inglesDb' => $inglesDb
          ])->layout('components.layouts.app');
     }
}

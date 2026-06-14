<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\RrhhPersonal;
use App\Models\NivelEducativo;
use App\Models\ExperienciaLaboral;
use App\Models\NivelIngles;
use App\Models\GerenciaUnidad;
use Livewire\Component;

class PerfilesView extends Component
{
    use \App\Traits\FiltraEmpleados;

    public $pestania_activa = 'individual';
    public $notificacion = null;
    
    public $ficha_usuario_seleccionado = '';
    public $usuarios = [];
     
     // Campos para nivel educativo
     public $edu_nivel_educativo = '';
     public $edu_titulo = '';
     public $edu_especialidad = '';
     public $edu_instituto = '';
     public $edu_graduado = false;
     public $edu_fecha_culminado = '';
     public $edu_ultimo_nivel = false;

     // Campos para experiencia laboral
     public $exp_cargo = '';
     public $exp_empresa = '';
     public $exp_desde = '';
     public $exp_hasta = '';
     public $exp_observacion = '';
     
     public $termino_busqueda = '';

     // Filtros para la matriz de horas gerencias
     public $filtro_gerencia = '';
     public $filtro_unidad = '';

     public function mount($pestania = null)
     {
          if ($pestania) {
               $this->pestania_activa = $pestania;
          }
          try {
               $this->usuarios = User::all();
               
               // Cargar empleados iniciales con filtros (vacíos por defecto)
               $empleados_iniciales = $this->aplicarFiltrosEmpleados(RrhhPersonal::query())
                   ->orderBy('nombre_empleado', 'asc')
                   ->limit(50)
                   ->get();
                   
               if ($empleados_iniciales->isNotEmpty()) {
                    $this->ficha_usuario_seleccionado = $empleados_iniciales->first()->ficha;
               }
          } catch (\Exception $excepcion) {
               $this->usuarios = collect([]);
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
               $this->mostrarNotificacion('Seleccione un empleado primero.', 'danger');
               return;
          }

          NivelEducativo::create([
               'ficha_empleado' => $this->ficha_usuario_seleccionado,
               'nivel_educativo' => $this->edu_nivel_educativo,
               'titulo' => $this->edu_titulo ?: null,
               'especialidad' => $this->edu_especialidad ?: null,
               'instituto' => $this->edu_instituto ?: null,
               'graduado' => $this->edu_graduado,
               'fecha_culminado' => $this->edu_fecha_culminado ? date('Y', strtotime($this->edu_fecha_culminado)) : null,
               'ultimo_nivel' => $this->edu_ultimo_nivel,
          ]);
          
          $this->reset(['edu_nivel_educativo', 'edu_titulo', 'edu_especialidad', 'edu_instituto', 'edu_graduado', 'edu_fecha_culminado', 'edu_ultimo_nivel']);
          $this->mostrarNotificacion('Educación registrada con éxito.');
     }

     public function eliminarEducacion($id)
     {
          NivelEducativo::where('id', $id)->delete();
          $this->mostrarNotificacion('Registro educativo eliminado.', 'danger');
     }

     public function agregarExperiencia()
     {
          if (!$this->ficha_usuario_seleccionado) {
               $this->mostrarNotificacion('Seleccione un empleado primero.', 'danger');
               return;
          }

          ExperienciaLaboral::create([
               'ficha_empleado' => $this->ficha_usuario_seleccionado,
               'cargo_desempeñado' => $this->exp_cargo,
               'empresa' => $this->exp_empresa ?: null,
               'desde' => $this->exp_desde,
               'hasta' => $this->exp_hasta ?: null,
               'observacion' => $this->exp_observacion ?: ''
          ]);

          $this->reset(['exp_cargo', 'exp_empresa', 'exp_desde', 'exp_hasta', 'exp_observacion']);
          $this->mostrarNotificacion('Experiencia laboral registrada.');
     }

     public function eliminarExperiencia($id)
     {
          ExperienciaLaboral::where('id', $id)->delete();
          $this->mostrarNotificacion('Experiencia laboral eliminada.', 'danger');
     }

     public function alternarIngles($columna)
     {
          if (!$this->ficha_usuario_seleccionado) return;

          $registro = NivelIngles::firstOrCreate(
              ['ficha_empleado' => $this->ficha_usuario_seleccionado],
              ['i1' => false, 'i2' => false, 'bb' => false, 'ba' => false, 'ib' => false, 'ia' => false, 'ab' => false, 'aa' => false]
          );

          $nuevoValor = !$registro->$columna;

          if ($nuevoValor) {
               $registro->i1 = false;
               $registro->i2 = false;
               $registro->bb = false;
               $registro->ba = false;
               $registro->ib = false;
               $registro->ia = false;
               $registro->ab = false;
               $registro->aa = false;
          }

          $registro->$columna = $nuevoValor;
          $registro->save();

          $this->mostrarNotificacion('Nivel de inglés actualizado.');
     }

     public function alternarEstado($ficha)
     {
          $this->mostrarNotificacion("Estado modificado para ficha $ficha.");
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
                  $educacionesDb = NivelEducativo::where('ficha_empleado', $this->ficha_usuario_seleccionado)->orderBy('created_at', 'desc')->get();
                  $experienciasDb = ExperienciaLaboral::where('ficha_empleado', $this->ficha_usuario_seleccionado)->orderBy('desde', 'desc')->get();
                  $inglesDb = NivelIngles::where('ficha_empleado', $this->ficha_usuario_seleccionado)->first();
              }
          }

          $experienciasInternas = $experienciasDb->filter(function($exp) {
               return strtoupper($exp->empresa) === 'VENPRECAR';
          });
          $experienciasExternas = $experienciasDb->filter(function($exp) {
               return strtoupper($exp->empresa) !== 'VENPRECAR';
          });

          // Variables para la matriz de gerencias
          $gerencias_opciones = collect([]);
          $unidades_opciones = collect([]);
          
          if ($this->pestania_activa === 'gerencia') {
               // Cargar gerencias únicas
               $gerencias_opciones = GerenciaUnidad::select('texto_gerencia')->distinct()->orderBy('texto_gerencia')->pluck('texto_gerencia');
               
               // Si hay una gerencia seleccionada, cargar sus unidades
               if ($this->filtro_gerencia) {
                    $unidades_opciones = GerenciaUnidad::where('texto_gerencia', $this->filtro_gerencia)
                         ->select('texto_unidad')
                         ->distinct()
                         ->orderBy('texto_unidad')
                         ->pluck('texto_unidad');
               }
          }

          return view('livewire.perfiles-view', [
              'empleados' => $empleados,
              'educacionesDb' => $educacionesDb,
              'experienciasInternas' => $experienciasInternas,
              'experienciasExternas' => $experienciasExternas,
              'inglesDb' => $inglesDb,
              'gerencias_opciones' => $gerencias_opciones,
              'unidades_opciones' => $unidades_opciones
          ])->layout('components.layouts.app');
     }
}

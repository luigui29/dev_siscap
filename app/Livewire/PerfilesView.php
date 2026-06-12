<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class PerfilesView extends Component
{
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
     public $ing_i1 = false;
     public $ing_i2 = false;
     public $ing_i3 = false;
     public $ing_i4 = false;

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
               $this->colaboradores = User::all();
               if ($this->colaboradores->isNotEmpty()) {
                    $this->ficha_usuario_seleccionado = $this->colaboradores->first()->ficha;
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
          $this->educaciones[] = [
               'ficha' => $this->ficha_usuario_seleccionado,
               'nivel_educativo' => $this->edu_nivel_educativo,
               'titulo' => $this->edu_titulo,
               'especialidad' => '',
               'instituto' => $this->edu_instituto,
               'fecha_culminado' => date('Y-m-d')
          ];
          $this->edu_titulo = '';
          $this->edu_instituto = '';
          $this->mostrarNotificacion('Educación registrada con éxito.');
     }

     public function agregarExperiencia()
     {
          $this->experiencias[] = [
               'ficha' => $this->ficha_usuario_seleccionado,
               'cargo_desempeniado' => $this->exp_cargo,
               'empresa' => $this->exp_empresa,
               'desde' => date('Y'),
               'hasta' => 'Actualidad',
               'observacion' => $this->exp_observacion
          ];
          $this->exp_cargo = '';
          $this->exp_empresa = '';
          $this->exp_observacion = '';
          $this->mostrarNotificacion('Experiencia laboral registrada.');
     }

     public function alternarIngles($nivel)
     {
          $propiedad = 'ing_' . $nivel;
          $this->$propiedad = !$this->$propiedad;
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
          return view('livewire.perfiles-view')->layout('components.layouts.app');
     }
}

<?php

namespace App\Livewire;

use App\Models\Programacion;
use App\Models\User;
use Livewire\Component;

class ProgramacionView extends Component
{
     public $pestania_activa = 'pre';
     public $notificacion = null;
     
     // Form fields
     public $id_area_seleccionada = 1;
     public $id_act_seleccionada = 101;
     public $id_subact_seleccionada = 1011;
     public $facilitador_ficha = '';
     public $institucion_input = 'VENPRECAR, C.A.';
     public $fecha_input = '';
     public $lugar_input = '';
     public $desde_input = '';
     public $hasta_input = '';
     public $duracion_input = 8;
     public $es_entrada_extra = false;

     public $colaboradores = [];
     public $participantes_seleccionados = [];
     
     public $propuestas = [];
     
     public $id_ejecucion_seleccionada = null;
     public $asistentes_fichas = [];
     
     public $mes_calendario = 'junio';

     public function mount($pestania = null)
     {
          if ($pestania) {
               $this->pestania_activa = $pestania;
          }
          try {
               $this->colaboradores = User::all();
               $this->propuestas = Programacion::all();
          } catch (\Exception $excepcion) {
               $this->colaboradores = collect([]);
               $this->propuestas = collect([]);
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

     public function alternarParticipante($ficha)
     {
          if (in_array($ficha, $this->participantes_seleccionados)) {
               $this->participantes_seleccionados = array_diff($this->participantes_seleccionados, [$ficha]);
          } else {
               $this->participantes_seleccionados[] = $ficha;
          }
     }

     public function guardarPropuesta()
     {
          $this->mostrarNotificacion('Propuesta pre-programada guardada exitosamente.');
          $this->reset(['facilitador_ficha', 'lugar_input', 'participantes_seleccionados']);
     }

     public function aprobarPropuesta($id)
     {
          $this->mostrarNotificacion("Propuesta #$id aprobada correctamente.");
     }

     public function rechazarPropuesta($id)
     {
          $this->mostrarNotificacion("Propuesta #$id rechazada.", 'danger');
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
          $this->mostrarNotificacion('Asistencia y horas hombre registradas exitosamente.');
          $this->id_ejecucion_seleccionada = null;
     }

     public function render()
     {
          return view('livewire.programacion-view')->layout('components.layouts.app');
     }
}

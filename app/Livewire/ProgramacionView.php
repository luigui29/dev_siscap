<?php

namespace App\Livewire;

use App\Models\Programacion;
use App\Models\User;
use Livewire\Component;

class ProgramacionView extends Component
{
     public $active_tab = 'pre';
     public $notification = null;
     
     // Form fields
     public $selected_area_id = 1;
     public $selected_act_id = 101;
     public $selected_subact_id = 1011;
     public $facilitador_ficha = '';
     public $institucion_input = 'VENPRECAR, C.A.';
     public $fecha_input = '';
     public $lugar_input = '';
     public $desde_input = '';
     public $hasta_input = '';
     public $duracion_input = 8;
     public $is_extra_input = false;

     public $colaboradores = [];
     public $selected_participants = [];
     
     public $proposals = [];
     
     public $selected_execution_id = null;
     public $asistentes_fichas = [];
     
     public $calendar_month = 'junio';

     public function mount()
     {
          try {
               $this->colaboradores = User::all();
               $this->proposals = Programacion::all();
          } catch (\Exception $e) {
               $this->colaboradores = collect([]);
               $this->proposals = collect([]);
          }
     }

     public function clearNotification()
     {
          $this->notification = null;
     }

     public function showNotification($msg, $type = 'success')
     {
          $this->notification = ['msg' => $msg, 'type' => $type];
     }

     public function toggleParticipant($ficha)
     {
          if (in_array($ficha, $this->selected_participants)) {
               $this->selected_participants = array_diff($this->selected_participants, [$ficha]);
          } else {
               $this->selected_participants[] = $ficha;
          }
     }

     public function saveProposal()
     {
          $this->showNotification('Propuesta pre-programada guardada exitosamente.');
          $this->reset(['facilitador_ficha', 'lugar_input', 'selected_participants']);
     }

     public function approveProposal($id)
     {
          $this->showNotification("Propuesta #$id aprobada correctamente.");
     }

     public function rejectProposal($id)
     {
          $this->showNotification("Propuesta #$id rechazada.", 'danger');
     }

     public function startExecution($id)
     {
          $this->selected_execution_id = $id;
          $this->asistentes_fichas = [];
     }

     public function toggleAttendance($ficha)
     {
          if (in_array($ficha, $this->asistentes_fichas)) {
               $this->asistentes_fichas = array_diff($this->asistentes_fichas, [$ficha]);
          } else {
               $this->asistentes_fichas[] = $ficha;
          }
     }

     public function saveExecution()
     {
          $this->showNotification('Asistencia y horas hombre registradas exitosamente.');
          $this->selected_execution_id = null;
     }

     public function render()
     {
          return view('livewire.programacion-view')->layout('components.layouts.app');
     }
}

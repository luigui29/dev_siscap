<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class PerfilesView extends Component
{
     public $active_tab = 'individual';
     public $notification = null;
     
     public $selected_user_ficha = '';
     public $colaboradores = [];
     
     // Form fields for Education
     public $edu_nivel_educativo = 'Técnico Medio';
     public $edu_titulo = '';
     public $edu_instituto = '';
     public $educations = [];

     // Form fields for Experience
     public $exp_cargo = '';
     public $exp_empresa = '';
     public $exp_observacion = '';
     public $experiences = [];

     // English Skills
     public $eng_i1 = false;
     public $eng_i2 = false;
     public $eng_i3 = false;
     public $eng_i4 = false;

     // Register Colaborador
     public $new_ficha = '';
     public $new_name = '';
     public $new_email = '';
     public $new_role = 'Instructor Adjunto';
     
     public $search_term = '';

     public function mount()
     {
          try {
               $this->colaboradores = User::all();
               if ($this->colaboradores->isNotEmpty()) {
                    $this->selected_user_ficha = $this->colaboradores->first()->ficha;
               }
          } catch (\Exception $e) {
               $this->colaboradores = collect([]);
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

     public function addEducation()
     {
          $this->educations[] = [
               'ficha' => $this->selected_user_ficha,
               'nivel_educativo' => $this->edu_nivel_educativo,
               'titulo' => $this->edu_titulo,
               'especialidad' => '',
               'instituto' => $this->edu_instituto,
               'fecha_culminado' => date('Y-m-d')
          ];
          $this->edu_titulo = '';
          $this->edu_instituto = '';
          $this->showNotification('Educación registrada con éxito.');
     }

     public function addExperience()
     {
          $this->experiences[] = [
               'ficha' => $this->selected_user_ficha,
               'cargo_desempeniado' => $this->exp_cargo,
               'empresa' => $this->exp_empresa,
               'desde' => date('Y'),
               'hasta' => 'Actualidad',
               'observacion' => $this->exp_observacion
          ];
          $this->exp_cargo = '';
          $this->exp_empresa = '';
          $this->exp_observacion = '';
          $this->showNotification('Experiencia laboral registrada.');
     }

     public function toggleEnglish($level)
     {
          $property = 'eng_' . $level;
          $this->$property = !$this->$property;
          $this->showNotification('Nivel de inglés actualizado.');
     }

     public function createColaborador()
     {
          $this->showNotification('Colaborador registrado exitosamente.');
          $this->new_ficha = '';
          $this->new_name = '';
          $this->new_email = '';
     }

     public function toggleStatus($ficha)
     {
          $this->showNotification("Estado modificado para ficha $ficha.");
     }

     public function deleteColaborador($ficha)
     {
          $this->showNotification("Colaborador ficha $ficha eliminado.", 'danger');
     }

     public function render()
     {
          return view('livewire.perfiles-view')->layout('components.layouts.app');
     }
}

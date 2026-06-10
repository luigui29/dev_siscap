<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Area;
use Livewire\Component;

class ConfiguracionView extends Component
{
     public $active_tab = 'roles';
     public $notification = null;
     
     public $search_term = '';
     public $selected_user_ficha = '';
     public $target_role = 'Analista';
     
     public $area_nombre = '';
     public $area_descripcion = '';
     public $area_estatus = true;
     public $editing_area_id = null;

     public $users = [];
     public $areas = [];

     public function mount()
     {
          try {
               $this->users = User::all();
               $this->areas = Area::all()->toArray();
          } catch (\Exception $e) {
               $this->users = collect([]);
               $this->areas = [];
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

     public function assignRole()
     {
          $this->showNotification('Nivel de rol actualizado.');
     }

     public function addOrEditArea()
     {
          $msg = $this->editing_area_id ? 'Área actualizada.' : 'Nueva área agregada.';
          $this->showNotification($msg);
          $this->editing_area_id = null;
          $this->area_nombre = '';
          $this->area_descripcion = '';
     }

     public function startEditArea($id)
     {
          $this->editing_area_id = $id;
          $this->area_nombre = 'Ejemplo de Área';
          $this->area_descripcion = 'Descripción de ejemplo.';
     }

     public function toggleAreaEstatus($id)
     {
          $this->showNotification('Estatus de área modificado.');
     }

     public function deleteArea($id)
     {
          $this->showNotification('Área eliminada del sistema.', 'danger');
     }

     public function saveGlobalSettings()
     {
          $this->showNotification('Ajustes globales guardados con éxito.');
     }

     public function render()
     {
          return view('livewire.configuracion-view')->layout('components.layouts.app');
     }
}

<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Area;
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

     public $usuarios = [];
     public $areas = [];

     public function mount()
     {
          try {
               $this->usuarios = User::all();
               $this->areas = Area::all()->toArray();
          } catch (\Exception $excepcion) {
               $this->usuarios = collect([]);
               $this->areas = [];
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

     public function asignarRol()
     {
          $this->mostrarNotificacion('Nivel de rol actualizado.');
     }

     public function agregarOEditarArea()
     {
          $mensaje = $this->id_area_editando ? 'Área actualizada.' : 'Nueva área agregada.';
          $this->mostrarNotificacion($mensaje);
          $this->id_area_editando = null;
          $this->area_nombre = '';
          $this->area_descripcion = '';
     }

     public function iniciarEdicionArea($id)
     {
          $this->id_area_editando = $id;
          $this->area_nombre = 'Ejemplo de Área';
          $this->area_descripcion = 'Descripción de ejemplo.';
     }

     public function alternarEstatusArea($id)
     {
          $this->mostrarNotificacion('Estatus de área modificado.');
     }

     public function eliminarArea($id)
     {
          $this->mostrarNotificacion('Área eliminada del sistema.', 'danger');
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

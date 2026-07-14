<?php

namespace App\Livewire;

use App\Models\PersonalProgramacion;
use App\Models\RrhhPersonal;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalProgramEmpleados extends Component
{
    public $programacion_id = null;

    public $empleados_matriculados = [];

    /* EVENTOS */
    /* Se abre el modal y se cargan los datos de
    * los asistentes desde la tabla "pl_programaciones"
    */
    #[On('abrir-modal-program-empleados')]
    public function abrir($id)
    {
        $this->programacion_id = $id;

        $registro = PersonalProgramacion::where('programacion_id', $id)->first();

        if ($registro) {
            $fichas = PersonalProgramacion::where('programacion_id', $id)->pluck('ficha_empleado');

            $this->empleados_matriculados = RrhhPersonal::whereIn('ficha', $fichas)->select('ficha', 'nombre_empleado', 'cedula', 'texto_gerencia', 'texto_unidad', 'texto_cargo')->get();
        }

        $this->dispatch('listo-modal-program-empleados');
    }

    public function render()
    {
        return view('modals.modal-program-empleados');
    }
}

<?php

namespace App\Livewire;

use App\Models\RrhhPersonal;
use App\Models\Programacion;
use App\Models\PersonalProgramacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalPreProgramEmpleados extends Component
{
    /* PROPIEDADES */
    public $data_filtrada = [
        'ficha' => null,
        'cedula' => null,
        'nombre' => null,
        'gerencia' => null,
        'cargo' => null,
        'unidad' => null,
    ];

    public $programacion_id = null;

    /* EVENTOS */
    /* Se abre el modal y se cargan los datos de
    * los asistentes desde la tabla "pl_programaciones"
    */
    #[On('abrir-modal-pre-program-empleados')]
    public function abrir($id = null)
    {
        $registro = PersonalProgramacion::where('programacion_id', $id)->first();

        $this->dispatch('listo-modal-pre-program-empleados');
    }

    /* PROPIEDADES COMPUTADAS */
    // Todos los empleados según filtros (limitado a 50 resultados)
    #[Computed]
    public function empleados_buscados()
    {
        return $this->filtrar(RrhhPersonal::query())
            ->orderBy('nombre_empleado', 'asc')
            ->limit(50)
            ->get();
    }

    // Todos los empleados ya matriculados en la programación seleccionada
    #[Computed]
    public function empleados_matriculados()
    {

    }

    public function filtrar($query)
    {
        $campos = [
            'ficha' => $this->data_filtrada['ficha'],
            'cedula' => $this->data_filtrada['cedula'],
            'nombre_empleado' => $this->data_filtrada['nombre'],
            'texto_gerencia' => $this->data_filtrada['gerencia'],
            'texto_cargo' => $this->data_filtrada['cargo'],
            'texto_unidad' => $this->data_filtrada['unidad'],
        ];

        foreach ($campos as $campo => $valor) {
            if (!empty($valor)) {
                $query->where($campo, 'ilike', '%'.$valor.'%');
            }
        }

        return $query;
    }

    // Se guardan los empleados matriculados en pl_programaciones
    public function guardar()
    {
        $this->validate();

        Programacion::updateOrCreate(
            ['id' => $this->programacion_id],
            [
                'actividad_id' => $this->actividad_seleccionada,
                'subactividad_id' => $this->subactividad_seleccionada,
                'facilitador_id' => $this->facilitador_seleccionado,
                'institucion' => $this->institucion,
                'fecha' => $this->fecha,
                'lugar' => $this->lugar,
                'desde' => sprintf('%02d:00', $this->desde),
                'hasta' => sprintf('%02d:00', $this->hasta),
                'duracion' => $this->hasta - $this->desde
            ]
        );

        $this->dispatch('pre-program-actualizada');
        $this->dispatch('cerrar-modal-pre-program-empleados');
    }

    // Se elimina la ficha del empleado del arreglo de empleados matriculados 
    public function quitar_empleado()
    {
        
    }

    public function limpiar()
    {
        $this->reset('empleados_matriculados');
    }

    public function render()
    {
        return view('modals.modal-program-pre-empleados');
    }
}

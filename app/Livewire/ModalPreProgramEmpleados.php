<?php

namespace App\Livewire;

use App\Models\PersonalProgramacion;
use App\Models\Programacion;
use App\Models\RrhhPersonal;
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

    public $empleados_matriculados = [];

    /* EVENTOS */
    /* Se abre el modal y se cargan los datos de
    * los asistentes desde la tabla "pl_programaciones"
    */
    #[On('abrir-modal-pre-program-empleados')]
    public function abrir($id)
    {
        $this->programacion_id = $id;

        $registro = PersonalProgramacion::where('programacion_id', $id)->first();

        if ($registro) {
            $fichas = PersonalProgramacion::where('programacion_id', $id)->pluck('ficha_empleado');

            $this->empleados_matriculados = RrhhPersonal::whereIn('ficha', $fichas)->select('ficha', 'nombre_empleado', 'cedula', 'texto_gerencia', 'texto_unidad', 'texto_cargo')->get();
        }

        $this->dispatch('listo-modal-pre-program-empleados');
    }

    // Se agrega la ficha del empleado al arreglo de empleados matriculados
    #[On('agregar-empleado')]
    public function agregar_empleado($ficha)
    {
        $this->empleados_matriculados = collect($this->empleados_matriculados);

        if (! $this->empleados_matriculados->contains('ficha', $ficha)) {
            $empleado = RrhhPersonal::where('ficha', $ficha)->select('ficha', 'nombre_empleado', 'cedula', 'texto_gerencia', 'texto_unidad', 'texto_cargo')->first();

            if ($empleado) {
                $this->empleados_matriculados->push($empleado);
            }
        }
    }

    // Se elimina la ficha del empleado del arreglo de empleados matriculados
    #[On('quitar-empleado')]
    public function quitar_empleado($ficha)
    {
        $this->empleados_matriculados = collect($this->empleados_matriculados)->filter(
            fn ($emp) => $emp->ficha != $ficha
        );
    }

    // Se obtiene la data filtrada por el componente FiltroEmpleados
    #[On('busqueda-filtrada-empleados')]
    public function obtenerDataFiltrada($filtros)
    {
        $this->data_filtrada = $filtros;
    }

    /* PROPIEDADES COMPUTADAS */
    // Fichas de los empleados ya matriculados (para validar en la vista)
    #[Computed]
    public function fichas_matriculadas(): array
    {
        return collect($this->empleados_matriculados)->pluck('ficha')->toArray();
    }

    // Todos los empleados según filtros (limitado a 50 resultados)
    #[Computed]
    public function empleados_buscados()
    {
        return $this->filtrar(RrhhPersonal::query())
            ->orderBy('nombre_empleado', 'asc')
            ->limit(50)
            ->get();
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
            if (! empty($valor)) {
                $query->where($campo, 'ilike', '%'.$valor.'%');
            }
        }

        return $query;
    }

    /* Se guardan las fichas de los empleados matriculados en pl_programaciones
    * (se borra los registros de la programacion si existian antes)
    */
    public function guardar()
    {
        DB::transaction(function () {
            PersonalProgramacion::where('programacion_id', $this->programacion_id)->delete();

            foreach ($this->empleados_matriculados as $emp) {
                PersonalProgramacion::create([
                    'programacion_id' => $this->programacion_id,
                    'ficha_empleado' => $emp->ficha,
                    'estatus' => null,
                    'causa' => null,
                ]);
            }
        });

        $this->dispatch('pre-program-actualizada');
        $this->dispatch('cerrar-modal-pre-program-empleados');
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

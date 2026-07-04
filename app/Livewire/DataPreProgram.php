<?php

namespace App\Livewire;

use App\Models\RrhhPersonal;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class DataPreProgram extends Component
{
    /* PROPIEDADES */
    public $data_filtrada_program = [
        'area' => null,
        'actividad' => null,
        'subactividad' => null,
        'facilitador' => null,
        'institucion' => null,
        'lugar' => null,
        'fecha_desde' => null,
        'fecha_hasta' => null,
        'tiempo_desde' => null,
        'tiempo_hasta' => null,
        'duracion_desde' => null,
        'duracion_hasta' => null,
    ];

    public $data_filtrada_empleados = [
        'ficha' => null,
        'cedula' => null,
        'nombre' => null,
        'gerencia' => null,
        'cargo' => null,
        'unidad' => null,
    ];

    public $program_seleccionada = null;

    /* EVENTOS */
    /*
    * Al recibir la busqueda de los filtros, se guarda en las datas correspondientes
    * y se reinicia el id de la programacion seleccionada (si se había seleccionado una previamente)
    */
    #[On('busqueda-filtrada-program')]
    public function obtenerDataProgram($filtros)
    {
        $this->data_filtrada_program = $filtros;
        $this->reset('program_seleccionada');
    }

    #[On('busqueda-filtrada-empleados')]
    public function obtenerDataEmpleados($filtros)
    {
        $this->data_filtrada_empleados = $filtros;
    }

    /*
    * Tras actualizar los registros se re-renderiza el componente
    * para mostrarlos en la página sin recargar
    */
    #[On('pre-program-actualizada')]
    public function actualizar() {}

    /* PROPIEDADES COMPUTADAS */
    // Todas las pre-programaciones según filtros (limitado a 50 resultados)
    #[Computed]
    public function pre_programaciones()
    {
        $vista = DB::table('mvw_pre_programaciones');

        return $this->filtrar_program($vista)
            ->orderBy('programacion_id', 'asc')
            ->limit(50)
            ->get();
    }

    // Todos los empleados según filtros (limitado a 50 resultados)
    #[Computed]
    public function empleados()
    {
        return $this->filtrar(RrhhPersonal::query())
            ->orderBy('nombre_empleado', 'asc')
            ->limit(50)
            ->get();
    }

    /*
    * Se revisa los valores rellenados de los campos del filtro de busqueda
    * Primero, se hace una consulta ilike si los primeros seis campos son ingresados
    * Luego se revisa las siguientes condiciones y se agrega una consulta específica
    * 1) Si ambos campos de fecha son ingresados, hacer una consulta por rango de fechas
    * 2) Si ambos campos de tiempo son ingresados, hacer una consulta por rango de horas
    * 3) Si ambos campos de duracion son ingresados, hacer una consulta por rango de duracion
    */
    public function filtrar_program($query)
    {
        $campos = [
            'nombre_area' => $this->data_filtrada_program['area'],
            'nombre_actividad' => $this->data_filtrada_program['actividad'],
            'nombre_subactividad' => $this->data_filtrada_program['subactividad'],
            'nombre_facilitador' => $this->data_filtrada_program['facilitador'],
            'institucion' => $this->data_filtrada_program['institucion'],
            'lugar' => $this->data_filtrada_program['lugar'],
            'desde' => $this->data_filtrada_program['tiempo_desde'],
            'hasta' => $this->data_filtrada_program['tiempo_hasta'],
            'duracion_desde' => $this->data_filtrada_program['duracion_desde'],
            'duracion_hasta' => $this->data_filtrada_program['duracion_hasta'],
        ];

        foreach ($campos as $campo => $valor) {
            if (! empty($valor)) {
                $query->where($campo, 'ilike', '%'.$valor.'%');
            }
        }

        if (! empty($this->data_filtrada_program['fecha_desde']) && ! empty($this->data_filtrada_program['fecha_hasta'])) {
            $query->whereBetween('fecha', [$this->data_filtrada_program['fecha_desde'], $this->data_filtrada_program['fecha_hasta']]);
        } elseif (! empty($this->data_filtrada_program['fecha_desde'])) {
            $query->where('fecha', '>=', $this->data_filtrada_program['fecha_desde']);
        } elseif (! empty($this->data_filtrada_program['fecha_hasta'])) {
            $query->where('fecha', '>=', $this->data_filtrada_program['fecha_hasta']);
        }

        if (! empty($this->data_filtrada_program['tiempo_desde']) && ! empty($this->data_filtrada_program['tiempo_hasta'])) {
            $query->where('desde', '<=', $this->data_filtrada_program['tiempo_hasta'])
                ->where('hasta', '>=', $this->data_filtrada_program['tiempo_desde']);
        } elseif (! empty($this->data_filtrada_program['tiempo_desde'])) {
            $query->where('desde', '>=', $this->data_filtrada_program['tiempo_desde']);
        } elseif (! empty($this->data_filtrada_program['tiempo_hasta'])) {
            $query->where('hasta', '<=', $this->data_filtrada_program['tiempo_hasta']);
        }

        if (! empty($this->data_filtrada_program['duracion_desde']) && ! empty($this->data_filtrada_program['duracion_hasta'])) {
            $query->whereBetween('duracion', [$this->data_filtrada_program['duracion_desde'], $this->data_filtrada_program['duracion_hasta']]);
        } elseif (! empty($this->data_filtrada_program['duracion_desde'])) {
            $query->where('duracion', '>=', $this->data_filtrada_program['duracion_desde']);
        } elseif (! empty($this->data_filtrada_program['duracion_hasta'])) {
            $query->where('duracion', '>=', $this->data_filtrada_program['duracion_hasta']);
        }

        return $query;
    }

    public function render()
    {
        return view('livewire.data-preprogram');
    }

    public function eliminar($programacion_id)
    {
        Programacion::findOrFail($programacion_id)->delete();
        $this->dispatch('pre-program-actualizada');
    }
}

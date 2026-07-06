<?php

namespace App\Livewire;

use App\Models\RrhhPersonal;
use App\Models\Programacion;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Carbon\Carbon;

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
        unset($this->pre_programaciones);
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

        $resultados = $this->filtrar_program($vista)
            ->orderBy('programacion_id', 'asc')
            ->limit(50)
            ->get();

        return $resultados->map(function ($item) {
            if ($item->fecha) {
                $item->fecha = Carbon::parse($item->fecha)->format('d-m-Y');
            }
            return $item;
        });
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
    * 1) Si cualquier campo de fecha es ingresado, hacer una consulta por rango de fechas
    * 2) Si cualquier campo de tiempo es ingresado, hacer una consulta por rango de horas
    * 3) Si cualquier campo de duracion es ingresado, hacer una consulta por rango de duracion
    */
    public function filtrar_program($query)
    {
        $campos = [
            'nombre_area' => $this->data_filtrada_program['area'] ?? null,
            'nombre_actividad' => $this->data_filtrada_program['actividad'] ?? null,
            'nombre_subactividad' => $this->data_filtrada_program['subactividad'] ?? null,
            'nombre_facilitador' => $this->data_filtrada_program['facilitador'] ?? null,
            'institucion' => $this->data_filtrada_program['institucion'] ?? null,
            'lugar' => $this->data_filtrada_program['lugar'] ?? null,
        ];

        foreach ($campos as $campo => $valor) {
            if (! empty(trim($valor ?? ''))) {
                $query->where($campo, 'ilike', '%'.trim($valor).'%');
            }
        }

        $campos_rango = [
            'f_desde' => $this->data_filtrada_program['fecha_desde'],
            'f_hasta' => $this->data_filtrada_program['fecha_hasta'],
            't_desde' => (!is_null($this->data_filtrada_program['tiempo_desde']) && $this->data_filtrada_program['tiempo_desde'] !== '') ? sprintf('%02d:00', $this->data_filtrada_program['tiempo_desde']) : null,
            't_hasta' => (!is_null($this->data_filtrada_program['tiempo_hasta']) && $this->data_filtrada_program['tiempo_hasta'] !== '') ? sprintf('%02d:00', $this->data_filtrada_program['tiempo_hasta']) : null,
            'd_desde' => $this->data_filtrada_program['duracion_desde'] ?? 0,
            'd_hasta' => $this->data_filtrada_program['duracion_hasta'] ?? 0,
        ];

        if (! empty($campos_rango['f_desde']) && ! empty($campos_rango['f_hasta'])) {
            $query->whereBetween('fecha', [$campos_rango['f_desde'], $campos_rango['f_hasta']]);
        } elseif (! empty($campos_rango['f_desde'])) {
            $query->where('fecha', '>=', $campos_rango['f_desde']);
        } elseif (! empty($campos_rango['f_hasta'])) {
            $query->where('fecha', '>=', $campos_rango['f_hasta']);
        }

        if (! empty($campos_rango['t_desde']) && ! empty($campos_rango['t_hasta'])) {
            $query->where('desde', '<=', $campos_rango['t_hasta'])
                ->where('hasta', '>=', $campos_rango['t_desde']);
        } elseif (! empty($campos_rango['t_desde'])) {
            $query->where('desde', '>=', $campos_rango['t_desde']);
        } elseif (! empty($campos_rango['t_hasta'])) {
            $query->where('hasta', '<=', $campos_rango['t_hasta']);
        }

        if (! empty($campos_rango['d_desde']) && ! empty($campos_rango['d_hasta'])) {
            $query->whereBetween('duracion', [$campos_rango['d_desde'], $campos_rango['d_hasta']]);
        } elseif (! empty($campos_rango['d_desde'])) {
            $query->where('duracion', '>=', $campos_rango['d_desde']);
        } elseif (! empty($campos_rango['d_hasta'])) {
            $query->where('duracion', '>=', $campos_rango['d_hasta']);
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

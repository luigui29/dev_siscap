<?php

namespace App\Livewire;

use App\Exports\ControlAsistenciaPdf;
use App\Models\Programacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class DataProgramFinal extends Component
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
        unset($this->programaciones);
    }

    /*
    * Tras actualizar los registros se re-renderiza el componente
    * para mostrarlos en la página sin recargar
    */
    #[On('program-final-actualizada')]
    public function actualizar() {}

    /* PROPIEDADES COMPUTADAS */
    // Todas las programaciones aún no ejecutadas según filtros (limitado a 50 resultados)
    #[Computed]
    public function programaciones()
    {
        $vista = DB::table('mvw_programaciones_finales');

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
            't_desde' => (! is_null($this->data_filtrada_program['tiempo_desde']) && $this->data_filtrada_program['tiempo_desde'] !== '') ? sprintf('%02d:00', $this->data_filtrada_program['tiempo_desde']) : null,
            't_hasta' => (! is_null($this->data_filtrada_program['tiempo_hasta']) && $this->data_filtrada_program['tiempo_hasta'] !== '') ? sprintf('%02d:00', $this->data_filtrada_program['tiempo_hasta']) : null,
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

    public function rechazar($programacion_id)
    {
        $query = Programacion::findOrFail($programacion_id);

        if ($query) {
            $query->aprobado = false;
            $query->save();
        }

        $this->dispatch('program-final-actualizada');
    }

    public function aprobar($programacion_id)
    {
        $query = Programacion::findOrFail($programacion_id);

        if ($query) {
            $query->aprobado = true;
            $query->save();
        }

        $this->dispatch('program-final-actualizada');
    }

    public function retroceder($programacion_id)
    {
        $query = Programacion::findOrFail($programacion_id);

        if ($query) {
            $query->aprobado = null;
            $query->save();
        }

        $this->dispatch('program-final-actualizada');
    }

    public function control_asistencia($programacion_id)
    {
        $query = Programacion::findOrFail($programacion_id);

        if (! $query) {
            return;
        }

        return (new ControlAsistenciaPdf(
            programacion: $query,
        ))->download();
    }

    public function render()
    {
        /**
         * Cada vez que se renderiza la vista, se vuelve a calcular las sumas mostradas
         * en las tarjetas de stats de la vista
         */

        $vista = DB::table('mvw_programaciones_finales');
        $query = $this->filtrar_program($vista);

        $totales_agrupados = (clone $query)->select('aprobado', DB::raw('count(*) as total'))
            ->groupBy('aprobado')
            ->get();

        $totales_program_aprob = 0;
        $totales_program_recha = 0;
        $totales_program_pend = 0;

        foreach ($totales_agrupados as $item) {
            if (is_null($item->aprobado)) {
                $totales_program_pend += $item->total;
            } elseif (in_array($item->aprobado, [true, 1, '1', 't', 'true', 'T', 'TRUE'], true)) {
                $totales_program_aprob += $item->total;
            } else {
                $totales_program_recha += $item->total;
            }
        }

        $totales_program = $totales_program_aprob + $totales_program_recha + $totales_program_pend;

        return view('livewire.data-program-final', compact(
            'totales_program',
            'totales_program_aprob',
            'totales_program_recha',
            'totales_program_pend'
        ));
    }
}

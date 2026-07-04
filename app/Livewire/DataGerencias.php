<?php

namespace App\Livewire;

use App\Exports\ResumenGerenciaPdf;
use App\Models\PersonalProgramacion;
use App\Models\Programacion;
use App\Models\RrhhPersonal;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class DataGerencias extends Component
{
    /* PROPIEDADES */
    public $data_filtrada = [
        'texto_gerencia' => null,
        'texto_unidad' => null,
    ];

    public $gerencia_seleccionada = null;

    public $unidad_seleccionada = null;

    /* EVENTOS */
    /*
    * Al recibir la busqueda del filtro, se guarda en las propiedades
    */
    #[On('busqueda-filtrada-gerencias')]
    public function obtenerDataFiltrada($filtros)
    {
        $this->data_filtrada = $filtros;
        $this->reset(['gerencia_seleccionada', 'unidad_seleccionada']);
    }

    /* PROPIEDADES COMPUTADAS */
    // Todas las gerencias y sus unidades según filtros
    #[Computed]
    public function gerencias()
    {
        $vista = DB::connection('pgsql_sap')->table('vw_gerencias_unidades');

        return $this->filtrar($vista)
            ->select('texto_gerencia')
            ->distinct()
            ->orderBy('texto_gerencia', 'asc')
            ->get();
    }

    // Retornar las unidades filtradas por gerencia y por los filtros usados
    #[Computed]
    public function unidades()
    {
        $vista = DB::connection('pgsql_sap')->table('vw_gerencias_unidades');

        $query = $this->filtrar($vista);

        if ($this->gerencia_seleccionada) {
            $query->where('texto_gerencia', $this->gerencia_seleccionada);
        }

        return $query->select('texto_unidad')
            ->distinct()
            ->orderBy('texto_unidad', 'asc')
            ->get();
    }

    /* Retornar la gerencia seleccionada si el usuario selecciona de la lista
    *  Además, calcular los atributos de horas de capacitación por unidad
    */
    #[Computed]
    public function gerencia()
    {
        $vista = DB::connection('pgsql_sap')->table('vw_gerencias_unidades');

        $query = $vista->when($this->gerencia_seleccionada, function ($q) {
            return $q->where('texto_gerencia', $this->gerencia_seleccionada);
        });

        $registros = $query->get();

        return $registros->map(function ($registro) {
            /* Número de empleados por unidad */
            $fichas = RrhhPersonal::where('texto_unidad', $registro->texto_unidad)
                ->pluck('ficha')
                ->toArray();

            $registro->numero_empleados = count($fichas);

            if (empty($fichas)) {
                $registro->pre_program = 0;
                $registro->program_final = 0;
                $registro->ejecuciones = 0;
                $registro->horas = 0;

                return $registro;
            }

            /* Cursos en los que ha participado cualquier empleado de la unidad */
            $programaciones = PersonalProgramacion::whereIn('ficha_empleado', $fichas)
                ->distinct()
                ->pluck('programacion_id')
                ->toArray();

            if (empty($programaciones)) {
                $registro->pre_program = 0;
                $registro->program_final = 0;
                $registro->ejecuciones = 0;
                $registro->horas = 0;

                return $registro;
            }

            $pre_programados = Programacion::whereIn('id', $programaciones)
                ->whereNull('aprobado')
                ->whereNull('ejecutado')
                ->count();

            $program_final = Programacion::whereIn('id', $programaciones)
                ->where('aprobado', true)
                ->whereNull('ejecutado')
                ->count();

            $ejecuciones = Programacion::whereIn('id', $programaciones)
                ->where('ejecutado', true)
                ->count();

            $horas = Programacion::whereIn('id', $programaciones)
                ->sum('duracion');

            $registro->pre_program = $pre_programados;
            $registro->program_final = $program_final;
            $registro->ejecuciones = $ejecuciones;
            $registro->horas = $horas ?? 0;

            return $registro;
        });
    }

    // Retornar la unidad seleccionada si el usuario selecciona de la lista
    #[Computed]
    public function unidad()
    {
        $vista = DB::connection('pgsql_sap')->table('vw_gerencias_unidades');

        if (! $this->unidad_seleccionada) {
            return $vista->get();
        }

        return $vista->where('texto_unidad', $this->unidad_seleccionada)->get();
    }

    public function filtrar($query)
    {
        $campos = [
            'texto_gerencia' => $this->data_filtrada['texto_gerencia'],
            'texto_unidad' => $this->data_filtrada['texto_unidad'],
        ];

        foreach ($campos as $campo => $valor) {
            if (! empty($valor)) {
                $query->where($campo, 'ilike', '%'.$valor.'%');
            }
        }

        return $query;
    }

    public function resumen_gerencias($gerencia)
    {
        if (! $gerencia) {
            return;
        }

        // Asegurar que la gerencia seleccionada sea la que se va a exportar
        if ($this->gerencia_seleccionada !== $gerencia) {
            $this->gerencia_seleccionada = $gerencia;
            // Se debe volver a computar `$this->gerencia` internamente, pero
            // al acceder a $this->gerencia, Livewire lo reevaluará si limpiamos la caché.
            unset($this->gerencia);
        }

        $unidades = $this->gerencia;

        return (new ResumenGerenciaPdf(
            nombre_gerencia: $gerencia,
            unidades: $unidades,
        ))->download();
    }

    public function render()
    {
        return view('livewire.data-gerencias');
    }
}

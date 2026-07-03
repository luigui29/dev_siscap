<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

use App\Models\RrhhPersonal;
use App\Models\PersonalProgramacion;
use App\Models\Programacion;

use Illuminate\Support\Facades\DB;

class DataGerencias extends Component
{
    /* PROPIEDADES */
    public $data_filtrada = [
        'texto_gerencia' => null,
        'texto_unidad' => null
    ];

    public $gerencia_seleccionada = null;
    public $unidad_seleccionada = null;

    /* EVENTOS */
    /*
    * Al recibir la busqueda del filtro, se guarda en las propiedades
    */
    #[On('busqueda-filtrada')]
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

    // Retornar la gerencia seleccionada si el usuario selecciona de la lista
    #[Computed]
    public function gerencia()
    {
        $vista = DB::connection('pgsql_sap')->table('vw_gerencias_unidades');

        $query = $vista->when($this->gerencia_seleccionada, function($q) {
            return $q->where('texto_gerencia', $this->gerencia_seleccionada);
        });

        $rows = $query->get();

        return $rows->map(function($row) {
            $fichas = RrhhPersonal::where('texto_unidad', $row->texto_unidad)
                ->pluck('ficha')
                ->toArray();
            $row->numero_empleados = count($fichas);
            if (empty($fichas)) {
                $row->pre_program = 0;
                $row->program_final = 0;
                $row->ejecuciones = 0;
                $row->horas = 0;
                return $row;
            }

            $programacionIds = PersonalProgramacion::whereIn('ficha_empleado', $fichas)
                ->distinct()
                ->pluck('programacion_id')
                ->toArray();

            if (empty($programacionIds)) {
                $row->pre_program = 0;
                $row->program_final = 0;
                $row->ejecuciones = 0;
                $row->horas = 0;
                return $row;
            }

            $preProgram = Programacion::whereIn('id', $programacionIds)
                ->whereNull('aprobado')
                ->whereNull('ejecutado')
                ->count();

            $programFinal = Programacion::whereIn('id', $programacionIds)
                ->where('aprobado', true)
                ->whereNull('ejecutado')
                ->count();

            $ejecuciones = Programacion::whereIn('id', $programacionIds)
                ->where('ejecutado', true)
                ->count();

            $horas = Programacion::whereIn('id', $programacionIds)
                ->sum('duracion');

            $row->pre_program = $preProgram;
            $row->program_final = $programFinal;
            $row->ejecuciones = $ejecuciones;
            $row->horas = $horas ?? 0;

            return $row;
        });
    }

    // Retornar la unidad seleccionada si el usuario selecciona de la lista
    #[Computed]
    public function unidad()
    {
        $vista = DB::connection('pgsql_sap')->table('vw_gerencias_unidades');

        if (!$this->unidad_seleccionada) {
            return $vista->get();
        }    

        return $vista->where('texto_unidad', $this->unidad_seleccionada)->get();
    }

    public function filtrar($query)
    {
        $campos = [
            'texto_gerencia' => $this->data_filtrada['texto_gerencia'],
            'texto_unidad' => $this->data_filtrada['texto_unidad']
        ];

        foreach ($campos as $campo => $valor) {
            if (!empty($valor)) {
                $query->where($campo, 'ilike', '%' . $valor . '%');
            }
        }

        return $query;
    }

    public function render()
    {
        return view('livewire.data-gerencias');
    }
}
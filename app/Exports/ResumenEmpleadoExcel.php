<?php

namespace App\Exports;

use App\Models\RrhhPersonal;
use App\Models\NivelEducativo;
use App\Models\ExperienciaLaboral;
use App\Models\NivelIngles;
use App\Models\Area;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ResumenEmpleadoExcel implements FromArray, WithCustomCsvSettings
{
    protected $ficha;

    public function __construct($ficha)
    {
        $this->ficha = $ficha;
    }

    public function array(): array
    {
        $empleado = RrhhPersonal::where('ficha', $this->ficha)->first();
        if (!$empleado) {
            return [];
        }

        $educaciones = NivelEducativo::where('ficha_empleado', $this->ficha)->orderBy('created_at', 'desc')->get();
        $experienciasDb = ExperienciaLaboral::where('ficha_empleado', $this->ficha)->orderBy('desde', 'desc')->get();
        $ingles = NivelIngles::where('ficha_empleado', $this->ficha)->first();

        $experienciasInternas = $experienciasDb->filter(function($exp) {
            return trim(strtoupper($exp->empresa)) === 'VENPRECAR';
        });
        $experienciasExternas = $experienciasDb->filter(function($exp) {
            return trim(strtoupper($exp->empresa)) !== 'VENPRECAR';
        });

        $areas = Area::where('estatus', true)->orderBy('nombre')->get();
        $cursosUsuario = DB::table('pl_programaciones')
            ->join('tbl_programaciones', 'pl_programaciones.programacion_id', '=', 'tbl_programaciones.id')
            ->join('tbl_actividades', 'tbl_programaciones.actividad_id', '=', 'tbl_actividades.id')
            ->where('pl_programaciones.ficha_empleado', $this->ficha)
            ->select(
                'tbl_programaciones.nombre',
                'tbl_programaciones.fecha',
                'tbl_programaciones.duracion',
                'pl_programaciones.estatus',
                'pl_programaciones.causa',
                'tbl_actividades.area_id'
            )
            ->orderBy('tbl_programaciones.fecha', 'desc')
            ->get();

        $rows = [];
        
        // Información General
        $rows[] = ['INFORMACIÓN GENERAL'];
        $rows[] = ['Nombre Completo', $empleado->nombre_empleado];
        $rows[] = ['Ficha', $empleado->ficha];
        $rows[] = ['Cargo', $empleado->texto_cargo ?? 'No definido'];
        $rows[] = ['Gerencia', $empleado->texto_gerencia ?? 'No definida'];
        $rows[] = ['Unidad', $empleado->texto_unidad ?? 'No definida'];
        $rows[] = [];

        // Nivel Educativo
        $rows[] = ['NIVEL EDUCATIVO'];
        $rows[] = ['NIVEL DE EDUCACIÓN', 'TÍTULO / CARRERA', 'INSTITUTO', 'GRADUADO', 'ÚLTIMO NIVEL', 'AÑO'];
        if ($educaciones->isEmpty()) {
            $rows[] = ['No hay formación registrada.'];
        } else {
            foreach ($educaciones as $edu) {
                $rows[] = [
                    $edu->nivel_educativo,
                    $edu->titulo . ($edu->especialidad ? ' - ' . $edu->especialidad : ''),
                    $edu->instituto,
                    $edu->graduado ? 'SÍ' : 'NO',
                    $edu->ultimo_nivel ? 'SÍ' : 'NO',
                    $edu->fecha_culminado
                ];
            }
        }
        $rows[] = [];

        // Experiencia Interna
        $rows[] = ['EXPERIENCIA LABORAL INTERNA'];
        $rows[] = ['CARGO DESEMPEÑADO', 'EMPRESA', 'DESDE', 'HASTA', 'OBSERVACIONES'];
        if ($experienciasInternas->isEmpty()) {
            $rows[] = ['No hay experiencia interna registrada.'];
        } else {
            foreach ($experienciasInternas as $exp) {
                $rows[] = [
                    $exp->cargo_desempeñado,
                    $exp->empresa,
                    $exp->desde ? \Carbon\Carbon::parse($exp->desde)->format('d/m/Y') : '',
                    $exp->hasta ? \Carbon\Carbon::parse($exp->hasta)->format('d/m/Y') : 'Actualidad',
                    $exp->observacion
                ];
            }
        }
        $rows[] = [];

        // Experiencia Externa
        $rows[] = ['EXPERIENCIA LABORAL EXTERNA'];
        $rows[] = ['CARGO DESEMPEÑADO', 'EMPRESA', 'DESDE', 'HASTA', 'OBSERVACIONES'];
        if ($experienciasExternas->isEmpty()) {
            $rows[] = ['No hay experiencia externa registrada.'];
        } else {
            foreach ($experienciasExternas as $exp) {
                $rows[] = [
                    $exp->cargo_desempeñado,
                    $exp->empresa,
                    $exp->desde ? \Carbon\Carbon::parse($exp->desde)->format('d/m/Y') : '',
                    $exp->hasta ? \Carbon\Carbon::parse($exp->hasta)->format('d/m/Y') : 'Actualidad',
                    $exp->observacion
                ];
            }
        }
        $rows[] = [];

        // Nivel de Inglés
        $rows[] = ['NIVEL DE INGLÉS'];
        if ($ingles) {
            $niveles = [];
            if ($ingles->i1) $niveles[] = 'Instrumental 1 (I1)';
            if ($ingles->i2) $niveles[] = 'Instrumental 2 (I2)';
            if ($ingles->bb) $niveles[] = 'Básico Básico (BB)';
            if ($ingles->ba) $niveles[] = 'Básico Alto (BA)';
            if ($ingles->ib) $niveles[] = 'Intermedio Básico (IB)';
            if ($ingles->ia) $niveles[] = 'Intermedio Alto (IA)';
            if ($ingles->ab) $niveles[] = 'Avanzado Básico (AB)';
            if ($ingles->aa) $niveles[] = 'Avanzado Alto (AA)';
            if (empty($niveles)) {
                $rows[] = ['No se han registrado niveles de inglés aprobados.'];
            } else {
                $rows[] = [implode(', ', $niveles)];
            }
        } else {
            $rows[] = ['No se han registrado niveles de inglés aprobados.'];
        }
        $rows[] = [];

        // Cursos
        $rows[] = ['PARTICIPACIÓN EN CURSOS DE CAPACITACIÓN'];
        foreach ($areas as $area) {
            $rows[] = ['ÁREA: ' . $area->nombre];
            $cursos = $cursosUsuario->where('area_id', $area->id);
            if ($cursos->isEmpty()) {
                $rows[] = ['No hay participación en cursos de esta área.'];
            } else {
                $rows[] = ['CURSO / PROGRAMA', 'FECHA', 'DURACIÓN (Hrs)', 'ESTATUS', 'CAUSA'];
                foreach ($cursos as $curso) {
                    $estatusTexto = 'Pendiente';
                    if (!is_null($curso->estatus)) {
                        $estatusTexto = $curso->estatus ? 'Asistente' : 'Inasistente';
                    }
                    $rows[] = [
                        $curso->nombre,
                        \Carbon\Carbon::parse($curso->fecha)->format('d/m/Y'),
                        number_format($curso->duracion, 1),
                        $estatusTexto,
                        $curso->causa ?: 'N/A'
                    ];
                }
            }
            $rows[] = [];
        }

        return $rows;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ',',
            'enclosure' => '"',
            'use_bom' => true,
        ];
    }
}

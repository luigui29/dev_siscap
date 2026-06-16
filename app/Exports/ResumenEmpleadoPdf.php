<?php

namespace App\Exports;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\RrhhPersonal;
use App\Models\NivelEducativo;
use App\Models\ExperienciaLaboral;
use App\Models\NivelIngles;
use App\Models\Area;
use Illuminate\Support\Facades\DB;

class ResumenEmpleadoPdf
{
    protected $ficha;

    public function __construct($ficha)
    {
        $this->ficha = $ficha;
    }

    public function download()
    {
        $empleado = RrhhPersonal::where('ficha', $this->ficha)->first();
        if (!$empleado) {
            return null;
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

        $cursosPorArea = [];
        foreach ($areas as $area) {
            $cursosPorArea[] = [
                'area_nombre' => $area->nombre,
                'cursos' => $cursosUsuario->where('area_id', $area->id)->values()
            ];
        }

        $html = view('pdfexports.resumen-empleado-pdf', compact(
            'empleado', 'educaciones', 'experienciasInternas', 'experienciasExternas', 'ingles', 'cursosPorArea'
        ))->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response()->streamDownload(function () use ($dompdf) {
            echo $dompdf->output();
        }, 'Resumen_Perfil_' . $empleado->ficha . '.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }
}

<?php

namespace App\Exports;

use App\Models\PersonalProgramacion;
use App\Models\Programacion;
use App\Models\RrhhPersonal;
use Dompdf\Dompdf;
use Dompdf\Options;

class ControlAsistenciaPdf
{
    public function __construct(
        protected Programacion $programacion,
    ) {}

    /**
     * Obtiene los empleados matriculados en la programación y genera el PDF.
     */
    public function download()
    {
        $programacion = $this->programacion;

        /* Obtener fichas de empleados matriculados en esta programación */
        $fichas = PersonalProgramacion::where('programacion_id', $programacion->id)
            ->pluck('ficha_empleado');

        /* Consultar datos del personal desde la tabla de RRHH */
        $empleados = RrhhPersonal::whereIn('ficha', $fichas)
            ->select('ficha', 'nombre_empleado', 'cedula', 'texto_gerencia', 'texto_cargo', 'texto_unidad')
            ->orderBy('nombre_empleado', 'asc')
            ->get();

        $html = view('pdf.control-asistencia-pdf', compact(
            'programacion', 'empleados'
        ))->render();

        $options = new Options;
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return response()->streamDownload(function () use ($dompdf) {
            echo $dompdf->output();
        }, 'Control_Asistencia_'.$programacion->id.'.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }
}

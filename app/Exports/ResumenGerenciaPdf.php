<?php

namespace App\Exports;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Collection;

class ResumenGerenciaPdf
{
    /**
     * @param  Collection  $unidades  Colección de unidades con sus cálculos
     */
    public function __construct(
        protected string $nombre_gerencia,
        protected Collection $unidades,
    ) {}

    public function download()
    {
        $nombre_gerencia = $this->nombre_gerencia;
        $unidades = $this->unidades;

        $total_empleados = $unidades->sum('numero_empleados');
        $total_horas = $unidades->sum('horas');
        $total_ejecuciones = $unidades->sum('ejecuciones');
        $total_pre_program = $unidades->sum('pre_program');
        $total_program_final = $unidades->sum('program_final');

        $html = view('pdf.resumen-gerencia-pdf', compact(
            'nombre_gerencia',
            'unidades',
            'total_empleados',
            'total_horas',
            'total_ejecuciones',
            'total_pre_program',
            'total_program_final'
        ))->render();

        $options = new Options;
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response()->streamDownload(function () use ($dompdf) {
            echo $dompdf->output();
        }, 'Resumen_Gerencia_'.$nombre_gerencia.'.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }
}

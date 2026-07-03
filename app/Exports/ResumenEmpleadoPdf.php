<?php

namespace App\Exports;

use App\Models\RrhhPersonal;
use Dompdf\Dompdf;
use Dompdf\Options;

use Illuminate\Support\Collection;

use Carbon\Carbon;

class ResumenEmpleadoPdf
{
    public function __construct(
        protected RrhhPersonal $empleado,
        protected ?Collection $educaciones,
        protected ?Collection $experiencias_internas,
        protected ?Collection $experiencias_externas,
        protected mixed $nivel_ingles,
        protected Collection $cursos,
    ) {}

    public function download()
    {
        $empleado = $this->empleado;
        $educaciones = $this->educaciones ?? collect();
        $ingles = $this->nivel_ingles;

        /* Formatear fechas de experiencias */
        $experiencias_internas = ($this->experiencias_internas ?? collect())->map(function ($exp) {
            $exp->desde = $exp->desde ? Carbon::parse($exp->desde)->format('d-m-Y') : null;
            $exp->hasta = $exp->hasta ? Carbon::parse($exp->hasta)->format('d-m-Y') : null;

            return $exp;
        });

        $experiencias_externas = ($this->experiencias_externas ?? collect())->map(function ($exp) {
            $exp->desde = $exp->desde ? Carbon::parse($exp->desde)->format('d-m-Y') : null;
            $exp->hasta = $exp->hasta ? Carbon::parse($exp->hasta)->format('d-m-Y') : null;

            return $exp;
        });

        /* Transformar la colección agrupada por nombre de area a un arreglo
         * con la estructura [['area_nombre' => ..., 'cursos' => ...], ...]
         * que espera la vista Blade del PDF.
         */
        $cursos_en_area = $this->cursos->map(function ($cursos_area, $nombre_area) {
            $cursos_formateados = $cursos_area->map(function ($curso) {
                $curso->duracion = number_format($curso->duracion, 1);

                return $curso;
            });

            return [
                'area_nombre' => $nombre_area,
                'cursos' => $cursos_formateados,
            ];
        })->values()->toArray();

        $html = view('pdf.resumen-empleado-pdf', compact(
            'empleado', 'educaciones', 'experiencias_internas', 'experiencias_externas', 'ingles', 'cursos_en_area'
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
        }, 'Resumen_Perfil_'.$empleado->ficha.'.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }
}

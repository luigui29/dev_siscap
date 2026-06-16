<?php

namespace App\Exports;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\RrhhPersonal;
use App\Models\Area;
use Illuminate\Support\Facades\DB;

class ResumenGerenciaPdf
{
    protected $gerencia;
    protected $unidad;

    public function __construct($gerencia, $unidad = null)
    {
        $this->gerencia = $gerencia;
        $this->unidad = $unidad;
    }

    public function download()
    {
        $query = RrhhPersonal::select('ficha', 'texto_gerencia', 'texto_unidad');
        if (!empty($this->gerencia)) {
            $query->where('texto_gerencia', $this->gerencia);
        }
        if (!empty($this->unidad)) {
            $query->where('texto_unidad', $this->unidad);
        }
        $empleados = $query->get();
        
        if ($empleados->isEmpty()) {
            return null; // O manejar el error
        }

        $fichas = $empleados->pluck('ficha')->toArray();
        $empleadosPorFicha = $empleados->keyBy('ficha');

        $participaciones = DB::table('pl_programaciones')
            ->join('tbl_programaciones', 'pl_programaciones.programacion_id', '=', 'tbl_programaciones.id')
            ->join('tbl_actividades', 'tbl_programaciones.actividad_id', '=', 'tbl_actividades.id')
            ->whereIn('pl_programaciones.ficha_empleado', $fichas)
            ->select('pl_programaciones.ficha_empleado', 'tbl_programaciones.duracion', 'tbl_actividades.area_id')
            ->get();

        $areas = Area::all()->keyBy('id');

        $datosPorUnidad = [];
        $totalHorasGerencia = 0;

        foreach ($empleados as $emp) {
            $unidad = $emp->texto_unidad ?: 'NO DEFINIDA';
            if (!isset($datosPorUnidad[$unidad])) {
                $datosPorUnidad[$unidad] = [
                    'nombre' => $unidad,
                    'total_horas' => 0,
                    'areas' => []
                ];
            }
        }

        foreach ($participaciones as $p) {
            $emp = $empleadosPorFicha->get($p->ficha_empleado);
            if (!$emp) continue;
            
            $unidad = $emp->texto_unidad ?: 'NO DEFINIDA';
            $areaId = $p->area_id;
            $areaNombre = isset($areas[$areaId]) ? $areas[$areaId]->nombre : 'SIN ÁREA';
            
            if (!isset($datosPorUnidad[$unidad]['areas'][$areaNombre])) {
                $datosPorUnidad[$unidad]['areas'][$areaNombre] = 0;
            }
            
            $horas = (float) $p->duracion;
            $datosPorUnidad[$unidad]['areas'][$areaNombre] += $horas;
            $datosPorUnidad[$unidad]['total_horas'] += $horas;
            $totalHorasGerencia += $horas;
        }
        
        ksort($datosPorUnidad);
        foreach ($datosPorUnidad as &$unidadData) {
            arsort($unidadData['areas']);
        }

        $tituloGerencia = !empty($this->gerencia) ? $this->gerencia : 'TODAS LAS GERENCIAS';
        if (!empty($this->unidad)) {
            $tituloGerencia .= ' - ' . $this->unidad;
        }

        $html = view('pdfexports.resumen-gerencia-pdf', compact(
            'tituloGerencia', 'datosPorUnidad', 'totalHorasGerencia'
        ))->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $nombreArchivo = 'Resumen_Gerencia_' . (!empty($this->gerencia) ? str_replace(' ', '_', $this->gerencia) : 'Global') . '.pdf';

        return response()->streamDownload(function () use ($dompdf) {
            echo $dompdf->output();
        }, $nombreArchivo, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}

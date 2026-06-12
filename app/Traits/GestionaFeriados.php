<?php

namespace App\Traits;

use Carbon\Carbon;

/**
 * Este Trait se utiliza en el Calendario para obtener los días laborables y mostrarlos como tal
 * También se utiliza para verificar si, por ejemplo, un caso se apertura en una fecha válida
 */
trait GestionaFeriados
{
    /**
     * Verifica si una fecha es día laboral.
     */
    public function esDiaLaboral(Carbon $fecha): bool
    {
        return ! $fecha->isWeekend() && ! $this->esFeriado($fecha);
    }

    /**
     * Verifica si una fecha es feriado fijo o móvil.
     */
    public function esFeriado(Carbon $fecha): bool
    {
        $fijos = config('feriados.fijos', []);
        $moviles = config('feriados.moviles.'.$fecha->year, []);

        $mesDia = $fecha->format('m-d');

        return in_array($mesDia, $fijos) || in_array($mesDia, $moviles);
    }

    /**
     * Ajusta una fecha al siguiente día laboral si cae en fin de semana o feriado.
     */
    public function obtenerProximoDiaLaboral(Carbon $fecha): Carbon
    {
        $fechaAjustada = $fecha->copy();

        while (! $this->esDiaLaboral($fechaAjustada)) {
            $fechaAjustada->addDay();
        }

        return $fechaAjustada;
    }
}

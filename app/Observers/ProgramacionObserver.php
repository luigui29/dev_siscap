<?php

namespace App\Observers;

use App\Models\Programacion;
use Illuminate\Support\Facades\DB;

class ProgramacionObserver
{
    /**
     * Cada vez que la tabla 'tbl_programaciones' recibe una nueva programacion,
     * se ejecuta este código.
     */
    public function created(Programacion $programacion): void
    {
        DB::unprepared('REFRESH MATERIALIZED VIEW CONCURRENTLY mvw_pre_programaciones');
    }

    /**
     * Cada vez que la tabla 'tbl_programaciones' se actualiza, se ejecuta este código
     * para borrar la cache de los empleados en cursos posteriormente desaprobados.
     */
    public function updated(Programacion $programacion): void
    {
        if ($programacion->wasChanged('aprobado')) {
            DB::unprepared('REFRESH MATERIALIZED VIEW CONCURRENTLY mvw_programaciones_empleados');
            DB::unprepared('REFRESH MATERIALIZED VIEW CONCURRENTLY mvw_pre_programaciones');
        }
    }

    /**
     * Cada vez que se borra un registro de la tabla 'tbl_programaciones', se ejecuta
     * este código.
     */
    public function deleted(Programacion $programacion): void
    {
        DB::unprepared('REFRESH MATERIALIZED VIEW CONCURRENTLY mvw_pre_programaciones');
    }

    /**
     * Handle the Programacion "restored" event.
     */
    public function restored(Programacion $programacion): void
    {
        //
    }

    /**
     * Handle the Programacion "force deleted" event.
     */
    public function forceDeleted(Programacion $programacion): void
    {
        //
    }
}

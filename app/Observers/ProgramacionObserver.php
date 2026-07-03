<?php

namespace App\Observers;

use App\Models\Programacion;
use Illuminate\Support\Facades\DB;

class ProgramacionObserver
{
    /**
     * Handle the Programacion "created" event.
     */
    public function created(Programacion $programacion): void
    {
        //
    }

    /**
     * Cada vez que la tabla 'tbl_programaciones' se actualiza, se ejecuta este código
     * para borrar la cache de los empleados en cursos posteriormente desaprobados .
     */
    public function updated(Programacion $programacion): void
    {
        if ($programacion->wasChanged('aprobado')) {
            DB::unprepared('REFRESH MATERIALIZED VIEW CONCURRENTLY mvw_programaciones_empleados');
        }
    }

    /**
     * Handle the Programacion "deleted" event.
     */
    public function deleted(Programacion $programacion): void
    {
        //
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

<?php

namespace App\Observers;

use App\Models\PersonalProgramacion;
use Illuminate\Support\Facades\DB;

class PersonalProgramacionObserver
{
    /*
    * Actualiza la vista materializada cuando cambia la programación del personal
    */
    public function refrescarCache(PersonalProgramacion $personalProgramacion): void
    {
        DB::unprepared('REFRESH MATERIALIZED VIEW CONCURRENTLY mvw_programaciones_empleados');
        DB::unprepared('REFRESH MATERIALIZED VIEW CONCURRENTLY mvw_programaciones_finales');
    }

    /**
     * Handle the PersonalProgramacion "created" event.
     */
    public function created(PersonalProgramacion $personalProgramacion): void
    {
        $this->refrescarCache($personalProgramacion);
    }

    /**
     * Handle the PersonalProgramacion "updated" event.
     */
    public function updated(PersonalProgramacion $personalProgramacion): void
    {
        $this->refrescarCache($personalProgramacion);
    }

    /**
     * Handle the PersonalProgramacion "deleted" event.
     */
    public function deleted(PersonalProgramacion $personalProgramacion): void
    {
        $this->refrescarCache($personalProgramacion);
    }

    /**
     * Handle the PersonalProgramacion "restored" event.
     */
    public function restored(PersonalProgramacion $personalProgramacion): void
    {
        //
    }

    /**
     * Handle the PersonalProgramacion "force deleted" event.
     */
    public function forceDeleted(PersonalProgramacion $personalProgramacion): void
    {
        //
    }
}

<?php

namespace App\Observers;

use App\Models\PersonalProgramacion;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PersonalProgramacionObserver
{
    /*
    * Limpieza de caché y actualización de la base de datos
    */
    public function refrescarCache(PersonalProgramacion $personalProgramacion): void
    {
        DB::unprepared('REFRESH MATERIALIZED VIEW CONCURRENTLY mvw_programaciones_empleados');

        $cacheKey = 'programaciones_empleado_'.$personalProgramacion->ficha_empleado;
        Cache::forget($cacheKey);
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
        * La siguiente vista materializada tiene el propósito de almacenar los nombres
        * de las actividades, subactividades y facilitadores de las pre-programaciones
        * [aprobado y ejecutado = null] así como su demás información
        */
        DB::statement('
            CREATE MATERIALIZED VIEW mvw_pre_programaciones AS
            SELECT
                tp.id AS programacion_id,
                ta.nombre AS nombre_area,
                tact.nombre AS nombre_actividad,
                tsact.nombre AS nombre_subactividad,
                tfac.nombre AS nombre_facilitador,
                tp.institucion,
                tp.fecha,
                tp.lugar,
                tp.desde,
                tp.hasta,
                tp.duracion
            FROM tbl_programaciones tp
            JOIN tbl_actividades tact ON tp.actividad_id = tact.id
            JOIN tbl_areas ta ON tact.area_id = ta.id
            JOIN tbl_subactividades tsact ON tp.subactividad_id = tsact.id
            JOIN tbl_facilitadores tfac ON tp.facilitador_id = tfac.id
            WHERE tp.aprobado IS NULL AND tp.ejecutado IS NULL
        ');
        /* INDICES */
        /*
        * Este índice único se utiliza para ejecutar REFRESH CONCURRENTLY
        * en PostgreSQL, lo cual permite el acceso a la vista mientras es actualizada.
        * Se compone del índice compuesto ya existente en pl_programaciones.
        */
        DB::statement('
            CREATE UNIQUE INDEX mvw_pre_programaciones_unique_idx
            ON mvw_pre_programaciones (programacion_id)
        ');

        /* Estos índices se utilizan para optimizar los filtros de area, actividad, subactividad y fecha */
        DB::statement('CREATE INDEX mvw_pre_programaciones_area_idx ON mvw_pre_programaciones (nombre_area);');
        DB::statement('CREATE INDEX mvw_pre_programaciones_actividad_idx ON mvw_pre_programaciones (nombre_actividad);');
        DB::statement('CREATE INDEX mvw_pre_programaciones_subactividad_idx ON mvw_pre_programaciones (nombre_subactividad);');
        DB::statement('CREATE INDEX mvw_pre_programaciones_fecha_idx ON mvw_pre_programaciones (fecha);');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP MATERIALIZED VIEW IF EXISTS mvw_pre_programaciones');
    }
};

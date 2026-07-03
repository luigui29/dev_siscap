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
        * La siguiente vista materializada tiene el propósito de almacenar información
        * a mostrar en el frontend con respecto a los cursos en los que los empleados
        * han sido matriculados (programaciones finales, [aprobado = true], pendientes
        * o no por ejecutar)
        */
        DB::statement('
            CREATE MATERIALIZED VIEW mvw_programaciones_empleados AS
            SELECT
                pl.programacion_id,
                pl.ficha_empleado,
                ta.nombre AS nombre_area,
                tact.nombre AS nombre_actividad,
                tsact.nombre AS nombre_subactividad,
                tfac.nombre AS nombre_facilitador,
                tp.institucion,
                tp.fecha,
                tp.lugar,
                tp.duracion,
                pl.estatus AS asistencia,
                pl.causa
            FROM pl_programaciones pl
            JOIN tbl_programaciones tp ON pl.programacion_id = tp.id
            JOIN tbl_actividades tact ON tp.actividad_id = tact.id
            JOIN tbl_areas ta ON tact.area_id = ta.id
            JOIN tbl_subactividades tsact ON tp.subactividad_id = tsact.id
            JOIN tbl_facilitadores tfac ON tp.facilitador_id = tfac.id
            WHERE tp.aprobado = true');

        /* INDICES */
        /*
        * Este índice único se utiliza para ejecutar REFRESH CONCURRENTLY
        * en PostgreSQL, lo cual permite el acceso a la vista mientras es actualizada.
        * Este índice se compone del índice compuesto ya existente en pl_programaciones.
        */
        DB::statement('
                CREATE UNIQUE INDEX mvw_programaciones_unique_idx
                ON mvw_programaciones_empleados (programacion_id, ficha_empleado)
            ');

        /*
        * El siguiente índice es utilizado para optimizar la búsqueda según
        * los filtros de empleados
        */
        DB::statement('
                CREATE INDEX mvw_programaciones_ficha_idx
                ON mvw_programaciones_empleados (ficha_empleado)
            ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP MATERIALIZED VIEW IF EXISTS mvw_programaciones_empleados');
    }
};

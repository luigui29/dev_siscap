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
        * La siguiente vista reúne las gerencias y las unidades de tbl_rrhh_personal
        * para usarlas en el filtro de gerencias y unidades.
        */
        DB::connection('pgsql_sap')->statement("
            CREATE OR REPLACE VIEW vw_gerencias_unidades AS
            SELECT
                ROW_NUMBER() OVER (ORDER BY texto_gerencia, texto_unidad) AS id,
                texto_gerencia,
                texto_unidad,
                COUNT(*) AS numero_empleados
            FROM
                tbl_rrhh_personal
            WHERE
                texto_status = 'ACTIVO'
            GROUP BY
                texto_gerencia,
                texto_unidad;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::connection('pgsql_sap')->statement("
            DROP VIEW IF EXISTS vw_gerencias_unidades;
        ");
    }
};

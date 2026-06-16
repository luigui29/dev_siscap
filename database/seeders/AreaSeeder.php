<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Area::factory()
            ->count(4)
            ->sequence(
                ['nombre' => 'AMBIENTE', 'descripcion' => 'Cursos sobre concientización ambiental y riesgos relacionados', 'estatus' => true],
                ['nombre' => 'ESTRATEGICA', 'descripcion' => 'Cursos sobre operaciones y efectividad a nivel empresarial', 'estatus' => true],
                ['nombre' => 'SEGURIDAD Y SALUD LABORAL', 'descripcion' => 'Cursos sobre cuidado y protección personal en las instalaciones de la empresa', 'estatus' => true],
                ['nombre' => 'TECNICA Y CONDUCTUAL', 'descripcion' => 'Cursos sobre etiqueta y tácticas para los trabajadores', 'estatus' => true],
             )
            ->create();
    }
}
<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory()
            ->count(3)
            ->sequence(
                ['nombre' => 'Analista', 'descripcion' => 'Analista', 'estatus' => true],
                ['nombre' => 'Coordinador', 'descripcion' => 'Coordinador', 'estatus' => true],
                ['nombre' => 'Gerente', 'descripcion' => 'Gerente', 'estatus' => true]
             )
            ->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\PersonalRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonalRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PersonalRole::factory()
            ->count(3)
            ->sequence(
                ['ficha_empleado' => 12345, 'rol_id' => 1],
                ['ficha_empleado' => 67890, 'rol_id' => 2],
                ['ficha_empleado' => 88888, 'rol_id' => 3]
            )
            ->create();
    }
}

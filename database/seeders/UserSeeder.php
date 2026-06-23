<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(3)
            ->sequence(
                ['ficha' => 12345, 'name' => "Analista Test", 'password' => "test.analista"],
                ['ficha' => 67890, 'name' => "Coord Test", 'password' => "test.coordinador"],
                ['ficha' => 88888, 'name' => "Gerente Test", 'password' => "test.gerente"]
            )
            ->create();
    }
}

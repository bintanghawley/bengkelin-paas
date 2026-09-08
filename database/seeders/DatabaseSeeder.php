<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $seeders = [
            RoleUserSeeder::class,
            ServiceSeeder::class,
            TireSeeder::class,
            OilSeeder::class,
            SparepartSeeder::class,
        ];

        $this->call($seeders);
    }
}

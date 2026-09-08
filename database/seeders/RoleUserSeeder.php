<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['nomor_telepon' => '081234567890'],
            [
                'name' => 'Admin',
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['nomor_telepon' => '081234567891'],
            [
                'name' => 'Mekanik',
                'password' => Hash::make('123456'),
                'role' => 'mekanik',
            ]
        );

        User::updateOrCreate(
            ['nomor_telepon' => '081234567892'],
            [
                'name' => 'Pengguna',
                'password' => Hash::make('123456'),
                'role' => 'pengguna',
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@propuestas.com',
            'password' => Hash::make('admin123'),
            'role' => 'Administrador'
        ]);

        User::create([
            'name' => 'Usuario Amigo',
            'email' => 'amigo@propuestas.com',
            'password' => Hash::make('amigo123'),
            'role' => 'Amigo'
        ]);
    }
}

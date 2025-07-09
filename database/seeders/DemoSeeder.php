<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Categoria;
use App\Models\Propuesta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuarios
        $admin = User::create([
            'name' => 'Administrador Municipal',
            'email' => 'admin@propuestas.com',
            'password' => Hash::make('admin123'),
            'role' => 'Administrador'
        ]);

        $amigo = User::create([
            'name' => 'Juan Pérez',
            'email' => 'amigo@propuestas.com',
            'password' => Hash::make('amigo123'),
            'role' => 'Amigo'
        ]);

        // Crear categorías
        $categorias = [
            'Infraestructura Vial',
            'Alumbrado Público',
            'Parques y Recreación',
            'Servicios Públicos',
            'Seguridad Ciudadana',
            'Medio Ambiente'
        ];

        foreach ($categorias as $nombre) {
            Categoria::create(['nombre' => $nombre]);
        }

        // Crear propuestas de ejemplo
        $propuestas = [
            [
                'titulo' => 'Reparación de calles en el centro',
                'categoria_id' => 1,
                'descripcion' => 'Las calles del centro de la ciudad necesitan reparación urgente debido a los baches y deterioro del pavimento que afectan el tránsito vehicular y peatonal.',
                'estado' => 'aprobada',
                'user_id' => $amigo->id
            ],
            [
                'titulo' => 'Instalación de luminarias LED',
                'categoria_id' => 2,
                'descripcion' => 'Propuesta para cambiar las luminarias tradicionales por tecnología LED en las principales avenidas para mejorar la iluminación y reducir el consumo energético.',
                'estado' => 'pendiente',
                'user_id' => $amigo->id
            ],
            [
                'titulo' => 'Nuevo parque infantil en zona residencial',
                'categoria_id' => 3,
                'descripcion' => 'Construcción de un parque infantil con juegos seguros y áreas verdes en el sector residencial Las Flores para el esparcimiento de las familias.',
                'estado' => 'pendiente',
                'user_id' => $admin->id
            ],
            [
                'titulo' => 'Mejora del sistema de recolección de basura',
                'categoria_id' => 4,
                'descripcion' => 'Optimizar las rutas y horarios de recolección de basura, además de implementar contenedores en puntos estratégicos de la ciudad.',
                'estado' => 'aprobada',
                'user_id' => $amigo->id
            ],
            [
                'titulo' => 'Cámaras de seguridad en parques',
                'categoria_id' => 5,
                'descripcion' => 'Instalación de un sistema de videovigilancia en los principales parques de la ciudad para mejorar la seguridad ciudadana.',
                'estado' => 'rechazada',
                'user_id' => $admin->id
            ]
        ];

        foreach ($propuestas as $propuesta) {
            Propuesta::create($propuesta);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Infraestructura',
            'Servicios Públicos',
            'Medio Ambiente',
            'Seguridad',
            'Educación',
            'Salud',
            'Transporte',
            'Cultura y Recreación'
        ];

        foreach ($categorias as $categoria) {
            Categoria::create(['nombre' => $categoria]);
        }
    }
}

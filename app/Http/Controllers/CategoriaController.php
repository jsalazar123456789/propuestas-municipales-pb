<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function store(Request $request)
    {
        try {
            \Log::info('Creando categoría:', $request->all());
            
            $request->validate(['nombre' => 'required|string|max:255']);
            $categoria = Categoria::create($request->only('nombre'));
            
            \Log::info('Categoría creada:', $categoria->toArray());
            
            return response()->json($categoria);
        } catch (\Exception $e) {
            \Log::error('Error creando categoría: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Propuesta;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index()
    {
        $totalPropuestas = Propuesta::count();
        
        $propuestasPorCategoria = Categoria::withCount('propuestas')
            ->with(['propuestas' => function($query) {
                $query->with('user')->latest();
            }])
            ->having('propuestas_count', '>', 0)
            ->orderBy('propuestas_count', 'desc')
            ->get()
            ->map(function ($categoria) use ($totalPropuestas) {
                $categoria->porcentaje = $totalPropuestas > 0 ? round(($categoria->propuestas_count / $totalPropuestas) * 100, 1) : 0;
                return $categoria;
            });

        $propuestasPorEstado = Propuesta::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get()
            ->map(function ($item) use ($totalPropuestas) {
                $item->porcentaje = $totalPropuestas > 0 ? round(($item->total / $totalPropuestas) * 100, 1) : 0;
                return $item;
            });

        $propuestasPorMes = Propuesta::select(
                DB::raw('YEAR(created_at) as año'),
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('año', 'mes')
            ->orderBy('año', 'desc')
            ->orderBy('mes', 'desc')
            ->limit(12)
            ->get();

        return view('reportes.index', compact(
            'totalPropuestas',
            'propuestasPorCategoria', 
            'propuestasPorEstado',
            'propuestasPorMes'
        ));
    }
}

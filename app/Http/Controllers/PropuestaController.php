<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Propuesta;
use Illuminate\Http\Request;

class PropuestaController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $propuestas = Propuesta::with(['categoria', 'user'])->latest()->get();
        } else {
            $propuestas = Propuesta::with(['categoria', 'user'])
                ->where('user_id', auth()->id())
                ->latest()->get();
        }
        
        return view('propuestas.index', compact('propuestas'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('propuestas.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'descripcion' => 'required|string',
            'observaciones' => 'nullable|string',
            'foto1' => 'nullable|image|max:2048',
            'foto2' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['titulo', 'categoria_id', 'descripcion', 'observaciones']);
        $data['user_id'] = auth()->id();
        
        if ($request->hasFile('foto1')) {
            $data['foto1'] = $request->file('foto1')->store('propuestas', 'public');
        }
        if ($request->hasFile('foto2')) {
            $data['foto2'] = $request->file('foto2')->store('propuestas', 'public');
        }

        Propuesta::create($data);
        return redirect()->route('propuestas.index')->with('success', 'Propuesta creada exitosamente');
    }

    public function show(Propuesta $propuesta)
    {
        if (!auth()->user()->isAdmin() && $propuesta->user_id !== auth()->id()) {
            abort(403, 'No tienes permisos para ver esta propuesta.');
        }
        
        $propuesta->load(['categoria', 'user']);
        return view('propuestas.show', compact('propuesta'));
    }

    public function aprobar(Propuesta $propuesta)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para aprobar propuestas.');
        }
        
        $propuesta->update(['estado' => 'aprobada']);
        return redirect()->back()->with('success', 'Propuesta aprobada exitosamente');
    }

    public function rechazar(Propuesta $propuesta)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para rechazar propuestas.');
        }
        
        $propuesta->update(['estado' => 'rechazada']);
        return redirect()->back()->with('success', 'Propuesta rechazada');
    }
}

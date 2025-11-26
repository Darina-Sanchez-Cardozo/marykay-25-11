<?php

namespace App\Http\Controllers;

use App\Models\Campania;
use Illuminate\Http\Request;

class CampaniaController extends Controller
{
    public function index()
    {
        $campanias = Campania::orderBy('id', 'ASC')->get();
        return view('compania.index', compact('campanias'));
    }

    public function create()
    {
        return view('compania.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'estado' => 'required|string'
        ]);

        Campania::create($request->all());

        return redirect()->route('campania.index')
            ->with('success', 'Campaña creada correctamente');
    }

    public function edit($id)
    {
        $campania = Campania::findOrFail($id);
        return view('compania.edit', compact('campania'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'estado' => 'required|string'
        ]);

        $campania = Campania::findOrFail($id);
        $campania->update($request->all());

        return redirect()->route('campania.index')
            ->with('success', 'Campaña actualizada correctamente');
    }

    public function destroy($id)
    {
        $campania = Campania::findOrFail($id);
        $campania->delete();

        return redirect()->route('campania.index')
            ->with('success', 'Campaña eliminada');
    }
}

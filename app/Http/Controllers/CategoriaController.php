<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::orderBy('id', 'ASC')->get();
        return view('categoria.index', compact('categorias'));
    }

    public function create()
    {
        return view('categoria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
        ]);

        Categoria::create($request->all());

        return redirect()->route('categoria.index')
                         ->with('success', 'Categoría creada correctamente');
    }

    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categoria.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->all());

        return redirect()->route('categoria.index')
                         ->with('success', 'Categoría actualizada correctamente');
    }

    public function destroy($id)
    {
        Categoria::destroy($id);

        return redirect()->route('categoria.index')
                         ->with('success', 'Categoría eliminada');
    }
}

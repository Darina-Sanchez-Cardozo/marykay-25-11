<?php

namespace App\Http\Controllers;

use App\Models\Categoria;

class CategoriaProductosController extends Controller
{
    public function index($id)
    {
        // Encuentra la categoría
        $categoria = Categoria::findOrFail($id);

        // Obtén sus productos
        $productos = $categoria->productos()->get();

        return view('categoria.productos', compact('categoria', 'productos'));
    }
}

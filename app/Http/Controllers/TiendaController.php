<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;

class TiendaController extends Controller
{
    public function index()
    {
        // Obtener todas las categorías
        $categorias = Categoria::orderBy('id', 'ASC')->get();

        // Obtener todos los productos
        $productos = Producto::orderBy('id', 'DESC')->get();

        // Enviar ambas variables a la vista
        return view('tienda.index', compact('categorias', 'productos'));
    }
}

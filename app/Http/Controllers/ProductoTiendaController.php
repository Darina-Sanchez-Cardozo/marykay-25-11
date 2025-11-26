<?php

namespace App\Http\Controllers;

use App\Models\Producto;

class ProductoTiendaController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('id', 'DESC')->get();

        return view('productos.lista', compact('productos'));
    }
}

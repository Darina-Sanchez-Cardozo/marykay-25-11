<?php

namespace App\Http\Controllers;

use App\Models\Producto;

class ProductoVistaController extends Controller
{
    public function show($id)
    {
        $producto = Producto::findOrFail($id);

        // Miniaturas (duplicadas por ahora, personalizable)
        $imagenes = [
            $producto->imagen,
            $producto->imagen,
            $producto->imagen,
            $producto->imagen,
        ];

        return view('tienda.producto', compact('producto', 'imagenes'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetalleVenta;
use App\Models\Resena;
use App\Models\VentaCliente;


class MisComprasController extends Controller
{
    // Mostrar compras del usuario actual
    public function index()
{
    // 1. ID del usuario logueado
    $clienteId = session('persona_id');

    if(!$clienteId){
        return view('miscompras.index', ['compras' => collect()]);
    }

    // 2. Buscar ventas del usuario
    $ventas = VentaCliente::where('persona_id', $clienteId)->pluck('id');

    // Si no tiene ventas, regresar vacío
    if($ventas->isEmpty()){
        return view('miscompras.index', ['compras' => collect()]);
    }

    // 3. Buscar detalles de esas ventas
    $compras = DetalleVenta::whereIn('venta_cliente_id', $ventas)
        ->with('producto')
        ->orderBy('created_at', 'DESC')
        ->get();

    return view('miscompras.index', compact('compras'));
}



    // Formulario para agregar reseña
    public function crearResena($detalleId)
    {
        $detalle = DetalleVenta::with('producto')->findOrFail($detalleId);

        return view('miscompras.resena', compact('detalle'));
    }

    // Guardar reseña
    public function guardarResena(Request $request)
    {
        $request->validate([
            'detalle_id' => 'required',
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string'
        ]);

        $detalle = DetalleVenta::findOrFail($request->detalle_id);

       Resena::create([
            'persona_id' => session('persona_id'),
            'producto_id' => $detalle->producto_id,
            'venta_id' => $detalle->venta_cliente_id,
            'calificacion' => $request->calificacion,
            'comentario' => $request->comentario,
        ]);



        return redirect()->route('miscompras.index')
            ->with('success', '¡Gracias por tu reseña!');
    }
}

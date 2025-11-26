<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\VentaCliente;

class CarritoController extends Controller
{
    // Mostrar carrito
 public function index()
{
    $personaId = session('persona_id');

    $detalles = DetalleVenta::with('producto')
                ->where('venta_cliente_id', $personaId)
                ->get();

    $subtotal = $detalles->sum(fn($d) => $d->cantidad * $d->producto->precio_menudeo);

    $envio = ($subtotal > 500) ? 0 : round($subtotal / 100) * 10;

    $total = $subtotal + $envio;

    return view('carrito.index', compact('detalles', 'subtotal', 'envio', 'total'));
}

    // Agregar producto al carrito
    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad'    => 'required|integer|min:1',
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        $subtotal = $producto->precio_menudeo * $request->cantidad;

     DetalleVenta::create([
    'producto_id'        => $producto->id,
    'cantidad'           => $request->cantidad,
    'venta_cliente_id'   => null,
    'venta_consultora_id'=> null,
]);


        return redirect()->route('carrito.agregar')
                         ->with('success', 'Producto agregado al carrito');
    }

    // Actualizar cantidad (se recalcula subtotal)
   public function actualizarCantidad(Request $request, $id)
{
    $request->validate([
        'cantidad' => 'required|integer|min:1',
    ]);

    $detalle = DetalleVenta::with('producto')->findOrFail($id);

    // SOLO actualizar cantidad
    $detalle->cantidad = $request->cantidad;
    $detalle->save(); // NO tocar subtotal
return redirect()->route('carrito.unico', $id);

}


    public function eliminar($id)
    {
        $personaId = session('persona_id');

        DetalleVenta::where('id', $id)
            ->where('venta_cliente_id', $personaId)
            ->delete();

        return redirect()->route('carrito');
    }

    // Eliminar línea del carrito
    public function destroy($id)
    {
        DetalleVenta::destroy($id);

        return redirect()->route('carrito.index')
                         ->with('success', 'Producto eliminado del carrito');
    }

    // Página siguiente (por ahora solo plantilla)
public function siguiente()
{
    $personaId = session('persona_id');

    // Obtener el único detalle del carrito
    $detalle = DetalleVenta::with('producto')
                ->where('venta_cliente_id', $personaId)
                ->latest()->first();

   if (!$detalle) {
    return back()->with('error', 'Tu carrito está vacío.');
}


    // Calcular valores reales
$subtotal = $detalle->cantidad * $detalle->producto->precio_menudeo;
$envio = ($subtotal > 500) ? 0 : ceil($subtotal * 0.10);
$total = $subtotal + $envio;

    return view('tienda.metodo_pago', compact('detalle','subtotal','envio','total'));
}





public function agregar($id)
{
    // 1️⃣ Obtener usuario logueado
    $personaId = session('persona_id');

    if (!$personaId) {
        return redirect()->route('usuarios.login')
            ->with('error', 'Debes iniciar sesión para agregar productos.');
    }

    // 2️⃣ Buscar el producto
    $producto = Producto::findOrFail($id);

    // 3️⃣ Buscar o crear la venta pendiente de este usuario
    $venta = VentaCliente::firstOrCreate(
        ['cliente_id' => $personaId, 'estado' => 'pendiente'],
        ['total' => 0, 'fecha_venta' => now()]
    );

    // 4️⃣ Crear línea del carrito (detalle de venta)
    $detalle = DetalleVenta::create([
        'producto_id'      => $producto->id,
        'cantidad'         => 1,
        'venta_cliente_id' => $venta->id
    ]);

    // 5️⃣ Recalcular total de la venta
    $venta->total = DetalleVenta::where('venta_cliente_id', $venta->id)
                                ->sum('subtotal');
    $venta->save();

    // 6️⃣ AHORA SÍ existe $detalle->id
    return redirect()->route('carrito.unico', $detalle->id);
}



public function carritoUnico($id)
{
    $detalle = DetalleVenta::with('producto')->findOrFail($id);

    $subtotal = $detalle->cantidad * $detalle->producto->precio_menudeo;

    $envio = ($subtotal > 500) ? 0 : ceil($subtotal / 100) * 10;

    $total = $subtotal + $envio;

 return view('carrito.unico', compact('detalle', 'subtotal', 'envio', 'total'));
}

public function metodoPago()
{
    $personaId = session('persona_id');

    // Encontrar venta activa
    $venta = VentaCliente::where('cliente_id', $personaId)
                         ->where('estado', 'pendiente')
                         ->first();

    if (!$venta) {
        return redirect()->route('carrito.index')
            ->with('error', 'Tu carrito está vacío.');
    }

    $detalle = DetalleVenta::with('producto')
                ->where('venta_cliente_id', $venta->id)
                ->latest()
                ->first();

    if (!$detalle) {
        return redirect()->route('carrito.index')
            ->with('error', 'No hay productos válidos en tu carrito.');
    }

    $subtotal = $detalle->cantidad * $detalle->producto->precio_menudeo;
    $envio = ($subtotal > 500) ? 0 : ceil($subtotal * 0.10);
    $total = $subtotal + $envio;

    return view('tienda.metodo_pago', compact('detalle', 'subtotal', 'envio', 'total'));
}





}

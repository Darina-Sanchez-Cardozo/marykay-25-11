<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\VentaCliente;
use Illuminate\Support\Facades\DB;
use App\Models\VentaConsultora;


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



   public function actualizarCantidad(Request $request, $id)
{
    $request->validate([
        'cantidad' => 'required|integer|min:1',
    ]);

try {
    $detalle = DetalleVenta::with('producto')->findOrFail($id);

    // SOLO actualizar cantidad
    $detalle->cantidad = $request->cantidad;
    $detalle->save(); // NO tocar subtotal


        return redirect()->route('carrito.unico', $id)
            ->with('success', 'Cantidad actualizada correctamente.');
 } catch (\Exception $e) {

        $mensaje = $e->getMessage();

        // Detecta mensaje del TRIGGER
        if (str_contains($mensaje, 'existencias') || str_contains($mensaje, 'suficientes')) {
            return redirect()->route('carrito.unico', $id)
                ->with('error', 'No hay existencias suficientes para este producto.');
        }

        // Error desconocido
        return redirect()->route('carrito.unico', $id)
            ->with('error', 'Ocurrió un error al actualizar la cantidad.');
    }

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

////////////////////////////////////////////
$rol = DB::table('personas')
    ->where('id', $personaId)
    ->value('rol');

$rol = trim(strtolower($rol)); // 🔥 Normaliza


    // Buscar producto
    $producto = Producto::findOrFail($id);


    try {

///7insertar a tbala bd dependiendo rol
if ($rol === 'cliente') {
    // Crear o buscar venta del CLIENTE
    $venta = VentaCliente::firstOrCreate(
    ['persona_id' => $personaId, 'estado' => 'pendiente'], 
    ['total' => 0, 'fecha' => now()]        
        );

    // Crear detalle en venta_cliente
    $detalle = DetalleVenta::create([
        'producto_id'        => $producto->id,
        'cantidad'           => 1,////////////////77
        'venta_cliente_id'   => $venta->id,
        'venta_consultora_id'=> null
    ]);
                $venta->total = DetalleVenta::where('venta_cliente_id', $venta->id)
                        ->sum('subtotal');
            $venta->save();
}
else {
    // Crear o buscar venta de CONSULTORA
$venta = VentaConsultora::firstOrCreate(
    ['persona_id' => $personaId, 'estado' => 'pendiente'],
    [
        'total' => 0,
        'fecha_venta' => now()
    ]
);

// Crear detalle
$detalle = DetalleVenta::create([
    'producto_id'        => $producto->id,
    'cantidad'           => 1,
    'venta_cliente_id'   => null,
    'venta_consultora_id'=> $venta->id
]);

       // Recalcular total
            $venta->total = DetalleVenta::where('venta_consultora_id', $venta->id)
                        ->sum('subtotal');
            $venta->save();
}

        return redirect()->route('carrito.unico', $detalle->id)
            ->with('success', 'Producto agregado al carrito.');

} catch (\Exception $e) {


        if (str_contains($e->getMessage(), 'existencias') ||
            str_contains($e->getMessage(), 'suficientes')) {

            return back()->with('error', 'No hay existencias suficientes.');
        }

        return back()->with('error', 'Ocurrió un error al agregar el producto.');
    }
}


public function carritoUnico($id)
{

    $personaId = session('persona_id');
    $rol = DB::table('personas')->where('id', $personaId)->value('rol');


    $detalle = DetalleVenta::with('producto')->findOrFail($id);

    $subtotal = $detalle->cantidad * $detalle->producto->precio_menudeo;

// Si es cliente → descuento_actual()
// Si NO → consultora (20%)
if ($rol === 'cliente') {
      $descuento = DB::select("SELECT descuento_actual() AS d")[0]->d;
    $descuento = $descuento ?? 0; // SI NO HAY DESCUENTO, SE VUELVE 0
} else {
    $descuento = 20;
}








    $iva= $subtotal*0.16;

    $subtotal_con_desc = $subtotal - ($subtotal * ($descuento / 100));

    $envio = ($subtotal > 500) ? 0 : ceil($subtotal / 100) * 10;

     $total = ($subtotal_con_desc + $envio+ $iva)- $descuento;


    return view('carrito.unico', compact(
        'detalle',
        'subtotal',
        'descuento',
        'subtotal_con_desc',
        'envio',
        'iva',
        'total'
    ));
}


///////////////////////////////////////////
//////////////////////////////////////
///////////////7
public function metodoPago()
{
    $personaId = session('persona_id');

    // Encontrar venta activa
 $venta = VentaCliente::where('persona_id', $personaId)
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
    $envio = ($subtotal > 500) ? 0 : ($subtotal * 0.10);
    //$iva= $subtotal*0.16;
    $total = $subtotal + $envio ;
 
 return view('tienda.metodo_pago', compact('venta', 'detalle', 'subtotal', 'envio','total'));
}
}



////////+++++++++++++++++++++++++++++++++++
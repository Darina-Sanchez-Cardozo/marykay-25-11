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
//////////////////////////////////////////////////////////////////4.28 pm

    $personaId = session('persona_id');

    $rol = DB::table('personas')->where('id', $personaId)->value('rol');
$rol = trim(strtolower($rol));

if (str_contains($rol, 'consult')) {

    $venta = VentaConsultora::where('persona_id', $personaId)
        ->where('estado', 'pendiente')
        ->latest()
        ->first();

    $detalles = DetalleVenta::with('producto')
        ->where('venta_consultora_id', optional($venta)->id)
        ->get();

} else {

    $venta = VentaCliente::where('persona_id', $personaId)
        ->where('estado', 'pendiente')
        ->latest()
        ->first();

    $detalles = DetalleVenta::with('producto')
        ->where('venta_cliente_id', optional($venta)->id)
        ->get();
}

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

    // Obtener rol
    $rol = DB::table('personas')->where('id', $personaId)->value('rol');
    $rol = trim(strtolower($rol));

    // ===============================
    //  CLIENTE
    // ===============================
    if (str_contains($rol, 'clien')) {

        // Obtener la venta pendiente del cliente
        $venta = VentaCliente::where('persona_id', $personaId)
            ->where('estado', 'pendiente')
            ->latest()
            ->first();

        if (!$venta) {
            return back()->with('error', 'Tu carrito está vacío.');
        }

        // Obtener detalles del cliente
        $detalle = DetalleVenta::with('producto')
            ->where('venta_cliente_id', $venta->id)
            ->latest()
            ->first();
    }

    // ===============================
    //  CONSULTORA
    // ===============================
    elseif (str_contains($rol, 'consult')) {

        // Obtener venta pendiente de consultora
        $venta = VentaConsultora::where('persona_id', $personaId)
            ->where('estado', 'pendiente')
            ->latest()
            ->first();

        if (!$venta) {
            return back()->with('error', 'Tu carrito está vacío.');
        }

        // Obtener detalles de la consultora
        $detalle = DetalleVenta::with('producto')
            ->where('venta_consultora_id', $venta->id)
            ->latest()
            ->first();
    }

    // ===============================
    // VALIDACIÓN GENERAL
    // ===============================
    if (!$detalle) {
        return back()->with('error', 'Tu carrito está vacío.');
    }

    // ===============================
    //   Cálculo de totales (NO SE CAMBIA)
    // ===============================
    $precio = ($rol === 'cliente')
        ? $detalle->producto->precio_menudeo
        : $detalle->producto->precio_mayoreo;

    $subtotal = $detalle->cantidad * $precio;
    $envio    = ($subtotal > 500) ? 0 : ceil($subtotal * 0.10);
    $total    = $subtotal + $envio;

    return view('tienda.metodo_pago', compact(
        'detalle', 'subtotal', 'envio', 'total'
    ));
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
session(['rol' => $rol]);


    // Buscar producto
    $producto = Producto::findOrFail($id);


    try {

///7insertar a tbala bd dependiendo rol
if ($rol === 'cliente') {
    // Crear o buscar venta del CLIENTE
    $venta = VentaCliente::firstOrCreate(
    ['persona_id' => $personaId, 'estado' => 'pendiente'], 
    ['total' => 0, 'fecha_venta' => now()]        
        );

    // Crear detalle en venta_cliente
// Buscar si este producto YA está en el carrito del cliente
$detalle = DetalleVenta::where('venta_cliente_id', $venta->id)
    ->where('producto_id', $producto->id)
    ->first();

if ($detalle) {
    // Ya existe → aumentar cantidad
    $detalle->cantidad += 1;
    $detalle->subtotal = $detalle->cantidad * $producto->precio_menudeo;
    $detalle->save();

} else {
    // No existe → crear uno nuevo
    $detalle = DetalleVenta::create([
        'producto_id'        => $producto->id,
        'cantidad'           => 1,
        'subtotal'           => $producto->precio_menudeo,
        'venta_cliente_id'   => $venta->id,
        'venta_consultora_id'=> null
    ]);
}

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

// Crear detalle..buscar y crear si no encuntra
$detalle = DetalleVenta::where('venta_consultora_id', $venta->id)
    ->where('producto_id', $producto->id)
    ->first();

if ($detalle) {
    $detalle->cantidad += 1;
    $detalle->subtotal = $detalle->cantidad * $producto->precio_mayoreo;
    $detalle->save();

} else {
    $detalle = DetalleVenta::create([
        'producto_id'        => $producto->id,
        'cantidad'           => 1,
        'subtotal'           => $producto->precio_mayoreo,
        'venta_cliente_id'   => null,
        'venta_consultora_id'=> $venta->id
    ]);
}


       // Recalcular total
            $venta->total = DetalleVenta::where('venta_consultora_id', $venta->id)
                        ->sum('subtotal');
            $venta->save();
}

       return redirect()->route('carrito.unico', $producto->id)
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

if (str_contains($rol, 'consult')) {
    $precio = $detalle->producto->precio_mayoreo; 
} else {
    $precio = $detalle->producto->precio_menudeo;
}


///////////procedimeinto precio total
$subtotal = $detalle->cantidad * $precio;


// Si es cliente → descuento_actual()
// Si NO → consultora (20%)
if ($rol === 'cliente') {
      $descuento = DB::select("SELECT descuento_actual() AS d")[0]->d;
    $descuento = $descuento ?? 0; // SI NO HAY DESCUENTO, SE VUELVE 0
} else {
    $descuento = 20;
}
 $subtotal_con_desc = $subtotal - ($subtotal * ($descuento / 100));
   $envio = ($subtotal > 500) ? 0 : ceil($subtotal / 100) * 10;
    $iva= $subtotal*0.16;

     $total = ($subtotal_con_desc + $envio+ $iva);

session([
    'total_carrito' => $total
]);

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
 if (!$rol = session('rol')) {
    // si sesión no existe, obtenerlo directo
    $rol = DB::table('personas')->where('id', $personaId)->value('rol');
    $rol = trim(strtolower($rol));
}


    // ======================================================
    // 🔵 BLOQUE NUEVO — MANEJO PARA CONSULTORA
    // ======================================================
    if ($rol === 'consultora') {

        // 1. Buscar venta activa de consultora
        $venta = \App\Models\VentaConsultora::where('persona_id', $personaId)
            ->where('estado', 'pendiente')
            ->first();

if (!$venta) {
    // Crear nueva venta consultora
    $venta = VentaConsultora::create([
        'persona_id' => $personaId,
        'estado'     => 'pendiente',
        'total'      => 0,
        'fecha_venta'      => now(),
    ]);
}


        // 2. Obtener detalle de venta consultora
     // Buscar detalles en la misma tabla "detallesventa"
        $detalle = DetalleVenta::with('producto')
            ->where('venta_consultora_id', $venta->id)
            ->latest()
            ->first();

        if (!$detalle) {
            return redirect('/tienda')
                ->with('error', 'Primero debes agregar productos al carrito.');
        }

 $total = session('total_carrito');

    if (!$total) {
        return redirect('/carrito')->with('error', 'No hay total calculado.');
    }

    return view('tienda.metodo_pago', compact('total'));
    }

////////////clientes 


    // Encontrar venta activa
 $venta = VentaCliente::where('persona_id', $personaId)
    ->where('estado', 'pendiente')
    ->first();

if (!$venta) {
    // Crear nueva venta automáticamente
    $venta = VentaCliente::create([
        'persona_id' => $personaId,
        'estado'     => 'pendiente',
        'total'      => 0,
        'fecha_venta'      => now(),
    ]);
}


  // Buscar detalle en la misma tabla de detalles
    $detalle = DetalleVenta::with('producto')
        ->where('venta_cliente_id', $venta->id)
        ->latest()
        ->first();

    if (!$detalle) {
        return redirect('/tienda')
            ->with('error', 'Primero debes agregar productos al carrito.');
    }
 $total = session('total_carrito');

    if (!$total) {
        return redirect('/carrito')->with('error', 'No hay total calculado.');
    }

    return view('tienda.metodo_pago', compact('total'));

 
}
}



////////+++++++++++++++++++++++++++++++++++
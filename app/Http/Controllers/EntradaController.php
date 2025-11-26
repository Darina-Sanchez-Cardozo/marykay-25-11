<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Entrada;
use App\Models\Producto;
use App\Models\Persona;
use Illuminate\Http\Request;

class EntradaController extends Controller
{
    // LISTA (INDEX)
    public function index()
    {
        $entradas = Entrada::with(['producto', 'almacenista'])->get();

        return view('almacen.index', compact('entradas'));
    }

    // FORM CREAR
    public function create()
    {
        $productos = Producto::all();
        $almacenistas = Persona::where('rol', 'almacenista')->get();

        return view('almacen.create', compact('productos', 'almacenistas'));
    }

    // GUARDAR


public function store(Request $request)
{
    // 1. Validación de Laravel
    $validated = $request->validate([
        'producto_id' => 'required',
        'cantidad' => 'required|integer|min:1',
        'precio_entrada' => 'required|numeric|min:0',
        'fecha_entrada' => 'required|date',
        'descripcion' => 'nullable|string',
        'almacenista_id' => 'required',

        // Campos usados por el procedimiento almacenado
        'nombre' => 'required|string',
        'costo' => 'required|numeric|min:0',
        'margen' => 'required|numeric|min:0',
        'iva' => 'required|numeric|min:0',
    ]);

    // 2. Insertar en la tabla entradas (si lo necesitas)
    Entrada::create($validated);

    // 3. Llamar al procedimiento almacenado BD
    DB::statement('CALL registrar_entrada(?, ?, ?, ?, ?)', [
        $validated['nombre'],
        $validated['cantidad'],
        $validated['costo'],
        $validated['margen'],
        $validated['iva'],
    ]);

    return redirect()
            ->route('almacen.index')
            ->with('success', 'Entrada registrada correctamente y existencias actualizadas.');
}


    // EDITAR
    public function edit($id)
    {
        $entrada = Entrada::findOrFail($id);
        $productos = Producto::all();
        $almacenistas = Persona::where('rol', 'almacenista')->get();

        return view('almacen.edit', compact('entrada', 'productos', 'almacenistas'));
    }

    // ACTUALIZAR
    public function update(Request $request, $id)
    {
        $entrada = Entrada::findOrFail($id);

        $entrada->update($request->all());

        return redirect()->route('almacen.index')->with('success', 'Entrada actualizada correctamente');
    }

    // ELIMINAR
    public function destroy($id)
    {
        Entrada::findOrFail($id)->delete();

        return redirect()->route('almacen.index')->with('success', 'Entrada eliminada');
    }
   public function dashboard()
{
    $entradas = Entrada::with(['producto', 'almacenista'])
                        ->orderBy('id', 'DESC')
                        ->take(10)
                        ->get();

    return view('almacen.dashboard', compact('entradas'));
}
public function createDash()
{
    $productos = Producto::all();
    $almacenistas = Persona::where('rol', 'almacenista')->get();

    return view('almacen.create_dash', compact('productos', 'almacenistas'));
}


}

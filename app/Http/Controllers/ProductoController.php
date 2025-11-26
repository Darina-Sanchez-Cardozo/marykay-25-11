<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Campania;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['campania', 'categoria'])
                             ->orderBy('id', 'ASC')->get();

        return view('producto.index', compact('productos'));
    }

    public function create()
    {
        $campanias = Campania::orderBy('nombre')->get();
        $categorias = Categoria::orderBy('nombre')->get();

        return view('producto.create', compact('campanias', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'codigo_barras' => 'required|string',
            'descripcion' => 'required|string',
            'precio_mayoreo' => 'required|numeric',
            'precio_menudeo' => 'required|numeric',
            'existencias' => 'required|numeric',
            'estado_producto' => 'required|string',
            'campania_id' => 'nullable|numeric',
            'categoria_id' => 'nullable|numeric',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5000'
        ]);

        $data = $request->all();

        // ⭐ GUARDAR IMAGEN
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $nombreImagen = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img'), $nombreImagen);
            $data['imagen'] = $nombreImagen; // Guardar nombre en BD
        }

        Producto::create($data);

        return redirect()->route('producto.index')
                         ->with('success', 'Producto agregado correctamente');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $campanias = Campania::orderBy('nombre')->get();
        $categorias = Categoria::orderBy('nombre')->get();

        return view('producto.edit', compact('producto', 'campanias', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string',
            'codigo_barras' => 'required|string',
            'descripcion' => 'required|string',
            'precio_mayoreo' => 'required|numeric',
            'precio_menudeo' => 'required|numeric',
            'existencias' => 'required|numeric',
            'estado_producto' => 'required|string',
            'campania_id' => 'nullable|numeric',
            'categoria_id' => 'nullable|numeric',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5000'
        ]);

        $producto = Producto::findOrFail($id);

        $data = $request->all();

        // ⭐ SI SUBEN UNA NUEVA IMAGEN
        if ($request->hasFile('imagen')) {

            // borrar imagen anterior si existe
            if ($producto->imagen && file_exists(public_path('img/' . $producto->imagen))) {
                unlink(public_path('img/' . $producto->imagen));
            }

            $file = $request->file('imagen');
            $nombreImagen = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img'), $nombreImagen);
            $data['imagen'] = $nombreImagen;
        }

        $producto->update($data);

        return redirect()->route('producto.index')
                         ->with('success', 'Producto actualizado correctamente');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        // ⭐ BORRAR IMAGEN
        if ($producto->imagen && file_exists(public_path('img/' . $producto->imagen))) {
            unlink(public_path('img/' . $producto->imagen));
        }

        $producto->delete();

        return redirect()->route('producto.index')
                         ->with('success', 'Producto eliminado');
    }
}

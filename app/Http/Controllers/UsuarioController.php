<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // 👉 Mostrar login
    public function loginVista()
    {
        return view('usuarios.login');
    }

    // 👉 Procesar login
public function login(Request $request)
{
    $request->validate([
        'correo_electronico' => 'required|email',
        'password' => 'required'
    ]);

    $persona = Persona::where('correo_electronico', $request->correo_electronico)->first();

    if (!$persona || !Hash::check($request->password, $persona->password)) {
        return back()->with('error', 'Credenciales incorrectas');
    }

    // Guardamos sesión
    session([
        'persona_id' => $persona->id,
        'persona_nombre' => $persona->nombre,
        'persona_rol' => $persona->rol
    ]);

    // 🔥 REDIRECCIÓN SEGÚN EL ROL
    switch ($persona->rol) {

        case 'admin':
            return redirect()->route('admin.dashboard');

        case 'almacenista':
            return redirect()->route('almacen.dashboard');

        case 'consultora':
            return redirect()->route('consultora.dashboard');

        case 'cliente':
        default:
            return redirect()->route('tienda.index');
    }
}


    // 👉 Cerrar sesión
    public function logout()
    {
        session()->flush();
        return redirect()->route('usuarios.login');
    }

    // 👉 Mostrar formulario registro
    public function registroVista()
    {
        return view('usuarios.registro');
    }

    // 👉 Guardar registro
    public function registro(Request $request)
    {
    $request->validate([
        'nombre' => 'required',
        'apellido_paterno' => 'required',
        'correo_electronico' => 'required|email|unique:personas,correo_electronico',
        'password' => 'required|min:6',
        'rol' => 'required|in:cliente,consultora',
    ]);

    Persona::create([
        'nombre' => $request->nombre,
        'apellido_paterno' => $request->apellido_paterno,
        'apellido_materno' => $request->apellido_materno ?? '',
        'direccion' => $request->direccion ?? '',
        'telefono' => $request->telefono ?? '',
        'fecha_nacimiento' => $request->fecha_nacimiento ?? null,
        'correo_electronico' => $request->correo_electronico,
        'password' => bcrypt($request->password),
        'estado' => 'Activo',
        'rol' => $request->rol,
    ]);

    return redirect()->route('usuarios.login')
        ->with('success', 'Registro exitoso. Ahora inicia sesión.');
}


}

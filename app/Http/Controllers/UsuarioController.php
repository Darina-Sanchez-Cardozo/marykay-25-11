<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


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
        'persona_rol' => $persona->rol,
        'is_consultora'  => ($persona->rol === 'consultora') // mantener estado
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
    //procedimiento
         $resultado = DB::select("CALL validarPersona(?, ?)", [
            $request->correo_electronico,
            $request->telefono
        ]);

        $respuesta = $resultado[0]->resultado;


        if ($respuesta === 'DUPLICADO_CORREO') {
            return back()->with('error', 'El correo ya está registrado.');
        }

        else if ($respuesta === 'DUPLICADO_TELEFONO') {
            return back()->with('error', 'El teléfono ya está registrado.');
        }

        else if ($respuesta === 'DUPLICADO_CORREO_TELEFONO') {
            return back()->with('error', 'El correo y teléfono ya están registrados.');
        }


    try {

        Persona::create([
            'nombre'            => $request->nombre,
            'apellido_paterno'  => $request->apellido_paterno,
            'apellido_materno'  => $request->apellido_materno ?? '',
            'direccion'         => $request->direccion ?? '',
            'telefono'          => $request->telefono,
            'fecha_nacimiento'  => $request->fecha_nacimiento,
            'correo_electronico'=> $request->correo_electronico,
            'password'          => bcrypt($request->password),
            'estado'            => 'Activo',
            'rol'               => $request->rol,
        ]);

        return redirect()->route('usuarios.login')
            ->with('success', 'Registro exitoso.');

    } catch (\Exception $e) {

    $msg = $e->getMessage();

    $dupTelefono = str_contains($msg, 'telefono');
    $dupCorreo   = str_contains($msg, 'correo_electronico');

    if ($dupTelefono && $dupCorreo) {
        return back()->with('error', 'El correo y teléfono ya están registrados.');
    }

    if ($dupTelefono) {
        return back()->with('error', 'El teléfono ya está registrado.');
    }

    if ($dupCorreo) {
        return back()->with('error', 'El correo ya está registrado.');
    }

    return back()->with('error', 'Ocurrió un error al registrar.');
}



}
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // POR AHORA SERÁ ESTÁTICO.
        $envio_exitoso = 12;
        $en_camino = 2392;
        $pendiente = 529;

        $ventas_consultoras = [
            ['consultora' => 'Carlos López', 'nivel' => 'Alta', 'productos' => 539],
            ['consultora' => 'Sofía Rodríguez', 'nivel' => 'Baja', 'productos' => 881],
            ['consultora' => 'Javier Hernández', 'nivel' => 'Alta', 'productos' => 194],
            ['consultora' => 'Elena Díaz', 'nivel' => 'Media', 'productos' => 251],
            ['consultora' => 'Luis Vargas', 'nivel' => 'Alta', 'productos' => 403],
        ];

        return view('admin.dashboard', compact(
            'envio_exitoso',
            'en_camino',
            'pendiente',
            'ventas_consultoras'
        ));
    }
}

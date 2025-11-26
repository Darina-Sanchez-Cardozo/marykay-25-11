<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsultoraDashboardController extends Controller
{
    public function index()
    {
        // Datos simulados — Aquí después se conectará a la BD
        $ventas = 45230;
        $devoluciones = 5263;
        $nuevos_clientes = 320;

        $asesorias = [
            [
                'nombre' => 'Mara Rebollar Contreras',
                'fecha' => '26/09/2025 — 8:00 a.m.',
                'telefono' => '553 874 2091',
                'ubicacion' => 'New York',
            ],
            [
                'nombre' => 'Mary Kay Confidently You',
                'fecha' => '10/09/2025 — 8:00 p.m.',
                'telefono' => '559 804 3265',
                'ubicacion' => 'Canadá',
            ],
        ];

        // categorías populares
        $categorias = [
            ['nombre' => 'Maquillaje', 'porcentaje' => 39],
            ['nombre' => 'Cuidado Piel', 'porcentaje' => 32],
            ['nombre' => 'Fragancias', 'porcentaje' => 29],
        ];

        return view('consultora.dashboard', compact(
            'ventas',
            'devoluciones',
            'nuevos_clientes',
            'asesorias',
            'categorias'
        ));
    }
}

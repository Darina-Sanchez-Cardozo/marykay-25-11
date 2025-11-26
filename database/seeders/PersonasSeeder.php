<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;

class PersonasSeeder extends Seeder
{
    public function run(): void
    {
        // === Administrador: Darina ===
        Persona::create([
            'nombre' => 'Darina',
            'apellido_paterno' => 'Gutiérrez',
            'apellido_materno' => 'Lozano',
            'direccion' => 'Av. Central #124, Monterrey, NL',
            'telefono' => '90000111223',
            'fecha_nacimiento' => '1995-04-12',
            'correo_electronico' => 'darina.admin@marykay.com',
            'password' => Hash::make('Admin123'),
            'estado' => 'Activo',
            'rol' => 'admin'
        ]);

        // === Administrador: Emmanuel ===
        Persona::create([
            'nombre' => 'Emmanuel',
            'apellido_paterno' => 'Hernández',
            'apellido_materno' => 'Salinas',
            'direccion' => 'Calle Fresno #455, Apodaca, NL',
            'telefono' => '90000111224',
            'fecha_nacimiento' => '1992-09-28',
            'correo_electronico' => 'emmanuel.admin@marykay.com',
            'password' => Hash::make('Admin123'),
            'estado' => 'Activo',
            'rol' => 'admin'
        ]);

        // === Administrador: Carolyn ===
        Persona::create([
            'nombre' => 'Carolyn',
            'apellido_paterno' => 'Martínez',
            'apellido_materno' => 'Ríos',
            'direccion' => 'Privada Palma Real #22, San Nicolás, NL',
            'telefono' => '90000111225',
            'fecha_nacimiento' => '1998-01-17',
            'correo_electronico' => 'carolyn.admin@marykay.com',
            'password' => Hash::make('Admin123'),
            'estado' => 'Activo',
            'rol' => 'admin'
        ]);

        // === Almacenista por defecto ===
        Persona::create([
            'nombre' => 'Almacenista',
            'apellido_paterno' => 'General',
            'apellido_materno' => 'Base',
            'direccion' => 'Zona Industrial #900, Monterrey, NL',
            'telefono' => '90000111226',
            'fecha_nacimiento' => '1990-05-10',
            'correo_electronico' => 'almacen@marykay.com',
            'password' => Hash::make('Almacen123'),
            'estado' => 'Activo',
            'rol' => 'almacenista'
        ]);
    }
}

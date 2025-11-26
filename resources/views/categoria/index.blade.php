@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow p-4">

        <!-- Título + botón -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold text-danger">Categorías de Productos 💄</h3>

            <a href="{{ route('categoria.create') }}" 
               class="btn btn-pink text-white fw-bold"
               style="background-color:#d63384; border:none; padding:8px 15px; border-radius:6px;">
               + Nueva Categoría
            </a>
        </div>

        <!-- Tabla -->
        <table class="table table-borderless">
            <thead>
                <tr class="text-uppercase text-muted">
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($categorias as $cat)
                <tr>
                    <td>{{ $cat->nombre }}</td>
                    <td>{{ $cat->descripcion }}</td>

                    <td>
                        <a href="{{ route('categoria.edit', $cat->id) }}" 
                           class="btn btn-sm btn-primary">Editar</a>

                        <form action="{{ route('categoria.destroy', $cat->id) }}" 
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger" 
                                    onclick="return confirm('¿Eliminar categoría?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Botón regresar -->
        <a href="{{ route('admin.dashboard') }}" 
           class="btn btn-outline-dark mt-3 w-100 fw-bold">Regresar</a>

    </div>
</div>

<p class="text-center text-muted mt-4">
    © 2025 Mary Kay Digital — Sistema de Venta de Maquillaje
</p>

@endsection

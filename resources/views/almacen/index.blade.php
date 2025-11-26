@extends('layouts.app')

@section('title', 'Entradas de Almacén')

@section('content')

<div class="card shadow-sm p-4">

    <h3 class="fw-bold mb-4" style="color:#c71585;">📦 Entradas de Almacén</h3>

    <a href="{{ route('almacen.create') }}" class="btn btn-pink mb-3">
        ➕ Nueva Entrada
    </a>

    <table class="table table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Entrada</th>
                <th>Fecha Entrada</th>
                <th>Almacenista</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($entradas as $e)
            <tr>
                <td>{{ $e->id }}</td>
                <td>{{ $e->producto->nombre ?? 'N/A' }}</td>
                <td>{{ $e->cantidad }}</td>
                <td>${{ number_format($e->precio_entrada,2) }}</td>
                <td>{{ $e->fecha_entrada }}</td>
                <td>{{ $e->almacenista->nombre ?? 'N/A' }}</td>
                <td>{{ $e->descripcion }}</td>

                <td>

                    <a href="{{ route('almacen.edit', $e->id) }}"
                       class="btn btn-warning btn-sm">Editar</a>

                    <form action="{{ route('almacen.destroy', $e->id) }}"
                          method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">
                            Eliminar
                        </button>
                    </form>


                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Botón Regresar -->
        <a href="{{ route('admin.dashboard') }}" 
           class="btn btn-outline-dark mt-3 w-100 text-center fw-bold">
            Regresar
        </a>

</div>

@endsection

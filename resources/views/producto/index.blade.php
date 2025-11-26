@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold text-danger">Catálogo de Productos Mary Kay 💄</h3>

            <a href="{{ route('producto.create') }}" 
               class="btn btn-pink text-white fw-bold"
               style="background-color:#d63384; border:none; padding:8px 15px; border-radius:6px;">
               + Agregar producto
            </a>
        </div>

        <table class="table table-borderless">
            <thead>
                <tr class="text-uppercase text-muted">
                    <th>Nombre</th>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Precio Mayoreo</th>
                    <th>Precio Menudeo</th>
                    <th>Existencias</th>
                    <th>Estado</th>
                    <th>Categoría</th>
                    <th>Campaña</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
            @foreach ($productos as $p)
                <tr>
                    <td>{{ $p->nombre }}</td>
                    <td>{{ $p->codigo_barras }}</td>
                    <td>{{ $p->descripcion }}</td>
                    <td>${{ number_format($p->precio_mayoreo, 2) }}</td>
                    <td>${{ number_format($p->precio_menudeo, 2) }}</td>
                    <td>{{ $p->existencias }}</td>

                    <td>
                        @if($p->estado_producto == 'Activo')
                        <span class="badge bg-success">Activo</span>
                        @else
                        <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </td>

                    <td>{{ $p->categoria->nombre ?? 'Sin categoría' }}</td>
                    <td>{{ $p->campania->nombre ?? 'Sin campaña' }}</td>

                    <td>
                        <a href="{{ route('producto.edit', $p->id) }}" class="btn btn-sm btn-primary">
                            Editar
                        </a>

                        <form action="{{ route('producto.destroy', $p->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Eliminar producto?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="{{ route('admin.dashboard') }}" 
           class="btn btn-outline-dark mt-3 w-100 fw-bold">
            Regresar
        </a>

    </div>
</div>

<p class="text-center text-muted mt-4">
    © 2025 Mary Kay Digital — Sistema de Venta de Maquillaje
</p>

@endsection

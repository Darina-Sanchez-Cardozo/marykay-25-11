@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <div class="card shadow p-4" style="border-radius:15px;">

        <h4 class="fw-bold text-danger mb-4">
            Editar producto 💄
        </h4>

        <form action="{{ route('producto.update', $producto->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- NOMBRE + CODIGO -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nombre *</label>
                    <input type="text" name="nombre" class="form-control"
                           value="{{ $producto->nombre }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Código de barras *</label>
                    <input type="text" name="codigo_barras" class="form-control"
                           value="{{ $producto->codigo_barras }}" required>
                </div>
            </div>

            <!-- DESCRIPCION -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Descripción *</label>
                <textarea name="descripcion" class="form-control" rows="3"
                          required>{{ $producto->descripcion }}</textarea>
            </div>

            <!-- PRECIOS + EXISTENCIAS -->
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Precio mayoreo *</label>
                    <input type="number" step="0.01" name="precio_mayoreo" 
                           value="{{ $producto->precio_mayoreo }}"
                           class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Precio menudeo *</label>
                    <input type="number" step="0.01" name="precio_menudeo"
                           value="{{ $producto->precio_menudeo }}"
                           class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Existencias *</label>
                    <input type="number" name="existencias"
                           value="{{ $producto->existencias }}"
                           class="form-control" required>
                </div>
            </div>

            <!-- ESTADO -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Estado *</label>
                <select name="estado_producto" class="form-control" required>
                    <option value="Activo" {{ $producto->estado_producto == 'Activo' ? 'selected' : '' }}>
                        Activo
                    </option>
                    <option value="Inactivo" {{ $producto->estado_producto == 'Inactivo' ? 'selected' : '' }}>
                        Inactivo
                    </option>
                </select>
            </div>

            <!-- CATEGORIA + CAMPAÑA -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Categoría</label>
                    <select name="categoria_id" class="form-control">
                        <option value="">Sin categoría</option>

                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}"
                                {{ $producto->categoria_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Campaña</label>
                    <select name="campania_id" class="form-control">
                        <option value="">Sin campaña</option>

                        @foreach($campanias as $camp)
                            <option value="{{ $camp->id }}"
                                {{ $producto->campania_id == $camp->id ? 'selected' : '' }}>
                                {{ $camp->nombre }}
                            </option>
                        @endforeach

                    </select>
                </div>
            </div>

            <!-- BOTONES -->
            <div class="d-flex justify-content-between mt-4">
                <button class="btn btn-primary fw-bold px-4">Actualizar</button>

                <a href="{{ route('producto.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>

        </form>

    </div>

</div>

<p class="text-center text-muted mt-4">
    © 2025 Mary Kay Digital — Sistema de Venta de Maquillaje
</p>

@endsection

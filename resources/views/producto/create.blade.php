@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow p-4" style="border-radius:15px;">

        <h4 class="fw-bold text-danger mb-4">Registrar nuevo producto 💄</h4>

        <form action="{{ route('producto.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nombre *</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Código de barras *</label>
                    <input type="text" name="codigo_barras" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Descripción *</label>
                <textarea name="descripcion" class="form-control" rows="3" required></textarea>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Precio mayoreo *</label>
                    <input type="number" step="0.01" name="precio_mayoreo" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Precio menudeo *</label>
                    <input type="number" step="0.01" name="precio_menudeo" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Existencias *</label>
                    <input type="number" name="existencias" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Estado *</label>
                <select name="estado_producto" class="form-control">
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Categoría</label>
                    <select name="categoria_id" class="form-control">
                        <option value="">Sin categoría</option>
                        @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Campaña</label>
                    <select name="campania_id" class="form-control">
                        <option value="">Sin campaña</option>
                        @foreach($campanias as $camp)
                        <option value="{{ $camp->id }}">{{ $camp->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button class="btn btn-pink text-white fw-bold px-4">Guardar</button>
            <a href="{{ route('producto.index') }}" class="btn btn-secondary">Cancelar</a>

        </form>
    </div>
</div>

@endsection

@extends('layouts.app')

@section('content')
<div class="container mt-5 d-flex justify-content-center">

    <div class="card shadow p-4" style="width: 600px; border-radius: 15px;">

        <h4 class="fw-bold text-danger mb-4 text-center">
            Editar Categoría 💄
        </h4>

        <form action="{{ route('categoria.update', $categoria->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nombre de la Categoría</label>
                <input type="text" name="nombre" class="form-control"
                       value="{{ $categoria->nombre }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3" required>{{ $categoria->descripcion }}</textarea>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button class="btn btn-primary px-4">Actualizar</button>

                <a href="{{ route('categoria.index') }}" class="btn btn-secondary">
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

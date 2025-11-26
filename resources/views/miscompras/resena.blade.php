@extends('layouts.app')

@section('content')

<div class="card shadow-sm p-4">
    <h3 class="fw-bold mb-3">Agregar Reseña</h3>

    <div class="mb-3">
        <strong>Producto:</strong> {{ $detalle->producto->nombre }}
    </div>

    <form action="{{ route('miscompras.resena.store') }}" method="POST">
        @csrf

        <input type="hidden" name="detalle_id" value="{{ $detalle->id }}">

        <label class="fw-bold">Calificación</label>
        <select name="calificacion" class="form-control mb-3" required>
            <option value="">Selecciona ⭐</option>
            <option value="1">⭐</option>
            <option value="2">⭐⭐</option>
            <option value="3">⭐⭐⭐</option>
            <option value="4">⭐⭐⭐⭐</option>
            <option value="5">⭐⭐⭐⭐⭐</option>
        </select>

        <label class="fw-bold">Comentario (opcional)</label>
        <textarea name="comentario" rows="3" class="form-control mb-3"></textarea>

        <button class="btn btn-dark w-100">Guardar Reseña</button>

    </form>
</div>

@endsection

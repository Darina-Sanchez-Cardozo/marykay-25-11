@extends('layouts.app')

@section('content')

<h3 class="fw-bold mb-4">Mis Compras</h3>

@if($compras->isEmpty())
    <p>No tienes compras registradas.</p>
@else
<div class="text-center mt-4">
        <a href="{{ route('tienda.index') }}" class="btn btn-outline-dark mt-3 w-25">Regresar</a>
    </div>

@foreach($compras as $c)
<div class="card shadow-sm mb-3 p-3">

    <div class="row">

        {{-- Info --}}
        <div class="col-md-6">
            <h5>{{ $c->producto->nombre }}</h5>
            <p class="text-muted">
                Cantidad: {{ $c->cantidad }}<br>
            </p>
        </div>

        {{-- Acciones --}}
        <div class="col-md-4 text-end">

            <h6 class="mb-2">¿Qué tal te pareció?</h6>

            <a href="{{ route('miscompras.resena', $c->id) }}"
                class="btn btn-dark">
                Agregar Reseña
            </a>
        </div>

    </div>
</div>
@endforeach

@endif

@endsection

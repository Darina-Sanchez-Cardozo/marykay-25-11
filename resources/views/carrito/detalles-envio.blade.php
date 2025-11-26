@extends('layouts.app')

@section('content')

<div class="container py-5">
    <h3 class="fw-bold mb-3">Detalles de envío</h3>

    <p>Esta es la siguiente página del proceso de compra. Aquí después se podrá
       capturar dirección, método de envío, etc.</p>

    <a href="{{ route('carrito.index') }}" class="btn btn-outline-secondary mt-3">
        Volver al carrito
    </a>
</div>

@endsection

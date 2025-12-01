@extends('layouts.app')

@section('content')

<style>
    .producto-img {
        width: 380px;
        height: 380px;
        object-fit: contain;
    }

    .mini-img {
        width: 60px;
        height: 60px;
        object-fit: contain;
        border: 1px solid #ddd;
        margin-right: 8px;
        cursor: pointer;
        transition: transform .2s;
    }

    .mini-img:hover {
        transform: scale(1.1);
    }
</style>

<div class="container py-5">

    {{-- FILA PRINCIPAL --}}
    <div class="row">

        {{-- IMAGEN GRANDE --}}
        <div class="col-md-5 text-center">
            <img id="mainImage"
                 src="{{ asset('img/' . $producto->imagen) }}"
                 class="producto-img mb-4"
                 alt="">

            {{-- MINI IMÁGENES (SI QUIERES DECORAR CON MINIATURAS) --}}
    <div class="text-center mb-4">

        <div class="d-flex justify-content-center gap-2">

            <img src="{{ asset('img/' . $producto->imagen) }}"
                 class="border rounded"
                 style="width: 60px; height: 60px; object-fit: cover;">

            <img src="{{ asset('img/' . $producto->imagen) }}"
                 class="border rounded"
                 style="width: 60px; height: 60px; object-fit: cover;">

            <img src="{{ asset('img/' . $producto->imagen) }}"
                 class="border rounded"
                 style="width: 60px; height: 60px; object-fit: cover;">

        </div>
    </div>
    
        </div>

        {{-- INFORMACIÓN DEL PRODUCTO --}}
        <div class="col-md-7">

            <h2 class="fw-bold">{{ $producto->nombre }}</h2>

            <h3 class="fw-bold my-3">${{ number_format($producto->precio_menudeo, 2) }} pesos</h3>

<form action="{{ route('carrito.agregar', ['id' => $producto->id]) }}" method="GET">

    <input type="hidden" name="producto_id" value="{{ $producto->id }}">
    <input type="hidden" name="cantidad" value="1">

    <button class="btn btn-dark">Agregar al carrito</button>

</form>


        </form>


        </div>

    </div>

    <hr class="my-5">

    {{-- DESCRIPCIÓN --}}
    <div class="mt-4 mb-5 px-3" style="max-width: 850px; margin: auto;">

        <h4 class="fw-bold mb-3 text-center">Descripción detallada</h4>

        <p class="text-muted fs-5 text-center" style="line-height: 1.7;">
            {{ $producto->descripcion }}
        </p>
    </div>

        <div class="text-end mt-4 mb-5">
<div class="text-end mt-9 mb-2">
    <a href="{{ url()->previous() }}" class="btn btn-outline-dark btn-sm px-3">
        Regresar
    </a>
</div>

</div>

</div>

@endsection

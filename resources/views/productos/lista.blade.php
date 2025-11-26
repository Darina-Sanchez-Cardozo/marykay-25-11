@extends('layouts.app')

@section('content')

<style>
    /* Contenedor de producto */
    .producto-card {
        text-align: center;
        padding: 15px;
        border-radius: 12px;
        transition: 0.3s ease;
    }

    .producto-card:hover {
        transform: translateY(-5px);
    }

    /* Imagen */
    .producto-card img {
        width: 180px;
        height: 180px;
        object-fit: contain;
        transition: transform 0.2s;
    }

    .producto-card img:hover {
        transform: scale(1.06);
    }

    /* Nombre del producto */
    .producto-nombre {
        margin-top: 10px;
        font-size: 16px;
        font-weight: 600;
        color: #111 !important;
        text-decoration: none !important;
        display: block;
    }

    /* Precio */
    .producto-precio {
        font-size: 14px;
        color: #555;
        margin-top: 5px;
    }
</style>

<div class="container py-5">

    <h2 class="fw-bold mb-4 text-center">Todos los Productos</h2>

    <div class="row g-4">

        @foreach ($productos as $p)
            <div class="col-md-3 col-sm-6">

                <div class="producto-card">

                    {{-- Imagen clickeable --}}
                    <a href="{{ route('tienda.producto', $p->id) }}">
                        <img src="{{ asset('img/' . $p->imagen) }}" alt="{{ $p->nombre }}">
                    </a>

                    {{-- Nombre del producto SIN apariencia de enlace --}}
                    <a href="{{ route('tienda.producto', $p->id) }}" class="producto-nombre">
                        {{ $p->nombre }}
                    </a>

                    {{-- Precio --}}
                    <p class="producto-precio">
                        ${{ number_format($p->precio_menudeo, 2) }} MXN
                    </p>

                </div>

            </div>
        @endforeach

    </div>

    <div class="text-center mt-4">
        <a href="{{ route('tienda.index') }}" class="btn btn-outline-dark mt-3 w-25">
            Regresar
        </a>
    </div>

</div>


@endsection

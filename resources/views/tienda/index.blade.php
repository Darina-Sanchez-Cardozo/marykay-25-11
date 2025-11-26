@extends('layouts.app')

@section('content')

<style>
    .categoria-item img {
        width: 110px;
        height: 110px;
        object-fit: contain;
    }
    .producto-item img {
        width: 160px;
        height: 160px;
        object-fit: contain;
        transition: transform .2s;
    }
    .producto-item img:hover {
        transform: scale(1.05);
    }

    .btn-mk-dark {
        background-color: #1d1f21;
        color: #fff !important;
        padding: 10px 28px;
        border-radius: 12px;
        font-weight: 500;
        font-size: 15px;
        border: none;
        transition: all 0.25s ease;
        display: inline-block;
    }

    .btn-mk-dark:hover {
        background-color: #2c2f33;
        transform: translateY(-2px);
        box-shadow: 0px 4px 10px rgba(0,0,0,0.18);
    }
</style>

<div class="container py-4">

    {{-- NAV SUPERIOR --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        {{-- BUSCADOR --}}
        <div class="d-flex align-items-center">
            <input type="text" class="form-control" placeholder="Búsqueda..." style="width: 250px;">
        </div>

        {{-- MENU --}}
        <div class="d-flex align-items-center gap-3">

    <a href="#" class="text-dark fw-bold">Inicio</a>
    <a href="#" class="text-dark fw-bold">Acerca de MaryKay</a>
    <a href="#" class="text-dark fw-bold">Ayuda</a>

    <a href="{{ route('usuarios.registro') }}" class="btn btn-outline-dark mt-9 w-5">Crear Cuenta</a>
    <a href="{{ route('usuarios.login') }}" class="btn btn-outline-dark mt-9 w-5">Ingresar</a>

    <a href="{{ route('miscompras.index') }}" class="btn btn-outline-dark mt-9 w-5">🛒 Mi carrito</a>

    <a href="{{ route('usuarios.login') }}" class="btn btn-outline-dark mt-9 w-5">Salir</a>

</div>


    </div>

    {{-- CATEGORÍAS DESDE LA BD --}}
    <div class="d-flex justify-content-around text-center mb-5">

        @foreach ($categorias as $cat)

            @php
                $img = 'categoria_' . $cat->id . '.png';
                $ruta = file_exists(public_path('img/' . $img))
                        ? asset('img/' . $img)
                        : asset('img/default_categoria.png');
            @endphp

            <div class="categoria-item">
                <a href="{{ route('categoria.productos', $cat->id) }}">
                    <img src="{{ $ruta }}" alt="{{ $cat->nombre }}">
                </a>

                <p class="fw-bold text-uppercase mt-2">
                    <a href="{{ route('categoria.productos', $cat->id) }}" class="text-dark">
                        {{ strtoupper($cat->nombre) }}
                    </a>
                </p>
            </div>

        @endforeach

    </div>

    {{-- TITULO DESCUENTOS --}}
    <h2 class="fw-bold text-center mb-4">LO MEJOR A UN GRAN PECIO Y EXCELENTE CALIDAD</h2>

    {{-- PRODUCTOS --}}
    <div class="row justify-content-center">

        @foreach ($productos as $p)
            <div class="col-md-2 text-center producto-item mb-4">

                {{-- Imagen del producto --}}
               <a href="{{ route('tienda.producto', $p->id) }}"><img src="{{ asset('img/' . $p->imagen) }}"></a>

                <p class="mt-2 fw-semibold text-center">{{ $p->nombre }}</p>
                        {{-- Precio --}}
            <p class="mt-1 text-muted">
                ${{ number_format($p->precio_menudeo, 2) }} MXN
            </p>

            </div>
        @endforeach

    </div>

    {{-- BOTÓN DESCUBRE MÁS --}}
    <div class="text-center mt-3 mb-5">
        <a href="{{ route('productos.lista') }}" class="btn btn-dark px-4">
            Descubre Más
        </a>
    </div>


    {{-- SECCIÓN EXTRA --}}
    <h3 class="fw-bold mb-4">Crea cosas únicas estando cómoda y luciendo increíble</h3>
    <p class="text-muted">Precios sugeridos al menudeo</p>

    <div class="row">

        @foreach ($productos->take(6) as $p)
           <div class="col-md-2 text-center producto-item mb-4">

                {{-- Imagen del producto --}}
               <a href="{{ route('tienda.producto', $p->id) }}"><img src="{{ asset('img/' . $p->imagen) }}"></a>

                <p class="mt-2 fw-semibold text-center">{{ $p->nombre }}</p>
                        {{-- Precio --}}
            <p class="mt-1 text-muted">
                ${{ number_format($p->precio_menudeo, 2) }} MXN
            </p>

            </div>
        @endforeach

    </div>

    <div class="text-center mt-3">
        <a href="{{ route('productos.lista') }}" class="btn btn-dark px-4">
            Descubre Más
        </a>
    </div>



</div>

@endsection

@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" 
     style="min-height: 100vh;">

    <div class="p-5 shadow-lg bg-white rounded-4" 
         style="max-width: 430px; width:100%;">

        <h2 class="text-center mb-4 fw-bold" style="color:#333;">
            Iniciar Sesión
        </h2>

        @if(session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('usuarios.login.post') }}">
            @csrf

            {{-- Correo --}}
            <label class="fw-semibold mb-1">Correo electrónico</label>
            <div class="input-group mb-3">
                <span class="input-group-text bg-white">
                    <i class="bi bi-envelope"></i>
                </span>
                <input type="email" name="correo_electronico" 
                    placeholder="usuario@gmail.com" 
                    class="form-control" required>
            </div>

            {{-- Contraseña --}}
            <label class="fw-semibold mb-1">Contraseña</label>
            <div class="input-group mb-4">
                <span class="input-group-text bg-white">
                    <i class="bi bi-lock"></i>
                </span>
                <input type="password" name="password" 
                    placeholder="********" 
                    class="form-control" required>
            </div>

            {{-- Botón --}}
            <button class="btn w-100 text-white fw-semibold py-2" 
                    style="background:#222; border-radius:10px;">
                Iniciar sesión
            </button>
        </form>

        {{-- Enlace inferior --}}
        <div class="text-center mt-3">
            <span class="text-muted">¿No tienes cuenta?</span>
            <a href="{{ route('usuarios.registro') }}" 
               style="text-decoration:none; font-weight:600;">
                Regístrate aquí
            </a>
        </div>

        <p class="text-center mt-4 text-muted" style="font-size:14px;">
            © 2025 Mary Kay Digital — Sistema de Venta de Maquillaje
        </p>

    </div>
</div>

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection

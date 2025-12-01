@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow p-4" style="width: 520px; border-radius: 15px;">


        @if (session('error'))
            <div class="alert alert-danger text-center fw-bold">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success text-center fw-bold">
                {{ session('success') }}
            </div>
        @endif

        <h3 class="text-center mb-4" style="font-weight:700;">Registro MaryKay</h3>

        <form method="POST" action="{{ route('usuarios.registro.post') }}">
            @csrf

            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>

                <div class="col mb-3">
                    <label class="form-label">Apellido Paterno</label>
                    <input type="text" name="apellido_paterno" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Apellido Materno</label>
                <input type="text" name="apellido_materno" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="correo_electronico" class="form-control" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">¿Quién eres?</label>
                <select name="rol" class="form-control" required>
                    <option value="cliente">Cliente</option>
                    <option value="consultora">Consultora</option>
                </select>
            </div>


            <!-- Campos ocultos porque tienen valores por defecto -->
            <input type="hidden" name="estado" value="Activo">

            <button class="btn btn-dark w-100 py-2" style="font-size: 17px; border-radius:8px;">
                Registrar
            </button>
        </form>

        <div class="text-center mt-3">
            ¿Ya tienes cuenta?
            <a href="{{ route('usuarios.login') }}">Inicia sesión</a>
        </div>

    </div>
</div>
@endsection

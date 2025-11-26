<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mary Kay Digital ')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI'; background-color: #fff; }
        .navbar-brand { color: #c71585 !important; font-weight: bold; }
        .btn-rosado { background-color: #c71585; color: white; }
        .btn-rosado:hover { background-color: #a0136b; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light shadow-sm">
    <div class="logo fw-bold" style="font-size:20px;">
    Mary Kay Digital

    @if(session()->has('persona_nombre'))
        <span class="ms-2" style="color:#c71585;">
            | Hola, {{ session('persona_nombre') }}
        </span>
    @endif
</div>

</nav>


<div class="container py-4">
    @yield('content')
</div>

<footer class="text-center py-3 border-top text-muted">
    © 2025 Mary Kay Digital — Sistema de Venta de Maquillaje
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

</body>
</html>

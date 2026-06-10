<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SISCAP' }}</title>
    <!-- CSS Bootstrap 4.6.1 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    
    @include('partials.styles')
    @livewireStyles
</head>
<body class="bg-light">
    <!-- Simple Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #334155;">
        <a class="navbar-brand font-weight-bold" href="/dashboard" style="font-family: 'Outfit', sans-serif;">
            <i class="fas fa-graduation-cap text-primary"></i> SISCAP
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/perfiles">Perfiles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/programacion">Programación</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/configuracion">Configuración</a>
                </li>
            </ul>
        </div>
    </nav>

    <main class="py-4">
        {{ $slot }}
    </main>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    
    @include('partials.scripts')
    @livewireScripts
</body>
</html>

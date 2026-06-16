<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SISCAP' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    
    @include('partials.styles')
    @livewireStyles
</head>
<body class="bg-light">
    <!-- NAVBAR -->
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
                <li class="nav-item dropdown" x-data="{ open: false }" @click.away="open = false">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" @click.prevent="open = !open" :class="{ 'show': open }" aria-expanded="false">
                        Perfiles
                    </a>
                    <div class="dropdown-menu" :class="{ 'show': open }" style="margin-top: 0;">
                        <a class="dropdown-item" href="/perfiles/individual">Perfil Individual</a>
                        <a class="dropdown-item" href="/perfiles/gerencia">Perfil Gerencial</a>
                    </div>
                </li>
                <li class="nav-item dropdown" x-data="{ open: false }" @click.away="open = false">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" @click.prevent="open = !open" :class="{ 'show': open }" aria-expanded="false">
                        Programación
                    </a>
                    <div class="dropdown-menu" :class="{ 'show': open }" style="margin-top: 0;">
                        <a class="dropdown-item" href="/programacion/pre">Pre-Programación</a>
                        <a class="dropdown-item" href="/programacion/final">Programación Final</a>
                        <a class="dropdown-item" href="/programacion/ejecucion">Ejecución</a>
                    </div>
                </li>
                <li class="nav-item dropdown" x-data="{ open: false }" @click.away="open = false">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" @click.prevent="open = !open" :class="{ 'show': open }" aria-expanded="false">
                        Configuración
                    </a>
                    <div class="dropdown-menu" :class="{ 'show': open }" style="margin-top: 0;">
                        <a class="dropdown-item" href="/configuracion/roles">Roles y Permisos</a>
                        <a class="dropdown-item" href="/configuracion/areas">Áreas de Capacitación</a>
                        <a class="dropdown-item" href="/configuracion/ajustes">Ajustes Generales</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

    <!-- JS GLOBAL -->
    @include('partials.scripts')
    @livewireScripts
</body>
</html>

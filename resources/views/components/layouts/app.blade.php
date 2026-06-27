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
    @include('partials.navbar')

    <main>
        {{ $slot }}
    </main>

    <!-- JS GLOBAL -->
    @include('partials.scripts')
    @livewireScripts
</body>
</html>

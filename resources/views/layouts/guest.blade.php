<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Nexus Compendium') }}</title>

    {{-- Estilos de Breeze (Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tus estilos personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body class="bg-gray-100 font-sans antialiased">
    <main>
        {{ $slot }}
    </main>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nexus Compendium - IPSS')</title>

    {{-- Bootstrap y estilos personalizados --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

    @yield('styles')
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">Inicio</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
                        @endguest

                        @auth
                            @php $rol = auth()->user()->role->nombre ?? null; @endphp

                            {{-- Enlace al dashboard por rol --}}
                            <li class="nav-item">
                                @if($rol === 'docente')
                                    <a class="nav-link" href="{{ route('dashboard.docente') }}">Panel Docente</a>
                                @elseif($rol === 'estudiante')
                                    <a class="nav-link" href="{{ route('dashboard.estudiante') }}">Panel Estudiante</a>
                                @else
                                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                                @endif
                            </li>

                            {{-- Enlaces exclusivos para docentes --}}
                            @if($rol === 'docente')
                                <li class="nav-item"><a class="nav-link" href="{{ route('proyectos.index') }}">Proyectos</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('tareas.index') }}">Tareas</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('usuarios.index') }}">Usuarios</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('reportes.index') }}">Reportes</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('actores.index') }}">Actores de Interés</a></li>
                            @endif

                            {{-- Enlaces exclusivos para estudiantes --}}
                            @if($rol === 'estudiante')
                                <li class="nav-item"><a class="nav-link" href="{{ route('proyectos.index') }}">Mis Proyectos</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('tareas.index') }}">Mis Tareas</a></li>
                            @endif

                            {{-- Logout --}}
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="nav-link btn btn-link p-0" style="color: inherit; text-decoration: none;">Cerrar sesión</button>
                                </form>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container py-4">
        @yield('content')
    </main>

    <footer class="bg-light text-center py-3 mt-5">
        <p class="mb-0">&copy; {{ date('Y') }} Nexus Compendium - IPSS. Todos los derechos reservados.</p>
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Marcar enlace activo
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
                const linkPath = new URL(link.href).pathname;
                if ((currentPath === '/' || currentPath === '/dashboard') && (linkPath === '/' || linkPath === '/dashboard')) {
                    link.classList.add('active');
                } else if (currentPath.startsWith(linkPath) && linkPath !== '/') {
                    link.classList.add('active');
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>

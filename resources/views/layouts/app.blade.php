<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nexus Compendium - IPSS')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                            </li>
                        @endguest

                        @auth
                            @php $user = auth()->user(); @endphp

                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
                            </li>

                            @if($user->esDocente())
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('proyectos.index') }}">Proyectos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('tareas.index') }}">Tareas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('usuarios.index') }}">Usuarios</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('reportes.index') }}">Reportes</a>
                                </li>
                            @elseif($user->esEstudiante())
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('proyectos.index') }}">Mis Proyectos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('tareas.index') }}">Mis Tareas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/equipos') }}">Mi Equipo</a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('chatgpt.view') }}">Asistente IA</a>
                            </li>
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

    <main class="container">
        @yield('content')
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>📚 Nexus Compendium</h3>
                <p>Sistema de Gestión de Proyectos de Vinculación con el Medio</p>
                <p>Instituto Profesional San Sebastián</p>
                <p style="margin-top: 1rem;">
                    <strong>Conectando conocimiento con impacto social</strong>
                </p>
            </div>
            <div class="footer-section">
                <h3>📞 Contacto</h3>
                <p>📍 Av. Principal 123, Santiago, Chile</p>
                <p>📧 contacto@nexuscompendium.cl</p>
                <p>☎️ +56 2 2234 5678</p>
                <p>🌐 www.nexuscompendium.cl</p>
            </div>
            <div class="footer-section">
                <h3>🔗 Enlaces Rápidos</h3>
                <p><a href="/proyectos">Ver Proyectos Activos</a></p>
                <p><a href="/usuarios">Gestión de Usuarios</a></p>
                <p><a href="/institutos">Instituciones Aliadas</a></p>
                <p><a href="/reportes">Reportes y Estadísticas</a></p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Nexus Compendium - Instituto Profesional San Sebastián. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
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

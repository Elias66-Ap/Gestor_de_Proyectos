<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestor de Proyectos')</title>

    <!-- Bootstrap debe ir primero -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- SOLO UNA VEZ: estilos globales del dashboard -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('styles')
</head>


<body>
    @if(auth()->guard('usuario')->check())
        <div class="sidebar">

            {{-- LOGO estilo Hamid --}}
            <div class="sidebar-logo d-flex align-items-center gap-3 mb-4">
                <div class="logo-box">
                    <i class="bi bi-grid-1x2-fill"></i>
                </div>
                <span class="logo-text">Hamid</span>
            </div>

            {{-- Perfil --}}
            <div class="profile-section d-flex align-items-center gap-3 mb-4">
                <img class="profile-photo"
                    src="{{ optional(auth()->guard('usuario')->user()->perfil)->imagen_url ?? asset('images/default.jpeg') }}">

                <div class="text-white">
                    <div class="profile-name">
                        {{ optional(auth()->guard('usuario')->user()->perfil)->nombre }}
                        {{ optional(auth()->guard('usuario')->user()->perfil)->apellido }}
                    </div>
                    <div class="profile-role">
                        {{ auth()->guard('usuario')->user()->rol }}
                    </div>
                </div>
            </div>

            <hr class="text-secondary">

            {{-- Menú del administrador --}}
            <ul class="nav flex-column">

                <li class="nav-item">
                    <a href="{{ route('admin.inicio') }}"
                        class="nav-link {{ request()->routeIs('admin.inicio') ? 'active' : '' }}">
                        <i class="ph ph-house"></i> Inicio
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.colaboradores') }}"
                        class="nav-link {{ request()->routeIs('admin.colaboradores*') ? 'active' : '' }}">
                        <i class="ph ph-users"></i> Colaboradores
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.proyecto') }}"
                        class="nav-link {{ request()->routeIs('admin.proyecto') ? 'active' : '' }}">
                        <i class="ph ph-folder"></i> Proyectos
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.notificacion') }}"
                        class="nav-link {{ request()->routeIs('admin.notificacion') ? 'active' : '' }}">
                        <i class="ph ph-chat-dots"></i> Mensajes
                        <span id="contador-notificaciones" class="badge bg-danger">3</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.perfil') }}"
                        class="nav-link {{ request()->routeIs('admin.perfil') ? 'active' : '' }}">
                        <i class="ph ph-user"></i> Perfil
                    </a>
                </li>

            </ul>

            {{-- Cerrar sesión --}}
            <div class="logout">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('salirFormAdmin').submit();">
                    <i class="ph ph-sign-out"></i> Cerrar sesión
                </a>
            </div>

            <form id="salirFormAdmin" method="POST" action="{{ route('logout') }}" class="d-none">
                @csrf
            </form>

        </div>
    @endif

    <!-- Contenido principal -->
    <div class="content">
        @yield('content')
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @yield('scripts')
</body>

</html>
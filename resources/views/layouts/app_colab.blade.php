<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colaboradores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="{{ asset('css/app.css')  }}" rel="stylesheet">
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

            {{-- Menú --}}
            <ul class="nav flex-column">

                <li class="nav-item">
                    <a href="{{ route('colab.inicio') }}"
                        class="nav-link {{ request()->routeIs('colab.inicio') ? 'active' : '' }}">
                        <i class="ph ph-house"></i> Inicio
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('colab.usuarios') }}"
                        class="nav-link {{ request()->routeIs('colab.usuarios') ? 'active' : '' }}">
                        <i class="ph ph-users"></i> Colaboradores
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('colab.tareas') }}"
                        class="nav-link {{ request()->routeIs('colab.tareas') ? 'active' : '' }}">
                        <i class="ph ph-list"></i> Tareas
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('colab.notificaciones') }}"
                        class="nav-link {{ request()->routeIs('colab.notificaciones') ? 'active' : '' }}">
                        <i class="ph ph-chat-dots"></i> Mensajes
                        <span id="contador-notificaciones" class="badge bg-danger">3</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('colab.perfil') }}"
                        class="nav-link {{ request()->routeIs('colab.perfil') ? 'active' : '' }}">
                        <i class="ph ph-user"></i> Perfil
                    </a>
                </li>

            </ul>

            {{-- Cerrar sesión --}}
            <div class="logout">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('salirForm').submit();">
                    <i class="ph ph-sign-out"></i> Cerrar sesión
                </a>
            </div>

            <form id="salirForm" method="POST" action="{{ route('logout') }}" class="d-none">
                @csrf
            </form>

        </div>
    @endif

    <div class="content">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @yield('scripts')
</body>

</html>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lider</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="{{ asset('css/app.css')  }}" rel="stylesheet">
    @yield('styles')
</head>

<body>
    @if(auth()->guard('usuario')->check())
        <div class="sidebar d-flex flex-column p-3">
            <div class="text-center mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Hamid" class="img-fluid mb-2" style="max-height:100px;">
                <div class="mt-3">
                    <img src="{{ optional(auth()->guard('usuario')->user()->perfil)->imagen_url ?? asset('images/default.jpeg') }}"
                        alt="Perfil" class="profile-img mb-1"
                        style="width:80px; height:80px; object-fit:cover; border-radius:50%;">

                    <div>
                        {{ optional(auth()->guard('usuario')->user()->perfil)->nombre }}
                        {{ optional(auth()->guard('usuario')->user()->perfil)->apellido }}
                    </div>
                    <small>{{ auth()->guard('usuario')->user()->rol}}</small>
                </div>
            </div>
    @endif
        <hr class="text-white">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item mb-2">
                <a href="{{ route('lider.inicio') }}"
                    class="nav-link d-flex align-items-center {{ request()->routeIs('lider.inicio') ? 'active' : '' }}">
                    <i class="bi bi-house-door me-2"></i> Inicio
                </a>
            </li>
            <!--<li class="nav-item mb-2">
                <a href="{{ route('lider.colaboradores') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('lider.colaboradores*') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i> Colaboradores
                </a>
            </li>-->
            <!-- <li class="nav-item mb-2">
                <a href="{{ route('lider.equipo') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('lider.equipos') ? 'active' : '' }}">
                    <i class="bi bi-kanban me-2"></i> Equipos
                </a>
            </li> -->
            <li class="nav-item mb-2">
                <a href="{{route('lider.proyectos')}}"
                    class="nav-link d-flex align-items-center {{ request()->routeIs('lider.proyectos') ? 'active' : '' }}">
                    <i class="bi bi-folder me-2"></i> Proyectos
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{route('lider.tareas')}}"
                    class="nav-link d-flex align-items-center {{ request()->routeIs('lider.tareas') ? 'active' : '' }}">
                    <i class="bi bi-list-task me-2"></i> Tareas
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('lider.notificacion') }}"
                    class="nav-link d-flex align-items-center {{ request()->routeIs('lider.notificacion') ? 'active' : '' }}">
                    <i class="bi bi-chat-left-dots me-2"></i>Mensajes<span id="contador-notificaciones"
                        class="badge rounded-pill bg-danger ms-auto">
                        3
                    </span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('lider.perfil') }}"
                    class="nav-link d-flex align-items-center {{ request()->routeIs('lider.perfil') ? 'active' : '' }}">
                    <i class="bi bi-person me-2"></i> Perfil
                </a>
            </li>
        </ul>

        <form action="{{ route('logout') }}" method="POST" class="d-none" id="salirForm">
            @csrf
        </form>

        <hr class="text-white mt-auto">
        <a href="{{ route('logout') }}" class="nav-link d-flex align-items-center"
            onclick="event.preventDefault(); document.getElementById('salirForm').submit();">
            <i class="bi bi-box-arrow-left ms-3 me-2"></i> Cerrar sesión
        </a>

    </div>

    <div class="content">
        @yield('content1')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @yield('scripts')
</body>

</html>
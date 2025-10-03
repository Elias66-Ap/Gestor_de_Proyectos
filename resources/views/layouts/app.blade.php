<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css')  }}" rel="stylesheet">
</head>

<body>

    <div class="sidebar d-flex flex-column p-3">
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Hamid" class="img-fluid mb-2" style="max-height:100px;">
            <div class="mt-3">
                <img src="{{ asset('images/incognito.jpeg') }}" alt="Perfil" class="profile-img mb-1">
                <div>Jose Perez</div>
                <small>Administrador</small>
            </div>
        </div>
        <hr class="text-white">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item mb-2">
                <a href="{{ route('admin.inicio') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.inicio') ? 'active' : '' }}">
                    <i class="bi bi-house-door me-2"></i> Inicio
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.colaboradores') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('admin.colaboradores*') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i> Colaboradores
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="#" class="nav-link d-flex align-items-center {{ request()->routeIs('equipos.*') ? 'active' : '' }}">
                    <i class="bi bi-kanban me-2"></i> Equipos
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="#" class="nav-link d-flex align-items-center {{ request()->routeIs('proyectos.*') ? 'active' : '' }}">
                    <i class="bi bi-folder me-2"></i> Proyectos
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="#" class="nav-link d-flex align-items-center {{ request()->routeIs('notificaciones') ? 'active' : '' }}">
                    <i class="bi bi-bell me-2"></i> Notificaciones
                </a>
            </li>
        </ul>

        <hr class="text-white mt-auto">
        <a href="{{ route('logout') }}" class="nav-link d-flex align-items-center">
            <i class="bi bi-box-arrow-left me-2"></i> Cerrar sesión
        </a>
    </div>

    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</body>

</html>
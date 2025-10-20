@extends('layouts.app')
@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/colaboradores.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<main>
    <div class="resumen-cajas">
        <div class="card-resumen">
            <h5>Tareas activas</h5>
            <h3>80</h3>
            <p>+15 esta semana</p>
        </div>
        <div class="card-resumen">
            <h5>Tareas completadas</h5>
            <h3>230</h3>
            <p>+30 este mes</p>
        </div>
        <div class="card-resumen">
            <button data-bs-toggle="modal" data-bs-target="#modalAddColab">
                <i class="bi bi-person-plus me-2"></i>Añadir colaboradores
            </button>
        </div>
    </div>

    <div class="prueba">
        <h1>Colaboradores</h1>
        <div class="contenedor">
            <input type="search" id="buscarColaborador" placeholder="Buscar colaborador...">
            <div class="sub-contenedor">
                <a href="#">Líderes</a>
                <a href="#">Colaboradores</a>
            </div>
        </div>

        <div class="tabla encabezado">
            <h3>Nombre</h3>
            <h3>Correo</h3>
            <h3>Rol</h3>
            <h3>Rendimiento</h3>
        </div>

        <div id="listaColaboradores">
            @foreach($usuario as $user )
            <div class="tabla fila-colaborador">
                <div>
                    <h6>{{ $user->perfil->nombre }}</h6>
                    <p>{{ $user->perfil->apellido }}</p>
                </div>
                <div>
                    <h6>{{ $user->correo }}</h6>
                </div>
                <div>
                    <h6>{{ $user->rol }}</h6>
                </div>
                <div class="btn">
                    <p>Bueno</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>

<script>
    document.getElementById('buscarColaborador').addEventListener('input', function () {
        const filtro = this.value.toLowerCase();
        const filas = document.querySelectorAll('.fila-colaborador');

        filas.forEach(fila => {
            const nombre = fila.querySelector('div h6').textContent.toLowerCase();
            const apellido = fila.querySelector('div p').textContent.toLowerCase();
            const correo = fila.querySelectorAll('div h6')[1].textContent.toLowerCase();

            // Mostrar la fila si coincide con nombre, apellido o correo
            if (nombre.includes(filtro) || apellido.includes(filtro) || correo.includes(filtro)) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@include('admin.registrar')
@endsection

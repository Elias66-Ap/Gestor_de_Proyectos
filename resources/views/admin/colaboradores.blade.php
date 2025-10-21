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
            <h3 id="tar_activas">0</h3>
            <p id="tar_semana">+1 esta semana</p>
        </div>
        <div class="card-resumen">
            <h5>Tareas completadas</h5>
            <h3 id="tar_completadas">0</h3>
            <p>+3 este mes</p>
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
            @foreach($usuarios as $user)
            <div class="tabla fila-colaborador">
                <div>
                    <h6>{{ $user['perfil']['nombre'] ?? 'N/A' }}</h6>
                    <p>{{ $user['perfil']['apellido'] ?? '' }}</p>
                </div>
                <div>
                    <h6>{{ $user['correo'] ?? 'N/A' }}</h6>
                </div>
                <div>
                    <h6>{{ $user['rol'] ?? 'N/A' }}</h6>
                </div>
                <div>
                    <h6>{{ isset($user['rendimiento']['rendimiento']) ? ($user['rendimiento']['rendimiento']*100) . ' %' : '0 %' }}</h6>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>

<script src="{{ asset('js/colab.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@include('admin.registrar')
@endsection
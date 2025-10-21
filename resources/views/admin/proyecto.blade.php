@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/proyecto.css') }}">
    <!-- Bootstrap Modal CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<main>
    <!-- Tarjetas de resumen -->
    <div class="resumen-cajas">
        <div class="card-resumen">
            <h5>Tareas activas</h5>
            <h3 id="tar_activas">0</h3>
            <p>+15 esta semana</p>
        </div>
        <div class="card-resumen">
            <h5>Tareas completadas</h5>
            <h3 id="tar_completadas">0</h3>
            <p>+6 desde ayer</p>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="contenedor">
        <!-- Sección Proyectos -->
        <div class="proyecto">
            <div class="proyecto-header">
                <h2>Proyectos</h2>
                <!-- Botón para abrir modal -->
                <button id="boton" data-bs-toggle="modal" data-bs-target="#modalProyecto">+ Nuevo</button>
                <div class="filtros">
                    <a href="#">Fecha</a>
                    <a href="#">Progreso</a>
                </div>
            </div>

            <!-- Proyecto individual -->
            @for ($i = 0; $i < 4; $i++)
            <div class="card-proyecto">
                <div class="info-proyecto">
                    <span class="nombre-proyecto">App móvil E-commerce</span>
                    <span class="estado en-progreso">En progreso</span>
                </div>
                <progress min="0" max="100" value="75"></progress>
                <div class="estadisticas">
                    <p>75 % completado</p>
                    <p>5 miembros | Entrega 15 Feb 2025</p>
                </div>
            </div>
            @endfor
        </div>

        <!-- Sección Tareas próximas -->
        <div class="tareas-vencidas">
            <h3>Tareas próximas a vencer</h3>
            @for ($i = 0; $i < 5; $i++)
            <div class="card-tarea">
                <div class="info-tarea">
                    <span class="nombre-tarea">App móvil E-commerce</span>
                    <span class="estado en-progreso">En progreso</span>
                </div>
                <div class="estadisticas-2">
                    <p>75% completado</p>
                    <p>25/11/25</p>
                </div>
            </div>
            @endfor
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/tareas.js') }}"></script>

@include('admin.registrar-proyecto')
@endsection

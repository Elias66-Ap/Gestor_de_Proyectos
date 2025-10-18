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
            <h3>80</h3>
            <p>+15 esta semana</p>
        </div>
        <div class="card-resumen">
            <h5>Tareas completadas</h5>
            <h3>8</h3>
            <p>+6 desde ayer</p>
        </div>
        <div class="card-resumen">
            <h5>Presupuesto</h5>
            <h3>S/2500</h3>
        </div>
        <div class="card-resumen">
            <h5>Gastado</h5>
            <h3>S/500</h3>
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

<!-- Modal Crear Proyecto -->
<div class="modal fade" id="modalProyecto" tabindex="-1" aria-labelledby="modalProyectoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalProyectoLabel">Crear nuevo proyecto</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form>
        <div class="modal-body">
            <div class="mb-3">
                <label for="nombreProyecto" class="form-label">Nombre del proyecto</label>
                <input type="text" class="form-control" id="nombreProyecto" placeholder="Ej. Plataforma web">
            </div>
            <div class="mb-3">
                <label for="fechaEntrega" class="form-label">Fecha de entrega</label>
                <input type="date" class="form-control" id="fechaEntrega">
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripcion</label>
                <input type="text" class="form-control" id="descripcion" min="0">
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select id="estado" class="form-select">
                    <option value="en-progreso" selected>En progreso</option>
                    <option value="completado">Completado</option>
                    <option value="pendiente">Pendiente</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap Modal JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection

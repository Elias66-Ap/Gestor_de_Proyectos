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
            <!-- Botón para abrir el modal -->
            <button data-bs-toggle="modal" data-bs-target="#modalAddColab">
                Añadir<br>colaboradores
            </button>
        </div>
    </div>

    <div class="prueba">
        <h1>Colaboradores</h1>
        <div class="contenedor">
            <input type="search" placeholder="Buscar colaborador...">
            <div class="sub-contenedor">
                <a href="#">Líderes</a>
                <a href="#">Colaboradores</a>
            </div>
        </div>

        <div class="tabla encabezado">
            <h3>Nombre</h3>
            <h3>Rol</h3>
            <h3>Presente</h3>
            <h3>Rendimiento</h3>
        </div>

        @for ($i = 0; $i < 5; $i++)
        <div class="tabla">
            <div>
                <h6>Miguel Ignacio de las Casas</h6>
                <p>Miguel</p>
            </div>
            <div>
                <h6>Líder</h6>
            </div>
            <div>
                <h6>May 16, 2025</h6>
                <p>6:30</p>
            </div>
            <div class="btn">
                <p>Bueno</p>
            </div>
        </div>
        @endfor
    </div>
</main>

<!-- Modal para añadir colaboradores -->
<div class="modal fade" id="modalColaborador" tabindex="-1" aria-labelledby="modalColaboradorLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalColaboradorLabel">Añadir Colaborador</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form>
        <div class="modal-body">
            <div class="mb-3">
                <label for="nombreColaborador" class="form-label">Nombre completo</label>
                <input type="text" class="form-control" id="nombreColaborador" placeholder="Ej. Juan Pérez">
            </div>
            <div class="mb-3">
                <label for="apodoColaborador" class="form-label">Apodo</label>
                <input type="text" class="form-control" id="apodoColaborador" placeholder="Ej. Juanito">
            </div>
            <div class="mb-3">
                <label for="rolColaborador" class="form-label">Rol</label>
                <select class="form-select" id="rolColaborador">
                    <option value="Líder">Líder</option>
                    <option value="Colaborador">Colaborador</option>
                    <option value="Invitado">Invitado</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="correoColaborador" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="correoColaborador" placeholder="correo@ejemplo.com">
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@include('admin.registrar')
@endsection


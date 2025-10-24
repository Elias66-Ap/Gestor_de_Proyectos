@extends('layouts.app')
@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/colaboradores.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Estilos de DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
</head>

<main>
    {{-- Cajas resumen --}}
    <div class="resumen-cajas my-5 d-flex justify-content-center">
  <div class="card-resumen bg-white shadow-sm border-0 rounded-4 p-4 d-flex align-items-center justify-content-between w-75 flex-wrap">

    <!-- Sección izquierda: ícono + texto -->
    <div class="d-flex align-items-center mb-3 mb-md-0">
      <i class="bi bi-person-plus display-5 text-primary me-4"></i>
      <div>
        <h4 class="fw-bold mb-1 text-dark">Agregar nuevos usuarios</h4>
        <p class="text-muted mb-0">Gestiona fácilmente el ingreso de nuevos colaboradores al sistema.</p>
      </div>
    </div>

    <!-- Sección derecha: botón -->
    <button class="btn btn-primary px-4 py-2 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalAddColab">
      <i class="bi bi-person-plus-fill me-2"></i> Añadir usuario
    </button>
  </div>
</div>

    {{-- Tabla de colaboradores --}}
    <div class="prueba container my-5">
  <div class="text-center mb-4">
    <h2 class="fw-bold text-primary">Usuarios</h2>
    <p class="text-muted">Lista de usuarios registrados y su rendimiento actual</p>
  </div>

  <div class="table-responsive shadow rounded-4 overflow-hidden">
    <table id="tablaColaboradores" class="table align-middle text-center mb-0">
      <thead class="bg-primary text-white">
        <tr>
          <th scope="col">Foto</th>
          <th scope="col">Nombre</th>
          <th scope="col">Correo</th>
          <th scope="col">Rol</th>
          <th scope="col">Rendimiento</th>
        </tr>
      </thead>
      <tbody class="table-light">
        @foreach($usuarios as $user)
          @php
            $porcentaje = isset($user['rendimiento']['rendimiento'])
              ? $user['rendimiento']['rendimiento'] * 100
              : 0;

            if ($porcentaje <= 25) {
                $color = 'bg-danger'; // rojo
            } elseif ($porcentaje <= 75) {
                $color = 'bg-primary'; // azul
            } else {
                $color = 'bg-success'; // verde
            }
          @endphp

          <tr class="hover-row">
            <td>
              <img
                src="{{ isset($user['perfil']['imagen'])
                    ? asset('storage/' . $user['perfil']['imagen'])
                    : asset('images/default.jpeg') }}"
                alt="Foto de {{ $user['perfil']['nombre'] ?? 'usuario' }}"
                class="rounded-circle border border-2 border-primary-subtle shadow-sm"
                style="width: 55px; height: 55px; object-fit: cover;">
            </td>

            <td>
              <strong>{{ $user['perfil']['nombre'] ?? 'N/A' }}</strong><br>
              <small class="text-muted">{{ $user['perfil']['apellido'] ?? '' }}</small>
            </td>

            <td class="text-muted">{{ $user['correo'] ?? 'N/A' }}</td>

            <td>
              <span class="badge bg-secondary px-3 py-2 rounded-pill">
                {{ $user['rol'] ?? 'N/A' }}
              </span>
            </td>

            <td>
              <div class="progress" style="height: 8px;">
                <div
                  class="progress-bar {{ $color }}"
                  role="progressbar"
                  style="width: {{ $porcentaje }}%;"
                  aria-valuenow="{{ $porcentaje }}"
                  aria-valuemin="0"
                  aria-valuemax="100">
                </div>
              </div>
              <small class="text-muted">{{ $porcentaje }} %</small>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<style>
  .hover-row:hover {
    background-color: #f3f6ff !important;
    transition: background-color 0.3s ease;
  }

  .table thead th {
    font-size: 0.9rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
  }
  .card-resumen {
    transition: all 0.3s ease;
  }

  .card-resumen:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  }

  .btn-primary {
    background-color: #4e73df;
    border: none;
    font-weight: 600;
  }

  .btn-primary:hover {
    background-color: #3759c9;
  }

  @media (max-width: 768px) {
    .card-resumen {
      flex-direction: column;
      text-align: center;
    }
  }
</style>


</main>

{{-- Scripts --}}
<script src="{{ asset('js/colab.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Dependencias DataTables --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#tablaColaboradores').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        },
        pageLength: 5,
        lengthChange: false,
        order: [[1, 'asc']]
    });
});
</script>

@include('admin.registrar')
@endsection

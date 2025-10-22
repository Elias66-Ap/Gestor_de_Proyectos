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

    {{-- Tabla de colaboradores --}}
    <div class="prueba">
        <h1>Colaboradores</h1>

        <table id="tablaColaboradores" class="table table-striped table-bordered align-middle text-center mt-4">
            <thead class="table-light">
                <tr>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Rendimiento</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $user)
                <tr>
                    <td>
                        <img
                            src="{{ isset($user['perfil']['imagen'])
                                ? asset('storage/' . $user['perfil']['imagen'])
                                : asset('images/default.jpeg') }}"
                            alt="Foto de {{ $user['perfil']['nombre'] ?? 'usuario' }}"
                            style="width:50px; height:50px; object-fit:cover; border-radius:50%;">
                    </td>
                    <td>
                        <strong>{{ $user['perfil']['nombre'] ?? 'N/A' }}</strong><br>
                        <small class="text-muted">{{ $user['perfil']['apellido'] ?? '' }}</small>
                    </td>
                    <td>{{ $user['correo'] ?? 'N/A' }}</td>
                    <td>{{ $user['rol'] ?? 'N/A' }}</td>
                    <td>
                        {{ isset($user['rendimiento']['rendimiento'])
                            ? ($user['rendimiento']['rendimiento'] * 100) . ' %'
                            : '0 %' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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

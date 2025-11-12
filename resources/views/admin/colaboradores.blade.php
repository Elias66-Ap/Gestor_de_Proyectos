@extends('layouts.app')
@section('styles')
  <link rel="stylesheet" href="{{ asset('css/colaboradores.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
  <main class="bg-light min-vh-100 py-5">

    <!-- ===== RESUMEN USUARIOS ===== -->
    <div class="resumen-cajas d-flex flex-wrap justify-content-between gap-4 mb-5">
      @php
        $cards = [
          ['title' => 'Usuarios Totales', 'id' => 'usuarios_total', 'icon' => 'bi-people-fill', 'bg' => 'primary', 'desc' => 'Usuarios registrados en el sistema'],
          ['title' => 'Usuarios Sin Perfil', 'id' => 'usuarios_sin_perfil', 'icon' => 'bi-person-x', 'bg' => 'warning', 'desc' => 'Pendientes de completar información'],
          ['title' => 'Usuarios Inactivos', 'id' => 'usuarios_inactivos', 'icon' => 'bi-person-slash', 'bg' => 'danger', 'desc' => 'Usuarios desactivados o pausados']
        ];
      @endphp

      @foreach($cards as $card)
        <div class="card-resumen shadow-sm border-0 rounded-4 p-4 flex-fill bg-white hover-card d-flex align-items-center">
          <div class="icon-circle bg-{{ $card['bg'] }} me-3">
            <i class="bi {{ $card['icon'] }} fs-3"></i>
          </div>
          <div class="flex-grow-1">
            <h6 class="text-muted mb-1">{{ $card['title'] }}</h6>
            <h2 id="{{ $card['id'] }}" class="fw-bold text-dark">0</h2>
            <p class="text-secondary small mb-0">{{ $card['desc'] }}</p>
          </div>
        </div>
      @endforeach
    </div>

    <div class="container">

      <!-- ===== CONTROLES ===== -->
      <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
          <h4 class="fw-bold text-primary mb-1">Usuarios Registrados</h4>
          <p class="text-muted small mb-0">Visualiza todos los usuarios del sistema</p>
        </div>

        <div class="d-flex gap-1 flex-wrap">
          <button class="btn btn-gradient px-4 py-2 rounded-pill btn-primary" data-bs-toggle="modal"
            data-bs-target="#modalAddColab">
            <i class="bi bi-person-plus-fill me-2"></i> Nuevo usuario
          </button>
        </div>

        <div class="d-flex gap-2 flex-wrap">
          <button id="btnVerTodos" class="btn btn-gradient-primary rounded-pill px-3 btn-primary">
            <i class="bi bi-people-fill me-1"></i> Todos
          </button>
          <button id="btnVerSinPerfil" class="btn btn-gradient-warning rounded-pill px-3 btn-outline-secondary">
            <i class="bi bi-person-x-fill me-1"></i> Sin perfil
          </button>
        </div>
      </div>

      <!-- ===== FILTROS ===== -->
      <div class="filter-bar mb-4 p-3 bg-white shadow-sm rounded-4 d-flex flex-wrap justify-content-center gap-2">
        @php
          $filtros = [
            ['label' => 'Todos', 'icon' => 'bi-list-ul', 'data' => 'todos', 'active' => true],
            ['label' => 'Líderes', 'icon' => 'bi-person-gear', 'data' => 'lider'],
            ['label' => 'Colaboradores', 'icon' => 'bi-person-workspace', 'data' => 'colaborador'],
            ['label' => 'Mejores', 'icon' => 'bi-graph-up-arrow', 'data' => 'mejor']
          ];
        @endphp

        @foreach($filtros as $filtro)
          <button class="btn filtro {{ $filtro['active'] ?? false ? 'active' : '' }}" data-filtro="{{ $filtro['data'] }}">
            <i class="bi {{ $filtro['icon'] }} me-1"></i> {{ $filtro['label'] }}
          </button>
        @endforeach

      </div>

      <!-- ===== TABLA USUARIOS ===== -->
      <div id="tablaUsuarios" class="table-wrapper shadow-sm rounded-4 bg-white overflow-hidden mb-5">
        <table id="tablaColaboradores" class="table align-middle table-hover mb-0">
          <thead class="table-header">
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
              @if(isset($user['rol']) && in_array($user['rol'], ['Colaborador', 'Lider']))
                @php
                  $porcentaje = isset($user['rendimiento']['rendimiento']) ? $user['rendimiento']['rendimiento'] * 100 : 0;
                  $color = $porcentaje <= 25 ? 'bg-danger' : ($porcentaje <= 75 ? 'bg-primary' : 'bg-success');
                @endphp
                <tr>
                  <td>
                    <div class="avatar-container">
                      <img
                        src="{{ isset($user['perfil']['imagen']) ? asset('storage/' . $user['perfil']['imagen']) : asset('images/default.jpeg') }}"
                        alt="Foto" class="avatar shadow-sm">
                    </div>
                  </td>
                  <td>
                    <strong class="text-dark">{{ $user['perfil']['nombre'] ?? 'N/A' }}</strong><br>
                    <small class="text-muted">{{ $user['perfil']['apellido'] ?? '' }}</small>
                  </td>
                  <td class="text-muted">{{ $user['correo'] ?? 'N/A' }}</td>
                  <td><small class="text-muted">{{ $user['rol'] }}</small></td>
                  <td>
                    <div class="progress-container">
                      <div class="progress">
                        <div class="progress-bar {{ $color }}" style="width: {{ $porcentaje }}%;"></div>
                      </div>
                      <small class="text-muted">{{ $porcentaje }}%</small>
                    </div>
                  </td>
                </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- ===== TABLA SIN PERFIL ===== -->
      <div id="tablaSinPerfilContainer" class="table-wrapper shadow-sm rounded-4 bg-white overflow-hidden d-none">
        <table id="tablaSinPerfil" class="table align-middle table-hover mb-0">
          <thead class="table-header bg-warning">
            <tr>
              <th>Correo</th>
              <th>Rol</th>
            </tr>
          </thead>
          <tbody>
            @forelse($sin_perfil as $usuario)
              <tr>
                <td>{{ $usuario['correo'] ?? 'N/A' }}</td>
                <td><small class="text-muted">{{ $user['rol'] }}</small></td>
              </tr>
            @empty
              <tr>
                <td colspan="2" class="text-muted py-4">No hay usuarios sin perfil 🎉</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </main>

  @include('admin.registrar')
@endsection

@section('scripts')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
  <script src="{{ asset('js/admin_usuarios.js') }}"></script>
@endsection
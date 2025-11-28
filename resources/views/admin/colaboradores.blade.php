@extends('layouts.app')
@section('styles')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="{{ asset('css/colaboradores.css') }}">
@endsection

@section('content')
  <main>

    <!-- ===== RESUMEN USUARIOS ===== -->

    <div class="row g-4 mb-5 stat-row">

      <div class="col-md-4">
        <div class="stat-card stat-big">
          <span class="stat-badge stat-positive">+2 esta semana</span>
          <div class="stat-icon icon-blue">
            <i class="bi bi-people-fill"></i>
          </div>
          <div class="stat-value" id="usuarios_total">12</div>
          <div class="stat-label">Usuarios Totales</div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="stat-card stat-big">
          <span class="stat-badge stat-warning">-1 desde ayer</span>
          <div class="stat-icon icon-yellow">
            <i class="bi bi-person-exclamation"></i>
          </div>
          <div class="stat-value" id="usuario_sin_perfil">2</div>
          <div class="stat-label">Usuarios sin Perfil</div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="stat-card stat-big">
          <span class="stat-badge stat-danger">+4 este mes</span>
          <div class="stat-icon icon-red">
            <i class="bi bi-person-dash-fill"></i>
          </div>
          <div class="stat-value" id="usuarios_inactivos">4</div>
          <div class="stat-label">Usuarios Inactivos</div>
        </div>
      </div>

    </div>


    <div class="usuarios-wrapper">

      <!-- Header con búsqueda y botones -->
      <div class="usuarios-header">
        <div class="buscador">
          <i class="bi bi-search"></i>
          <input type="text" id="buscadorUsuarios" placeholder="Buscar usuario...">
        </div>

        <div class="acciones-header">

          <!-- FILTRO DE ROLES -->
          <div class="filter-select">
            <i class="bi bi-people"></i>
            <select id="filtroRol">
              <option value="">Roles</option>
              <option value="Lider">Líderes</option>
              <option value="Colaborador">Colaboradores</option>
            </select>
          </div>

          <!-- FILTRO DE RENDIMIENTO -->
          <div class="filter-select">
            <i class="bi bi-bar-chart"></i>
            <select id="filtroRend">
              <option value="">Rendimiento</option>
              <option value="80">80% o más</option>
              <option value="50">50% a 79%</option>
              <option value="0">Menos de 50%</option>
            </select>
          </div>

          <!-- BOTÓN SIN PERFIL -->
          <button class="btn-filtrar" id="btnSinPerfil">
            <i class="bi bi-person-exclamation"></i> Sin perfil
          </button>

          <!-- RESTABLECER -->
          <button class="btn-filtrar" id="btnTodos">
            <i class="bi bi-ui-checks"></i> Todos
          </button>

          <!-- BOTÓN NUEVO USUARIO -->
          <button class="btn-nuevo" data-bs-toggle="modal" data-bs-target="#modalAddColab">
            <i class="bi bi-person-plus"></i> Nuevo Usuario
          </button>
          @include('admin.registrar')
        </div>

      </div>

      <!-- Tabla moderna -->
      <div class="tabla-usuarios">

        <div class="tabla-header">
          <span>Usuario</span>
          <span>Rol</span>
          <span>Correo</span>
          <span>Rendimiento</span>
          <span>Acciones</span>
        </div>

        <!-- FILA -->
        @foreach ($usuarios as $index => $u)@php
            $rendimiento = ($u['rendimiento']['rendimiento'] ?? 0) * 100;

            $foto = $u['perfil']['imagen'] ?? null;
            $nombre = $u['perfil']['nombre'];
            $apellido = $u['perfil']['apellido'];
            $iniciales = strtoupper(substr($nombre, 0, 1) . substr($apellido, 0, 1));

            $colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#a855f7'];
            $color = $colors[$index % count($colors)];
          @endphp
          <div class="fila-usuario"
            data-busqueda="{{ strtolower($u['perfil']['nombre'] . ' ' . $u['perfil']['apellido'] . ' ' . $u['correo']) }}">
            <div class="user-info">
              @if($foto)
                <img src="{{ asset('storage/' . $foto) }}" class="user-avatar">
              @else
                <div class="user-avatar-inicial" style="background-color: {{ $color }};">
                  {{ $iniciales }}
                </div>
              @endif
              <span class="user-name">{{ $u['perfil']['nombre'] }} {{ $u['perfil']['apellido'] }} </span>
            </div>

            <span class="user-role">{{ $u['rol'] }} </span>
            <span class="user-email">{{ $u['correo'] }} </span>

            <div class="user-progress">
              <div class="progress-bar">
                <div style="width: {{ $rendimiento }}%"></div>
              </div>
              <span>{{ $rendimiento }}%</span>
            </div>

            <a href="#" class="btn-ver">Ver Perfil</a>
          </div>
        @endforeach
      </div>

      <!-- Paginación -->
      <div class="paginacion">
        <button><i class="bi bi-chevron-left"></i></button>
        <button><i class="bi bi-chevron-right"></i></button>
      </div>

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
          @forelse($sin_perfil as $user)
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
  <script src="{{ asset('js/admin_usuarios.js') }}"></script>
  <script>
    document.addEventListener("DOMContentLoaded", () => {

      const buscador = document.getElementById("buscadorUsuarios");
      const filas = document.querySelectorAll(".fila-usuario");

      const filtroRol = document.getElementById("filtroRol");
      const filtroRend = document.getElementById("filtroRend");
      const btnSinPerfil = document.getElementById("btnSinPerfil");
      const btnTodos = document.getElementById("btnTodos");

      /* ====================================================
         FUNCIÓN GENERAL QUE APLICA TODOS LOS FILTROS
      ======================================================= */
      function aplicarFiltros() {

        let texto = buscador.value.toLowerCase().trim();
        let rol = filtroRol.value;
        let rendimiento = filtroRend.value;

        filas.forEach(fila => {

          let contenido = fila.dataset.busqueda;
          let filaRol = fila.querySelector(".user-role").innerText.trim();
          let correo = fila.querySelector(".user-email").innerText.trim();

          let porcentaje = parseInt(
            fila.querySelector(".user-progress span").innerText.replace("%", "")
          );

          let mostrar = true;

          /* ===== FILTRO BUSCADOR ===== */
          if (!contenido.includes(texto)) {
            mostrar = false;
          }

          /* ===== FILTRO ROL ===== */
          if (rol && filaRol !== rol) {
            mostrar = false;
          }

          /* ===== FILTRO RENDIMIENTO ===== */
          if (rendimiento !== "") {
            if (rendimiento == 80 && porcentaje < 80) mostrar = false;
            if (rendimiento == 50 && (porcentaje < 50 || porcentaje > 79)) mostrar = false;
            if (rendimiento == 0 && porcentaje >= 50) mostrar = false;
          }

          /* ===== APLICAR ===== */
          if (mostrar) {
            fila.classList.remove("oculto");
          } else {
            fila.classList.add("oculto");
          }

        });

      }

      /* ====================================================
         EVENTO BUSCADOR
      ======================================================= */
      buscador.addEventListener("input", aplicarFiltros);

      /* ====================================================
         EVENTOS FILTROS
      ======================================================= */
      filtroRol.addEventListener("change", aplicarFiltros);
      filtroRend.addEventListener("change", aplicarFiltros);

      /* ====================================================
         BOTÓN SIN PERFIL
      ======================================================= */
      btnSinPerfil.addEventListener("click", () => {
        filas.forEach(fila => {
          const correo = fila.querySelector(".user-email").innerText.trim();

          if (!correo) {
            fila.classList.remove("oculto");
          } else {
            fila.classList.add("oculto");
          }
        });

        // Limpiar selects, pero no el buscador
        filtroRol.value = "";
        filtroRend.value = "";
      });

      /* ====================================================
         BOTÓN MOSTRAR TODOS
      ======================================================= */
      btnTodos.addEventListener("click", () => {

        filtroRol.value = "";
        filtroRend.value = "";
        buscador.value = "";

        filas.forEach(fila => fila.classList.remove("oculto"));
      });

    });
  </script>

@endsection
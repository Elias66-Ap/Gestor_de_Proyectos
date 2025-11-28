@extends('layouts.app_lider')

@section('styles')
  <link rel="stylesheet" href="{{ asset('css/lider/tareas.css') }}">
@endsection

@section('content1')
  <div class="container-fluid py-5">

    <div class="row g-4 mb-5">
      <div class="col-md-3">
        <div class="stat-card">
          <span class="stat-badge" id="#">+2 esta semana</span>
          <div class="stat-icon icon-blue">
            <i class="bi bi-kanban-fill"></i>
          </div>
          <div class="stat-value" id="tar_total"><i class="bi bi-arrow-clockwise"></i></div>
          <div class="stat-label">Tareas total</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <span class="stat-badge" id="#">+1 desde ayer</span>
          <div class="stat-icon icon-orange">
            <i class="bi bi-check-circle-fill"></i>
          </div>
          <div class="stat-value" id="tar_activas"><i class="bi bi-arrow-clockwise"></i></div>
          <div class="stat-label">Tareas activas</div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="stat-card">
          <span class="stat-badge" id="#">+4 este mes</span>
          <div class="stat-icon icon-green">
            <i class="bi bi-calendar-event"></i>
          </div>
          <div class="stat-value" id="tar_completadas"><i class="bi bi-arrow-clockwise"></i></div>
          <div class="stat-label">Tareas completadas</div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-icon icon-pink">
            <i class="bi bi-speedometer2"></i>
          </div>
          <div class="stat-value" id="tar_hoy"><i class="bi bi-arrow-clockwise"></i></div>
          <div class="stat-label">Entrega hoy</div>
        </div>
      </div>
    </div>

    {{-- ==================== FILTROS ==================== --}}
    <div class="card filter-bar p-3 mb-4 shadow-sm border-0 rounded-4">
      <div class="row g-3 align-items-center">

        <div class="col-md-3">
          <label class="small text-muted">Estado</label>
          <select id="filtroEstado" class="form-select rounded-3">
            <option value="">Todos</option>
            <option value="Por hacer">Por hacer</option>
            <option value="En proceso">En proceso</option>
            <option value="Revision">En revisión</option>
            <option value="Hecho">Completadas</option>
          </select>
        </div>

        <div class="col-md-3">
          <label class="small text-muted">Prioridad</label>
          <select id="filtroPrioridad" class="form-select rounded-3">
            <option value="">Todas</option>
            <option value="Alta">Alta</option>
            <option value="Media">Media</option>
            <option value="Baja">Baja</option>
          </select>
        </div>

        <div class="col-md-3">
          <label class="small text-muted">Fecha</label>
          <select id="filtroFecha" class="form-select rounded-3">
            <option value="">Todas</option>
            <option value="hoy">Hoy</option>
            <option value="semana">Esta semana</option>
            <option value="vencidas">Vencidas</option>
          </select>
        </div>

        <div class="col-md-3 text-end">
          <button id="btnLimpiarFiltros" class="btn btn-outline-secondary rounded-pill px-4">
            Limpiar filtros
          </button>
        </div>
      </div>
    </div>

    {{-- ==================== LISTA DE TAREAS ==================== --}}
    <div class="row g-4" id="listaTareas">

      @foreach ($tareas as $tar)
        @php
          $fecha = Carbon\Carbon::parse($tar['fecha_vencimiento'])->translatedFormat('d M Y');
          $prioridad = $tar['prioridad'] ?? 'Baja';

          [$progreso, $prio_color] = match ($tar['estado']) {
            'Por hacer' => [5, 'danger'],
            'En proceso' => [50, 'warning'],
            'Revision' => [75, 'primary'],
            'Hecho' => [100, 'success'],
            default => [0, 'secondary'],
          };
        @endphp

        <div class="col-lg-6 tarea-item" data-estado="{{ $tar['estado'] }}" data-prioridad="{{ $prioridad }}"
          data-fecha="{{ $tar['fecha_vencimiento'] }}">

          <div class="card tarea-card shadow-sm border-0 rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="estado-pill estado-{{ strtolower(str_replace(' ', '', $tar['estado'])) }}">
                {{ $tar['estado'] }}
              </span>
              <span
                class="badge bg-{{ $prioridad == 'Alta' ? 'danger' : ($prioridad == 'Media' ? 'warning text-dark' : 'info text-dark') }}">
                {{ $prioridad }}
              </span>
            </div>

            <h5 class="fw-bold mb-2">{{ $tar['titulo'] }}</h5>

            <div class="progress mb-2" style="height: 8px;">
              <div class="progress-bar bg-{{ $prio_color }}" style="width: {{ $progreso }}%"></div>
            </div>

            <div class="d-flex justify-content-between text-muted small mt-2">
              <span><i class="bi bi-bar-chart"></i> {{ $progreso }}%</span>
              <span><i class="bi bi-calendar3"></i> {{ $fecha }}</span>
            </div>
          </div>
        </div>

      @endforeach
    </div>

  </div>

  <div id="lider-info" data-id="{{ auth()->guard('usuario')->user()->id }}"></div>
@endsection

@section('scripts')
  <script src="{{ asset('js/dashboard_lider.js') }}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const items = document.querySelectorAll('.tarea-item');

      function filtrar() {
        const estado = document.getElementById('filtroEstado').value;
        const prioridad = document.getElementById('filtroPrioridad').value;
        const fecha = document.getElementById('filtroFecha').value;

        items.forEach(item => {
          let show = true;

          if (estado && item.dataset.estado !== estado) show = false;
          if (prioridad && item.dataset.prioridad !== prioridad) show = false;

          // filtro por fecha
          if (fecha) {
            const fechaTarea = new Date(item.dataset.fecha);
            const hoy = new Date();

            if (fecha === 'hoy' && fechaTarea.toDateString() !== hoy.toDateString()) show = false;

            if (fecha === 'semana') {
              const semanaInicio = new Date();
              semanaInicio.setDate(hoy.getDate() - 7);
              if (fechaTarea < semanaInicio) show = false;
            }

            if (fecha === 'vencidas' && fechaTarea >= hoy) show = false;
          }

          item.style.display = show ? 'block' : 'none';
        });
      }

      document.querySelectorAll('#filtroEstado, #filtroPrioridad, #filtroFecha')
        .forEach(f => f.addEventListener('change', filtrar));

      document.getElementById('btnLimpiarFiltros').addEventListener('click', () => {
        document.getElementById('filtroEstado').value = '';
        document.getElementById('filtroPrioridad').value = '';
        document.getElementById('filtroFecha').value = '';
        filtrar();
      });
    });

  </script>
@endsection
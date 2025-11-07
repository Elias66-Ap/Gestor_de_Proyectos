@extends('layouts.app_lider')

@section('content1')
<div class="container-fluid py-5">

  {{-- KPIs generales --}}
  <div class="row g-4 mb-5">
    <div class="col-md-3">
      <div class="card kpi-card border-0 text-center py-4 bg-gradient-primary text-white">
        <i class="bi bi-list-check fs-2 mb-2"></i>
        <h6 class="mb-1">Tareas Totales</h6>
        <h3 class="fw-bold" id="tar_total">0</h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card kpi-card border-0 text-center py-4 bg-gradient-warning text-dark">
        <i class="bi bi-hourglass-split fs-2 mb-2"></i>
        <h6 class="mb-1">Activas</h6>
        <h3 class="fw-bold" id="tar_activas">0</h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card kpi-card border-0 text-center py-4 bg-gradient-success text-white">
        <i class="bi bi-check-circle fs-2 mb-2"></i>
        <h6 class="mb-1">Completadas</h6>
        <h3 class="fw-bold" id="tar_completadas">0</h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card kpi-card border-0 text-center py-4 bg-gradient-danger text-white">
        <i class="bi bi-calendar-event fs-2 mb-2"></i>
        <h6 class="mb-1">Entregas Hoy</h6>
        <h3 class="fw-bold" id="tar_hoy">0</h3>
      </div>
    </div>
  </div>

  {{-- Lista de tareas --}}
  <div class="row g-4">
    @foreach ($tareas as $tar)
      @php
        $fecha = Carbon\Carbon::parse($tar['fecha_vencimiento'])->translatedFormat('d M Y');
        $prioridad = match ($tar['prioridad']) {
          'Alta' => 'danger',
          'Media' => 'warning text-dark',
          'Baja' => 'info text-dark',
          default => 'primary'
        };

        [$progreso, $prio_color] = match ($tar['estado']) {
          'Por hacer' => [5, 'danger'],
          'En proceso' => [50, 'warning'],
          'Revision' => [75, 'primary'],
          'Hecho' => [100, 'success'],
          default => [0, 'secondary']
        };
      @endphp

      <div class="col-lg-6">
        <div class="card tarea-card border-0 shadow-sm rounded-4 p-3 position-relative">
          <div class="priority-bar bg-{{ $prio_color }}"></div>
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="fw-semibold text-dark">{{ $tar['titulo'] }}</span>
            <span class="badge bg-{{ $prioridad }}">{{ $tar['prioridad'] }}</span>
          </div>

          <div class="progress mb-2" style="height: 8px;">
            <div class="progress-bar {{ 'bg-' . $prio_color }}"
                 role="progressbar"
                 style="width: {{ $progreso }}%; transition: width 0.5s ease;"
                 aria-valuenow="{{ $progreso }}"
                 aria-valuemin="0"
                 aria-valuemax="100"></div>
          </div>

          <div class="d-flex justify-content-between small text-muted mt-1">
            <span>{{ $progreso }}%</span>
            <span><i class="bi bi-calendar3 me-1"></i>{{ $fecha }}</span>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

{{-- Scripts --}}
<div id="lider-info" data-id="{{ auth()->guard('usuario')->user()->id }}"></div>

<style>
  /* === KPI CARDS === */
  .kpi-card {
    border-radius: 1rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .kpi-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
  }

  /* === TASK CARDS === */
  .tarea-card {
    background: #fff;
    transition: all 0.3s ease;
    overflow: hidden;
  }
  .tarea-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.12);
  }
  .priority-bar {
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 4px;
    border-radius: 4px 0 0 4px;
  }

  /* === GRADIENT THEMES === */
  .bg-gradient-primary {
    background: linear-gradient(135deg, #4e73df, #224abe);
  }
  .bg-gradient-success {
    background: linear-gradient(135deg, #1cc88a, #198754);
  }
  .bg-gradient-warning {
    background: linear-gradient(135deg, #f6c23e, #dda20a);
  }
  .bg-gradient-danger {
    background: linear-gradient(135deg, #e74a3b, #be2617);
  }
</style>
@endsection

@section('scripts')
<script src="{{ asset('js/dashboard_lider.js') }}"></script>
@endsection

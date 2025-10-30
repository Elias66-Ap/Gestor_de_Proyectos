@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/proyecto.css') }}">
@endsection

@section('content')
<main class="container py-4">

  <!-- TARJETAS DE RESUMEN -->
  <div class="resumen-cajas d-flex justify-content-between flex-wrap mb-4">
    <div class="card-resumen shadow-sm border-0 rounded-4 p-3 flex-fill mx-2 text-center bg-light">
      <h6 class="text-muted">Proyectos activos</h6>
      <h2 id="proy_activos" class="fw-bold text-primary">0</h2>
      <p class="text-secondary small mb-0">En desarrollo</p>
    </div>
    <div class="card-resumen shadow-sm border-0 rounded-4 p-3 flex-fill mx-2 text-center bg-light">
      <h6 class="text-muted">Proyectos en pausa</h6>
      <h2 id="proy_pausa" class="fw-bold text-warning">0</h2>
      <p class="text-secondary small mb-0">Pausado</p>
    </div>
    <div class="card-resumen shadow-sm border-0 rounded-4 p-3 flex-fill mx-2 text-center bg-light">
      <h6 class="text-muted">Proyectos completados</h6>
      <h2 id="proy_completados" class="fw-bold text-success">0</h2>
      <p class="text-secondary small mb-0">Finalizados</p>
    </div>
  </div>

  <!-- CONTENEDOR PRINCIPAL -->
  <div class="contenedor">

    <!-- ENCABEZADO -->
    <div class="proyecto-header d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold text-dark mb-0">Proyectos</h2>

      <div class="d-flex align-items-center gap-3">
        <a href="#" id="filtroFecha" class="text-decoration-none text-secondary hover-underline">📅 Fecha</a>
        <a href="#" id="filtroProgreso" class="text-decoration-none text-secondary hover-underline">📈 Progreso</a>
        <button id="boton" data-bs-toggle="modal" data-bs-target="#modalProyecto"
          class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
          + Nuevo
        </button>
      </div>
    </div>

    @foreach($proyectos as $proyecto)
    <div class="card shadow-sm border-0 rounded-4 mb-4 overflow-hidden" id="tarjeta-{{ $proyecto['id'] }}">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <h5 class="fw-bold mb-1 text-dark">{{ $proyecto['nombre'] }}</h5>
          </div>
          <button class="btn btn-sm btn-outline-secondary rounded-pill">
            <i class="bi bi-three-dots"></i>
          </button>
        </div>
        <p class="text-muted mb-4" style="line-height: 1.5; max-width: 700px;">
          {{ \Illuminate\Support\Str::limit(
          $proyecto['descripcion_breve'] ?? $proyecto['descripcion'] ?? 'Sin descripción breve disponible.',
          160
      ) }}
          @if(strlen($proyecto['descripcion_breve'] ?? '') > 160)
          <a href="#" class="text-decoration-none small text-primary">Ver más</a>
          @endif
        </p>

        <div class="row g-4 align-items-center mb-3">
          <div class="col-6 col-md-3">
            <small class="text-secondary">📅 Fecha inicio</small><br>
            <strong>{{ $proyecto['fecha_inicio'] ? \Carbon\Carbon::parse($proyecto['fecha_inicio'])->format('d M Y') : '—' }}</strong>
          </div>
          <div class="col-6 col-md-3">
            <small class="text-secondary">⏰ Fecha entrega</small><br>
            <strong>{{ $proyecto['fecha_entrega'] ? \Carbon\Carbon::parse($proyecto['fecha_entrega'])->format('d M Y') : '—' }}</strong>
          </div>
          <div class="col-6 col-md-3">
            <small class="text-secondary">👥 Miembros</small><br>
            <strong>{{ $proyecto['miembros_count'] ?? 0 }}</strong>
          </div>
          <div class="col-6 col-md-3 text-md-end">
            <small class="text-secondary">Progreso</small>
            <div class="mt-2">
              <progress
                value="{{ $proyecto['progreso'] }}"
                max="100"
                class="w-100"
                style="height: 10px;">
                {{ $proyecto['progreso'] }}%
              </progress>
            </div>
            <small class="d-block mt-1 text-secondary">{{ $proyecto['progreso'] }}%</small>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</main>

<!-- MODAL -->
@include('admin.registrar-proyecto')

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/proyectos.js') }}"></script>
@endsection
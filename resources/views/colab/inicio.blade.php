@extends('layouts.app_colab')

@section('content')
<div class="container-fluid py-5" style="background-color: #f4f6fa;">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-1">👋 Hola, {{ auth()->user()->nombre ?? 'Colaborador' }}</h2>
            <p class="text-muted mb-0">Este es tu resumen general de actividades.</p>
        </div>

    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center py-4">
                <i class="bi bi-list-check text-primary fs-2 mb-2"></i>
                <h6 class="text-muted mb-1">Tareas totales</h6>
                <h3 class="fw-bold text-primary" id="tar_total">0</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center py-4">
                <i class="bi bi-hourglass-split text-warning fs-2 mb-2"></i>
                <h6 class="text-muted mb-1">Pendientes</h6>
                <h3 class="fw-bold text-warning" id="tar_pendientes">0</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center py-4">
                <i class="bi bi-check-circle text-success fs-2 mb-2"></i>
                <h6 class="text-muted mb-1">Completadas</h6>
                <h3 class="fw-bold text-success" id="tar_completadas">0</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center py-4">
                <i class="bi bi-calendar-event text-danger fs-2 mb-2"></i>
                <h6 class="text-muted mb-1">Próximas entregas</h6>
                <h3 class="fw-bold text-danger" id="tar_hoy">0</h3>
            </div>
        </div>
    </div>

    {{-- Tareas y Proyectos --}}
    <div class="row g-4">

        {{-- Tareas asignadas --}}


        {{-- Proyectos del colaborador --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-4 text-primary">📁 Proyectos donde participas</h5>

                    @foreach($proyectos as $pro)
                    <div class="mb-4 project-card" style="transition: transform 0.3s, box-shadow 0.3s;">
                        <div class="fw-semibold">{{ $pro['nombre'] }}</div>
                        <div class="progress my-2" style="height: 8px; border-radius: 10px;">
                            <div class="progress-bar bg-primary" style="width: {{ $pro['progreso'] }}%; transition: width 1s;"></div>
                        </div>
                        <div class="text-muted small">{{ $pro['progreso'] }}% completado</div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">🗂️ Tareas asignadas</h5>

                    @foreach($tareas as $tar)
                    @php
                    $fecha = Carbon\Carbon::parse($tar['fecha_vencimiento'])->translatedFormat('d M Y');

                    $prioridad = '';

                    if ($tar['prioridad'] === 'Alta') {
                    $prioridad = 'danger';
                    } elseif ($tar['prioridad'] === 'Media') {
                    $prioridad = 'warning text-dark';
                    } elseif ($tar['prioridad'] === 'Baja') {
                    $prioridad = 'info text-dark';
                    } else {
                    $prioridad = 'primary';
                    }

                    $progreso = 0;
                    $prio_color='';

                    if($tar['estado'] === 'Por hacer'){
                    $progreso = 10;
                    $pro_color = 'danger';
                    }elseif($tar['estado'] === 'En proceso'){
                    $progreso = 50;
                    $pro_color = 'warning';
                    }elseif($tar['estado'] === 'Revision'){
                    $progreso = 75;
                    $pro_color = 'primary';
                    }elseif($tar['estado'] === 'Hecho'){
                    $progreso=100;
                    $pro_color = 'success';
                    }
                    @endphp
                    <div class="mb-3 p-3 rounded-3 bg-light task-card" style="transition: transform 0.3s, box-shadow 0.3s;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">{{ $tar['titulo'] }}</span>
                            <span class="badge bg-{{ $prioridad }} text-uppercase">{{ $tar['prioridad'] }}</span>
                        </div>
                        <div class="progress mb-2" style="height: 8px; border-radius: 10px;">
                            <div class="progress-bar bg-{{ $pro_color}}" style="width: {{ $progreso }}%; transition: width 1s;"></div>
                        </div>
                        <div class="d-flex justify-content-between small text-muted">
                            <span>{{ $progreso }}% completado</span>
                            <span><i class="bi bi-calendar3 me-1"></i>{{ $fecha }}</span>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>

    </div>

</div>
<div id="user-info" data-id="{{ auth()->guard('usuario')->user()->id }}"></div>
{{-- Animaciones hover para tarjetas --}}
<style>
    .task-card:hover,
    .project-card:hover,
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
    }
</style>


@endsection
@section('scripts')
<script src="{{ asset('js/dash_colab.js') }}"></script>
@endsection
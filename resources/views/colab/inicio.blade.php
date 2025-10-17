@extends('layouts.app_colab')

@section('content')
<div class="container-fluid py-5" style="background-color: #f4f6fa;">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-1">👋 Hola, {{ Auth::user()->name ?? 'Colaborador' }}</h2>
            <p class="text-muted mb-0">Este es tu resumen general de actividades.</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="bi bi-plus-circle me-2"></i> Nueva tarea
        </button>
    </div>

    {{-- Estadísticas rápidas --}}
    <div class="row g-4 mb-5">
        @foreach([
            ['title'=>'Proyectos activos','value'=>4,'color'=>'primary','icon'=>'bi-folder'],
            ['title'=>'Tareas asignadas','value'=>12,'color'=>'warning','icon'=>'bi-list-check'],
            ['title'=>'Tareas completadas','value'=>7,'color'=>'success','icon'=>'bi-check-circle'],
            ['title'=>'Próximas entregas','value'=>3,'color'=>'danger','icon'=>'bi-calendar3']
        ] as $stat)
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center py-4 bg-white" style="transition: transform 0.3s, box-shadow 0.3s;">
                <i class="bi {{ $stat['icon'] }} fs-2 text-{{ $stat['color'] }} mb-2"></i>
                <h6 class="text-muted mb-1">{{ $stat['title'] }}</h6>
                <h3 class="fw-bold text-{{ $stat['color'] }}">{{ $stat['value'] }}</h3>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Tareas y Proyectos --}}
    <div class="row g-4">

        {{-- Tareas asignadas --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">🗂️ Tareas asignadas</h5>

                    @foreach([
                        ['titulo'=>'Diseñar login responsive','prioridad'=>'alta','color'=>'danger','progreso'=>80,'fecha'=>'18/10/2025'],
                        ['titulo'=>'Corregir bug en módulo de reportes','prioridad'=>'media','color'=>'warning','progreso'=>45,'fecha'=>'20/10/2025'],
                        ['titulo'=>'Actualizar documentación técnica','prioridad'=>'baja','color'=>'info','progreso'=>20,'fecha'=>'25/10/2025'],
                    ] as $t)
                    <div class="mb-3 p-3 rounded-3 bg-light task-card" style="transition: transform 0.3s, box-shadow 0.3s;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">{{ $t['titulo'] }}</span>
                            <span class="badge bg-{{ $t['color'] }} text-uppercase">{{ $t['prioridad'] }}</span>
                        </div>
                        <div class="progress mb-2" style="height: 8px; border-radius: 10px;">
                            <div class="progress-bar bg-{{ $t['color'] }}" style="width: {{ $t['progreso'] }}%; transition: width 1s;"></div>
                        </div>
                        <div class="d-flex justify-content-between small text-muted">
                            <span>{{ $t['progreso'] }}% completado</span>
                            <span><i class="bi bi-calendar3 me-1"></i>{{ $t['fecha'] }}</span>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>

        {{-- Proyectos del colaborador --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-4 text-primary">📁 Proyectos donde participas</h5>

                    @foreach([
                        ['nombre'=>'CRM empresarial','progreso'=>60],
                        ['nombre'=>'API microservicios','progreso'=>80],
                        ['nombre'=>'App móvil E-commerce','progreso'=>45],
                    ] as $p)
                    <div class="mb-4 project-card" style="transition: transform 0.3s, box-shadow 0.3s;">
                        <div class="fw-semibold">{{ $p['nombre'] }}</div>
                        <div class="progress my-2" style="height: 8px; border-radius: 10px;">
                            <div class="progress-bar bg-primary" style="width: {{ $p['progreso'] }}%; transition: width 1s;"></div>
                        </div>
                        <div class="text-muted small">{{ $p['progreso'] }}% completado</div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>

    </div>
</div>

{{-- Animaciones hover para tarjetas --}}
<style>
.task-card:hover, .project-card:hover, .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.12);
}
</style>
@endsection

@extends('layouts.app_colab')

@section('styles')
<style>
/* General */
body {
    background-color: #f4f6fa;
}
.card {
    border-radius: 1rem;
}

/* Tarjetas de dashboard */
.card .fs-2 {
    display: block;
    margin-bottom: 0.5rem;
}

/* Proyectos */
.project-card {
    background: #fff;
    padding: 1rem 1.5rem;
    border-radius: 1rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 25px rgba(0,0,0,0.1);
}
.project-card .fw-semibold {
    font-size: 1.05rem;
}

/* Progreso */
.progress {
    height: 10px;
    border-radius: 10px;
}
.progress-bar {
    transition: width 0.8s ease;
}

/* Tareas */
.task-card {
    background: #fff;
    padding: 1rem;
    border-radius: 1rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.task-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
.task-card .badge {
    font-size: 0.75rem;
}

/* Scroll tareas */
.task-list {
    max-height: 400px; /* Ajustable */
    overflow-y: auto;
    padding-right: 5px; /* Espacio para scrollbar */
}

/* Scrollbar moderno */
.task-list::-webkit-scrollbar {
    width: 6px;
}
.task-list::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.2);
    border-radius: 3px;
}
.task-list::-webkit-scrollbar-track {
    background: transparent;
}

/* Encabezado */
h2, h5 {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Responsivo */
@media(max-width: 768px){
    .task-list {
        max-height: 300px;
    }
}
</style>
@endsection

@section('content')
<div class="container-fluid py-5">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-1">👋 Hola, {{ auth()->user()->nombre ?? 'Colaborador' }}</h2>
            <p class="text-muted mb-0">Este es tu resumen general de actividades.</p>
        </div>
    </div>

    {{-- Dashboard --}}
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

    {{-- Contenido principal --}}
    <div class="row g-4">

        {{-- Proyectos --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-4 text-primary">📁 Proyectos donde participas</h5>

                    @foreach($proyectos as $pro)
                    <a href="{{ route ('tablero.proyecto', $pro['id']) }}" class="text-decoration-none text-dark">
                    <div class="mb-4 project-card">
                        <div class="fw-semibold">{{ $pro['nombre'] }}</div>
                        <div class="progress my-2">
                            <div class="progress-bar bg-primary" style="width: {{ $pro['progreso'] }}%;"></div>
                        </div>
                        <div class="text-muted small">{{ $pro['progreso'] }}% completado</div>
                    </div>
                    </a>
                    @endforeach

                </div>
            </div>
        </div>

        {{-- Tareas --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">🗂️ Tareas asignadas</h5>

                    <div class="task-list">
                        @foreach($tareas as $tar)
                        @php
                            $fecha = Carbon\Carbon::parse($tar['fecha_vencimiento'])->translatedFormat('d M Y');
                            $prioridad = match($tar['prioridad']){
                                'Alta' => 'danger',
                                'Media' => 'warning text-dark',
                                'Baja' => 'info text-dark',
                                default => 'primary'
                            };
                            $progreso = match($tar['estado']){
                                'Por hacer' => 10,
                                'En proceso' => 50,
                                'Revision' => 75,
                                'Hecho' => 100,
                                default => 0
                            };
                            $pro_color = match($tar['estado']){
                                'Por hacer' => 'danger',
                                'En proceso' => 'warning',
                                'Revision' => 'primary',
                                'Hecho' => 'success',
                                default => 'secondary'
                            };
                        @endphp
                        <div class="mb-3 p-3 rounded-3 bg-light task-card">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-semibold">{{ $tar['titulo'] }}</span>
                                <span class="badge bg-{{ $prioridad }} text-uppercase">{{ $tar['prioridad'] }}</span>
                            </div>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-{{ $pro_color}}" style="width: {{ $progreso }}%;"></div>
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
</div>

<div id="user-info" data-id="{{ auth()->guard('usuario')->user()->id }}"></div>

@endsection

@section('scripts')
<script src="{{ asset('js/dash_colab.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const taskList = document.querySelector('.task-list');
    
    taskList.addEventListener('wheel', (e) => {
        if (taskList.scrollHeight > taskList.clientHeight) {
            taskList.scrollBy({
                top: e.deltaY,
                behavior: 'smooth'
            });
        }
    }, { passive: true }); 
});

</script>
@endsection

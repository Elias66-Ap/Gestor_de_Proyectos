@extends('layouts.app_colab')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/colab/inicio.css') }}">
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
                <div class="stat-card">
                    <span class="stat-badge">+2 esta semana</span>
                    <div class="stat-icon icon-blue">
                        <i class="bi bi-list-check"></i>
                    </div>
                    <div class="stat-value" id="tar_total">12</div>
                    <div class="stat-label">Tareas Totales</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card">
                    <span class="stat-badge">-1 desde ayer</span>
                    <div class="stat-icon icon-orange">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div class="stat-value" id="tar_pendientes">2</div>
                    <div class="stat-label">Pendientes</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card">
                    <span class="stat-badge">+4 este mes</span>
                    <div class="stat-icon icon-green">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stat-value" id="tar_completadas">4</div>
                    <div class="stat-label">Completadas</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon icon-pink">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                    <div class="stat-value" id="tar_hoy">0</div>
                    <div class="stat-label">Próximas Entregas</div>
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
                            <a href="{{ route('tablero.proyecto', ['id' => $pro['id'], 'from' => url()->current()]) }}"
                                class="text-decoration-none text-dark">
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
                                    $prioridad = match ($tar['prioridad']) {
                                        'Alta' => 'danger',
                                        'Media' => 'warning text-dark',
                                        'Baja' => 'info text-dark',
                                        default => 'primary'
                                    };
                                    $progreso = match ($tar['estado']) {
                                        'Por hacer' => 10,
                                        'En proceso' => 50,
                                        'Revision' => 75,
                                        'Hecho' => 100,
                                        default => 0
                                    };
                                    $pro_color = match ($tar['estado']) {
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
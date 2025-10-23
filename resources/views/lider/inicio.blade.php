@extends('layouts.app_lider')

@section('content1')
<div class="container-fluid bg-light min-vh-100 py-4 px-5">

    {{-- ==== CABECERA ==== --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold">📊 Panel General del Líder</h2>
        <p class="text-muted">Tareas y proyectos en tiempo real</p>
    </div>

    {{-- ==== RESUMEN SUPERIOR ==== --}}
    <div class="row gx-5 gy-4 mb-5 justify-content-center">
        {{-- Tareas completadas --}}
        <div class="col-md-2 col-sm-6">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center">
                <i class="bi bi-clipboard-check fs-3 text-success mb-2"></i>
                <h6 class="text-muted">Tareas Completadas</h6>
                <h4 class="fw-bold text-dark" id="tar_completadas">0</h4>
                <small class="text-success fw-semibold">
                    <i class="bi bi-graph-up"></i> +12% semana
                </small>
            </div>
        </div>

        {{-- Tareas pendientes --}}
        <div class="col-md-2 col-sm-6">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center">
                <i class="bi bi-hourglass-split fs-3 text-warning mb-2"></i>
                <h6 class="text-muted">Tareas Pendientes</h6>
                <h4 class="fw-bold text-dark" id="tar_pendientes">128</h4>
                <small class="text-danger fw-semibold">
                    <i class="bi bi-graph-down"></i> -3 hoy
                </small>
            </div>
        </div>

        {{-- Proyectos activos --}}
        <div class="col-md-2 col-sm-6">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center">
                <i class="bi bi-diagram-3 fs-3 text-info mb-2"></i>
                <h6 class="text-muted">Proyectos Activos</h6>
                <h4 class="fw-bold text-dark" id="pro_activos">14</h4>
                <small class="text-success fw-semibold">
                    <i class="bi bi-graph-up"></i> 0 nuevos
                </small>
            </div>
        </div>

        {{-- Proyectos terminados --}}
        <div class="col-md-2 col-sm-6">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center">
                <i class="bi bi-check2-circle fs-3 text-secondary mb-2"></i>
                <h6 class="text-muted">Proyectos Terminados</h6>
                <h4 class="fw-bold text-dark" id="pro_completados">27</h4>
                <small class="text-success fw-semibold">
                    <i class="bi bi-graph-up"></i> 0 mes
                </small>
            </div>
        </div>
    </div>

    {{-- ==== GRÁFICOS ==== --}}
    <div class="row g-4 justify-content-center">
        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0 rounded-4 p-3 h-100">
                <h6 class="fw-bold text-center mb-3">Proyectos Activos vs Terminados</h6>
                <canvas id="proyectosChart" height="200"></canvas>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0 rounded-4 p-3 h-100">
                <h6 class="fw-bold text-center mb-3">Tareas Completadas (Últimos 6 meses)</h6>
                <canvas id="tareasCompletadasChart" height="200"></canvas>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0 rounded-4 p-3 h-100">
                <h6 class="fw-bold text-center mb-3">Tareas Pendientes (Últimos 6 meses)</h6>
                <canvas id="tareasPendientesChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ==== ESTILOS ==== --}}
<style>
    body {
        background-color: #f8fafc;
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    }

    .row.gx-5 > [class*='col-'] {
        margin-right: 15px;
        margin-left: 15px;
    }
</style>

{{-- ==== LIBRERÍAS ==== --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- ==== SCRIPTS DASHBOARD ==== --}}
<script>
    document.addEventListener('DOMContentLoaded', cargarChartProyectos);

    // === Proyectos activos vs terminados ===
    async function cargarChartProyectos() {
        try {
            const res = await fetch('http://127.0.0.1:8000/api/dashboard/proyectos');
            const json = await res.json();

            if (json.status === 'success') {
                const ctx = document.getElementById('proyectosChart').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Activos', 'Terminados', 'En pausa'],
                        datasets: [{
                            data: [
                                json.data.activos,
                                json.data.completados,
                                json.data.pausa
                            ],
                            backgroundColor: ['#36b9cc', '#1cc88a', '#f6c23e']
                        }]
                    },
                    options: { plugins: { legend: { position: 'bottom' } } }
                });
            }
        } catch (error) {
            console.error('Error cargando chart:', error);
        }
    }

    // === Tareas completadas ===
    new Chart(document.getElementById('tareasCompletadasChart'), {
        type: 'line',
        data: {
            labels: ['May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct'],
            datasets: [{
                label: 'Completadas',
                data: [150, 200, 250, 300, 350, 400],
                borderColor: '#1cc88a',
                backgroundColor: 'rgba(28, 200, 138, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: { plugins: { legend: { display: false } } }
    });

    // === Tareas pendientes ===
    new Chart(document.getElementById('tareasPendientesChart'), {
        type: 'line',
        data: {
            labels: ['May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct'],
            datasets: [{
                label: 'Pendientes',
                data: [80, 100, 120, 90, 110, 95],
                borderColor: '#f6c23e',
                backgroundColor: 'rgba(246, 194, 62, 0.3)',
                fill: true,
                tension: 0.4
            }]
        },
        options: { plugins: { legend: { display: false } } }
    });
</script>

{{-- ==== ARCHIVOS EXTERNOS ==== --}}
<script src="{{ asset('js/tareas.js') }}"></script>
<script src="{{ asset('js/usuarios.js') }}"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
@endsection

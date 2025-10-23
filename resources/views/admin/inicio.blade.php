@extends('layouts.app')

@section('content')
<div class="container-fluid bg-light min-vh-100 py-4 px-5">

    {{-- ==== CABECERA ==== --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold">📊 Panel General del Administrador</h2>
        <p class="text-muted">Monitorea usuarios, tareas y proyectos en tiempo real</p>
    </div>

    {{-- ==== RESUMEN SUPERIOR ==== --}}
    <div class="row g-4 mb-4">
        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center">
                <i class="bi bi-people fs-3 text-primary mb-2"></i>
                <h6 class="text-muted">Usuarios Totales</h6>
                <h4 class="fw-bold text-dark" id="total_usu">0</h4>
                <small class="text-success fw-semibold" id="tot_usu"><i class="bi bi-graph-up"></i> +5% este mes</small>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center">
                <i class="bi bi-clipboard-check fs-3 text-success mb-2"></i>
                <h6 class="text-muted">Tareas Completadas</h6>
                <h4 class="fw-bold text-dark" id="tar_completadas">0</h4>
                <small class="text-success fw-semibold" id="tar_comp"><i class="bi bi-graph-up"></i> +12% semana</small>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center">
                <i class="bi bi-hourglass-split fs-3 text-warning mb-2"></i>
                <h6 class="text-muted">Tareas Pendientes</h6>
                <h4 class="fw-bold text-dark" id="tar_pendientes">128</h4>
                <small class="text-danger fw-semibold" id="tar_pend"><i class="bi bi-graph-down"></i> -3 hoy</small>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center">
                <i class="bi bi-diagram-3 fs-3 text-info mb-2"></i>
                <h6 class="text-muted">Proyectos Activos</h6>
                <h4 class="fw-bold text-dark" id="pro_activos">14</h4>
                <small class="text-success fw-semibold" id="pro_act"><i class="bi bi-graph-up"></i> 0 nuevos</small>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center">
                <i class="bi bi-check2-circle fs-3 text-secondary mb-2"></i>
                <h6 class="text-muted">Proyectos Terminados</h6>
                <h4 class="fw-bold text-dark" id="pro_completados">27</h4>
                <small class="text-success fw-semibold" id="pro_com"><i class="bi bi-graph-up"></i> 0 mes</small>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center">
                <i class="bi bi-lightning-charge fs-3 text-danger mb-2"></i>
                <h6 class="text-muted">Productividad Promedio</h6>
                <h4 class="fw-bold text-dark" id="promedio_rendimiento">89%</h4>
            </div>
        </div>
    </div>

    {{-- ==== GRÁFICOS ==== --}}
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 p-3">
                <h6 class="fw-bold text-center mb-3">Usuarios Registrados (Últimos 6 meses)</h6>
                <canvas id="usuariosChart"></canvas>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 p-3">
                <h6 class="fw-bold text-center mb-3">Proyectos Activos vs Terminados</h6>
                <canvas id="proyectosChart"></canvas>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 p-3">
                <h6 class="fw-bold text-center mb-3">Productividad General</h6>
                <canvas id="productividadChart"></canvas>
            </div>
        </div>
    </div>

</div>

{{-- ==== ESTILOS ==== --}}
<style>
    body { background-color: #f8fafc; }
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
</style>

{{-- ==== LIBRERÍAS ==== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

{{-- ==== GRÁFICOS ==== --}}
<script>
    // Usuarios por mes
    new Chart(document.getElementById('usuariosChart'), {
        type: 'line',
        data: {
            labels: ['May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct'],
            datasets: [{
                label: 'Usuarios',
                data: [120, 180, 220, 260, 310, 400],
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.2)',
                tension: 0.4,
                fill: true
            }]
        },
        options: { plugins: { legend: { display: false } } }
    });

    // Proyectos activos vs terminados
    new Chart(document.getElementById('proyectosChart'), {
        type: 'doughnut',
        data: {
            labels: ['Activos', 'Terminados', 'En pausa'],
            datasets: [{
                data: [14, 27, 3],
                backgroundColor: ['#36b9cc', '#1cc88a', '#f6c23e']
            }]
        },
        options: { plugins: { legend: { position: 'bottom' } } }
    });

    // Productividad
    new Chart(document.getElementById('productividadChart'), {
        type: 'bar',
        data: {
            labels: ['Comunicación', 'Eficiencia', 'Calidad', 'Colaboración', 'Innovación'],
            datasets: [{
                label: 'Puntaje (%)',
                data: [85, 90, 88, 82, 87],
                backgroundColor: '#ff6384',
                borderRadius: 6
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, max: 100 } }
        }
    });
</script>
<script src="{{ asset('js/dashboard.js') }}"></script>
@endsection

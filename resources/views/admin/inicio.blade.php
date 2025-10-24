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
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 p-3">
                <h6 class="fw-bold text-center mb-3">Usuarios Registrados</h6>
                <canvas id="usuariosChart" height="180" width="348"></canvas>
            </div>
        </div>

        <div class="col-lg-4">
    <div class="card shadow-sm border-0 rounded-4 p-3">
        <h6 class="fw-bold text-center mb-3">Proyectos Activos vs Terminados</h6>
        <canvas id="proyectosChart" height="180"></canvas>
        <div class="text-center mt-3">
            <small class="text-muted">
                <i class="bi bi-circle-fill text-info"></i> Activos &nbsp;
                <i class="bi bi-circle-fill text-success"></i> Terminados &nbsp;
                <i class="bi bi-circle-fill text-warning"></i> En pausa
            </small>
        </div>
    </div>
</div>
<div class="text-center mb-5">
    <h2 class="fw-bold">Accesos rápidos</h2>
</div>

<div class="resumen-cajas d-flex justify-content-center flex-wrap gap-4">
    <div class="card-resumen text-center shadow-sm border-0 rounded-4 p-4">
        <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#modalAddColab">
            <i class="bi bi-person-plus me-2"></i>Añadir colaboradores
        </button>
    </div>

    <div class="card-resumen text-center shadow-sm border-0 rounded-4 p-4">
        <button id="boton" class="btn btn-outline-success w-100" data-bs-toggle="modal" data-bs-target="#modalProyecto">
            <i class="bi bi-plus-circle me-2"></i>Nuevo proyecto
        </button>
    </div>

    <div class="card-resumen text-center shadow-sm border-0 rounded-4 p-4">
        <button class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#modalMensaje">
            <i class="bi bi-envelope-plus me-2"></i>Nuevo mensaje
        </button>
    </div>
</div>

<style>
.resumen-cajas {
    margin-top: 20px;
}

.card-resumen {
    width: 240px;
    transition: all 0.3s ease;
}

.card-resumen:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.card-resumen button {
    border-radius: 12px;
    font-weight: 600;
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.card-resumen button:hover {
    transform: scale(1.05);
}
</style>


{{-- ==== LIBRERÍAS ==== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

{{-- ==== GRÁFICOS ==== --}}
<script>
    // Usuarios por mes
    async function cargarChartUsuarios() {
        try {
            const res = await fetch('http://127.0.0.1:8000/api/usuarios/por/mes');
            const json = await res.json();

            if (json.status === 'success') {
                const ctx = document.getElementById('usuariosChart').getContext('2d');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: json.labels,
                        datasets: [{
                            label: 'Usuarios',
                            data: json.data,
                            borderColor: '#4e73df',
                            backgroundColor: 'rgba(78, 115, 223, 0.2)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }
        } catch (error) {
            console.error('Error cargando chart:', error);
        }
    }

    document.addEventListener('DOMContentLoaded', cargarChartUsuarios);

    // Proyectos activos vs terminados
    async function cargarChartProyectos() {
    try {
        const res = await fetch('http://127.0.0.1:8000/api/dashboard/proyectos');
        const json = await res.json();

        if (json.status === 'success') {
            const ctx = document.getElementById('proyectosChart').getContext('2d');

            // Crear gradientes para los segmentos
            const gradActivos = ctx.createLinearGradient(0, 0, 0, 200);
            gradActivos.addColorStop(0, '#36b9cc');
            gradActivos.addColorStop(1, '#4fd1c5');

            const gradCompletados = ctx.createLinearGradient(0, 0, 0, 200);
            gradCompletados.addColorStop(0, '#1cc88a');
            gradCompletados.addColorStop(1, '#2ecc71');

            const gradPausa = ctx.createLinearGradient(0, 0, 0, 200);
            gradPausa.addColorStop(0, '#f6c23e');
            gradPausa.addColorStop(1, '#feca57');

            // Agregamos sombra al gráfico (efecto más visual)
            const originalDraw = Chart.controllers.doughnut.prototype.draw;
            Chart.controllers.doughnut.prototype.draw = function() {
                originalDraw.apply(this, arguments);
                const ctx = this.chart.ctx;
                ctx.save();
                ctx.shadowColor = 'rgba(0, 0, 0, 0.15)';
                ctx.shadowBlur = 10;
                ctx.shadowOffsetX = 3;
                ctx.shadowOffsetY = 3;
                ctx.restore();
            };

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
                        backgroundColor: [gradActivos, gradCompletados, gradPausa],
                        borderWidth: 2,
                        borderColor: '#fff',
                        hoverOffset: 15
                    }]
                },
                options: {
                    cutout: '70%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.formattedValue || '';
                                    return `${label}: ${value} proyectos`;
                                }
                            },
                            backgroundColor: 'rgba(0,0,0,0.7)',
                            padding: 10,
                            titleFont: { size: 13 },
                            bodyFont: { size: 12 }
                        }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true
                    }
                }
            });
        }
    } catch (error) {
        console.error('Error cargando chart:', error);
    }
}

document.addEventListener('DOMContentLoaded', cargarChartProyectos);




</script>
@include('admin.nuevo-mensaje')

<script src="{{ asset('js/tareas.js') }}"></script>
<script src="{{ asset('js/usuarios.js') }}"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
@include('admin.registrar')
@include('admin.registrar-proyecto')


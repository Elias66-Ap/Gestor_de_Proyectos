@extends('layouts.app')

@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/proyecto.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<main>
    <!-- Tarjetas de resumen -->
    <div class="resumen-cajas">
        <div class="card-resumen">
            <h5>Tareas activas</h5>
            <h3 id="tar_activas">0</h3>
            <p>+15 esta semana</p>
        </div>
        <div class="card-resumen">
            <h5>Tareas completadas</h5>
            <h3 id="tar_completadas">0</h3>
            <p>+6 desde ayer</p>
        </div>
    </div>

    <div class="contenedor">
        <div class="proyecto">
            <div class="proyecto-header">
                <h2>Proyectos</h2>
                <button id="boton" data-bs-toggle="modal" data-bs-target="#modalProyecto">+ Nuevo</button>
                <div class="filtros">
                    <a href="#">Fecha</a>
                    <a href="#">Progreso</a>
                </div>
            </div>

            @foreach ($proyectos as $pro)
            <div class="card-proyecto">
                <div class="info-proyecto">
                    <span class="nombre-proyecto">{{ $pro['nombre'] }}</span>
                    <span class="estado en-progreso">En progreso</span>
                </div>
                <progress min="0" max="100" value="{{ $pro['progreso'] }}">En progreso</progress>
                <div class="estadisticas">
                    <p>{{ $pro['progreso'] }} % completado</p>
                    <p>5 miembros | {{ $pro['fecha_entrega'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="tareas-vencidas">
            <h3>Tareas próximas a vencer</h3>
            @for ($i = 0; $i < 5; $i++)
            <div class="card-tarea">
                <div class="info-tarea">
                    <span class="nombre-tarea">App móvil E-commerce</span>
                    <span class="estado en-progreso">En progreso</span>
                </div>
                <div class="estadisticas-2">
                    <p>75% completado</p>
                    <p>25/11/25</p>
                </div>
            </div>
            @endfor
        </div>
    </div>

    <!-- DASHBOARD DE GRÁFICOS -->
    <section class="dashboard-graficos mt-5">
        <h2 class="text-center mb-4">📊 Dashboard de Actividad</h2>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <canvas id="grafico1"></canvas>
            </div>
            <div class="col-md-4">
                <canvas id="grafico2"></canvas>
            </div>
            <div class="col-md-4">
                <canvas id="grafico3"></canvas>
            </div>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/tareas.js') }}"></script>

<script>
    // === GRÁFICO 1: BARRAS ===
    new Chart(document.getElementById('grafico1'), {
        type: 'bar',
        data: {
            labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie'],
            datasets: [{
                label: 'Tareas completadas',
                data: [5, 8, 6, 9, 12],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            aspectRatio: 1,
            scales: { y: { beginAtZero: true } }
        }
    });

    // === GRÁFICO 2: LÍNEAS ===
    new Chart(document.getElementById('grafico2'), {
        type: 'line',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
            datasets: [{
                label: 'Progreso general (%)',
                data: [20, 35, 40, 60, 75, 90],
                fill: true,
                tension: 0.3,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            aspectRatio: 1
        }
    });

    // === GRÁFICO 3: DONUT ===
    new Chart(document.getElementById('grafico3'), {
        type: 'doughnut',
        data: {
            labels: ['En progreso', 'Completadas', 'Pendientes'],
            datasets: [{
                data: [45, 35, 20],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            aspectRatio: 1
        }
    });
</script>

@include('admin.registrar-proyecto')
@endsection

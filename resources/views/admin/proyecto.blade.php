@extends('layouts.app')

@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/proyecto.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card-proyecto-link {
            display: block;
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>

<main>
    <!-- Tarjetas de resumen -->
    <div class="resumen-cajas">
        <div class="card-resumen">
            <h5>Proyectos Activos</h5>
            <h3 id="tar_activas">10</h3>
            <p>+1 esta semana</p>
        </div>
        <div class="card-resumen">
            <h5>Proyectos completados</h5>
            <h3 id="tar_completadas">2</h3>
            <p>1 desde ayer</p>
        </div>
        <div class="card-resumen">
            <h5>Proyectos Pendientes</h5>
            <h3 id="tar_completadas">2</h3>
            <p>1 desde ayer</p>
        </div>
    </div>

    <div class="contenedor">

    {{-- ======= SECCIÓN DE PROYECTOS ======= --}}
    <div class="proyecto bg-white p-4 rounded-4 shadow-sm">
        <div class="proyecto-header d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Proyectos</h2>

            <div class="d-flex align-items-center gap-3">
                <div class="filtros d-flex gap-2">
                    <a href="#" class="filtro active" data-filtro="fecha">Fecha</a>
                    <a href="#" class="filtro" data-filtro="progreso">Progreso</a>
                </div>

                <button id="boton" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalProyecto">
                    <i class="bi bi-plus-circle me-1"></i> Nuevo
                </button>
            </div>
        </div>

        {{-- LISTADO DE PROYECTOS --}}
        <div id="lista-proyectos">
            @foreach ($proyectos as $pro)
                <a href="{{ route('tablero.proyecto', $pro['id']) }}" class="card-proyecto-link text-decoration-none">
                    <div class="card-proyecto border rounded-3 p-3 mb-3 shadow-sm">
                        <div class="info-proyecto d-flex justify-content-between align-items-center mb-2">
                            <span class="nombre-proyecto fw-semibold">{{ $pro['nombre'] }}</span>
                            <span id="pro" class="estado en-progreso text-primary fw-medium">En progreso</span>
                        </div>

                        <progress min="0" max="100" value="{{ $pro['progreso'] }}" class="w-100 mb-2"></progress>

                        <div class="estadisticas d-flex justify-content-between small text-muted">
                            <p class="mb-0">{{ $pro['progreso'] }}% completado</p>
                            <p class="mb-0">{{ $pro['fecha_entrega'] }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    {{-- ======= SECCIÓN DE TAREAS ======= --}}
    <div class="tareas-vencidas bg-white p-4 rounded-4 shadow-sm mt-4">
        <h3 class="fw-bold mb-3">Tareas próximas a vencer</h3>
        @for ($i = 0; $i < 5; $i++)
            <div class="card-tarea border rounded-3 p-3 mb-2 shadow-sm">
                <div class="info-tarea d-flex justify-content-between align-items-center mb-1">
                    <span class="nombre-tarea fw-semibold">App móvil E-commerce</span>
                    <span class="estado en-progreso text-primary fw-medium">En progreso</span>
                </div>
                <div class="estadisticas-2 d-flex justify-content-between small text-muted">
                    <p class="mb-0">75% completado</p>
                    <p class="mb-0">25/11/25</p>
                </div>
            </div>
        @endfor
    </div>
</div>

{{-- ======= SCRIPT PARA FILTRAR ======= --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filtros = document.querySelectorAll('.filtro');
        const contenedor = document.querySelector('#lista-proyectos');
        const proyectos = Array.from(contenedor.children);

        filtros.forEach(f => {
            f.addEventListener('click', e => {
                e.preventDefault();
                filtros.forEach(x => x.classList.remove('active'));
                f.classList.add('active');

                const tipo = f.dataset.filtro;
                const ordenados = [...proyectos].sort((a, b) => {
                    const progA = parseInt(a.querySelector('progress').value);
                    const progB = parseInt(b.querySelector('progress').value);
                    const fechaA = a.querySelector('.estadisticas p:last-child').textContent.trim();
                    const fechaB = b.querySelector('.estadisticas p:last-child').textContent.trim();

                    if (tipo === 'progreso') return progB - progA; // Descendente
                    if (tipo === 'fecha') return new Date(fechaA) - new Date(fechaB); // Ascendente
                });

                contenedor.innerHTML = '';
                ordenados.forEach(p => contenedor.appendChild(p));
            });
        });
    });
</script>

{{-- ======= ESTILOS OPCIONALES ======= --}}
<style>
    .filtros a {
        color: #555;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
        padding: 4px 10px;
        border-radius: 6px;
    }
    .filtros a:hover {
        background-color: #f1f1f1;
    }
    .filtros a.active {
        background-color: #0d6efd;
        color: #fff;
    }

</style>

    <!-- DASHBOARD DE GRÁFICOS -->

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



@include('admin.registrar-proyecto')
@endsection

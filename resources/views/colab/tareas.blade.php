@extends('layouts.app_colab')
@section('styles')
    <style>
        .task-card {
            transition: all 0.25s ease-in-out;
            border: 1px solid #e7e8ec;
        }

        .task-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
            border-color: #d3d6df;
        }

        .filtro-corporativo {
            border: 1px solid #d1d5db;
            padding: 0.55rem 0.75rem;
            border-radius: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .filtro-corporativo:focus {
            border-color: #0d6efd;
            /* azul corporativo */
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
            outline: none;
        }

        .filtro-corporativo:hover {
            border-color: #0d6efd;
        }

        .form-label {
            font-size: 0.875rem;
        }

        .card {
            border: none;
            padding: 1.5rem 1.5rem 1.5rem 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .task-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.25s ease-in-out;
            border: 1px solid #e7e8ec;
            min-height: 303px;
            /* altura mínima uniforme */
        }

        .task-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
            border-color: #d3d6df;
        }

        .task-card .card-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }

        .task-card .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .task-card .descripcion {
            flex-grow: 1;
            min-height: 45px;
            /* asegura que todas tengan espacio similar */
            margin-bottom: 1rem;
        }

        .task-card .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-5" style="background-color: #eef1f6;">

        <div class="mb-5">
            <h2 class="fw-bold mb-1">📌 Mis Tareas</h2>
            <p class="text-muted">Visualiza rápidamente el estado y prioridad de tus tareas asignadas.</p>
        </div>

        {{-- FILTROS --}}
        <div class="card shadow-sm border-0 rounded-4 p-4 mb-5" style="background-color: #ffffff;">
            <div class="row g-3 align-items-end">

                {{-- Filtro por estado --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary">Estado</label>
                    <select id="filtroEstado" class="form-select filtro-corporativo">
                        <option value="">Todos</option>
                        <option value="Por hacer">Por hacer</option>
                        <option value="En proceso">En proceso</option>
                        <option value="Revision">Revisión</option>
                        <option value="Hecho">Hecho</option>
                    </select>
                </div>

                {{-- Filtro por prioridad --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary">Prioridad</label>
                    <select id="filtroPrioridad" class="form-select filtro-corporativo">
                        <option value="">Todas</option>
                        <option value="Alta">Alta</option>
                        <option value="Media">Media</option>
                        <option value="Baja">Baja</option>
                    </select>
                </div>

                {{-- Filtro por fecha --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary">Fecha de vencimiento</label>
                    <select id="filtroFecha" class="form-select filtro-corporativo">
                        <option value="">Todo</option>
                        <option value="hoy">Hoy</option>
                        <option value="manana">Mañana</option>
                        <option value="semana">Esta semana</option>
                        <option value="mes">Este mes</option>
                    </select>
                </div>

                {{-- Buscar --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary">Buscar</label>
                    <input id="filtroTexto" type="text" class="form-control filtro-corporativo"
                        placeholder="Buscar tarea...">
                </div>

            </div>
        </div>


        <div class="row g-4">

            @foreach ($tareas as $tar)

                @php
                    $fecha = Carbon\Carbon::parse($tar['fecha_vencimiento'])->translatedFormat('d M Y');

                    // PRIORIDAD
                    $prioridad = match ($tar['prioridad']) {
                        'Alta' => 'danger',
                        'Media' => 'warning text-dark',
                        'Baja' => 'info text-dark',
                        default => 'primary'
                    };

                    // PROGRESO
                    $progreso = match ($tar['estado']) {
                        'Por hacer' => 10,
                        'En proceso' => 50,
                        'Revision' => 75,
                        'Hecho' => 100,
                        default => 0
                    };

                    // COLOR DE ESTADO
                    $estadoColor = match ($tar['estado']) {
                        'Por hacer' => 'danger',
                        'En proceso' => 'warning',
                        'Revision' => 'primary',
                        'Hecho' => 'success',
                        default => 'secondary'
                    };
                @endphp

                <div class="col-lg-6 col-xl-4">
                    <div class="task-card shadow-sm rounded-4 bg-white p-4" data-estado="{{ $tar['estado'] }}"
                        data-prioridad="{{ $tar['prioridad'] }}" data-titulo="{{ strtolower($tar['titulo']) }}"
                        data-fecha="{{ $tar['fecha_vencimiento'] }}">

                        {{-- Header: Título + Prioridad + Botón --}}
                        <div class="card-header">
                            <h5 class="fw-semibold mb-0 text-dark">
                                <i class="bi bi-check2-square text-{{ $estadoColor }} me-2"></i>
                                {{ $tar['titulo'] }}
                            </h5>

                            <div class="d-flex align-items-center">
                                <span class="badge bg-{{ $prioridad }} px-3 py-2 rounded-pill me-2">
                                    {{ $tar['prioridad'] }}
                                </span>

                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary rounded-circle" type="button"
                                        id="dropdownMenuButton{{ $tar['id'] }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="dropdownMenuButton{{ $tar['id'] }}">
                                        <li><a class="dropdown-item" href="#">Mini Tablero</a></li>
                                        <li><a class="dropdown-item" href="#">Ver tarea</a></li>
                                        <li><a class="dropdown-item" href="#">Ir al tablero</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Body: Descripción + Progreso --}}
                        <div class="card-body">
                            @if (!empty($tar['descripcion']))
                                <p class="descripcion text-muted small">
                                    {{ $tar['descripcion'] }}
                                </p>
                            @endif

                            {{-- Progreso --}}
                            <div class="mb-2">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted">Progreso</span>
                                    <span class="fw-bold text-dark">{{ $progreso }}%</span>
                                </div>
                                <div class="progress rounded-pill" style="height: 8px;">
                                    <div class="progress-bar bg-{{ $estadoColor }}" style="width: {{ $progreso }}%;"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Footer: Estado + Fecha --}}
                        <div class="card-footer">
                            <span class="badge border border-{{ $estadoColor }} text-{{ $estadoColor }} px-3 py-1 rounded-pill">
                                {{ $tar['estado'] }}
                            </span>

                            <span class="text-muted small">
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ $fecha }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    {{-- Estilos Modernos --}}

@endsection
@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const filtroEstado = document.getElementById("filtroEstado");
            const filtroPrioridad = document.getElementById("filtroPrioridad");
            const filtroTexto = document.getElementById("filtroTexto");
            const filtroFecha = document.getElementById("filtroFecha");
            const contenedor = document.querySelector(".row.g-4");

            function aplicarFiltros() {
                const estado = filtroEstado.value;
                const prioridad = filtroPrioridad.value;
                const texto = filtroTexto.value.toLowerCase();
                const fechaFiltro = filtroFecha.value;

                const hoy = new Date();
                const manana = new Date();
                manana.setDate(hoy.getDate() + 1);

                const primerDiaSemana = new Date(hoy);
                primerDiaSemana.setDate(hoy.getDate() - hoy.getDay() + 1); // lunes
                const ultimoDiaSemana = new Date(primerDiaSemana);
                ultimoDiaSemana.setDate(primerDiaSemana.getDate() + 6); // domingo

                const primerDiaMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
                const ultimoDiaMes = new Date(hoy.getFullYear(), hoy.getMonth() + 1, 0);

                const sieteDias = new Date();
                sieteDias.setDate(hoy.getDate() + 7);

                const tarjetas = Array.from(contenedor.querySelectorAll(".task-card"));

                tarjetas.forEach(card => {
                    const cardEstado = card.getAttribute("data-estado");
                    const cardPrioridad = card.getAttribute("data-prioridad");
                    const cardTitulo = card.getAttribute("data-titulo");
                    const cardFechaStr = card.getAttribute("data-fecha");
                    const cardFecha = new Date(cardFechaStr);

                    const coincideEstado = estado === "" || cardEstado === estado;
                    const coincidePrioridad = prioridad === "" || cardPrioridad === prioridad;
                    const coincideTexto = cardTitulo.includes(texto);

                    // Filtro de fecha relativo
                    let coincideFecha = true;
                    switch (fechaFiltro) {
                        case "hoy":
                            coincideFecha = cardFecha.toDateString() === hoy.toDateString();
                            break;
                        case "manana":
                            coincideFecha = cardFecha.toDateString() === manana.toDateString();
                            break;
                        case "semana":
                            coincideFecha = cardFecha >= primerDiaSemana && cardFecha <= ultimoDiaSemana;
                            break;
                        case "mes":
                            coincideFecha = cardFecha >= primerDiaMes && cardFecha <= ultimoDiaMes;
                            break;
                        default:
                            coincideFecha = true;
                    }

                    if (coincideEstado && coincidePrioridad && coincideTexto && coincideFecha) {
                        card.parentElement.style.display = "block";
                    } else {
                        card.parentElement.style.display = "none";
                    }
                });

                // Ordenar visualmente las tarjetas visibles por fecha ascendente
                const tarjetasVisibles = Array.from(contenedor.querySelectorAll(".task-card"))
                    .filter(card => card.parentElement.style.display !== "none")
                    .sort((a, b) => new Date(a.getAttribute("data-fecha")) - new Date(b.getAttribute("data-fecha")));

                tarjetasVisibles.forEach(card => {
                    contenedor.appendChild(card.parentElement); // Reinsertar en orden
                });
            }

            filtroEstado.addEventListener("change", aplicarFiltros);
            filtroPrioridad.addEventListener("change", aplicarFiltros);
            filtroTexto.addEventListener("input", aplicarFiltros);
            filtroFecha.addEventListener("change", aplicarFiltros);

            // Ejecutar al cargar para ordenar inicialmente
            aplicarFiltros();
        });
    </script>


@endsection
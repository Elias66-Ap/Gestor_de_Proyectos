@extends('layouts.app_colab')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/proyecto.css') }}">
<style>
/* Filtros */
.filtro-corporativo {
    border: 1px solid #d1d5db;
    padding: 0.5rem 0.75rem;
    border-radius: 1.5rem;
    transition: all 0.3s ease;
    box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);
}
.filtro-corporativo:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.25);
    outline: none;
}

/* Grid responsivo */
#contenedorProyectos {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

/* Tarjeta */
.project-card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    border-radius: 1rem;
    background: #fff;
    padding: 1.5rem;
    min-height: 220px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 25px rgba(0,0,0,0.1);
}

/* Header de tarjeta */
.project-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}
.project-card-header h5 {
    font-size: 1.1rem;
}
.project-card-header button {
    border: none;
    background: transparent;
    color: #6c757d;
    cursor: pointer;
}

/* Descripción */
.project-card p {
    font-size: 0.9rem;
    color: #6c757d;
    flex-grow: 1;
    margin-bottom: 1rem;
}

/* Estado */
.project-badge {
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.35rem 0.75rem;
    border-radius: 50px;
    color: #fff;
    display: inline-block;
}
.project-badge.activo { background-color: #0d6efd; }
.project-badge.completado { background-color: #198754; }
.project-badge.pausado { background-color: #ffc107; color: #212529; }

/* Progress bar */
.project-progress {
    height: 8px;
    border-radius: 50px;
    overflow: hidden;
    background: #e9ecef;
}
.project-progress-bar {
    height: 100%;
    border-radius: 50px;
    transition: width 0.3s ease;
}
</style>
@endsection

@section('content')
<main class="container py-5" style="background-color: #eef1f6;">

    <div class="mb-4">
        <h2 class="fw-bold mb-1">📌 Mis Proyectos</h2>
        <p class="text-muted">Filtra y accede rápidamente a los proyectos que te competen.</p>
    </div>

    {{-- FILTROS --}}
    <div class="card shadow-sm border-0 rounded-4 p-4 mb-5 bg-white">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold text-secondary">Estado</label>
                <select id="filtroEstado" class="form-select filtro-corporativo">
                    <option value="0" selected>Activo</option>
                    <option value="1">Completado</option>
                    <option value="3">Pausado</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-secondary">Progreso</label>
                <select id="filtroProgreso" class="form-select filtro-corporativo">
                    <option value="">Todos</option>
                    <option value="0-25">0-25%</option>
                    <option value="26-50">26-50%</option>
                    <option value="51-75">51-75%</option>
                    <option value="76-100">76-100%</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-secondary">Fecha entrega</label>
                <select id="filtroFecha" class="form-select filtro-corporativo">
                    <option value="">Todo</option>
                    <option value="hoy">Hoy</option>
                    <option value="manana">Mañana</option>
                    <option value="semana">Esta semana</option>
                    <option value="mes">Este mes</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-secondary">Buscar</label>
                <input type="text" id="filtroTexto" class="form-control filtro-corporativo" placeholder="Buscar proyecto...">
            </div>
        </div>
    </div>

    {{-- TARJETAS --}}
    <div id="contenedorProyectos">
        @foreach($proyectos as $proyecto)
        @php
            $progreso = $proyecto['progreso'] ?? 0;
            $estadoText = match($proyecto['completado']){
                0 => 'Activo',
                1 => 'Completado',
                3 => 'Pausado',
                default => 'Desconocido'
            };
            $estadoClass = match($proyecto['completado']){
                0 => 'activo',
                1 => 'completado',
                3 => 'pausado',
                default => 'secondary'
            };
        @endphp
        <a href="{{ route('tablero.proyecto', $proyecto['id']) }}" class="text-decoration-none text-dark">
            <div class="project-card" 
                 data-estado="{{ $proyecto['completado'] }}"
                 data-progreso="{{ $progreso }}"
                 data-titulo="{{ strtolower($proyecto['nombre']) }}"
                 data-fecha="{{ $proyecto['fecha_entrega'] }}">
                 
                <div class="project-card-header">
                    <h5>{{ $proyecto['nombre'] }}</h5>
                    <button><i class="bi bi-three-dots"></i></button>
                </div>

                <p>{{ \Illuminate\Support\Str::limit($proyecto['descripcion_breve'] ?? 'Sin descripción', 120) }}</p>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="project-badge {{ $estadoClass }}">{{ $estadoText }}</span>
                    <small class="text-muted">{{ $progreso }}%</small>
                </div>

                <div class="project-progress">
                    <div class="project-progress-bar bg-{{ $estadoClass }}" style="width: {{ $progreso }}%;"></div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const filtroEstado = document.getElementById("filtroEstado");
    const filtroProgreso = document.getElementById("filtroProgreso");
    const filtroTexto = document.getElementById("filtroTexto");
    const filtroFecha = document.getElementById("filtroFecha");
    const contenedor = document.getElementById("contenedorProyectos");

    function aplicarFiltros() {
        const estado = filtroEstado.value;
        const progresoFiltro = filtroProgreso.value;
        const texto = filtroTexto.value.toLowerCase();
        const fechaFiltro = filtroFecha.value;

        const hoy = new Date();
        const manana = new Date(); manana.setDate(hoy.getDate() + 1);
        const primerDiaSemana = new Date(hoy); primerDiaSemana.setDate(hoy.getDate() - hoy.getDay() + 1);
        const ultimoDiaSemana = new Date(primerDiaSemana); ultimoDiaSemana.setDate(primerDiaSemana.getDate() + 6);
        const primerDiaMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
        const ultimoDiaMes = new Date(hoy.getFullYear(), hoy.getMonth()+1, 0);

        Array.from(contenedor.querySelectorAll(".project-card")).forEach(card => {
            const cardEstado = card.dataset.estado;
            const cardTitulo = card.dataset.titulo;
            const cardFecha = new Date(card.dataset.fecha);
            const cardProgreso = parseInt(card.dataset.progreso,10);

            let coincideEstado = estado === "" || cardEstado === estado;
            let coincideTexto = cardTitulo.includes(texto);

            let coincideProgreso = true;
            if(progresoFiltro){
                const [min,max] = progresoFiltro.split('-').map(Number);
                coincideProgreso = cardProgreso >= min && cardProgreso <= max;
            }

            let coincideFecha = true;
            switch(fechaFiltro){
                case "hoy": coincideFecha = cardFecha.toDateString() === hoy.toDateString(); break;
                case "manana": coincideFecha = cardFecha.toDateString() === manana.toDateString(); break;
                case "semana": coincideFecha = cardFecha >= primerDiaSemana && cardFecha <= ultimoDiaSemana; break;
                case "mes": coincideFecha = cardFecha >= primerDiaMes && cardFecha <= ultimoDiaMes; break;
            }

            card.parentElement.style.display = (coincideEstado && coincideProgreso && coincideTexto && coincideFecha) ? "block" : "none";
        });
    }

    filtroEstado.addEventListener("change", aplicarFiltros);
    filtroProgreso.addEventListener("change", aplicarFiltros);
    filtroTexto.addEventListener("input", aplicarFiltros);
    filtroFecha.addEventListener("change", aplicarFiltros);

    aplicarFiltros();
});
</script>
@endsection

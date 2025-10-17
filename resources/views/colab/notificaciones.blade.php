@extends('layouts.app_colab')

@section('content')
<div class="container-fluid py-5" style="background-color: #f4f6fa;">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-1">🔔 Notificaciones</h2>
            <p class="text-muted mb-0">Mantente al día con las nuevas tareas asignadas y actualizaciones de tu equipo.</p>
        </div>
        <button class="btn btn-outline-primary rounded-pill px-4 shadow-sm">
            <i class="bi bi-check2-all me-2"></i> Marcar todas como leídas
        </button>
    </div>

    {{-- Lista de notificaciones --}}
    <div class="list-group">
        @foreach([
            ['mensaje'=>'Se te ha asignado la tarea "Diseñar login responsive".','fecha'=>'16/10/2025','tipo'=>'tarea','leida'=>false],
            ['mensaje'=>'Se te ha asignado la tarea "Actualizar documentación técnica".','fecha'=>'15/10/2025','tipo'=>'tarea','leida'=>true],
            ['mensaje'=>'Se te ha asignado la tarea "Corregir bug en módulo de reportes".','fecha'=>'14/10/2025','tipo'=>'tarea','leida'=>false],
            ['mensaje'=>'Tarea "Revisar API microservicios" marcada como completada.','fecha'=>'12/10/2025','tipo'=>'info','leida'=>true],
        ] as $notif)
        <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center shadow-sm mb-3 rounded-4 notification-card"
             style="background-color: {{ $notif['leida'] ? '#ffffff' : '#e3f2fd' }}; transition: transform 0.3s, box-shadow 0.3s;">
            <div class="d-flex align-items-center">
                <i class="bi {{ $notif['tipo']=='tarea' ? 'bi-list-check' : 'bi-info-circle' }} me-3 fs-4 text-{{ $notif['leida'] ? 'secondary' : 'primary' }}"></i>
                <div>
                    <p class="mb-1">{{ $notif['mensaje'] }}</p>
                    <small class="text-muted"><i class="bi bi-calendar3 me-1"></i>{{ $notif['fecha'] }}</small>
                </div>
            </div>
            @if(!$notif['leida'])
            <span class="badge bg-primary rounded-pill animate-pulse">Nuevo</span>
            @endif
        </div>
        @endforeach
    </div>

</div>

{{-- Hover y animación pulse --}}
<style>
.notification-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.12);
}

@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.8; }
    100% { transform: scale(1); opacity: 1; }
}

.animate-pulse {
    animation: pulse 1.5s infinite;
}
</style>
@endsection

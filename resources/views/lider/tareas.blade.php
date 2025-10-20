@extends('layouts.app_lider')

@section('content1')
<div class="container-fluid py-5">

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-1">Mis Tareas</h2>
            <p class="text-muted mb-0">Aquí puedes ver todas tus tareas asignadas y su progreso.</p>
        </div>

    </div>
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center py-4">
                <h6 class="text-muted mb-1">Tareas totales</h6>
                <h3 class="fw-bold text-primary">12</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center py-4">
                <h6 class="text-muted mb-1">Pendientes</h6>
                <h3 class="fw-bold text-warning">4</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center py-4">
                <h6 class="text-muted mb-1">Completadas</h6>
                <h3 class="fw-bold text-success">7</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center py-4">
                <h6 class="text-muted mb-1">Próximas entregas</h6>
                <h3 class="fw-bold text-danger">1</h3>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 tarea-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-semibold">Diseñar landing page</span>
                    <span class="badge bg-danger">Alta</span>
                </div>
                <div class="progress mb-2" style="height: 6px;">
                    <div class="progress-bar bg-dark" style="width: 45%;"></div>
                </div>
                <div class="d-flex justify-content-between small text-muted">
                    <span>45% completado</span>
                    <span><i class="bi bi-calendar3 me-1"></i> 20/10/2025</span>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 tarea-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-semibold">Revisión de código backend</span>
                    <span class="badge bg-warning text-dark">Media</span>
                </div>
                <div class="progress mb-2" style="height: 6px;">
                    <div class="progress-bar bg-dark" style="width: 70%;"></div>
                </div>
                <div class="d-flex justify-content-between small text-muted">
                    <span>70% completado</span>
                    <span><i class="bi bi-calendar3 me-1"></i> 22/10/2025</span>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 tarea-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-semibold">Documentación del proyecto</span>
                    <span class="badge bg-info text-dark">Baja</span>
                </div>
                <div class="progress mb-2" style="height: 6px;">
                    <div class="progress-bar bg-dark" style="width: 90%;"></div>
                </div>
                <div class="d-flex justify-content-between small text-muted">
                    <span>90% completado</span>
                    <span><i class="bi bi-calendar3 me-1"></i> 18/10/2025</span>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 tarea-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-semibold">Pruebas funcionales</span>
                    <span class="badge bg-success">Completada</span>
                </div>
                <div class="progress mb-2" style="height: 6px;">
                    <div class="progress-bar bg-dark" style="width: 100%;"></div>
                </div>
                <div class="d-flex justify-content-between small text-muted">
                    <span>100% completado</span>
                    <span><i class="bi bi-calendar3 me-1"></i> 10/10/2025</span>
                </div>
            </div>
        </div>
    </div>

</div>
<style>
.tarea-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.12);
    transition: transform 0.3s, box-shadow 0.3s;
}
</style>
@endsection

@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background-color: #f4f6fa;">

    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="fw-bold mb-0">👤 Mi Perfil</h2>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="bi bi-pencil-square me-2"></i> Editar Perfil
        </button>
    </div>

    {{-- Sección de perfil centrada --}}
    <div class="row justify-content-center mb-5">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                <div class=text-center>
                </div>

            </div>
        </div>
    </div>

    {{-- Detalles personales --}}
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4">Detalles Personales</h5>
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Nombre</label>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Apellido</label>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Apodo</label>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Correo</label>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Teléfono</label>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Fecha de Nacimiento</label>
\                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Hobby</label>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Habilidades</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Hover effect opcional --}}
<style>
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.12);
    transition: transform 0.3s, box-shadow 0.3s;
}
</style>
@endsection

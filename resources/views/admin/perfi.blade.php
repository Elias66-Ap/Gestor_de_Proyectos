@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background-color: #f4f6fa;">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="fw-bold mb-0">👤 Mi Perfil</h2>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalEditarPerfil">
            <i class="bi bi-pencil-square me-2"></i> Editar Perfil
        </button>
    </div>

    {{-- Sección de perfil centrada --}}
    <div class="row justify-content-center mb-5">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                <img src="https://i.pravatar.cc/150?img=15" class="rounded-circle mb-3" width="120" height="120" alt="avatar">
                <h5 class="fw-bold mb-1">Juan Pérez</h5>
                <p class="text-muted mb-0">Colaborador</p>
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
                        <p class="fw-semibold">Juan</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Apellido</label>
                        <p class="fw-semibold">Pérez</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Apodo</label>
                        <p class="fw-semibold">Juampi</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Correo</label>
                        <p class="fw-semibold">juan.perez@example.com</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Teléfono</label>
                        <p class="fw-semibold">+51 999 888 777</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Fecha de Nacimiento</label>
                        <p class="fw-semibold">15/05/1998</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Hobby</label>
                        <p class="fw-semibold">Fútbol</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Habilidades</label>
                        <p class="fw-semibold">Programación, Liderazgo</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Modal Editar Perfil --}}
<div class="modal fade" id="modalEditarPerfil" tabindex="-1" aria-labelledby="modalEditarPerfilLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header bg-primary text-white rounded-top-4">
        <h5 class="modal-title fw-semibold" id="modalEditarPerfilLabel">
          <i class="bi bi-pencil-square me-2"></i> Editar Perfil
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="nombre" class="form-label fw-semibold">Nombre</label>
              <input type="text" class="form-control rounded-pill" id="nombre" value="Juan">
            </div>
            <div class="col-md-6">
              <label for="apellido" class="form-label fw-semibold">Apellido</label>
              <input type="text" class="form-control rounded-pill" id="apellido" value="Pérez">
            </div>
            <div class="col-md-6">
              <label for="apodo" class="form-label fw-semibold">Apodo</label>
              <input type="text" class="form-control rounded-pill" id="apodo" value="Juampi">
            </div>
            <div class="col-md-6">
              <label for="correo" class="form-label fw-semibold">Correo</label>
              <input type="email" class="form-control rounded-pill" id="correo" value="juan.perez@example.com">
            </div>
            <div class="col-md-6">
              <label for="telefono" class="form-label fw-semibold">Teléfono</label>
              <input type="text" class="form-control rounded-pill" id="telefono" value="+51 999 888 777">
            </div>
            <div class="col-md-6">
              <label for="nacimiento" class="form-label fw-semibold">Fecha de Nacimiento</label>
              <input type="date" class="form-control rounded-pill" id="nacimiento" value="1998-05-15">
            </div>
            <div class="col-md-6">
              <label for="hobby" class="form-label fw-semibold">Hobby</label>
              <input type="text" class="form-control rounded-pill" id="hobby" value="Fútbol">
            </div>
            <div class="col-md-6">
              <label for="habilidades" class="form-label fw-semibold">Habilidades</label>
              <input type="text" class="form-control rounded-pill" id="habilidades" value="Programación, Liderazgo">
            </div>
          </div>
        </div>

        <div class="modal-footer border-0">
          <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
            Cancelar
          </button>
          <button type="submit" class="btn btn-primary rounded-pill px-4">
            Guardar Cambios
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Hover effect --}}
<style>
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.12);
    transition: transform 0.3s, box-shadow 0.3s;
}
</style>
@endsection

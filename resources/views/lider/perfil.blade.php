@extends('layouts.app_lider')

@section('content1')
<div class="container-fluid py-5">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="fw-bold mb-0">Mi Perfil</h2>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm"
                data-bs-toggle="modal"
                data-bs-target="#modalEditarPerfil">
            <i class="bi bi-pencil-square me-2"></i> Editar Perfil
        </button>
    </div>

    {{-- Sección de perfil centrada --}}
    <div class="row justify-content-center mb-5">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                <div class="text-center">
                    <img src="{{ optional(auth()->guard('usuario')->user()->perfil)->imagen_url ?? asset('images/default.jpeg') }}"
                         alt="Perfil" class="rounded-circle mb-3" style="width:120px; height:120px; object-fit:cover;">
                </div>
                <h5 class="fw-bold mb-1">
                    {{ optional(auth()->guard('usuario')->user()->perfil)->nombre ?? auth()->guard('usuario')->user()->name ?? '-' }}
                    {{ optional(auth()->guard('usuario')->user()->perfil)->apellido ?? '-' }}
                </h5>
                <p class="text-muted mb-0">{{ auth()->guard('usuario')->user()->rol ?? '-' }}</p>
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
                        <div class="fw-semibold">{{ optional(auth()->guard('usuario')->user()->perfil)->nombre ?? auth()->guard('usuario')->user()->name ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Apellido</label>
                        <div class="fw-semibold">{{ optional(auth()->guard('usuario')->user()->perfil)->apellido ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Apodo</label>
                        <div class="fw-semibold">{{ optional(auth()->guard('usuario')->user()->perfil)->apodo ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Correo</label>
                        <div class="fw-semibold">{{ auth()->guard('usuario')->user()->correo ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Teléfono</label>
                        <div class="fw-semibold">{{ optional(auth()->guard('usuario')->user()->perfil)->telefono ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Fecha de Nacimiento</label>
                        <div class="fw-semibold">{{ optional(auth()->guard('usuario')->user()->perfil)->fecha_nacimiento ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Hobby</label>
                        <div class="fw-semibold">{{ optional(auth()->guard('usuario')->user()->perfil)->hobby ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Habilidades</label>
                        <div class="fw-semibold">{{ optional(auth()->guard('usuario')->user()->perfil)->habilidades ?? '-' }}</div>
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
              <input type="text" class="form-control rounded-pill" id="nombre" value="{{ optional(auth()->guard('usuario')->user()->perfil)->nombre ?? auth()->guard('usuario')->user()->name ?? '' }}">
            </div>
            <div class="col-md-6">
              <label for="apellido" class="form-label fw-semibold">Apellido</label>
              <input type="text" class="form-control rounded-pill" id="apellido" value="{{ optional(auth()->guard('usuario')->user()->perfil)->apellido ?? auth()->guard('usuario')->user()->name ?? '' }}">
            </div>
            <div class="col-md-6">
              <label for="apodo" class="form-label fw-semibold">Apodo</label>
              <input type="text" class="form-control rounded-pill" id="apodo" value="{{ optional(auth()->guard('usuario')->user()->perfil)->apodo ?? auth()->guard('usuario')->user()->name ?? '' }}">
            </div>
            <div class="col-md-6">
              <label for="correo" class="form-label fw-semibold">Correo</label>
              <input type="email" class="form-control rounded-pill" id="correo" value="{{ auth()->guard('usuario')->user()->correo}}">
            </div>
            <div class="col-md-6">
              <label for="telefono" class="form-label fw-semibold">Teléfono</label>
              <input type="text" class="form-control rounded-pill" id="telefono" value="{{ optional(auth()->guard('usuario')->user()->perfil)->telefono ?? auth()->guard('usuario')->user()->name ?? '' }}">
            </div>
            <div class="col-md-6">
              <label for="nacimiento" class="form-label fw-semibold">Fecha de Nacimiento</label>
              <input type="date" class="form-control rounded-pill" id="nacimiento" value="{{ optional(auth()->guard('usuario')->user()->perfil)->fecha_nacimiento ?? auth()->guard('usuario')->user()->name ?? '' }}">
            </div>
            <div class="col-md-6">
              <label for="hobby" class="form-label fw-semibold">Hobby</label>
              <input type="text" class="form-control rounded-pill" id="hobby" value="{{ optional(auth()->guard('usuario')->user()->perfil)->hobby ?? auth()->guard('usuario')->user()->name ?? '' }}">
            </div>
            <div class="col-md-6">
              <label for="habilidades" class="form-label fw-semibold">Habilidades</label>
              <input type="text" class="form-control rounded-pill" id="habilidades" value="{{ optional(auth()->guard('usuario')->user()->perfil)->habilidades ?? auth()->guard('usuario')->user()->name ?? '' }}">
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

{{-- Bootstrap JS (si no está ya en tu layout) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection

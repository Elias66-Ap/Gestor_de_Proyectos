@extends('layouts.app_lider')

@section('content1')
@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
<div class="container-fluid py-5" style="background-color: #f4f6fa;">

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

</div>
  {{-- BOTÓN CAMBIAR CONTRASEÑA --}}
  <div class="text-center mt-5">
    <button class="btn btn-outline-danger rounded-pill px-4 py-2 shadow-sm"
      data-bs-toggle="modal"
      data-bs-target="#modalCambiarContraseña">
      <i class="bi bi-shield-lock me-2"></i> Cambiar Contraseña
    </button>
  </div>


{{-- ==== MODAL CAMBIAR CONTRASEÑA ==== --}}
<div class="modal fade" id="modalCambiarContraseña" tabindex="-1" aria-labelledby="modalCambiarContraseñaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header bg-primary text-white rounded-top-4">
        <h5 class="modal-title fw-semibold" id="modalCambiarContraseñaLabel">
          <i class="bi bi-shield-lock me-2"></i> Cambiar Contraseña
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

        @csrf
        @method('PATCH')
        <div class="modal-body">
  <div class="mb-3">
    <label for="contraseña_actual" class="form-label fw-semibold">Contraseña Actual</label>
    <input type="password" name="contraseña_actual" id="contraseña_actual"
      class="form-control rounded-pill" required>
  </div>

  <div class="mb-3">
    <label for="nueva_contraseña" class="form-label fw-semibold">Nueva Contraseña</label>
    <input type="password" name="nueva_contraseña" id="nueva_contraseña"
      class="form-control rounded-pill"
      required
      pattern="[A-Za-z0-9]{8,}"
      title="Debe tener al menos 8 caracteres (letras o números).">
    <small class="text-muted">Debe tener al menos 8 caracteres (puede incluir letras y números).</small>
  </div>

  <div class="mb-3">
    <label for="confirmar_contraseña" class="form-label fw-semibold">Confirmar Nueva Contraseña</label>
    <input type="password" name="confirmar_contraseña" id="confirmar_contraseña"
      class="form-control rounded-pill" required>
  </div>
</div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary rounded-pill px-4">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Modal Editar Perfil --}}
<div class="modal fade" id="modalEditarPerfil" tabindex="-1" aria-labelledby="modalEditarPerfilLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-4">

      <!-- ==== CABECERA ==== -->
      <div class="modal-header bg-primary text-white rounded-top-4">
        <h5 class="modal-title fw-semibold" id="modalEditarPerfilLabel">
          <i class="bi bi-pencil-square me-2"></i> Editar Perfil
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <!-- ==== FORMULARIO ==== -->
        @csrf
        @method('PATCH')

        <div class="modal-body px-4 pt-4 pb-3">
          <div class="row g-4 align-items-center">

            <!-- ==== FOTO ==== -->
            <div class="col-md-4 text-center">
              <label for="imagen" class="form-label fw-semibold d-block mb-2">Foto de Perfil</label>

              <div class="d-flex flex-column align-items-center">
                <img
                  id="previewImagen"
                  src="{{ isset($user->perfil->imagen) ? asset('storage/' . $user->perfil->imagen) : asset('images/default.jpeg') }}"
                  alt="Foto de perfil actual"
                  class="rounded-circle border border-3 border-primary shadow-sm mb-3"
                  style="width: 180px; height: 180px; object-fit: cover;"
                >

                <input type="file" class="form-control form-control-sm rounded-pill w-75" id="imagen" name="imagen" accept="image/*">
                <small class="text-muted mt-2">Formatos permitidos: JPG, PNG, JPEG</small>
              </div>
            </div>

            <!-- ==== DATOS PERSONALES ==== -->
            <div class="col-md-8">
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="nombre" class="form-label fw-semibold">Nombre</label>
                  <input type="text" class="form-control rounded-pill" id="nombre" name="nombre"
                    value="{{ $user->perfil->nombre ?? '' }}">
                </div>

                <div class="col-md-6">
                  <label for="apellido" class="form-label fw-semibold">Apellido</label>
                  <input type="text" class="form-control rounded-pill" id="apellido" name="apellido"
                    value="{{ $user->perfil->apellido ?? '' }}">
                </div>

                <div class="col-md-6">
                  <label for="apodo" class="form-label fw-semibold">Alias</label>
                  <input type="text" class="form-control rounded-pill" id="apodo" name="apodo"
                    value="{{ $user->perfil->apodo ?? '' }}">
                </div>

                <div class="col-md-6">
                  <label for="telefono" class="form-label fw-semibold">Teléfono</label>
                  <input type="text" class="form-control rounded-pill" id="telefono" name="telefono"
                    value="{{ $user->perfil->telefono ?? '' }}">
                </div>

                <div class="col-md-6">
                  <label for="hobby" class="form-label fw-semibold">Hobby</label>
                  <input type="text" class="form-control rounded-pill" id="hobby" name="hobby"
                    value="{{ $user->perfil->hobby ?? '' }}">
                </div>
              </div>
            </div>
          </div>

          <hr class="my-4">

          <!-- ==== HABILIDADES ==== -->
          <div>
            <label class="form-label fw-semibold">Habilidades Técnicas</label>
            <div class="row">
              <!-- Lenguajes -->
              <div class="col-md-4">
                <p class="fw-semibold mb-2 text-primary">Lenguajes</p>
                @foreach(['JavaScript', 'Python', 'PHP', 'Java', 'C#', 'TypeScript'] as $lenguaje)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="habilidades[]" value="{{ $lenguaje }}"
                      id="{{ strtolower($lenguaje) }}"
                      {{ in_array($lenguaje, old('habilidades', explode(',', $user->perfil->habilidades ?? ''))) ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ strtolower($lenguaje) }}">{{ $lenguaje }}</label>
                  </div>
                @endforeach
              </div>

              <!-- Frameworks -->
              <div class="col-md-4">
                <p class="fw-semibold mb-2 text-primary">Frameworks</p>
                @foreach(['Laravel', 'Angular', 'React', 'Vue.js', 'Spring Boot'] as $fw)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="habilidades[]" value="{{ $fw }}"
                      id="{{ strtolower(str_replace(' ', '', $fw)) }}"
                      {{ in_array($fw, old('habilidades', explode(',', $user->perfil->habilidades ?? ''))) ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ strtolower(str_replace(' ', '', $fw)) }}">{{ $fw }}</label>
                  </div>
                @endforeach
              </div>

              <!-- Herramientas -->
              <div class="col-md-4">
                <p class="fw-semibold mb-2 text-primary">Herramientas</p>
                @foreach(['Git / GitHub', 'Docker', 'MySQL', 'Figma', 'Postman'] as $tool)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="habilidades[]" value="{{ $tool }}"
                      id="{{ strtolower(str_replace([' ', '/'], '', $tool)) }}"
                      {{ in_array($tool, old('habilidades', explode(',', $user->perfil->habilidades ?? ''))) ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ strtolower(str_replace([' ', '/'], '', $tool)) }}">{{ $tool }}</label>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>

        <!-- ==== BOTONES ==== -->
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


<style>
  .card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
    transition: transform 0.3s, box-shadow 0.3s;
  }
</style>
<script>
  document.getElementById('imagen').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('previewImagen');
    if (file) {
      const reader = new FileReader();
      reader.onload = e => preview.src = e.target.result;
      reader.readAsDataURL(file);
    }
  });
</script>

{{-- Bootstrap JS (si no está ya en tu layout) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection

<div class="modal fade" id="modalAddColab" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg rounded-4 border-0">

            <!-- HEADER -->
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #005bea, #00c6fb);">
                <h5 class="modal-title fw-semibold">
                    <i class="bi bi-person-plus-fill me-2"></i> Nuevo Colaborador
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body px-5 py-4">
                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    @if ($errors->any())
                    <div class="alert alert-danger rounded-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="correo" class="form-label fw-semibold">Correo electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-envelope-at"></i></span>
                                <input type="email" class="form-control border-0 shadow-sm" id="correo" name="correo" placeholder="ejemplo@gmail.com" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="rol" class="form-label fw-semibold">Rol</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-people-fill"></i></span>
                                <select class="form-select border-0 shadow-sm" id="rol" name="rol" required>
                                    <option value="" disabled selected>Selecciona un rol</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Lider">Líder</option>
                                    <option value="Colaborador">Colaborador</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="passwordd" class="form-label fw-semibold">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control border-0 shadow-sm" id="passwordd" name="passwordd" placeholder="********" minlength="8" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="passwordd_confirmation" class="form-label fw-semibold">Confirmar Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-shield-lock-fill"></i></span>
                                <input type="password" class="form-control border-0 shadow-sm" id="passwordd_confirmation" name="passwordd_confirmation" placeholder="********" minlength="8" required>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-light px-4 me-2 border rounded-3" data-bs-dismiss="modal">
                            <i class="bi bi-arrow-left me-1"></i> Volver
                        </button>
                        <button type="submit" class="btn text-white px-4 rounded-3" style="background: linear-gradient(135deg, #005bea, #00c6fb);">
                            <i class="bi bi-check2-circle me-1"></i> Agregar
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('modalAddColab'));
        myModal.show();
    });
</script>
@endif

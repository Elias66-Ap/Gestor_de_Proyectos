<div class="modal fade" id="modalAddColab" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title fw-semibold text-dark">
                    <i class="bi bi-person-plus me-2 text-dark"></i>Añadir Colaborador
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" placeholder="example@gmail.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-select" id="rol" name="rol">
                            <option selected>Selecciona un rol</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Lider">Lider</option>
                            <option value="Colaborador">Colaborador</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="passwordd" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="passwordd" name="passwordd" placeholder="" minlength="8" required>
                    </div>
                    <div class="mb-3">
                        <label for="passwordd_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="passwordd_confirmation" name="passwordd_confirmation" placeholder="" minlength="8" required>
                    </div>
                    <div class="mb-3 text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Volver</button>
                        <button type="submit" class="btn btn-primary">Agregar</button>
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

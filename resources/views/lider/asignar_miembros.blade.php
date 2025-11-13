<!-- Modal Asignar Miembros -->
<div class="modal fade" id="modalAsignarMiembros" tabindex="-1" aria-labelledby="modalAsignarMiembrosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 shadow-lg">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalAsignarMiembrosLabel">
          Asignar miembros al proyecto
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="formAsignarMiembros" method="POST" action="{{ route('agregar.miembros') }}">
        @csrf
        <div class="modal-body">
          <input type="hidden" name="proyecto_id" id="modalAsignarProyectoId">

          <!-- Select de colaboradores -->
          <div class="mb-3">
            <label for="selectMiembros" class="form-label fw-bold">Selecciona colaborador</label>
            <select id="selectMiembros" class="form-select">
              <option selected disabled>Seleccione un colaborador</option>
            </select>
          </div>

          <!-- Lista visual de seleccionados -->
          <div class="mb-3">
            <label class="form-label fw-bold">Miembros seleccionados</label>
            <ul id="listaSeleccionados" class="list-group border rounded-3 p-2" style="max-height: 200px; overflow-y: auto;">
              <li class="text-muted text-center">No hay miembros seleccionados</li>
            </ul>
          </div>

          <div class="text-end">
            <button type="submit" class="btn btn-success rounded-pill px-4">
              Asignar
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

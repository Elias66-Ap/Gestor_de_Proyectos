<!-- Modal Crear Proyecto -->
<div class="modal fade" id="modalProyecto" tabindex="-1" aria-labelledby="modalProyectoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalProyectoLabel">Crear nuevo proyecto</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form>
        <div class="modal-body">
            <div class="mb-3">
                <label for="nombreProyecto" class="form-label">Nombre del proyecto</label>
                <input type="text" class="form-control" id="nombreProyecto" placeholder="Ej. Plataforma web">
            </div>
            <div class="mb-3">
                <label for="fechaEntrega" class="form-label">Fecha de entrega</label>
                <input type="date" class="form-control" id="fechaEntrega">
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripcion</label>
                <input type="text" class="form-control" id="descripcion" min="0">
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select id="estado" class="form-select">
                    <option value="en-progreso" selected>En progreso</option>
                    <option value="completado">Completado</option>
                    <option value="pendiente">Pendiente</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

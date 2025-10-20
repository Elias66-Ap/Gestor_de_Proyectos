<!-- Modal Enviar Mensaje -->
<div class="modal fade" id="modalMensaje" tabindex="-1" aria-labelledby="modalMensajeLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalMensajeLabel">✉️ Nuevo mensaje</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form>
        <div class="modal-body">

          <!-- Destinatarios -->
          <div class="row mb-3 align-items-center">
            <div class="col-md-5">
              <label for="destinatario" class="form-label">Miembros</label>
              <select id="destinatario" class="form-select">
                <option selected>Ninguno...</option>
                <option>Amaya - Colaborador</option>
                <option>Sergio - Líder</option>
              </select>
            </div>
            <div class="col-md-5">
              <label for="area" class="form-label">Área</label>
              <select id="area" class="form-select">
                <option selected>Ninguno...</option>
                <option>Back-end</option>
                <option>Front-end</option>
              </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="todos">
                <label class="form-check-label" for="todos">Todos</label>
              </div>
            </div>
          </div>

          <!-- Asunto -->
          <div class="mb-3">
            <label for="asunto" class="form-label">Asunto</label>
            <input type="text" class="form-control" id="asunto" placeholder="Ej. Reunión semanal">
          </div>

          <!-- Fecha programada (opcional) -->
          <div class="mb-3">
            <label for="fechaEnvio" class="form-label">Programar envío (opcional)</label>
            <input type="datetime-local" class="form-control" id="fechaEnvio">
          </div>

          <!-- Mensaje -->
          <div class="mb-3">
            <label for="contenidoMensaje" class="form-label">Mensaje</label>
            <textarea class="form-control" id="contenidoMensaje" rows="4" placeholder="Escribe tu mensaje aquí..."></textarea>
          </div>

          <!-- Estado del mensaje -->


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
      </form>
    </div>
  </div>
</div>

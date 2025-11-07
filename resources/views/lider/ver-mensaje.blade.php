<!-- MODAL VER MENSAJE SIMPLE -->
<div class="modal fade" id="modalVerMensaje" tabindex="-1" aria-labelledby="modalVerMensajeLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-lg">

      <div class="modal-header bg-primary text-white rounded-top-4">
        <h5 class="modal-title fw-bold" id="modalVerMensajeLabel">
          <i class="bi bi-envelope-paper me-2"></i> Mensaje
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body p-4">
        <div class="mb-3">
          <h6 class="text-secondary fw-semibold mb-1">
            <i class="bi bi-person-fill me-2 text-primary"></i>Destinatario
          </h6>
          <p id="mensajeNombre" class="text-dark fw-bold mb-3">—</p>
        </div>

        <div class="mb-3">
          <h6 class="text-secondary fw-semibold mb-1">
            <i class="bi bi-card-text me-2 text-primary"></i>Asunto
          </h6>
          <p id="mensajeAsunto" class="text-dark fw-bold mb-3">—</p>
        </div>

        <div>
          <h6 class="text-secondary fw-semibold mb-1">
            <i class="bi bi-chat-dots-fill me-2 text-primary"></i>Contenido
          </h6>
          <div id="mensajeContenido" class="bg-light p-3 rounded-3 shadow-sm text-muted" style="white-space: pre-line;">
            —
          </div>
        </div>
      </div>

      <div class="modal-footer border-0 bg-light rounded-bottom-4 justify-content-end">
        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-1"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

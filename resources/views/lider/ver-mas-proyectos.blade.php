<div class="modal fade" id="modalDetallesProyecto" tabindex="-1" aria-labelledby="detallesProyectoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">

            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                    <i class="bi bi-folder2-open"></i> Detalles del Proyecto
                </h5>
            </div>
            <div class="modal-body p-4">
                <div class="mb-4">
                    <h6 class="text-secondary fw-semibold mb-1">
                        <i class="bi bi-card-heading me-2 text-primary"></i> Título del proyecto
                    </h6>
                    <h5 id="nombreProyectoModal" class="fw-bold text-dark border-start border-3 border-primary ps-3 mt-2"></h5>
                </div>
                <div class="mb-4">
                    <h6 class="text-secondary fw-semibold mb-1">
                        <i class="bi bi-text-paragraph me-2 text-primary"></i> Descripción
                    </h6>
                    <p id="descripcionProyectoModal" class="text-muted bg-light p-3 rounded-3 shadow-sm small" style="line-height: 1.6;">
                        Cargando descripción...
                    </p>
                </div>
                <div>
                    <h6 class="text-secondary fw-semibold mb-3">
                        <i class="bi bi-lightning-charge-fill me-2 text-warning"></i> Accesos rápidos
                    </h6>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" id="btnEditarProyecto" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="bi bi-pencil-square me-1"></i> Editar proyecto
                        </button>
                        <button type="button"
        class="btn btn-outline-warning rounded-pill px-4 btn-pausar-proyecto"
        data-id="{{ $proyecto['id'] }}">
  <i class="bi bi-pause-circle me-1"></i> Pausar proyecto
</button>
                        <button type="button" class="btn btn-outline-danger rounded-pill px-4">
                            <i class="bi bi-trash3 me-1"></i> Eliminar proyecto
                        </button>
                        <a href="{{ route('tablero.proyecto', ['id' => $proyecto['id']]) }}"
                            class="btn btn-outline-success rounded-pill px-4">
                            <i class="bi bi-kanban me-1"></i> Ver tablero
                        </a>
                    </div>
                </div>

            </div>
            <div class="modal-footer border-0 bg-light justify-content-end py-3">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Detalle Proyecto -->
<div class="modal fade" id="modalDetalleProyecto" tabindex="-1" aria-labelledby="modalDetalleProyectoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalDetalleProyectoLabel">
                    Proyecto: <span id="modalProyectoNombre" class="fw-bold"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="modalProyectoId">

                <h6 class="fw-bold text-dark mb-2">Descripción detallada</h6>
                <p id="modalProyectoDescripcion" class="text-muted"></p>

                <hr>

                <h6 class="fw-bold text-dark mb-2">Miembros asignados</h6>
                <ul id="listaMiembrosAsignados" class="list-unstyled mb-0">
                    <li class="text-muted text-center">Cargando miembros...</li>
                </ul>
            </div>
        </div>
    </div>
</div>

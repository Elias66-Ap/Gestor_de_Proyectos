<div class="modal fade" id="modalProyecto" tabindex="-1" aria-labelledby="modalProyectoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

      <!-- Encabezado -->
      <div class="modal-header bg-primary text-white">
        <div class="d-flex align-items-center w-100">
          <i class="bi bi-folder2-open fs-4 me-2"></i>
          <div>
            <h5 class="modal-title fw-bold mb-0" id="modalProyectoLabel">Nuevo Proyecto</h5>
            <small class="text-white-50">Complete los campos para registrar un nuevo proyecto</small>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="formProyecto" action="{{ route('crear.proyecto') }}" method="POST" class="bg-light">
        @csrf
        <div class="modal-body px-4 py-4">

          <!-- Nombre -->
          <div class="mb-4">
            <label for="nombre" class="form-label fw-semibold text-secondary">Nombre del proyecto</label>
            <input type="text" class="form-control form-control-lg" id="nombre" name="nombre"
                   placeholder="Ej. Plataforma web corporativa" required>
          </div>

          <!-- Descripción breve -->
          <div class="mb-4">
            <label for="descripcion_breve" class="form-label fw-semibold text-secondary">Descripción breve</label>
            <textarea class="form-control" id="descripcion_breve" name="descripcion_breve" rows="2"
                      placeholder="Describe brevemente el propósito del proyecto"></textarea>
          </div>

          <!-- Descripción detallada -->
          <div class="mb-4">
            <label for="descripcion_detalle" class="form-label fw-semibold text-secondary">Descripción detallada</label>
            <textarea class="form-control" id="descripcion_detalle" name="descripcion_detalle" rows="4"
                      placeholder="Incluye alcance, fases y requerimientos específicos"></textarea>
          </div>

          <!-- Fecha de entrega -->
          <div class="mb-4">
            <label for="fecha_entrega" class="form-label fw-semibold text-secondary">Fecha de entrega</label>
            <div class="input-group">
              <span class="input-group-text bg-secondary text-white"><i class="bi bi-calendar-event"></i></span>
              <input type="text" class="form-control" id="fecha_entrega" name="fecha_entrega"
                     placeholder="Selecciona fecha y hora">
            </div>
          </div>

        </div>

        <!-- Footer -->
        <div class="modal-footer bg-white border-top">
          <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-check-circle me-1"></i> Guardar proyecto
          </button>
        </div>

      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>


<script>

  flatpickr("#fecha_entrega", {
    dateFormat: "Y-m-d H:i",
    enableTime: true,
    minDate: new Date().fp_incr(30), // hoy
    time_24hr: true,
    minuteIncrement: 1,
    locale: "es",
  });
</script>

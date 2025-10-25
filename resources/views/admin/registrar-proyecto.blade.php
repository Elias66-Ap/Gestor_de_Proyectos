<!-- Modal Crear Proyecto -->
<div class="modal fade" id="modalProyecto" tabindex="-1" aria-labelledby="modalProyectoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalProyectoLabel">Crear nuevo proyecto</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formProyecto" action="{{ route('crear.proyecto') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="nombreProyecto" class="form-label">Nombre del proyecto</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej. Plataforma web">
          </div>
          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripcion</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion">
          </div>
          <div class="mb-3">
            <label for="fechaEntrega" class="form-label">Fecha de entrega</label>
            <input type="text" class="form-control" id="fecha_entrega" name="fecha_entrega">
          </div>
          <div class="mb-3">
            <label for="lider" class="form-label">Lider</label>
            <select id="lider" name="id_usuarios[]" onclick="cargarLideres()" class="form-select">
              <option value="" selected>Seleccione un lider</optiom>
            </select>
          </div>
          <div class="mb-3">
            <label for="colaboradores" class="form-label">Colaborador</label>
            <select id="colaboradores" name="id_usuarios[]" onclick="cargarColaboradores()" class="form-select" placeholder="Eliga los colaboradores" multiple size="5">
            </select>
          </div>

          <div id="colaboradores-seleccionados" class="mt-2"></div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
      </form>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
  async function cargarLideres() {
    const select = document.getElementById('lider');

    if (select.dataset.cargado === "true") return;

    try {
      const response = await fetch("http://127.0.0.1:8000/api/lideres");
      const result = await response.json();

      console.log(result)

      if (result.status === "error") {
        select.innerHTML = `<option value="">${result.message}</option>`;
        return;
      }

      select.innerHTML = '<option value="">Seleccione un líder</option>';

      result.data.forEach(lider => {
        const option = document.createElement('option');
        option.value = lider.id;
        option.textContent = lider.perfil.nombre + " " + lider.perfil.apellido;
        select.appendChild(option);
      });

      select.dataset.cargado = "true";

    } catch (error) {
      console.error("Error cargando líderes:", error);
      select.innerHTML = '<option value="">Error al cargar líderes</option>';
    }
  }

  async function cargarColaboradores() {
    const select = document.getElementById('colaboradores');

    if (select.dataset.cargado === "true") return;

    try {
      const response = await fetch("http://127.0.0.1:8000/api/colaboradores");
      const result = await response.json();

      if (result.status === "error") {
        select.innerHTML = `<option value="">${result.message}</option>`;
        return;
      }

      select.innerHTML = ''; // limpiar select

      result.data.forEach(colaborador => {
        if (colaborador.perfil) {
          const option = document.createElement('option');
          option.value = colaborador.id;
          option.textContent = colaborador.perfil.nombre + " " + colaborador.perfil.apellido;
          select.appendChild(option);
        }
      });

      select.dataset.cargado = "true";

    } catch (error) {
      console.error("Error cargando colaboradores:", error);
      select.innerHTML = '<option value="">Error al cargar colaboradores</option>';
    }
  }

  // Función para mostrar los seleccionados como chips con opción de eliminar
  function actualizarSeleccionados() {
    const select = document.getElementById('colaboradores');
    const contenedor = document.getElementById('colaboradores-seleccionados');
    contenedor.innerHTML = ''; // limpiar contenedor

    Array.from(select.selectedOptions).forEach(option => {
      const chip = document.createElement('span');
      chip.className = 'badge bg-primary me-1';
      chip.textContent = option.textContent;

      // Botón de eliminar
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'btn-close btn-close-white btn-sm ms-1';
      btn.setAttribute('aria-label', 'Cerrar');
      btn.onclick = () => {
        option.selected = false; // quitar selección
        actualizarSeleccionados(); // actualizar chips
      };

      chip.appendChild(btn);
      contenedor.appendChild(chip);
    });

  }

  flatpickr("#fecha_entrega", {
    dateFormat: "Y-m-d H-i",
    enableTime: true,
    minDate: new Date().fp_incr(30), // hoy
    time_24hr: true,
  });

  // Escuchar cambios en el select
  document.getElementById('colaboradores').addEventListener('change', actualizarSeleccionados);

  document.addEventListener('DOMContentLoaded', () => {
    cargarLideres();
    cargarColaboradores();
  });
</script>
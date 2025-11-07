<!-- Modal Enviar Mensaje -->
<div class="modal fade" id="modalMensaje" tabindex="-1" aria-labelledby="modalMensajeLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-4">
      
      <!-- Header -->
      <div class="modal-header border-0 bg-light px-4 py-3">
        <div class="d-flex align-items-center">
          <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width:42px;height:42px;">
            <i class="bi bi-envelope-paper-fill fs-5"></i>
          </div>
          <div>
            <h5 class="modal-title fw-semibold mb-0 text-dark">Nuevo mensaje</h5>
            <small class="text-muted">Comunicación interna</small>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>


      <!-- Body -->
      <form action="{{route('enviar.mensaje')}}" method="POST">
        @csrf
        <div class="modal-body px-4 pt-3 pb-0">

          <!-- Destinatarios -->
          <div class="mb-3">
            <label for="destinatario" class="form-label fw-semibold text-secondary">Destinatario</label>
            <select id="destinatario" name="id_destinatario[]" class="form-select border-0 shadow-sm bg-light rounded-3" multiple>
              <option selected>Seleccione...</option>
            </select>
          </div>


          <div id="usuariosSeleccionados" class="mb-3 d-flex flex-wrap gap-2">
            <!-- Aquí se agregarán las etiquetas -->
          </div>
          <div id="inputsDestinatarios"></div>
          <!-- Asunto -->
          <div class="mb-3">
            <label for="asunto" class="form-label fw-semibold text-secondary">Asunto</label>
            <input type="text" class="form-control border-0 shadow-sm bg-light rounded-3" id="asunto" name="asunto" placeholder="Ej. Reunión semanal">
          </div>

          <!-- Mensaje -->
          <div class="mb-3">
            <label for="contenidoMensaje" class="form-label fw-semibold text-secondary">Mensaje</label>
            <textarea class="form-control border-0 shadow-sm bg-light rounded-3" id="contenidoMensaje" name="contenido" rows="5" placeholder="Escribe tu mensaje aquí..."></textarea>
          </div>

        </div>


        <!-- Footer -->
        <div class="modal-footer border-0 bg-light px-4 py-3 d-flex justify-content-end">
          <button type="button" class="btn btn-outline-secondary px-4 rounded-3" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary px-4 rounded-3 fw-semibold">Enviar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  async function cargarUsuarios() {
    const select = document.getElementById('destinatario');

    if (select.dataset.cargado === "true") return;

    try {
      const response = await fetch('http://127.0.0.1:8000/api/usuarios-todos');
      const result = await response.json();

      if (result.status == 'error') {
        select.innerHTML = '<option Error al cargar usuarios</option>';
        return;
      }

      select.innerHTML = 'selected>Seleccione...</option>';
      result.data.forEach(usuario => {
        const option = document.createElement('option');
        option.value = usuario.id;
        option.textContent = `${usuario.perfil.nombre} ${usuario.perfil.apellido}`;
        select.appendChild(option);
      });

      select.dataset.cargado = "true";

    } catch (error) {
      console.error('Error al cargar usuarios:', error);
      select.innerHTML = '<option value="">Error al cargar usuarios</option>';
    }

  }

  var modal = document.getElementById('modalMensaje')
  modal.addEventListener('show.bs.modal', function() {
    cargarUsuarios();
  });

  const usuariosSeleccionados = new Map(); // guardamos id + nombre completo

  // Cuando cambie el select
  document.getElementById('destinatario').addEventListener('change', function() {
    const select = this;
    const usuarioId = select.value;
    if (!usuarioId) return;

    // Buscar datos del usuario en el select
    const usuarioNombre = select.options[select.selectedIndex].text;

    // Evitar duplicados
    if (!usuariosSeleccionados.has(usuarioId)) {
      usuariosSeleccionados.set(usuarioId, usuarioNombre);
      agregarUsuarioTag(usuarioId, usuarioNombre);
    }

    select.value = ""; // resetear select
  });

  function agregarUsuarioTag(id, nombre) {
    const contenedor = document.getElementById('usuariosSeleccionados');

    const tag = document.createElement('div');
    tag.className = "bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1 d-flex align-items-center gap-2";
    tag.dataset.id = id;

    tag.innerHTML = `
    <span>${nombre}</span>
    <button type="button" class="btn-close btn-close-sm" aria-label="Remove"></button>
  `;

    // Botón eliminar
    tag.querySelector('button').addEventListener('click', function() {
      usuariosSeleccionados.delete(id);
      tag.remove();
    });

    contenedor.appendChild(tag);
  }

  document.querySelector('#modalMensaje form').addEventListener('submit', function(e) {
    const contenedor = document.getElementById('inputsDestinatarios');
    contenedor.innerHTML = '';

    usuariosSeleccionados.forEach((nombre, id) => {
      if (!id || isNaN(id)) return; // ignora valores inválidos
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_destinatario[]';
      input.value = id;
      contenedor.appendChild(input);
    });

  });

</script>
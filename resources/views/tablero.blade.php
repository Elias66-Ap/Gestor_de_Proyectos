<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tablero</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <link href="{{ asset('css/tablero.css') }}" rel="stylesheet">
</head>

<body>
  @php
    use Carbon\Carbon;
  @endphp

  <div class="kanban-header">
    <div class="kanban-title d-flex align-items-center gap-2">
      <div>
        <h2>{{ $proyecto['nombre'] }}</h2>
        <small><i class="bi bi-people"></i> {{ $proyecto['miembros_count'] }} miembros &nbsp; | &nbsp; <i
            class="bi bi-calendar-event"></i> Entrega
          {{ Carbon::parse($proyecto['fecha_entrega'])->format('d-m-Y') }}</small>
      </div>
    </div>
    <div class="d-flex align-items-center gap-4 mt-3 mt-md-0">
      <div class="text-end">
        <p class="mb-1">Progreso General</p>
        <div class="progress" style="width: 220px;">
          <div class="progress-bar" role="progressbar" style="width: {{ $proyecto['progreso'] }}%;"></div>
        </div>
        <small>{{ $proyecto['progreso'] }}%</small>
      </div>
      <a href="{{ route('salir.tablero') }}" class="btn-exit-pro d-flex align-items-center gap-2 px-3">
        <i class="bi bi-box-arrow-right fs-5"></i>
        <span>Salir</span>
      </a>
    </div>
  </div>

  <div class="kanban-board">
    {{-- Columna Por hacer --}}
    <div class="kanban-column">
      <div class="kanban-column-header text-secondary bg-light">
        <span>Por hacer</span>
        <button type="button" class="btn-add-task" data-column="Por hacer" data-bs-toggle="modal"
          data-bs-target="#taskModal"><i class="bi bi-plus-lg"></i></button>
      </div>
      <div class="kanban-tasks">
        @foreach ($proyecto['tareas'] as $tarea)
          @if (strtolower($tarea['estado']) == 'por hacer')
            <div class="kanban-task" data-id="{{ $tarea['id'] }}">
              <div class="kanban-task-title d-flex justify-content-between align-items-center">
                <span>{{ $tarea['titulo'] }}</span>
                <div class="d-flex align-items-center gap-2">
                  @php
                    $badgeClass = $tarea['prioridad'] == 'Alta' ? 'danger' : ($tarea['prioridad'] == 'Media' ? 'warning text-dark' : 'success');
                  @endphp
                  <span class="badge bg-{{ $badgeClass }}">{{ $tarea['prioridad'] }}</span>
                  <div class="dropdown">
                    <button class="btn btn-sm btn-light p-0" type="button" data-bs-toggle="dropdown">
                      <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li><a class="dropdown-item edit-task" href="#">Editar</a></li>
                      <li><a class="dropdown-item delete-task" href="#">Eliminar</a></li>
                      <li>
                        <a class="dropdown-item subir-task" href="#" data-id="{{ $tarea['id'] }}"
                          data-titulo="{{ $tarea['titulo'] }}" data-descripcion="{{ $tarea['descripcion'] }}"
                          data-estado="{{ $tarea['estado'] }}" data-contenido='@json($tarea["contenidos"])'
                          data-bs-toggle="modal">
                          Subir Tarea
                        </a>
                      </li>

                    </ul>
                  </div>
                </div>
              </div>
              <p>{{ $tarea['descripcion'] }}</p>
              <div class="kanban-task-footer d-flex justify-content-between">
                <span><i class="bi bi-person-circle"></i> {{ $tarea['asignado']['nombre'] }}
                  {{ $tarea['asignado']['apellido'] }}</span>
                <span>{{ \Carbon\Carbon::parse($tarea['fecha_vencimiento'])->format('d-m-Y') }}</span>
              </div>
            </div>
          @endif
        @endforeach
      </div>
    </div>

    {{-- Columna En proceso --}}
    <div class="kanban-column">
      <div class="kanban-column-header text-white" style="background:#0d6efd;">
        <span>En proceso</span>
        <button type="button" class="btn-add-task" data-column="En proceso" data-bs-toggle="modal"
          data-bs-target="#taskModal"><i class="bi bi-plus-lg"></i></button>
      </div>
      <div class="kanban-tasks">
        @foreach ($proyecto['tareas'] as $tarea)
          @if (strtolower($tarea['estado']) == 'en proceso')
            @include('task', ['tarea' => $tarea])
          @endif
        @endforeach
      </div>
    </div>

    {{-- Columna En revisión --}}
    <div class="kanban-column">
      <div class="kanban-column-header text-dark bg-warning">
        <span>En revisión</span>
        <button type="button" class="btn-add-task" data-column="En revisión" data-bs-toggle="modal"
          data-bs-target="#taskModal"><i class="bi bi-plus-lg"></i></button>
      </div>
      <div class="kanban-tasks">
        @foreach ($proyecto['tareas'] as $tarea)
          @if (strtolower($tarea['estado']) == 'revision')
            @include('task', ['tarea' => $tarea])
          @endif
        @endforeach
      </div>
    </div>

    {{-- Columna Hecho --}}
    <div class="kanban-column">
      <div class="kanban-column-header text-white bg-success">
        <span>Hecho</span>
        <button type="button" class="btn-add-task" data-column="Hecho" data-bs-toggle="modal"
          data-bs-target="#taskModal"><i class="bi bi-plus-lg"></i></button>
      </div>
      <div class="kanban-tasks">
        @foreach ($proyecto['tareas'] as $tarea)
          @if (strtolower($tarea['estado']) == 'hecho')
            @include('task', ['tarea' => $tarea])
          @endif
        @endforeach
      </div>
    </div>
  </div>



  <!-- Modal -->
  <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="taskModalLabel">Nueva Tarea</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <form id="taskForm" method="POST" action="{{ route('crear.tarea', $proyecto['id']) }}">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="taskTitle" class="form-label">Título</label>
              <input type="text" class="form-control" id="taskTitle" name="nombre" required>
            </div>
            <div class="mb-3">
              <label for="taskDesc" class="form-label">Descripción</label>
              <textarea class="form-control" id="taskDesc" name="descripcion" rows="3"></textarea>
            </div>
            <div class="mb-3">
              <label for="taskPriority" class="form-label">Prioridad</label>
              <select class="form-select" id="taskPriority" name="prioridad">
                <option value="Alta">Alta</option>
                <option value="Media">Media</option>
                <option value="Baja" selected>Baja</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="taskDueDate" class="form-label">Fecha de entrega</label>
              <input type="date" class="form-control" id="taskDueDate" name="fecha_vencimiento">
            </div>
            <div class="mb-3">
              <label for="taskAssignee" class="form-label">Responsable</label>
              <select class="form-select" id="selectUsuarios" name="id_asignado">
                <option selected>Seleccione el miembro</option>
                @foreach ($miembros as $m)
                  <option value={{ $m['id_usu'] }}>{{$m['nombre']}} {{ $m['apellido'] }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Tareas --}}
  <div class="modal fade" id="verTareaModal" tabindex="-1" aria-labelledby="TareaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content shadow-lg border-0 rounded-4">
        <!-- HEADER -->
        <div class="modal-header bg-light border-0 py-3 rounded-top-4">
          <h5 class="modal-title fw-bold" id="TareaModalLabel">
            <i class="bi bi-journal-text me-2 fw-bold text-dark"></i> Título de la Tarea
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <!-- BODY -->
        <div class="modal-body px-4 pb-4">

          <!-- Descripción -->
          <div class="mb-4">
            <label class="fw-semibold text-dark mb-1 fw-bold">Descripción</label>
            <div class="p-3 bg-light rounded-3 border">
              <p class="mb-0 text-muted" id="descripcionTarea">
                Aquí irá la descripción detallada de la tarea...
              </p>
            </div>
          </div>

          <!-- Estado -->
          <form action="{{ route('subir.tarea') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_tarea" id="id_tarea">
            <div class="mb-4">
              <label class="fw-semibold text-dark mb-2 d-block fw-bold">Estado</label>

              <div class="estado-container">
                <label class="estado-option">
                  <input type="radio" name="estado" value="Por hacer">
                  <span class="estado-btn">
                    <i class="bi bi-circle"></i> Por hacer
                  </span>
                </label>

                <label class="estado-option">
                  <input type="radio" name="estado" value="En proceso">
                  <span class="estado-btn">
                    <i class="bi bi-arrow-repeat"></i> En proceso
                  </span>
                </label>

                <label class="estado-option">
                  <input type="radio" name="estado" value="Revision">
                  <span class="estado-btn">
                    <i class="bi bi-search"></i> Revisión
                  </span>
                </label>

                <label class="estado-option">
                  <input type="radio" name="estado" value="Hecho">
                  <span class="estado-btn">
                    <i class="bi bi-check2-circle"></i> Hecho
                  </span>
                </label>
              </div>

              <input type="hidden" name="estado" value="">

            </div>
            <div class="mb-3">
              <label class="fw-bold">Contenido</label>
              <!-- TOOLBAR -->
              <div id="toolbar">
                <span class="ql-formats">
                  <button class="ql-bold"></button>
                  <button class="ql-italic"></button>
                  <button class="ql-underline"></button>
                </span>
                <span class="ql-formats">
                  <button class="ql-list" value="ordered"></button>
                  <button class="ql-list" value="bullet"></button>
                </span>
                <!-- Boton para subir archivos-->
                <span class="ql-formats">
                  <button class="ql-link" id="btn-upload-archivo"></button>
                  <input type="file" name="archivos[]" id="file-input-archivos" style="display:none" multiple>
                </span>
              </div>
              <!-- EDITOR -->
              <div id="descripcionEditor" style="height: 200px; background: white;"></div>
              <!-- Campo oculto para enviar al backend -->
              <input type="hidden" name="texto" id="texto">
            </div>
            <div class="mt-2 d-none" id="contenedor-lista-archivos">
              <label class="fw-semibold text-secondary mb-1">Archivos seleccionados</label>
              <div id="lista-archivos" class="small text-muted"></div>
            </div>
            <div>
              <label class="fw-semibold text-secondary mb-1">Tareas subidas</label>
              <div id="contenidosTarea" class="mb-3 d-flex flex-column gap-2">
                <!-- Aquí se generarán las tarjetas dinámicamente -->
              </div>
            </div>

        </div>
        <!-- FOOTER -->
        <div class="modal-footer border-0 px-4 pb-4">
          <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal">
            Cancelar
          </button>
          <button type="submit" class="btn btn-primary rounded-3 px-4">
            Subir Tarea
          </button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {

      // Base de la API (puedes usar tu constante desde Blade si ya la tienes)
      const apiBase = "http://127.0.0.1:8000/api";

      const modal = document.getElementById('verTareaModal');
      const form = modal.querySelector('form');

      let cambioPendiente = null;

      // =======================
      //   ABRIR MODAL "Subir Tarea"
      // =======================
      document.querySelectorAll('.subir-task').forEach(btn => {
        btn.addEventListener('click', function (e) {
          e.preventDefault();

          // Datos desde data-*
          const titulo = this.dataset.titulo;
          const descripcion = this.dataset.descripcion;
          const estado = this.dataset.estado || '';
          const idTarea = this.dataset.id;

          // Colocar en el modal
          modal.querySelector('#TareaModalLabel').textContent = titulo;
          modal.querySelector('#descripcionTarea').textContent = descripcion;
          modal.querySelector('#id_tarea').value = idTarea;

          // Contenedor de contenidos ya subidos
          const contenedor = modal.querySelector('#contenidosTarea');
          contenedor.innerHTML = ''; // limpiar

          // Obtener contenidos de data-attributes
          let contenidos = [];
          try {
            // data-contenido='@json($tarea["contenidos"])'
            contenidos = JSON.parse(this.dataset.contenido);
          } catch (e) {
            contenidos = [];
          }
          if (!Array.isArray(contenidos)) {
            contenidos = [];
          }

          // Limpiar lista de archivos seleccionados del usuario (nuevos)
          archivosSeleccionados = [];
          renderListaArchivos();

          // =======================
          //   GENERAR TARJETAS DE CONTENIDO YA SUBIDO
          // =======================
          contenidos.forEach((item) => {
            const tarjeta = document.createElement('div');
            tarjeta.className = 'contenido-linea';

            // ARCHIVO
            if (item.tipo === 'archivo') {
              const fileName = item.valor.split('/').pop();
              const fileUrl = `http://127.0.0.1:8000/storage/${item.valor}`;

              tarjeta.innerHTML = `
              <div class="contenido-izquierda">
                <i class="bi bi-file-earmark-text contenido-icono"></i>
                <a href="${fileUrl}" target="_blank" rel="noopener noreferrer" class="contenido-nombre">
                  ${fileName}
                </a>
              </div>
              <button type="button" class="btn btn-link p-0 contenido-eliminar" title="Eliminar archivo">
                <i class="bi bi-trash"></i>
              </button>
            `;
            }

            // TEXTO
            else if (item.tipo === 'texto') {
              tarjeta.innerHTML = `
              <div class="contenido-izquierda">
                <i class="bi bi-card-text contenido-icono"></i>
                <div>
                  <div class="contenido-label">Comentario/Link</div>
                  <div class="contenido-texto">${item.valor}</div>
                </div>
              </div>
            `;
            }

            // LINK
            else if (item.tipo === 'link') {
              tarjeta.innerHTML = `
              <div class="contenido-izquierda">
                <i class="bi bi-link-45deg contenido-icono"></i>
                <div>
                  <div class="contenido-label">Enlace</div>
                  <a href="${item.valor}" target="_blank" rel="noopener noreferrer" class="contenido-link">
                    ${item.valor}
                  </a>
                </div>
              </div>
            `;
            }

            contenedor.appendChild(tarjeta);
          });

          // =======================
          //   MARCAR ESTADO ACTUAL EN LOS RADIOS PILL
          // =======================
          const normalizarEstado = (str) => {
            return (str || '')
              .toLowerCase()
              .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // quitar acentos
              .trim();
          };

          const estadoNormalizado = normalizarEstado(estado);

          modal.querySelectorAll('input[name="estado"]').forEach(radio => {
            const valorNormalizado = normalizarEstado(radio.value);
            radio.checked = (valorNormalizado === estadoNormalizado);
          });

          // Mostrar modal
          const bsModal = new bootstrap.Modal(modal);
          bsModal.show();
        });
      });

      // =======================
      //   CAMBIAR ESTADO POR JS (LLAMADA A LA API)
      // =======================
      modal.addEventListener('change', function (e) {
        if (e.target.name !== 'estado') return; // solo radios de estado

        const nuevoEstado = e.target.value; // "Por hacer", "En proceso", "En revision", "Hecho"
        const idTarea = modal.querySelector('#id_tarea').value;
        console.log("Id de la tarea", idTarea);

        fetch(`${apiBase}/tareas/cambiar-estado/${idTarea}`, {
          method: 'PATCH',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ estado: nuevoEstado }),
        })
          .then(res => res.json())
          .then(data => {
            if (data.status === 'success') {
              moverTarjetaKanban(idTarea, nuevoEstado);

              // Actualizar el dataset del botón que abre el modal
              const boton = document.querySelector(`.subir-task[data-id="${idTarea}"]`);
              if (boton) {
                boton.dataset.estado = nuevoEstado;
              }

              cambioPendiente = {
                id: idTarea,
                estado: nuevoEstado
              };


            } else {
              alert("No se pudo cambiar el estado.");
            }
          })
          .catch(() => alert("Error al conectar con el servidor."));

      });

      function moverTarjetaKanban(idTarea, nuevoEstado) {
        const normalizar = (str) => {
          return (str || '')
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .trim();
        };

        let estadoNorm = normalizar(nuevoEstado);
        if (estadoNorm === 'revision') {
          estadoNorm = 'en revision';
        }

        const tarjeta = document.querySelector(`.kanban-task[data-id="${idTarea}"]`);
        if (!tarjeta) return;

        const columnas = document.querySelectorAll('.kanban-column');
        let columnaDestino = null;

        columnas.forEach(col => {
          const titulo = col.querySelector('.kanban-column-header span').textContent.trim();
          let tituloNorm = normalizar(titulo);
          if (tituloNorm === 'revision') {
            tituloNorm = 'en revision';
          }
          if (tituloNorm === estadoNorm) {
            columnaDestino = col.querySelector('.kanban-tasks');
          }
        });

        if (!columnaDestino) return;

        columnaDestino.appendChild(tarjeta);
        tarjeta.dataset.estado = nuevoEstado;
      }



      //   QUILL
      const quill = new Quill('#descripcionEditor', {
        theme: 'snow',
        placeholder: 'Sube el contenido...',
        modules: { toolbar: '#toolbar' }
      });

      // =======================
      //   BOTÓN PARA ABRIR INPUT DE ARCHIVOS
      // =======================
      document.getElementById('btn-upload-archivo').addEventListener('click', (e) => {
        e.preventDefault(); // Evita el prompt de enlace de Quill
        document.getElementById('file-input-archivos').click();
      });

      // =======================
      //   ARCHIVOS SELECCIONADOS (BADGES + MULTIPLES TANDAS)
      // =======================
      const fileInput = document.getElementById('file-input-archivos');
      const listaArchivosDiv = document.getElementById('lista-archivos');
      const contenedorListaArchivos = document.getElementById('contenedor-lista-archivos');

      let archivosSeleccionados = [];

      // Selección de archivos (puede hacerse en varias tandas)
      fileInput.addEventListener('change', (event) => {
        const nuevos = Array.from(event.target.files);

        // Acumular con los que ya había
        archivosSeleccionados = archivosSeleccionados.concat(nuevos);

        // Reconstruir FileList para el input
        const dt = new DataTransfer();
        archivosSeleccionados.forEach(f => dt.items.add(f));
        fileInput.files = dt.files;

        // Limpiar el value del input para poder seleccionar de nuevo los mismos si se quiere
        event.target.value = '';

        renderListaArchivos();
      });

      function renderListaArchivos() {
        listaArchivosDiv.innerHTML = '';

        if (archivosSeleccionados.length === 0) {
          contenedorListaArchivos.classList.add('d-none');
          return;
        }

        contenedorListaArchivos.classList.remove('d-none');

        archivosSeleccionados.forEach((file, index) => {
          const badge = document.createElement('div');
          badge.className = 'archivo-badge';

          badge.innerHTML = `
          <span class="archivo-icono">
            <i class="bi bi-paperclip"></i>
          </span>
          <span class="archivo-nombre" title="${file.name}">
            ${file.name}
          </span>
          <button type="button" class="archivo-eliminar" data-index="${index}">
            &times;
          </button>
        `;

          listaArchivosDiv.appendChild(badge);
        });

        // Eliminar archivo desde badge
        listaArchivosDiv.querySelectorAll('.archivo-eliminar').forEach(btn => {
          btn.addEventListener('click', () => {
            const i = parseInt(btn.dataset.index, 10);

            // Quitar del array
            archivosSeleccionados.splice(i, 1);

            // Reconstruir FileList
            const dt = new DataTransfer();
            archivosSeleccionados.forEach(f => dt.items.add(f));
            fileInput.files = dt.files;

            renderListaArchivos();
          });
        });
      }

      // =======================
      //   SUBMIT FORM (ENVIAR QUILL)
      // =======================
      form.addEventListener('submit', function () {
        // Pasar contenido de Quill al input hidden
        document.getElementById('texto').value = quill.root.innerHTML;
        // NO tocamos los radios de estado: el cambio ya se mandó por fetch.
      });

    });
  </script>




</body>

</html>
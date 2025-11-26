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
            <div class="kanban-task">
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

              <div class="d-flex gap-4 flex-wrap">

                <div class="form-check">
                  <input class="form-check-input" type="radio" name="estado" id="estado1" value="Por hacer">
                  <label class="form-check-label" for="estado1">Por hacer</label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="radio" name="estado" id="estado2" value="En proceso">
                  <label class="form-check-label" for="estado2">En Proceso</label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="radio" name="estado" id="estado3" value="Revision">
                  <label class="form-check-label" for="estado3">Revisión</label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="radio" name="estado" id="estado4" value="Hecho">
                  <label class="form-check-label" for="estado3">Hecho</label>
                </div>

                

              </div>
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

            <div id="contenidosTarea" class="mb-3 d-flex flex-column gap-2">
              <!-- Aquí se generarán las tarjetas dinámicamente -->
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

      // Escuchar clic en todos los botones .subir-task
      document.querySelectorAll('.subir-task').forEach(btn => {
        btn.addEventListener('click', function (e) {
          e.preventDefault();

          const modal = document.getElementById('verTareaModal');

          // Obtener datos desde data-*
          const titulo = this.dataset.titulo;
          const descripcion = this.dataset.descripcion;
          const estado = this.dataset.estado;
          const idTarea = this.dataset.id;

          // Colocar en el modal
          modal.querySelector('#TareaModalLabel').textContent = titulo;
          modal.querySelector('#descripcionTarea').textContent = descripcion;
          modal.querySelector('#id_tarea').value = idTarea;

          // Contenedor de tarjetas
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

          // Generar tarjetas
          contenidos.forEach((item) => {
            const tarjeta = document.createElement('div');
            tarjeta.className = 'contenido-card';

            if (item.tipo === 'archivo') {
              const fileName = item.valor.split('/').pop();
              const fileUrl = `http://127.0.0.1:8000/storage/${item.valor}`;

              tarjeta.innerHTML = `
      <div class="d-flex align-items-center gap-3">
        <div class="contenido-icon contenido-icon-archivo">
          <i class="bi bi-file-earmark-text"></i>
        </div>
        <div>
          <div class="contenido-meta-label">Archivo adjunto</div>
          <div class="fw-semibold">${fileName}</div>
        </div>
      </div>

      <div class="d-flex gap-2">
        <a href="${fileUrl}" class="btn btn-sm btn-outline-primary" rel="noopener noreferrer" target="_blank">
          <i class="bi bi-download me-1"></i> Descargar
        </a>
      </div>
    `;
            } else if (item.tipo === 'texto') {
              tarjeta.innerHTML = `
      <div class="d-flex align-items-start gap-3 w-100">
        <div class="contenido-icon contenido-icon-texto">
          <i class="bi bi-card-text"></i>
        </div>
        <div>
          <div class="contenido-meta-label">Comentario / Link</div>
          <div class="contenido-texto-body">
            ${item.valor}
          </div>
        </div>
      </div>
    `;
            } else if (item.tipo === 'link') {
              tarjeta.innerHTML = `
      <div class="d-flex align-items-center gap-3">
        <div class="contenido-icon contenido-icon-texto">
          <i class="bi bi-link-45deg"></i>
        </div>
        <div>
          <div class="contenido-meta-label">Enlace</div>
          <a href="${item.valor}" target="_blank" rel="noopener noreferrer" class="fw-semibold text-decoration-none">
            ${item.valor}
          </a>
        </div>
      </div>
    `;
            }

            contenedor.appendChild(tarjeta);
          });

          // Seleccionar el radio correspondiente al estado
          modal.querySelectorAll('input[name="estado"]').forEach(radio => {
            radio.checked = (radio.value.toLowerCase() === estado.toLowerCase());
          });

          const bsModal = new bootstrap.Modal(modal);
          bsModal.show();
        });
      });

      // Inicializar Quill
      const quill = new Quill('#descripcionEditor', {
        theme: 'snow',
        placeholder: 'Sube el contenido...',
        modules: { toolbar: '#toolbar' }
      });

      // Abrir selector de archivos al hacer clic en el icono de enlace
      document.getElementById('btn-upload-archivo').addEventListener('click', (e) => {
        e.preventDefault(); // Evita el prompt de enlace de Quill
        document.getElementById('file-input-archivos').click();
      });

      // Mostrar lista de archivos seleccionados
      const fileInput = document.getElementById('file-input-archivos');
      const listaArchivosDiv = document.getElementById('lista-archivos');
      const contenedorListaArchivos = document.getElementById('contenedor-lista-archivos');

      fileInput.addEventListener('change', (event) => {
        const files = event.target.files;
        listaArchivosDiv.innerHTML = ''; // limpiamos

        if (files.length > 0) {
          contenedorListaArchivos.classList.remove('d-none');

          const ul = document.createElement('ul');
          ul.classList.add('mb-0', 'ps-3');

          Array.from(files).forEach(file => {
            const li = document.createElement('li');
            li.textContent = file.name;
            ul.appendChild(li);
          });

          listaArchivosDiv.appendChild(ul);
        } else {
          contenedorListaArchivos.classList.add('d-none');
        }
      });


      const form = document.querySelector('#verTareaModal form');
      form.addEventListener('submit', function () {
        // Pasar contenido de Quill al input hidden
        document.getElementById('texto').value = quill.root.innerHTML;
      });

    });
  </script>



</body>

</html>
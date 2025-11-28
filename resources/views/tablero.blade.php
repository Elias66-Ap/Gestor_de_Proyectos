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

    $inicio = Carbon::parse($proyecto['fecha_inicio'])->format('d M Y');
    $fin = Carbon::parse($proyecto['fecha_entrega'])->format('d M Y');
  @endphp

  <div id="custom-alert-container"></div>

  <!-- WRAPPER GENERAL -->
  <div class="tablero-wrapper">
    <div class="kanban-header sticky-top shadow-sm">

      <!-- IZQUIERDA: Botón volver + Título + Fechas -->
      <div class="header-left-group">

        <a href="{{ route('salir.tablero') }}" class="header-back-btn">
          <i class="bi bi-arrow-left"></i>
          Volver
        </a>

        <div class="header-text-block">

          <h1 class="project-title">{{ $proyecto['nombre'] }}</h1>

          <p class="project-subtitle">
            {{ $proyecto['descripcion_breve'] ?? 'Sin descripción' }}
          </p>

          <p class="project-dates">
            <i class="bi bi-calendar-event"></i>{{ $inicio }} a {{ $fin }}
          </p>
        </div>
      </div>

      <!-- DERECHA: Miembros + Crear tarea -->
      <div class="header-right">

        <div class="project-members-stack">
          @php $count = count($miembros); @endphp

          @foreach ($miembros as $index => $m)
            @php
              $foto = $m['imagen'] ?? null;
              $nombre = $m['nombre'];
              $apellido = $m['apellido'];
              $iniciales = strtoupper(substr($nombre, 0, 1) . substr($apellido, 0, 1));

              $colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#a855f7'];
              $color = $colors[$index % count($colors)];
            @endphp

            @if ($index < 3)
              <div class="member-item">
                @if ($foto)
                  <img src="{{ asset('storage/' . $foto) }}" class="project-member-avatar-img">
                @else
                  <div class="project-member-avatar initials" style="background: {{ $color }}">
                    {{ $iniciales }}
                  </div>
                @endif
              </div>
            @endif
          @endforeach

          @if ($count > 3)
            <div class="more-members">+{{ $count - 3 }}</div>
          @endif

        </div>

        <button class="btn-create-task" data-bs-toggle="modal" data-bs-target="#taskModal">
          <i class="bi bi-plus-lg"></i> Add Task
        </button>

      </div>
    </div>


    {{-- TABLERO KANBAN --}}
    <div class="kanban-board">
      {{-- Columna Por hacer --}}
      <div class="kanban-column">
        <div class="kanban-column-header">
          <div class="d-flex align-items-center gap-2">
            <span class="column-title">Por hacer</span>
          </div>
        </div>
        <div class="kanban-tasks">
          @foreach ($proyecto['tareas'] as $tarea)
            @if (strtolower($tarea['estado']) == 'por hacer')
              @include('task', ['tarea' => $tarea])
            @endif
          @endforeach
        </div>
      </div>


      {{-- Columna En proceso --}}
      <div class="kanban-column">
        <div class="kanban-column-header">
          <div class="d-flex align-items-center gap-2">
            <span class="column-title">En proceso</span>
          </div>
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
        <div class="kanban-column-header">
          <div class="d-flex align-items-center gap-2">
            <span class="column-title">Revisión</span>
          </div>
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
        <div class="kanban-column-header">
          <div class="d-flex align-items-center gap-2">
            <span class="column-title">Hecho</span>
          </div>
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

  {{-- Modaltarea --}}
  <div class="modal fade" id="verTareaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="TareaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content shadow-lg border-0 rounded-4">

        <div class="modal-header bg-light border-0 py-3 rounded-top-4">
          <h5 class="modal-title fw-bold" id="TareaModalLabel">
            <i class="bi bi-journal-text me-2 fw-bold text-dark"></i> Título de la Tarea
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body px-4 pb-4">

          <form action="{{ route('subir.tarea') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="id_tarea" id="id_tarea">

            <div class="mb-4">
              <label class="fw-semibold text-dark mb-1 fw-bold">Descripción</label>
              <div class="p-3 bg-light rounded-3 border">
                <p class="mb-0 text-muted" id="descripcionTarea"></p>
              </div>
            </div>

            <div class="btn-group w-100 estado-group" role="group" aria-label="Estados de tarea">

              <input type="radio" class="btn-check estado-radio" name="estado" id="estado1" value="Por hacer">
              <label class="estado-pill" for="estado1">📝 Por hacer</label>

              <input type="radio" class="btn-check estado-radio" name="estado" id="estado2" value="En proceso">
              <label class="estado-pill" for="estado2">⚙️ En proceso</label>

              <input type="radio" class="btn-check estado-radio" name="estado" id="estado3" value="Revision">
              <label class="estado-pill" for="estado3">🔍 Revisión</label>

              <input type="radio" class="btn-check estado-radio" name="estado" id="estado4" value="Hecho">
              <label class="estado-pill" for="estado4">✅ Hecho</label>

            </div>


            <div class="mb-3">
              <label class="fw-bold">Contenido</label>

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
                <span class="ql-formats">
                  <button class="ql-link" id="btn-upload-archivo"></button>
                </span>
              </div>

              <input type="file" name="archivos[]" id="file-input-archivos" multiple style="display:none">

              <div id="descripcionEditor" style="height:200px; background:white;"></div>
              <input type="hidden" name="texto" id="texto">
            </div>

            <div id="contenedor-lista-archivos" class="mt-2 d-none">
              <label class="fw-semibold text-secondary mb-1">Archivos seleccionados</label>
              <div id="lista-archivos"></div>
            </div>

            <div>
              <label class="fw-semibold text-secondary mb-1">Tareas subidas</label>
              <div id="contenidosTarea" class="mb-3 d-flex flex-column gap-2">
              </div>
            </div>

            <div class="modal-footer border-0 px-0 pb-0 pt-4 d-flex justify-content-between align-items-center">

              <!-- IZQUIERDA: Avatar + Nombre -->
              <div id="asignadoFooter" class="d-flex align-items-center gap-2">
                <div id="avatarAsignado" class="task-avatar"></div>
                <span id="nombreAsignado" class="fw-semibold text-dark"></span>
              </div>

              <!-- DERECHA: Botones -->
              <div class="d-flex gap-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Subir Tarea</button>
              </div>

            </div>

          </form>

        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
  <script>
    document.addEventListener('click', function (e) {

      const isButton = e.target.closest('.task-dropdown-btn');
      const allDropdowns = document.querySelectorAll('.task-dropdown-wrapper');

      // Cerrar todos
      allDropdowns.forEach(dd => dd.classList.remove('open'));

      // Abrir solo el clicado
      if (isButton) {
        const wrapper = isButton.closest('.task-dropdown-wrapper');
        wrapper.classList.toggle('open');
      }
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {

      // 🟦 FIX: Prevenir que Bootstrap mueva o clone el modal (rompe el input file)
      var modalEl = document.getElementById('verTareaModal');
      modalEl.addEventListener('shown.bs.modal', function () {
        document.body.appendChild(modalEl);
      });
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

          // ASIGNADO DESDE JSON
          let asignado = {};
          try {
            asignado = JSON.parse(this.dataset.asignado);
          } catch (e) {
            asignado = null;
          }

          const avatarDiv = document.getElementById('avatarAsignado');
          const nombreSpan = document.getElementById('nombreAsignado');

          // Resetear contenido previo
          avatarDiv.innerHTML = '';

          if (asignado) {
            const nombre = asignado.nombre ?? "";
            const apellido = asignado.apellido ?? "";
            const imagen = asignado.imagen ?? null;

            // Mostrar nombre completo
            nombreSpan.textContent = `${nombre} ${apellido}`;

            // Si hay foto → usar imagen
            if (imagen) {
              avatarDiv.innerHTML = `
            <img src="/storage/${imagen}" alt="Foto perfil">
        `;
            } else {
              // Si no hay foto → usar iniciales
              const iniciales = (nombre.charAt(0) + apellido.charAt(0)).toUpperCase();

              avatarDiv.textContent = iniciales;

              // Color aleatorio bonito
              const colores = ["#2563eb", "#10b981", "#f59e0b", "#ef4444", "#8b5cf6"];
              const color = colores[(nombre.charCodeAt(0) + apellido.charCodeAt(0)) % colores.length];

              avatarDiv.style.background = color;
              avatarDiv.style.color = "white";
            }
          }


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
            tarjeta.className = 'contenido-linea';

            // GUARDAR ID DEL CONTENIDO EN LA TARJETA
            tarjeta.dataset.idContenido = item.id;

            // ===== ARCHIVO =====
            if (item.tipo === 'archivo') {
              const fileName = item.valor.split('/').pop();
              const fileUrl = `http://127.0.0.1:8000/storage/${item.valor}`;

              tarjeta.innerHTML = `
            <div class="contenido-izquierda d-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-text contenido-icono"></i>

                <a href="${fileUrl}" target="_blank" rel="noopener noreferrer" class="contenido-nombre">
                    ${fileName}
                </a>
            </div>

            <div class="d-flex align-items-center gap-2">
                <!-- DESCARGAR -->
                <a href="${fileUrl}" download class="btn btn-link p-0 contenido-descargar" title="Descargar archivo">
                    <i class="bi bi-download"></i>
                </a>

                <!-- ELIMINAR -->
                <button type="button" class="btn btn-link p-0 contenido-eliminar" title="Eliminar archivo">
                    <i class="bi bi-trash text-danger"></i>
                </button>
            </div>
        `;
            }

            // ===== TEXTO =====
            else if (item.tipo === 'texto') {
              tarjeta.innerHTML = `
            <div class="contenido-izquierda">
                <i class="bi bi-card-text contenido-icono"></i>
                <div>
                    <div class="contenido-label">Comentario/Link</div>
                    <div class="contenido-texto">${item.valor}</div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-link p-0 contenido-eliminar" title="Eliminar archivo">
                    <i class="bi bi-trash text-danger"></i>
                </button>
            </div>
        `;
            }

            // ===== LINK =====
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

            // AÑADIR LA TARJETA AL CONTENEDOR
            contenedor.appendChild(tarjeta);

            // ===============================
            // ✅ AGREGAR EVENTO ELIMINAR AQUÍ
            // ===============================
            const btnEliminar = tarjeta.querySelector('.contenido-eliminar');
            if (btnEliminar) {
              btnEliminar.addEventListener('click', function () {
                const idContenido = tarjeta.dataset.idContenido;
                eliminarArchivo(idContenido, tarjeta);
              });
            }

          });

          // Agregar listeners a botones eliminar cuando se cargan las tarjetas

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

      let archivosSeleccionados = [];

      // Cuando el usuario selecciona archivos (puede hacerlo en VARIAS tandas)
      fileInput.addEventListener('change', function () {

        if (!this.files || this.files.length === 0) return;

        for (let file of this.files) {
          archivosSeleccionados.push(file);
        }

        // Crear FileList REAL
        const dataTransfer = new DataTransfer();
        archivosSeleccionados.forEach(f => dataTransfer.items.add(f));
        fileInput.files = dataTransfer.files;

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

        // Asignar eventos a los botones de eliminar
        listaArchivosDiv.querySelectorAll('.archivo-eliminar').forEach(btn => {
          btn.addEventListener('click', () => {
            const i = parseInt(btn.dataset.index, 10);

            // Quitar del array
            archivosSeleccionados.splice(i, 1);

            // Reconstruir FileList y reasignar al input
            const dt = new DataTransfer();
            archivosSeleccionados.forEach(f => dt.items.add(f));
            fileInput.files = dt.files;

            // Volver a pintar la lista
            renderListaArchivos();
          });
        });
      }

      const form = document.querySelector('#verTareaModal form');
      form.addEventListener('submit', function () {
        // Pasar contenido de Quill al input hidden
        document.getElementById('texto').value = quill.root.innerHTML;
      });

      let deleteId = null;
      let deleteCard = null;

      // Función bonita de confirmación
      function eliminarArchivo(idContenido, tarjetaElemento) {

        if (!confirm("¿Seguro que deseas eliminar este archivo?")) return;

        fetch(`http://127.0.0.1:8000/api/tareas/eliminar/${idContenido}`, {
          method: 'DELETE',
          headers: { 'Content-Type': 'application/json' },
        })
          .then(res => res.json())
          .then(data => {
            if (data.status === "success") {
              tarjetaElemento.remove();  // quitar visualmente
            } else {
              alert("No se pudo eliminar el archivo");
            }
          })
          .catch(() => alert("Error al conectar con el servidor."));
      }

    });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const alertContainer = document.getElementById('custom-alert-container');

      // Mostrar alert success
      @if(session('success'))
        showCustomAlert("{{ session('success') }}", "success");
      @endif

      // Mostrar alert error
      @if(session('error'))
        showCustomAlert("{{ session('error') }}", "error");
      @endif

        function showCustomAlert(message, type = "success") {
          const alert = document.createElement('div');
          alert.classList.add(
            "custom-alert",
            type === "success" ? "custom-alert-success" : "custom-alert-error"
          );

          alert.innerHTML = `
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <span>${message}</span>
                <button style="border:none; background:none; color:white; font-size:18px; line-height:14px; cursor:pointer;">×</button>
            </div>
        `;

          // añadir al contenedor
          alertContainer.appendChild(alert);

          // botón de cerrar
          alert.querySelector("button").addEventListener("click", () => removeAlert(alert));

          // auto cerrar en 4 segundos
          setTimeout(() => removeAlert(alert), 4000);
        }

      function removeAlert(alert) {
        alert.style.animation = "slideUp 0.4s ease forwards";
        setTimeout(() => alert.remove(), 400);
      }
    });
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {

      const urlApi = "http://127.0.0.1:8000/api";

      // Cuando el usuario cambie el estado de la tarea
      document.querySelectorAll(".estado-radio").forEach(radio => {
        radio.addEventListener("change", function () {

          const nuevoEstado = this.value;
          const idTarea = document.querySelector("#verTareaModal #id_tarea").value;
          console.log("ID recibido en cambio de estado:", idTarea);

          fetch(`${urlApi}/tareas/cambiar-estado/${idTarea}`, {
            method: "PATCH",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ estado: nuevoEstado })
          })
            .then(res => res.json())
            .then(data => {
              if (data.status === "success") {

                const card = document.querySelector(`.kanban-task[data-id="${idTarea}"]`);

                if (card) {

                  // 🔄 ACTUALIZAR EL DATA-ESTADO
                  const btnSubir = card.querySelector(".subir-task");
                  if (btnSubir) btnSubir.dataset.estado = nuevoEstado;

                  // 1️⃣ ANIMACIÓN DE SALIDA
                  card.style.transition = "0.3s";
                  card.style.opacity = "0";
                  card.style.transform = "translateX(30px)";

                  setTimeout(() => {

                    // 2️⃣ MOVER TARJETA A LA NUEVA COLUMNA
                    const columnas = {
                      "Por hacer": ".kanban-column:nth-child(1) .kanban-tasks",
                      "En proceso": ".kanban-column:nth-child(2) .kanban-tasks",
                      "Revision": ".kanban-column:nth-child(3) .kanban-tasks",
                      "Hecho": ".kanban-column:nth-child(4) .kanban-tasks"
                    };

                    const nuevaColumna = document.querySelector(columnas[nuevoEstado]);
                    nuevaColumna.prepend(card); // también puede ser append

                    // 3️⃣ ANIMACIÓN DE ENTRADA
                    setTimeout(() => {
                      card.style.opacity = "1";
                      card.style.transform = "scale(1.02)";
                    }, 150);

                    setTimeout(() => {
                      card.style.transform = "scale(1)";
                    }, 350);

                  }, 300);
                }

                showCustomAlert("Estado actualizado", "success");
              } else {
                showCustomAlert("No se pudo actualizar el estado", "error");
              }
            })
            .catch(() => {
              showCustomAlert("Error de conexión", "error");
            });

        });
      });

    });
  </script>


</body>

</html>
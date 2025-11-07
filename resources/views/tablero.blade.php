<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Kanban - E-commerce Redesign</title>

  <!-- Bootstrap y Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #f7f9fc, #eaeef5);
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    .kanban-header {
      background: linear-gradient(90deg, #0d2a5c, #173b8f);
      color: white;
      padding: 1.8rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
      border-bottom: 4px solid #00b0ff;
    }

    .kanban-title h2 {
      font-weight: 800;
      margin-bottom: 0.3rem;
      letter-spacing: 0.5px;
    }

    .kanban-title small i {
      margin-right: 5px;
    }

    .progress {
      height: 12px;
      border-radius: 8px;
      overflow: hidden;
      background: rgba(255, 255, 255, 0.2);
    }

    .progress-bar {
      background: #00b0ff;
    }

    .kanban-board {
      padding: 2rem;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 1.5rem;
      max-width: 1600px;
      margin: auto;
    }

    .kanban-column {
      background: #fff;
      border-radius: 15px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
      transition: all 0.25s ease;
      border: 1px solid #e5e7eb;
    }

    .kanban-column:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .kanban-column-header {
      padding: 0.9rem 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 600;
      font-size: 1rem;
    }

    .kanban-column-header button {
      border: none;
      background: rgba(255, 255, 255, 0.25);
      color: inherit;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.2s ease;
    }

    .kanban-column-header button:hover {
      background: rgba(255, 255, 255, 0.5);
    }

    .kanban-tasks {
      padding: 1rem;
      display: flex;
      flex-direction: column;
      gap: 0.8rem;
      max-height: 500px;
      overflow-y: auto;
      scrollbar-width: thin;
      scrollbar-color: #cfcfcf transparent;
    }

    .kanban-tasks::-webkit-scrollbar {
      width: 6px;
    }

    .kanban-tasks::-webkit-scrollbar-thumb {
      background: #cfcfcf;
      border-radius: 6px;
    }

    .kanban-task {
      background: #fff;
      border: 1px solid #e3e3e3;
      border-radius: 10px;
      padding: 0.85rem;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
      transition: all 0.25s ease;
      cursor: grab;
    }

    .kanban-task:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      transform: translateY(-2px);
    }

    .kanban-task-title {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 600;
      margin-bottom: 0.4rem;
    }

    .kanban-task p {
      font-size: 0.87rem;
      color: #6c757d;
      margin-bottom: 0.6rem;
    }

    .kanban-task-footer {
      display: flex;
      justify-content: space-between;
      font-size: 0.8rem;
      color: #6c757d;
    }

    .kanban-task-footer i {
      margin-right: 5px;
    }

    .badge {
      font-size: 0.7rem;
      padding: 0.4em 0.6em;
      border-radius: 20px;
      text-transform: capitalize;
      letter-spacing: 0.5px;
    }

    @keyframes fadeInUp {
      0% {
        opacity: 0;
        transform: translateY(10px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .kanban-column,
    .kanban-task {
      animation: fadeInUp 0.4s ease both;
    }

    .btn-exit-pro {
      background: rgba(255, 255, 255, 0.12);
      border: 1px solid rgba(255, 255, 255, 0.25);
      color: #fff;
      font-weight: 500;
      border-radius: 30px;
      padding: 0.5rem 1rem;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .btn-exit-pro:hover {
      background: linear-gradient(90deg, #ff4e50, #f9d423);
      color: #fff;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .btn-exit-pro i {
      font-size: 1.2rem;
    }

    .btn-exit-pro span {
      font-size: 0.95rem;
    }
  </style>
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
          {{ \Carbon\Carbon::parse($proyecto['fecha_entrega'])->format('d-m-Y') }}</small>
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
      <button class="btn-exit-pro d-flex align-items-center gap-2 px-3">
        <i class="bi bi-box-arrow-right fs-5"></i>
        <span>Salir</span>
      </button>
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
                    </ul>
                  </div>
                </div>
              </div>
              <p>{{ $tarea['descripcion'] }}</p>
              <div class="kanban-task-footer d-flex justify-content-between">
                <span><i class="bi bi-person-circle"></i> {{ $tarea['id_asignado'] }}</span>
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
        <form id="taskForm">
          <div class="modal-header">
            <h5 class="modal-title" id="taskModalLabel">Nueva Tarea</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="taskTitle" class="form-label">Título</label>
              <input type="text" class="form-control" id="taskTitle" required>
            </div>
            <div class="mb-3">
              <label for="taskDesc" class="form-label">Descripción</label>
              <textarea class="form-control" id="taskDesc" rows="3"></textarea>
            </div>
            <div class="mb-3">
              <label for="taskPriority" class="form-label">Prioridad</label>
              <select class="form-select" id="taskPriority">
                <option value="alta">Alta</option>
                <option value="media">Media</option>
                <option value="baja" selected>Baja</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="taskDueDate" class="form-label">Fecha de entrega</label>
              <input type="date" class="form-control" id="taskDueDate">
            </div>
            <div class="mb-3">
              <label for="taskAssignee" class="form-label">Responsable</label>
              <select class="form-select" id="taskAssignee">
                <option value="Ana Andrade">Ana Andrade</option>
                <option value="Jose Romero">Jose Romero</option>
                <option value="Maria Lopez">Maria Lopez</option>
                <option value="Hugo Hurtado">Hugo Hurtado</option>
                <option value="Gabriel Romero">Gabriel Romero</option>
                <option value="Julián Collins">Julián Collins</option>
              </select>
            </div>
            <input type="hidden" id="taskColumn">
            <input type="hidden" id="taskIndex">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    let draggedTask = null;

    function allowDrag(task) {
      task.setAttribute('draggable', true);
      task.addEventListener('dragstart', () => draggedTask = task);
      task.addEventListener('dragend', () => draggedTask = null);
    }

    document.addEventListener('DOMContentLoaded', () => {
      const taskForm = document.getElementById('taskForm');
      const taskTitle = document.getElementById('taskTitle');
      const taskDesc = document.getElementById('taskDesc');
      const taskPriority = document.getElementById('taskPriority');
      const taskDueDate = document.getElementById('taskDueDate');
      const taskAssignee = document.getElementById('taskAssignee');
      const taskColumnInput = document.getElementById('taskColumn');
      const taskIndexInput = document.getElementById('taskIndex');

      // Configurar columnas para drop
      document.querySelectorAll('.kanban-tasks').forEach(column => {
        column.addEventListener('dragover', e => e.preventDefault());
        column.addEventListener('drop', e => {
          if (draggedTask) column.appendChild(draggedTask);
        });
      });

      document.querySelectorAll('.btn-add-task').forEach(btn => {
        btn.addEventListener('click', () => {
          taskForm.reset();
          taskIndexInput.value = '';
          taskColumnInput.value = btn.getAttribute('data-column');
          document.getElementById('taskModalLabel').textContent = 'Nueva Tarea';
        });
      });

      taskForm.addEventListener('submit', e => {
        e.preventDefault();
        const columnName = taskColumnInput.value;
        const taskContainer = Array.from(document.querySelectorAll('.kanban-column')).find(col =>
          col.querySelector('.kanban-column-header span').textContent === columnName
        ).querySelector('.kanban-tasks');

        const badgeClass = taskPriority.value === 'alta' ? 'danger' : taskPriority.value === 'media' ? 'warning text-dark' : 'success';

        if (taskIndexInput.value !== '') {
          const taskDiv = taskContainer.children[taskIndexInput.value];
          taskDiv.querySelector('.kanban-task-title span').textContent = taskTitle.value;
          const badge = taskDiv.querySelector('.badge');
          badge.textContent = taskPriority.value;
          badge.className = `badge bg-${badgeClass}`;
          taskDiv.querySelector('p').textContent = taskDesc.value;
          taskDiv.querySelectorAll('.kanban-task-footer span')[0].innerHTML = `<i class="bi bi-person-circle"></i> ${taskAssignee.value}`;
          taskDiv.querySelectorAll('.kanban-task-footer span')[1].textContent = taskDueDate.value || '--/--/----';
        } else {
          const taskDiv = document.createElement('div');
          taskDiv.classList.add('kanban-task');
          taskDiv.innerHTML = `
        <div class="kanban-task-title d-flex justify-content-between align-items-center">
          <span>${taskTitle.value}</span>
          <div class="d-flex align-items-center gap-2">
            <span class="badge bg-${badgeClass}">${taskPriority.value}</span>
            <div class="dropdown">
              <button class="btn btn-sm btn-light p-0" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots-vertical"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item edit-task" href="#">Editar</a></li>
                <li><a class="dropdown-item delete-task" href="#">Eliminar</a></li>
              </ul>
            </div>
          </div>
        </div>
        <p>${taskDesc.value}</p>
        <div class="kanban-task-footer d-flex justify-content-between">
          <span><i class="bi bi-person-circle"></i> ${taskAssignee.value}</span>
          <span>${taskDueDate.value || '--/--/----'}</span>
        </div>
      `;
          taskContainer.appendChild(taskDiv);
          allowDrag(taskDiv);

          taskDiv.querySelector('.edit-task').addEventListener('click', e => {
            e.preventDefault();
            taskTitle.value = taskDiv.querySelector('.kanban-task-title span').textContent;
            taskDesc.value = taskDiv.querySelector('p').textContent;
            const badgeText = taskDiv.querySelector('.badge').textContent;
            taskPriority.value = badgeText.toLowerCase();
            taskDueDate.value = taskDiv.querySelectorAll('.kanban-task-footer span')[1].textContent;
            taskAssignee.value = taskDiv.querySelectorAll('.kanban-task-footer span')[0].textContent.replace('Ana Andrade', 'Ana Andrade').trim();
            taskColumnInput.value = columnName;
            taskIndexInput.value = Array.from(taskContainer.children).indexOf(taskDiv);
            new bootstrap.Modal(document.getElementById('taskModal')).show();
          });

          taskDiv.querySelector('.delete-task').addEventListener('click', e => {
            e.preventDefault();
            taskDiv.remove();
          });
        }

        bootstrap.Modal.getInstance(document.getElementById('taskModal')).hide();
      });
    });
  </script>

</body>

</html>
<div class="kanban-task" data-id="{{ $tarea['id'] }}">

    <div class="d-flex justify-content-between align-items-start">

        <div>
            <span class="priority-pill 
                                        {{ $tarea['prioridad'] == 'Alta' ? 'priority-high' :
    ($tarea['prioridad'] == 'Media' ? 'priority-medium' : 'priority-low') }}">
                {{ $tarea['prioridad'] }}
            </span>

            <div class="kanban-task-title-text mt-2">
                {{ $tarea['titulo'] }}
            </div>

            <p class="kanban-task-desc">
                {{ $tarea['descripcion'] }}
            </p>
        </div>

        <!-- DROPDOWN CUSTOM -->
        <div class="task-dropdown-wrapper">
            <button class="task-dropdown-btn">
                <i class="bi bi-three-dots-vertical"></i>
            </button>

            <div class="task-dropdown-menu">
                <a href="#" class="edit-task">Editar</a>
                <a href="#" class="delete-task">Eliminar</a>
                <a href="#" class="subir-task" data-id="{{ $tarea['id'] }}" data-titulo="{{ $tarea['titulo'] }}"
                    data-descripcion="{{ $tarea['descripcion'] }}" data-estado="{{ $tarea['estado'] }}"
                    data-contenido='@json($tarea["contenidos"])' data-asignado='@json($tarea["asignado"])'>
                    Subir contenido
                </a>

            </div>
        </div>
    </div>

    <div class="kanban-task-footer">
        <span><i class="bi bi-calendar-event"></i>
            {{ \Carbon\Carbon::parse($tarea['fecha_vencimiento'])->format('d M') }}
            </span> <span class="task-avatar">
            {{ substr($tarea['asignado']['nombre'], 0, 1) }}{{ substr($tarea['asignado']['apellido'], 0, 1) }}
        </span>
    </div>

</div>
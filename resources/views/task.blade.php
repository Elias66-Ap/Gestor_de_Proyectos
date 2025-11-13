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
        <span><i class="bi bi-person-circle"></i> {{ $tarea['asignado']['nombre'] }}</span>
        <span>{{ \Carbon\Carbon::parse($tarea['fecha_vencimiento'])->format('d-m-Y') }}</span>
    </div>
</div>

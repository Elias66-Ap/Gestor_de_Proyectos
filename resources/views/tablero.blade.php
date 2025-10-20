<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Kanban - E-commerce Redesign</title>

    {{-- Bootstrap y Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f7f9fc, #eaeef5);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Header */
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
            background: rgba(255,255,255,0.2);
        }
        .progress-bar {
            background: #00b0ff;
        }

        /* Board */
        .kanban-board {
            padding: 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.5rem;
            max-width: 1600px;
            margin: auto;
        }

        /* Columns */
        .kanban-column {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: all 0.25s ease;
            border: 1px solid #e5e7eb;
        }
        .kanban-column:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
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
            background: rgba(255,255,255,0.25);
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
            background: rgba(255,255,255,0.5);
        }

        /* Tasks */
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
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
            transition: all 0.25s ease;
        }
        .kanban-task:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
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

        /* Badges con más estilo */
        .badge {
            font-size: 0.7rem;
            padding: 0.4em 0.6em;
            border-radius: 20px;
            text-transform: capitalize;
            letter-spacing: 0.5px;
        }

        /* Animaciones */
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

    {{-- HEADER --}}
    <div class="kanban-header">
    <div class="kanban-title d-flex align-items-center gap-2">
        <div>
            <h2>E-commerce Redesign</h2>
            <small>
                <i class="bi bi-people"></i> 8 miembros &nbsp; | &nbsp;
                <i class="bi bi-calendar-event"></i> Entrega 28-06-2025
            </small>
        </div>
    </div>
    <div class="d-flex align-items-center gap-4 mt-3 mt-md-0">
        <div class="text-end">
            <p class="mb-1">Progreso General</p>
            <div class="progress" style="width: 220px;">
                <div class="progress-bar" role="progressbar" style="width: 75%;"></div>
            </div>
            <small>75%</small>
        </div>
        <button class="btn-exit-pro d-flex align-items-center gap-2 px-3">
            <i class="bi bi-box-arrow-right fs-5"></i>
            <span>Salir</span>
        </button>
    </div>
</div>

    {{-- TABLERO --}}
    <div class="kanban-board">

        {{-- Por hacer --}}
        <div class="kanban-column">
            <div class="kanban-column-header text-secondary bg-light">
                <span>Por hacer</span>
                <button><i class="bi bi-plus-lg"></i></button>
            </div>
            <div class="kanban-tasks">
                <div class="kanban-task">
                    <div class="kanban-task-title">
                        <span>Diseño de Wireframes</span>
                        <span class="badge bg-danger">alta</span>
                    </div>
                    <p>Crear diseños para las páginas principales.</p>
                    <div class="kanban-task-footer">
                        <span><i class="bi bi-person-circle"></i> Ana Andrade</span>
                        <span>31/05/2025</span>
                    </div>
                </div>

                <div class="kanban-task">
                    <div class="kanban-task-title">
                        <span>Configurar bases de datos</span>
                        <span class="badge bg-success">baja</span>
                    </div>
                    <p>Establecer esquemas y conexiones.</p>
                    <div class="kanban-task-footer">
                        <span><i class="bi bi-person-circle"></i> Jose Romero</span>
                        <span>02/06/2025</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- En proceso --}}
        <div class="kanban-column">
            <div class="kanban-column-header text-white" style="background:#0d6efd;">
                <span>En proceso</span>
                <button><i class="bi bi-plus-lg"></i></button>
            </div>
            <div class="kanban-tasks">
                <div class="kanban-task">
                    <div class="kanban-task-title">
                        <span>Implementar Autenticación</span>
                        <span class="badge bg-warning text-dark">media</span>
                    </div>
                    <p>Sistema login y registro de usuarios.</p>
                    <div class="kanban-task-footer">
                        <span><i class="bi bi-person-circle"></i> Maria Lopez</span>
                        <span>02/06/2025</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- En revisión --}}
        <div class="kanban-column">
            <div class="kanban-column-header text-dark bg-warning">
                <span>En revisión</span>
                <button><i class="bi bi-plus-lg"></i></button>
            </div>
            <div class="kanban-tasks">
                <div class="kanban-task">
                    <div class="kanban-task-title">
                        <span>Testing de componentes</span>
                        <span class="badge bg-success">baja</span>
                    </div>
                    <p>Pruebas unitarias de integración.</p>
                    <div class="kanban-task-footer">
                        <span><i class="bi bi-person-circle"></i> Hugo Hurtado</span>
                        <span>02/06/2025</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Hecho --}}
        <div class="kanban-column">
            <div class="kanban-column-header text-white bg-success">
                <span>Hecho</span>
                <button><i class="bi bi-plus-lg"></i></button>
            </div>
            <div class="kanban-tasks">
                <div class="kanban-task">
                    <div class="kanban-task-title">
                        <span>Configuración Inicial</span>
                        <span class="badge bg-danger">alta</span>
                    </div>
                    <p>Setup del proyecto y dependencias.</p>
                    <div class="kanban-task-footer">
                        <span><i class="bi bi-person-circle"></i> Gabriel Romero</span>
                        <span>02/06/2025</span>
                    </div>
                </div>

                <div class="kanban-task">
                    <div class="kanban-task-title">
                        <span>Documentación API</span>
                        <span class="badge bg-danger">alta</span>
                    </div>
                    <p>Documentación endpoints y schemas.</p>
                    <div class="kanban-task-footer">
                        <span><i class="bi bi-person-circle"></i> Julián Collins</span>
                        <span>02/06/2025</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>

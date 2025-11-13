@extends('layouts.app_lider')

@section('styles')
  <link rel="stylesheet" href="{{ asset('css/proyecto.css') }}">
@endsection

@section('content1')

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <main class="container py-4">
    <!-- TARJETAS DE RESUMEN -->
    <div class="resumen-cajas d-flex justify-content-between flex-wrap mb-4">
      <div class="card-resumen shadow-sm border-0 rounded-4 p-3 flex-fill mx-2 text-center bg-light">
        <h6 class="text-muted">Proyectos activos</h6>
        <h2 id="proy_activos" class="fw-bold text-primary">0</h2>
        <p class="text-secondary small mb-0">En desarrollo</p>
      </div>
      <div class="card-resumen shadow-sm border-0 rounded-4 p-3 flex-fill mx-2 text-center bg-light">
        <h6 class="text-muted">Proyectos en pausa</h6>
        <h2 id="proy_pausa" class="fw-bold text-warning">0</h2>
        <p class="text-secondary small mb-0">Pausado</p>
      </div>
      <div class="card-resumen shadow-sm border-0 rounded-4 p-3 flex-fill mx-2 text-center bg-light">
        <h6 class="text-muted">Proyectos completados</h6>
        <h2 id="proy_completados" class="fw-bold text-success">0</h2>
        <p class="text-secondary small mb-0">Finalizados</p>
      </div>
    </div>

    <!-- CONTENEDOR PRINCIPAL -->
    <div class="contenedor">

      <!-- ENCABEZADO -->
      <div class="proyecto-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark mb-0">Proyectos</h2>

        <div class="d-flex align-items-center gap-3">
          <a href="#" id="filtroFecha" class="text-decoration-none text-secondary hover-underline">📅 Fecha</a>
          <a href="#" id="filtroProgreso" class="text-decoration-none text-secondary hover-underline">📈 Progreso</a>
          <button id="boton" data-bs-toggle="modal" data-bs-target="#modalProyecto"
            class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
            + Nuevo
          </button>
        </div>
      </div>

      @foreach($proyectos as $proyecto)
          <div class="card shadow-sm border-0 rounded-4 mb-4 overflow-hidden" id="tarjeta-{{ $proyecto['id'] }}">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                  <h5 class="fw-bold mb-1 text-dark">{{ $proyecto['nombre'] }}</h5>
                </div>
                {{-- Opciones --}}
                <div class="dropdown">
                  <button class="btn btn-sm btn-outline-secondary rounded-pill" type="button"
                    id="dropdownMenuButton-{{ $proyecto['id'] }}" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-three-dots"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton-{{ $proyecto['id'] }}">
                    <li>
                      <a class="dropdown-item btn-ver-miembros" href="#" data-proyecto-id="{{ $proyecto['id'] }}">
                        <i class="bi bi-eye me-2"></i> Ver detalle
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item btn-asignar-miembros" href="#" data-proyecto-id="{{ $proyecto['id'] }}">
                        <i class="bi bi-person-plus me-2"></i> Asignar miembros
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item btn-ver-tablero" href="{{ route('tablero.proyecto', $proyecto['id']) }}">
                        <i class="bi bi-clipboard"></i> Ver tablero
                      </a>
                    </li>
                  </ul>
                </div>

              </div>

              <p class="text-muted mb-4" style="line-height: 1.5; max-width: 700px;">
                {{ \Illuminate\Support\Str::limit(
          $proyecto['descripcion_breve'] ?? $proyecto['descripcion'] ?? 'Sin descripción breve disponible.',
          160
        ) }}
                @if(strlen($proyecto['descripcion_breve'] ?? '') > 160)
                  <a href="#" class="text-decoration-none small text-primary">Ver más</a>
                @endif
              </p>

              <div class="row g-4 align-items-center mb-3">
                <div class="col-6 col-md-3">
                  <small class="text-secondary">📅 Fecha inicio</small><br>
                  <strong>{{ $proyecto['fecha_inicio'] ? \Carbon\Carbon::parse($proyecto['fecha_inicio'])->translatedFormat('d F Y') : '—' }}</strong>
                </div>
                <div class="col-6 col-md-3">
                  <small class="text-secondary">⏰ Fecha entrega</small><br>
                  <strong>{{ $proyecto['fecha_entrega'] ? \Carbon\Carbon::parse($proyecto['fecha_entrega'])->translatedFormat('d F Y') : '—' }}</strong>
                </div>
                <div class="col-6 col-md-3">
                  <small class="text-secondary">👥 Miembros</small><br>
                  <strong>{{ $proyecto['miembros_count'] ?? 0 }}</strong>
                </div>
                <div class="col-6 col-md-3 text-md-end">
                  <small class="text-secondary">Progreso</small>
                  <div class="mt-2">
                    <progress value="{{ $proyecto['progreso'] }}" max="100" class="w-100" style="height: 10px;">
                      {{ $proyecto['progreso'] }}%
                    </progress>
                  </div>
                  <small class="d-block mt-1 text-secondary">{{ $proyecto['progreso'] }}%</small>
                </div>
              </div>

            </div>
          </div>
      @endforeach
    </div>
    <div id="lider-info" data-id="{{ auth()->guard('usuario')->user()->id }}"></div>
  </main>
  @include('lider.asignar_miembros')
  @include('lider.miembros')
  @include('lider.registrar-proyecto')

@endsection
@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const modal = new bootstrap.Modal(document.getElementById('modalDetalleProyecto'));

      document.querySelectorAll('.btn-ver-miembros').forEach(btn => {
        btn.addEventListener('click', async (e) => {
          e.preventDefault();

          const id = btn.getAttribute('data-proyecto-id');

          try {
            const response = await fetch('http://127.0.0.1:8000/api/ver-proyecto/' + id);
            const data = await response.json();

            // Datos del proyecto
            document.getElementById('modalProyectoNombre').textContent = data.proyecto.nombre;
            document.getElementById('modalProyectoDescripcion').textContent = data.proyecto.descripcion_detalle ?? '';
            document.getElementById('modalProyectoId').value = data.proyecto.id;

            // Lista de miembros asignados
            const lista = document.getElementById('listaMiembrosAsignados');
            lista.innerHTML = '';

            if (data.miembros.length === 0) {
              lista.innerHTML = '<li class="text-muted text-center">No hay miembros asignados</li>';
            } else {
              data.miembros.forEach(m => {
                const li = document.createElement('li');
                li.className = 'd-flex align-items-center gap-2 py-2';
                li.innerHTML = `
                              <span class="d-inline-block bg-success rounded-circle p-1"></span>
                              ${m.nombre} ${m.apellido ?? ''}
                            `;
                lista.appendChild(li);
              });
            }

            modal.show();
          } catch (error) {
            console.error('Error al cargar el proyecto:', error);
          }
        });
      });
    });

    document.addEventListener('DOMContentLoaded', () => {
      const modalAsignar = new bootstrap.Modal(document.getElementById('modalAsignarMiembros'));
      const selectMiembros = document.getElementById('selectMiembros');
      const proyectoIdInput = document.getElementById('modalAsignarProyectoId');
      const listaSeleccionados = document.getElementById('listaSeleccionados');
      let seleccionados = []; // Array para guardar IDs seleccionados

      // Abrir modal y cargar colaboradores
      document.querySelectorAll('.btn-asignar-miembros').forEach(btn => {
        btn.addEventListener('click', async (e) => {
          e.preventDefault();

          const proyectoId = btn.getAttribute('data-proyecto-id');
          proyectoIdInput.value = proyectoId;

          try {
            const response = await fetch('http://127.0.0.1:8000/api/colaboradores');
            const data = await response.json();

            selectMiembros.innerHTML = '<option selected disabled>Seleccione un colaborador</option>';

            if (data.data && data.data.length > 0) {
              data.data.forEach(m => {
                const option = document.createElement('option');
                option.value = m.id;
                option.textContent = `${m.perfil.nombre} ${m.perfil.apellido ?? ''}`;
                selectMiembros.appendChild(option);
              });
            } else {
              const option = document.createElement('option');
              option.textContent = 'No hay miembros disponibles';
              option.disabled = true;
              selectMiembros.appendChild(option);
            }

            // Reiniciar lista visual y array
            seleccionados = [];
            actualizarListaVisual();

            modalAsignar.show();
          } catch (error) {
            console.error('Error al cargar los miembros:', error);
          }
        });
      });

      // Agregar miembro seleccionado al hacer cambio en el select
      selectMiembros.addEventListener('change', () => {
        const valor = selectMiembros.value;
        const texto = selectMiembros.selectedOptions[0].textContent;

        if (valor && !seleccionados.find(s => s.id == valor)) {
          seleccionados.push({ id: valor, nombre: texto });
          actualizarListaVisual();
        }

        // Resetear select a placeholder
        selectMiembros.selectedIndex = 0;
      });

      // Función para actualizar la lista visual
      function actualizarListaVisual() {
        listaSeleccionados.innerHTML = '';
        if (seleccionados.length === 0) {
          listaSeleccionados.innerHTML = '<li class="text-muted text-center">No hay miembros seleccionados</li>';
          return;
        }

        seleccionados.forEach(s => {
          const li = document.createElement('li');
          li.className = 'list-group-item d-flex justify-content-between align-items-center';
          li.innerHTML = `${s.nombre}
              <span class="badge bg-danger cursor-pointer" onclick="quitarSeleccion('${s.id}')">x</span>`;
          listaSeleccionados.appendChild(li);
        });
      }

      // Función global para quitar un miembro
      window.quitarSeleccion = function (id) {
        seleccionados = seleccionados.filter(s => s.id != id);
        actualizarListaVisual();
      }

      // Cuando se envíe el formulario, crear inputs hidden con los ids
      document.getElementById('formAsignarMiembros').addEventListener('submit', (e) => {
        // Limpiar inputs antiguos
        document.querySelectorAll('#formAsignarMiembros input[name="id_usuarios[]"]').forEach(i => i.remove());

        seleccionados.forEach(s => {
          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'id_usuarios[]';
          input.value = s.id;
          document.getElementById('formAsignarMiembros').appendChild(input);
        });
      });
    });

  </script>
  <script src="{{ asset('js/dashboard_lider.js') }}"></script>
@endsection
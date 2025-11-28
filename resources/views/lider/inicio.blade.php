@extends('layouts.app_lider')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/lider/inicio.css') }}">
@endsection
@section('content1')

  <main>


    {{-- -NUEVOSOS --}}
    <div class="row g-4 mb-5">
      <div class="col-md-3">
        <div class="stat-card">
          <span class="stat-badge" id="var_creadas">+2 esta semana</span>
          <div class="stat-icon icon-blue">
            <i class="bi bi-kanban-fill"></i>
          </div>
          <div class="stat-value" id="tar_creadas">12</div>
          <div class="stat-label">Tareas Creadas</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <span class="stat-badge" id="var_asignadas">+1 desde ayer</span>
          <div class="stat-icon icon-orange">
            <i class="bi bi-check-circle-fill"></i>
          </div>
          <div class="stat-value" id="tar_asignadas">2</div>
          <div class="stat-label">Tareas asignadas</div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="stat-card">
          <span class="stat-badge" id="pro_activos_var">+4 este mes</span>
          <div class="stat-icon icon-green">
            <i class="bi bi-trophy-fill"></i>
          </div>
          <div class="stat-value" id="pro_activos">4</div>
          <div class="stat-label">Proyectos activos</div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-icon icon-pink">
            <span class="stat-badge" id="pro_completados_var">+4 este mes</span>
            <i class="bi bi-speedometer2"></i>
          </div>
          <div class="stat-value" id="pro_completados">70%</div>
          <div class="stat-label">Proyectos completados</div>
        </div>
      </div>
    </div>



    {{-- ==== GRÁFICOS ==== --}}
    <div class="row g-4 justify-content-center">

      {{-- === Tareas (gráfico de líneas con cambio de mes) === --}}
      <div class="col-lg-7 col-md-10">
        <div class="card shadow-sm border-0 rounded-4 p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">📈 Tareas Completadas vs Pendientes</h5>
            <select id="mesSelector" class="form-select w-auto">
              <option value="enero">Enero</option>
              <option value="febrero">Febrero</option>
              <option value="marzo">Marzo</option>
              <option value="abril">Abril</option>
              <option value="mayo" selected>Mayo</option>
              <option value="junio">Junio</option>
              <option value="julio">Julio</option>
              <option value="agosto">Agosto</option>
              <option value="septiembre">Septiembre</option>
              <option value="octubre">Octubre</option>
              <option value="noviembre">Noviembre</option>
              <option value="diciembre">Diciembre</option>
            </select>
          </div>
          <canvas id="tareasChart" width="230" height="130"></canvas>
        </div>
      </div>

      {{-- Proyectos (doughnut) --}}
      <div class="col-lg-4 col-md-6">
        <div class="card shadow-sm border-0 rounded-4 p-3 h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0">📊 Proyectos Activos vs Terminados</h6>
            <select id="selectProyectos" class="form-select w-auto">
              <option value="0">Enero</option>
              <option value="1">Febrero</option>
              <option value="2">Marzo</option>
              <option value="3">Abril</option>
              <option value="4">Mayo</option>
              <option value="5">Junio</option>
              <option value="6">Julio</option>
              <option value="7">Agosto</option>
              <option value="8">Septiembre</option>
              <option value="9">Octubre</option>
              <option value="10">Noviembre</option>
              <option value="11">Diciembre</option>
            </select>
          </div>
          <canvas id="proyectosChart" height="200"></canvas>
        </div>
      </div>

      {{-- Productividad --}}

    </div>

    </div>
    <div class="text-center mb-5">
      <h2 class="fw-bold">Accesos rápidos</h2>
    </div>
    <div class="resumen-cajas d-flex justify-content-center flex-wrap gap-4">

      <div class="card-resumen text-center shadow-sm border-0 rounded-4 p-4">
        <button id="boton" class="btn btn-outline-success w-100" data-bs-toggle="modal" data-bs-target="#modalProyecto">
          <i class="bi bi-plus-circle me-2"></i>Nuevo proyecto
        </button>
      </div>

      <div class="card-resumen text-center shadow-sm border-0 rounded-4 p-4">
        <button class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#modalMensaje">
          <i class="bi bi-envelope-plus me-2"></i>Nuevo mensaje
        </button>
      </div>
    </div>
    <!-- Obtenemos el Id-->
    <div id="lider-info" data-id="{{ auth()->guard('usuario')->user()->id }}"></div>
  </main>
  {{-- ==== LIBRERÍAS ==== --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  {{-- ==== SCRIPT: NUEVO GRÁFICO DE TAREAS ==== --}}
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Datos de ejemplo por mes (reemplaza con fetch si quieres datos reales)
      const datosPorMes = {
        tareas: [{
          completadas: [100, 120, 150, 180, 160, 170],
          pendientes: [60, 55, 70, 65, 60, 50]
        },
        {
          completadas: [130, 140, 155, 170, 180, 190],
          pendientes: [70, 65, 60, 55, 50, 45]
        },
        {
          completadas: [150, 160, 180, 200, 210, 220],
          pendientes: [50, 55, 60, 65, 70, 60]
        },
        {
          completadas: [140, 150, 160, 170, 175, 180],
          pendientes: [80, 70, 60, 55, 50, 45]
        },
        {
          completadas: [150, 200, 250, 300, 350, 400],
          pendientes: [80, 100, 120, 90, 110, 95]
        },
        {
          completadas: [180, 220, 260, 310, 370, 420],
          pendientes: [60, 80, 100, 70, 90, 85]
        },
        {
          completadas: [200, 230, 270, 330, 380, 430],
          pendientes: [70, 75, 90, 60, 85, 70]
        },
        {
          completadas: [220, 250, 300, 350, 400, 450],
          pendientes: [60, 70, 80, 65, 75, 60]
        },
        {
          completadas: [240, 270, 320, 370, 420, 470],
          pendientes: [50, 60, 70, 55, 65, 50]
        },
        {
          completadas: [260, 290, 340, 390, 440, 490],
          pendientes: [40, 55, 60, 50, 55, 45]
        },
        {
          completadas: [270, 310, 360, 410, 460, 510],
          pendientes: [35, 50, 55, 45, 50, 40]
        },
        {
          completadas: [300, 330, 380, 420, 470, 520],
          pendientes: [30, 45, 50, 40, 45, 35]
        }
        ],
        proyectos: [{
          activos: 5,
          terminados: 2,
          pausa: 1
        },
        {
          activos: 6,
          terminados: 3,
          pausa: 1
        },
        {
          activos: 4,
          terminados: 5,
          pausa: 0
        },
        {
          activos: 7,
          terminados: 4,
          pausa: 2
        },
        {
          activos: 8,
          terminados: 3,
          pausa: 2
        },
        {
          activos: 9,
          terminados: 4,
          pausa: 1
        },
        {
          activos: 7,
          terminados: 6,
          pausa: 0
        },
        {
          activos: 6,
          terminados: 5,
          pausa: 1
        },
        {
          activos: 8,
          terminados: 6,
          pausa: 2
        },
        {
          activos: 9,
          terminados: 7,
          pausa: 1
        },
        {
          activos: 10,
          terminados: 8,
          pausa: 1
        },
        {
          activos: 12,
          terminados: 10,
          pausa: 0
        }
        ],
        productividad: [{
          lider: 80,
          colaborador: 75
        },
        {
          lider: 82,
          colaborador: 78
        },
        {
          lider: 85,
          colaborador: 80
        },
        {
          lider: 86,
          colaborador: 81
        },
        {
          lider: 88,
          colaborador: 83
        },
        {
          lider: 90,
          colaborador: 84
        },
        {
          lider: 92,
          colaborador: 86
        },
        {
          lider: 91,
          colaborador: 85
        },
        {
          lider: 89,
          colaborador: 84
        },
        {
          lider: 88,
          colaborador: 83
        },
        {
          lider: 87,
          colaborador: 82
        },
        {
          lider: 86,
          colaborador: 81
        }
        ]
      };

      // IDs y elementos
      const tareasEl = document.getElementById('tareasChart');
      const proyEl = document.getElementById('proyectosChart');

      if (!tareasEl || !proyEl) {
        console.error('Canvas faltante: revisa que existan tareasChart, proyectosChart y graficoProductividad');
        return;
      }

      // ---- Chart: Tareas (línea con 2 datasets) ----
      const semanas = ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4', 'Semana 5', 'Semana 6'];
      const chartTareas = new Chart(tareasEl.getContext('2d'), {
        type: 'line',
        data: {
          labels: semanas,
          datasets: [{
            label: 'Completadas',
            data: datosPorMes.tareas[4].completadas, // Mayo por defecto (índice 4)
            borderColor: '#1cc88a',
            backgroundColor: 'rgba(28,200,138,0.18)',
            fill: true,
            tension: 0.4,
            borderWidth: 2,
            pointRadius: 4
          },
          {
            label: 'Pendientes',
            data: datosPorMes.tareas[4].pendientes,
            borderColor: '#f6c23e',
            backgroundColor: 'rgba(246,194,62,0.2)',
            fill: true,
            tension: 0.4,
            borderWidth: 2,
            pointRadius: 4
          }
          ]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top'
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                color: '#444'
              }
            },
            x: {
              ticks: {
                color: '#444'
              }
            }
          }
        }
      });

      // ---- Chart: Proyectos (doughnut) ----
      const chartProy = new Chart(proyEl.getContext('2d'), {
        type: 'doughnut',
        data: {
          labels: ['Activos', 'Terminados', 'En pausa'],
          datasets: [{
            data: [datosPorMes.proyectos[4].activos, datosPorMes.proyectos[4].terminados, datosPorMes.proyectos[4].pausa],
            backgroundColor: ['#36b9cc', '#1cc88a', '#f6c23e']
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
        }
      });

      // ---- Chart: Productividad (barra líder vs colaborador) ----


      // ---- Selectores ----
      const selectTareas = document.getElementById('selectTareas') || document.getElementById('mesSelector'); // admito ambos nombres
      const selectProyectos = document.getElementById('selectProyectos');
      const selectProductividad = document.getElementById('selectProductividad');

      // función segura para convertir value -> índice (si tu select usa 0..11 o usa nombres)
      function valorAIndice(val) {
        // si es número (0..11) lo devolvemos
        if (!isNaN(parseInt(val))) return parseInt(val);
        // si es nombre de mes (enero..diciembre)
        const meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        const idx = meses.indexOf(String(val).toLowerCase());
        return idx >= 0 ? idx : 4; // default mayo
      }

      // listeners
      if (selectTareas) {
        selectTareas.addEventListener('change', (e) => {
          const idx = valorAIndice(e.target.value);
          const d = datosPorMes.tareas[idx];
          chartTareas.data.datasets[0].data = d.completadas;
          chartTareas.data.datasets[1].data = d.pendientes;
          chartTareas.update();
        });
      }

      if (selectProyectos) {
        selectProyectos.addEventListener('change', (e) => {
          const idx = valorAIndice(e.target.value);
          const d = datosPorMes.proyectos[idx];
          chartProy.data.datasets[0].data = [d.activos, d.terminados, d.pausa];
          chartProy.update();
        });
      }

      if (selectProductividad) {
        selectProductividad.addEventListener('change', (e) => {
          const idx = valorAIndice(e.target.value);
          const d = datosPorMes.productividad[idx];
          chartProd.data.datasets[0].data = [d.lider, d.colaborador];
          chartProd.update();
        });
      }

    }); // DOMContentLoaded
  </script>
  @include('lider.nuevo-mensaje')
  @include('lider.registrar-proyecto')
@endsection


@section('scripts')
<script src="{{ asset('js/dashboard_lider.js') }}"></script>
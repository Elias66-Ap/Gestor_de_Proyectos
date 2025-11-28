@extends('layouts.app')
@section('styles')
  <script></script>
  <link rel="stylesheet" href="{{ asset('css/admin/inicio.css') }}">
@endsection
@section('content')

  <main>
    {{-- -NUEVOSOS --}}
    <div class="row g-4 mb-5">
      <div class="col-md-3">
        <div class="stat-card">
          <span class="stat-badge" id="tar_comp">+2 esta semana</span>
          <div class="stat-icon icon-blue">
            <i class="bi bi-kanban-fill"></i>
          </div>
          <div class="stat-value" id="tar_completadas">12</div>
          <div class="stat-label">Tareas Completados</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <span class="stat-badge" id="pro_com">+1 desde ayer</span>
          <div class="stat-icon icon-orange">
            <i class="bi bi-check-circle-fill"></i>
          </div>
          <div class="stat-value" id="pro_completados">2</div>
          <div class="stat-label">Proyectos completados</div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="stat-card">
          <span class="stat-badge" id="pro_act">+4 este mes</span>
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
            <i class="bi bi-speedometer2"></i>
          </div>
          <div class="stat-value" id="promedio_rendimiento">70%</div>
          <div class="stat-label">Rendimiento promedio</div>
        </div>
      </div>
    </div>


    {{-- ==== GRÁFICOS ==== --}}
    <div class="row g-4 justify-content-center">

      {{-- === Tareas (gráfico de líneas con cambio de mes) === --}}
      {{-- === Tareas (gráfico de líneas) === --}}
      <div class="col-lg-7 col-md-10">
        <div class="chart-card">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">📈 Tareas Completadas vs Pendientes</h5>
            <select id="mesSelector" class="form-select w-auto">
              <option value="enero">Enero</option>
              <option value="febrero">Febrero</option>
              <option value="marzo">Marzo</option>
              <option value="abril">Abril</option>
              <option value="mayo">Mayo</option>
              <option value="junio">Junio</option>
              <option value="julio">Julio</option>
              <option value="agosto">Agosto</option>
              <option value="septiembre">Septiembre</option>
              <option value="octubre" selected>Octubre</option>
              <option value="noviembre">Noviembre</option>
              <option value="diciembre">Diciembre</option>
            </select>
          </div>
          <canvas id="tareasChart" width="230" height="130"></canvas>
        </div>
      </div>

      {{-- === Proyectos (doughnut) === --}}
      <div class="col-lg-4 col-md-6">
        <div class="chart-card h-100">
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
              <option value="9" selected>Octubre</option>
              <option value="10">Noviembre</option>
              <option value="11">Diciembre</option>
            </select>
          </div>
          <canvas id="proyectosChart" height="200"></canvas>
        </div>
      </div>


    </div>

    <div class="accesos-rapidos-container mb-4">
      <h5 class="fw-bold mb-3">Accesos Rápidos</h5>

      <div class="accesos-grid">

        <!-- Añadir Colaborador -->
        <div class="acceso-item" data-bs-toggle="modal" data-bs-target="#modalAddColab">
          <div class="acceso-icon acceso-blue">
            <i class="bi bi-person-plus"></i>
          </div>
          <div class="acceso-title">Añadir Colaborador</div>
          <div class="acceso-sub">Registrar nuevo miembro</div>
        </div>

        <!-- Nuevo Proyecto -->
        <div class="acceso-item" data-bs-toggle="modal" data-bs-target="#modalProyecto">
          <div class="acceso-icon acceso-green">
            <i class="bi bi-file-earmark-plus"></i>
          </div>
          <div class="acceso-title">Nuevo Proyecto</div>
          <div class="acceso-sub">Crear proyecto</div>
        </div>

        <!-- Nuevo Mensaje -->
        <div class="acceso-item" data-bs-toggle="modal" data-bs-target="#modalMensaje">
          <div class="acceso-icon acceso-pink">
            <i class="bi bi-envelope-plus"></i>
          </div>
          <div class="acceso-title">Nuevo Mensaje</div>
          <div class="acceso-sub">Enviar aviso interno</div>
        </div>

      </div>
    </div>



  </main>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    Chart.defaults.font.family = "Plus Jakarta Sans, Segoe UI, sans-serif";
    Chart.defaults.color = "#4b5563"; // gris suave
    Chart.defaults.borderColor = "rgba(0,0,0,0.05)";

    /* Líneas más suaves */
    Chart.defaults.elements.line.borderWidth = 3;
    Chart.defaults.elements.line.tension = 0.35;

    /* Puntos pequeños */
    Chart.defaults.elements.point.radius = 4;
    Chart.defaults.elements.point.hoverRadius = 5;

    /* Leyenda estilo compacto */
    Chart.defaults.plugins.legend.labels.boxWidth = 12;
    Chart.defaults.plugins.legend.labels.boxHeight = 12;
    Chart.defaults.plugins.legend.labels.font = { size: 12 };

    /* Doughnut estilo premium */
    Chart.defaults.plugins.legend.position = 'bottom';
    Chart.defaults.plugins.legend.labels.padding = 16;
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const datosPorMes = {
        proyectos: [
          { activos: 5, terminados: 2, pausa: 1 },
          { activos: 6, terminados: 3, pausa: 1 },
          { activos: 4, terminados: 5, pausa: 0 },
          { activos: 7, terminados: 4, pausa: 2 },
          { activos: 8, terminados: 3, pausa: 2 },
          { activos: 9, terminados: 4, pausa: 1 },
          { activos: 7, terminados: 6, pausa: 0 },
          { activos: 6, terminados: 5, pausa: 1 },
          { activos: 8, terminados: 6, pausa: 2 },
          { activos: 9, terminados: 7, pausa: 1 },
          { activos: 10, terminados: 8, pausa: 1 },
          { activos: 12, terminados: 10, pausa: 0 }
        ]
      };

      const tareasEl = document.getElementById('tareasChart');
      const proyEl = document.getElementById('proyectosChart');

      if (!tareasEl || !proyEl) {
        console.error('Canvas faltante: revisa que existan tareasChart y proyectosChart');
        return;
      }

      // ---- Chart: Tareas ----
      const semanas = ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4', 'Semana 5', 'Semana 6'];
      const chartTareas = new Chart(tareasEl.getContext('2d'), {
        type: 'line',
        data: {
          labels: semanas,
          datasets: [
            {
              label: 'Completadas',
              data: [],
              borderColor: '#3b82f6',
              backgroundColor: 'rgba(59,130,246,0.15)',
              fill: true
            },
            {
              label: 'Pendientes',
              data: [],
              borderColor: '#f59e0b',
              backgroundColor: 'rgba(245,158,11,0.15)',
              fill: true
            }
          ]
        },
        options: {
          responsive: true,
          scales: {
            y: {
              grid: {
                color: "rgba(0,0,0,0.04)",
              },
              ticks: { color: "#6b7280" }
            },
            x: {
              grid: { display: false },
              ticks: { color: "#6b7280" }
            }
          }
        }
      });


      // ---- Chart: Proyectos ----
      const chartProy = new Chart(proyEl.getContext('2d'), {
        type: 'doughnut',
        data: {
          labels: ['Activos', 'Terminados', 'En pausa'],
          datasets: [{
            data: [0, 0, 0],
            backgroundColor: [
              '#3b82f6', // azul
              '#22c55e', // verde
              '#f59e0b'  // naranja
            ],
            borderWidth: 4,
            spacing: 6,
            cutout: '65%', // hace el centro más grande = estilo premium
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { position: 'bottom' }
          }
        }
      });


      const selectTareas = document.getElementById('mesSelector');
      const selectProyectos = document.getElementById('selectProyectos');

      function valorAIndice(val) {
        if (!isNaN(parseInt(val))) return parseInt(val);
        const meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        const idx = meses.indexOf(String(val).toLowerCase());
        return idx >= 0 ? idx : 4;
      }

      const baseUrlProy = 'http://127.0.0.1:8000/api/proyectos-mes/';
      const baseUrlTareas = 'http://127.0.0.1:8000/api/tareas-mes/';

      if (selectProyectos) {
        selectProyectos.addEventListener('change', async (e) => {
          const idx = valorAIndice(e.target.value) + 1;
          try {
            const res = await fetch(baseUrlProy + idx);
            const data = await res.json();
            chartProy.data.datasets[0].data = [data.activos, data.terminados, data.pausa];
            chartProy.update();
          } catch (err) { console.error('Error cargando proyectos del mes:', err); }
        });
        selectProyectos.dispatchEvent(new Event('change'));
      }

      if (selectTareas) {
        selectTareas.addEventListener('change', async (e) => {
          const idx = valorAIndice(e.target.value) + 1;
          try {
            const res = await fetch(baseUrlTareas + idx);
            const data = await res.json();
            chartTareas.data.labels = data.map(d => d.semana);
            chartTareas.data.datasets[0].data = data.map(d => d.completadas);
            chartTareas.data.datasets[1].data = data.map(d => d.pendientes);
            chartTareas.update();
          } catch (err) { console.error('Error cargando tareas del mes:', err); }
        });
        selectTareas.dispatchEvent(new Event('change'));
      }

    });
  </script>

  @include('admin.registrar')
  @include('admin.registrar-proyecto')
  <script src="{{ asset('js/dashboard.js') }}"></script>
  @include('admin.nuevo-mensaje')

@endsection
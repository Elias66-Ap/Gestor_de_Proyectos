@extends('layouts.app')
@section('content')

  <div class="container-fluid bg-light min-vh-100 py-4 px-5">

    {{-- ==== CABECERA ==== --}}
    <div class="text-center mb-5">
      <h2 class="fw-bold">📊 Panel General del Administrador</h2>
      <p class="text-muted">Monitorea usuarios, tareas y proyectos en tiempo real</p>
    </div>

    {{-- ==== RESUMEN SUPERIOR ==== --}}
    <div class="row gx-3 gy-3 mb-5 justify-content-around">

      <!-- Tareas Completadas -->
      <div class="col-12 col-md-3 col-lg-2">
        <div class="card border-0 rounded-4 shadow-sm p-3 text-center" style="background: #ffffff;">
          <i class="bi bi-clipboard-check fs-2 text-secondary mb-2"></i>
          <h6 class="text-uppercase text-muted">Tareas Completadas</h6>
          <h3 class="fw-bold text-dark" id="tar_completadas">0</h3>
          <small class="text-muted fw-semibold" id="tar_comp">
            <i class="bi bi-arrow-up-short text-success"></i> +12% semana
          </small>
        </div>
      </div>

      <!-- Tareas Pendientes -->
      <div class="col-12 col-md-3 col-lg-2">
        <div class="card border-0 rounded-4 shadow-sm p-3 text-center" style="background: #ffffff;">
          <i class="bi bi-hourglass-split fs-2 text-secondary mb-2"></i>
          <h6 class="text-uppercase text-muted">Tareas Pendientes</h6>
          <h3 class="fw-bold text-dark" id="tar_pendientes">0</h3>
          <small class="text-muted fw-semibold" id="tar_pend">
            <i class="bi bi-arrow-down-short text-danger"></i> -
          </small>
        </div>
      </div>

      <!-- Proyectos Activos -->
      <div class="col-12 col-md-3 col-lg-2">
        <div class="card border-0 rounded-4 shadow-sm p-3 text-center" style="background: #ffffff;">
          <i class="bi bi-diagram-3 fs-2 text-secondary mb-2"></i>
          <h6 class="text-uppercase text-muted">Proyectos Activos</h6>
          <h3 class="fw-bold text-dark" id="pro_activos">0</h3>
          <small class="text-muted fw-semibold" id="pro_act">
            <i class="bi bi-arrow-up-short text-muted"></i> -
          </small>
        </div>
      </div>

      <!-- Proyectos Terminados -->
      <div class="col-12 col-md-3 col-lg-2">
        <div class="card border-0 rounded-4 shadow-sm p-3 text-center" style="background: #ffffff;">
          <i class="bi bi-check2-circle fs-2 text-secondary mb-2"></i>
          <h6 class="text-uppercase text-muted">Proyectos Terminados</h6>
          <h3 class="fw-bold text-dark" id="pro_completados">0</h3>
          <small class="text-muted fw-semibold" id="pro_com">
            <i class="bi bi-arrow-up-short text-success"></i> -
          </small>
        </div>
      </div>

      <!-- Productividad Promedio -->
      <div class="col-12 col-md-3 col-lg-2">
        <div class="card border-0 rounded-4 shadow-sm p-3 text-center" style="background: #ffffff;">
          <i class="bi bi-speedometer2 fs-2 text-secondary mb-2"></i>
          <h6 class="text-uppercase text-muted">Productividad Promedio</h6>
          <h3 class="fw-bold text-dark" id="prod_promedio">0%</h3>
          <small class="text-muted fw-semibold" id="prod_detalle">
            Última semana
          </small>
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
              <option value="9" selected>Octubre</option>
              <option value="10">Noviembre</option>
              <option value="11">Diciembre</option>
            </select>
          </div>
          <canvas id="proyectosChart" height="200"></canvas>
        </div>
      </div>

    </div>

    <div class="text-center mb-5">
      <h2 class="fw-bold">Accesos rápidos</h2>
    </div>

    <div class="resumen-cajas d-flex justify-content-center flex-wrap gap-4">
      <div class="card-resumen text-center shadow-sm border-0 rounded-4 p-4">
        <button class="btn btn-outline-primary" style="width: 200px;" data-bs-toggle="modal"
          data-bs-target="#modalAddColab">
          <i class="bi bi-person-plus me-2"></i>Añadir colaborador
        </button>
      </div>

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

  </div>

  <style>
    .resumen-cajas {
      margin-top: 20px;
    }

    .card-resumen {
      width: 240px;
      transition: all 0.3s ease;
    }

    .card-resumen:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .card-resumen button {
      border-radius: 12px;
      font-weight: 600;
      padding: 10px 15px;
      transition: all 0.3s ease;
    }

    .card-resumen button:hover {
      transform: scale(1.05);
    }
  </style>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            { label: 'Completadas', data: [], borderColor: '#1cc88a', backgroundColor: 'rgba(28,200,138,0.18)', fill: true, tension: 0.4, borderWidth: 2, pointRadius: 4 },
            { label: 'Pendientes', data: [], borderColor: '#f6c23e', backgroundColor: 'rgba(246,194,62,0.2)', fill: true, tension: 0.4, borderWidth: 2, pointRadius: 4 }
          ]
        },
        options: { responsive: true, plugins: { legend: { position: 'top' } }, scales: { y: { beginAtZero: true, ticks: { color: '#444' } }, x: { ticks: { color: '#444' } } } }
      });

      // ---- Chart: Proyectos ----
      const chartProy = new Chart(proyEl.getContext('2d'), {
        type: 'doughnut',
        data: { labels: ['Activos', 'Terminados', 'En pausa'], datasets: [{ data: [0, 0, 0], backgroundColor: ['#36b9cc', '#1cc88a', '#f6c23e'] }] },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
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
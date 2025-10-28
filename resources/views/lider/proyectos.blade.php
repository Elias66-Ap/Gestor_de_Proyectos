@extends('layouts.app_lider')

@section('content1')
<head>
  <link rel="stylesheet" href="{{ asset('css/proyecto.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<main>
  <!-- Tarjetas de resumen -->
  <div class="resumen-cajas">
    <div class="card-resumen">
      <h5>Proyectos activos</h5>
      <h3 id="activosCount">0</h3>
      <p>En desarrollo</p>
    </div>
    <div class="card-resumen">
      <h5>Proyectos en pausa</h5>
      <h3 id="activosCount">2</h3>
      <p>Pausado</p>
    </div>
    <div class="card-resumen">
      <h5>Proyectos completados</h5>
      <h3 id="completadosCount">0</h3>
      <p>Finalizados</p>
    </div>
  </div>

  <!-- Contenido principal -->
  <div class="contenedor">
    <!-- Sección Proyectos -->
    <div class="proyecto">
      <div class="proyecto-header">
        <h2>Proyectos</h2>
        <button id="boton" data-bs-toggle="modal" data-bs-target="#modalProyecto">+ Nuevo</button>

        <!-- Filtros -->
        <div class="filtros">
          <a href="#" id="filtroFecha">📅 Fecha</a>
          <a href="#" id="filtroProgreso">📈 Progreso</a>
        </div>
      </div>

      <!-- Lista de proyectos -->
      <div id="listaProyectos"></div>
    </div>

    <!-- Sección Tareas próximas -->
    <div class="tareas-vencidas">
      <h3>Tareas próximas a vencer</h3>
      @for ($i = 0; $i < 5; $i++)
      <div class="card-tarea">
        <div class="info-tarea">
          <span class="nombre-tarea">App móvil E-commerce</span>
          <span class="estado en-progreso">En progreso</span>
        </div>
        <div class="estadisticas-2">
          <p>75% completado</p>
          <p>25/11/25</p>
        </div>
      </div>
      @endfor
    </div>
  </div>
</main>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const proyectos = [
    { nombre: 'App móvil E-commerce', descripcion: 'Aplicación de compras en línea.', lider: 'Job Parco', colaboradores: 8, progreso: 75, fecha: '2025-01-15' },
    { nombre: 'Sistema de Inventario', descripcion: 'Gestión de stock en tiempo real.', lider: 'Job Parco', colaboradores: 8, progreso: 95, fecha: '2025-01-20' },
    { nombre: 'Plataforma Educativa', descripcion: 'Portal de cursos en línea.', lider: 'Job Parco', colaboradores: 8, progreso: 40, fecha: '2025-03-05' },
    { nombre: 'Web de Reservas', descripcion: 'Sistema de reservas de hoteles.', lider: 'Job Parco', colaboradores: 8, progreso: 90, fecha: '2025-02-01' }
  ];

  const lista = document.getElementById('listaProyectos');
  const activosCount = document.getElementById('activosCount');
  const completadosCount = document.getElementById('completadosCount');

  function renderProyectos(data) {
    lista.innerHTML = '';
    data.forEach(p => {
      const estado = p.progreso === 100 ? 'completado' : 'en-progreso';
      const card = document.createElement('div');
      card.className = 'card-proyecto mt-3';
      card.innerHTML = `
        <div class="info-proyecto">
          <span class="nombre-proyecto">${p.nombre}</span>
          <span class="estado ${estado}">${p.progreso === 100 ? 'Completado' : 'En progreso'}</span>
        </div>
        <p class="mt-2 text-muted">${p.descripcion}</p>
        <p><strong>Líder:</strong> ${p.lider} || <strong>Colaboradores:</strong> ${p.colaboradores}</p>
        <progress min="0" max="100" value="${p.progreso}"></progress>
        <div class="estadisticas">
          <p>${p.progreso}% completado</p>
          <p>Entrega ${new Date(p.fecha).toLocaleDateString('es-PE')}</p>
        </div>
      `;
      lista.appendChild(card);
    });

    const activos = data.filter(p => p.progreso < 100).length;
    const completados = data.filter(p => p.progreso === 100).length;
    activosCount.textContent = activos;
    completadosCount.textContent = completados;
  }

  // Render inicial
  renderProyectos(proyectos);

  // Filtros
  document.getElementById('filtroFecha').addEventListener('click', e => {
    e.preventDefault();
    const ordenados = [...proyectos].sort((a, b) => new Date(a.fecha) - new Date(b.fecha));
    renderProyectos(ordenados);
  });

  document.getElementById('filtroProgreso').addEventListener('click', e => {
    e.preventDefault();
    const ordenados = [...proyectos].sort((a, b) => b.progreso - a.progreso);
    renderProyectos(ordenados);
  });
</script>

@include('lider.registrar-proyecto')
@endsection

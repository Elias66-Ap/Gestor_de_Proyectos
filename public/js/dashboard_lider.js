
async function cargarDashboard() {
    const id = document.getElementById('lider-info').dataset.id;
    try {
        const response = await fetch('http://127.0.0.1:8000/api/dashboard-lider/' + id);
        const { status, data } = await response.json();

        console.log({ status, data });

        if (status === 'success') {
            document.getElementById('tar_creadas').textContent = data.tareas.creadas;
            document.getElementById('var_creadas').textContent = data.tareas.creadasSemana;
            document.getElementById('tar_pendientes').textContent = data.tareas.pendientes;
            document.getElementById('var_pendientes').textContent = data.tareas.pendientesHoy;
            document.getElementById('tar_asignadas').textContent = data.tareas.asignadas;
            document.getElementById('var_asignadas').textContent = data.tareas.asignadasSemana;

            document.getElementById('pro_activos').textContent = data.proyectos.activos;
            document.getElementById('pro_activos_var').textContent = data.proyectos.activosMes;
            document.getElementById('pro_completados').textContent = data.proyectos.completados;
            document.getElementById('pro_completados_var').textContent = data.proyectos.completadosMes;
            document.getElementById('pro_creados').textContent = data.proyectos.creados;
            document.getElementById('pro_creados_var').textContent = data.proyectos.creadosMes;
        }
    } catch (error) {
        console.error("Error al cargar el dashboard", error);
    }
}

document.addEventListener('DOMContentLoaded', cargarDashboard);
setInterval(cargarDashboard, 30000);

async function cargarProyectos() {
    const id = document.getElementById('lider-info').dataset.id;

    try {
        const response = await fetch('http://127.0.0.1:8000/api/dashboard-proyectos-lider/' + id);
        const { status, proyectos } = await response.json();

        console.log({ status, proyectos });

        if (status === 'success') {
            document.getElementById('proy_activos').textContent = proyectos.activos;
            document.getElementById('proy_completados').textContent = proyectos.completados;
            document.getElementById('proy_pausa').textContent = proyectos.pausados;
        }
    } catch (error) {
        console.error("Error al cargar los proyectos", error);
    }
}

document.addEventListener('DOMContentLoaded', cargarProyectos);
setInterval(cargarProyectos, 30000);

async function cargarTareas() {
    const id = document.getElementById('lider-info').dataset.id;

    try {
        const response = await fetch('http://127.0.0.1:8000/api/dashboard-tareas-lider/' + id);
        const { status, tareas } = await response.json();

        if (status === 'success') {
            document.getElementById('tar_total').textContent = tareas.total;
            document.getElementById('tar_activas').textContent = tareas.activas;
            document.getElementById('tar_completadas').textContent = tareas.completadas;
            document.getElementById('tar_hoy').textContent = tareas.hoy;
        }

    } catch (error) {

        console.error('Error al cargar las tareas', error);
    }
}

document.addEventListener('DOMContentLoaded', cargarTareas);
setInterval(cargarTareas, 30000);
async function actualizarDashboard() {
    try {
        const res = await fetch('http://127.0.0.1:8000/api/dashboard/resumen');
        const { status, data } = await res.json();

        if (status === 'success') {
            document.getElementById('total_usu').textContent = data.usuarios.total;
            document.getElementById('tar_pendientes').textContent = data.tareas.pendientes;
            document.getElementById('tar_completadas').textContent = data.tareas.completas;
            document.getElementById('pro_activos').textContent = data.proyectos.activos;
            document.getElementById('pro_completados').textContent = data.proyectos.completados;
            document.getElementById('promedio_rendimiento').textContent = data.rendimiento.promedio;

            document.querySelector('#total_usu + small').textContent = data.usuarios.nuevos;
            document.querySelector('#tar_completadas + small').textContent = data.tareas.variacion_completas;
            document.querySelector('#tar_pendientes + small').textContent = data.tareas.diferencia_pendientes;
            document.querySelector('#pro_activos + small').textContent = data.proyectos.nuevos;
            document.querySelector('#pro_completados + small').textContent = data.proyectos.variacion_completados;
            document.querySelector('#promedio_rendimiento + small').textContent = data.rendimiento.cambio;
        }
    } catch (error) {
        console.error("Error al actualizar dashboard:", error);
    }
}

document.addEventListener('DOMContentLoaded', actualizarDashboard);
setInterval(actualizarDashboard, 30000);

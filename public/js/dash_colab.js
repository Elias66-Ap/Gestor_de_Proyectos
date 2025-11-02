async function cargarTareas() {
    const userElement = document.getElementById('user-info');
    const userId = userElement.dataset.id; 
    
    try {
        const response = await fetch(`http://127.0.0.1:8000/api/dashboard-colaborador/${userId}`);

        const { status, data } = await response.json();
        if (status === 'success') {
            document.getElementById('tar_pendientes').textContent = data.pendientes;
            document.getElementById('tar_completadas').textContent = data.completadas;
            document.getElementById('tar_total').textContent = data.total;
            document.getElementById('tar_hoy').textContent = data.hoy;
        }
    } catch (error) {
        console.error("Error al cargar tareas:", error);
    }
}
 
document.addEventListener('DOMContentLoaded', cargarTareas);
setInterval(cargarTareas, 30000);

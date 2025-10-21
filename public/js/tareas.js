function actualizarTareasActivas() {
    fetch('http://127.0.0.1:8000/api/tareas/activas')
        .then(response => {
            console.log('HTTP status:', response.status);
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('tar_activas').textContent = data.data;
            }
        })
        .catch(error => console.error('Error de red:', error));
}

function actualizarTareasCompletas() {
    fetch('http://127.0.0.1:8000/api/tareas/completas')
        .then(response => {
            console.log('HTTP status:', response.status);
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('tar_completadas').textContent = data.data;
            }
        })
        .catch(error => console.error('Error de red:', error));
}

function actualizarTareasResumen() {
    actualizarTareasActivas();
    actualizarTareasCompletas();
}

// Ejecutar al cargar el DOM
document.addEventListener('DOMContentLoaded', () => {
    actualizarTareasResumen();
    // Actualizar cada 30 segundos
    setInterval(actualizarTareasResumen, 30000);
});

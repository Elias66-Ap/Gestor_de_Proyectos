document.getElementById('buscarColaborador').addEventListener('input', function () {
    const filtro = this.value.toLowerCase();
    const filas = document.querySelectorAll('.fila-colaborador');

    filas.forEach(fila => {
        const nombre = fila.querySelector('div h6').textContent.toLowerCase();
        const apellido = fila.querySelector('div p').textContent.toLowerCase();
        const correo = fila.querySelectorAll('div h6')[1].textContent.toLowerCase();

        // Mostrar la fila si coincide con nombre, apellido o correo
        if (nombre.includes(filtro) || apellido.includes(filtro) || correo.includes(filtro)) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });
});

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

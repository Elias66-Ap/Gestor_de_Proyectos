function actualizarTotalUsuarios() {
    fetch('http://127.0.0.1:8000/api/usuarios/total')
        .then(response => {
            console.log('HTTP status:', response.status);
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('total_usu').textContent = data.data;
            }
        })
        .catch(error => console.error('Error de red:', error));
}



function actualizarUsuariosResumen() {
    actualizarTotalUsuarios();
}

document.addEventListener('DOMContentLoaded', () => {
    actualizarUsuariosResumen();
    setInterval(actualizarUsuariosResumen, 30000);
});
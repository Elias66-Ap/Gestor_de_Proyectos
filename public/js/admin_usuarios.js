const API_BASE = 'http://127.0.0.1:8000/api';

async function dashboardUsuarios() {
    try {
        const response = await fetch(API_BASE + '/dashboard/usuarios');
        const { status, usuarios } = await response.json();

        console.log({ status, usuarios });

        if (status === 'success') {
            document.getElementById('usuarios_total').textContent = usuarios.totales;
            document.getElementById('usuarios_sin_perfil').textContent = usuarios.sin_perfil;
            document.getElementById('usuarios_inactivos').textContent = usuarios.inactivos;
        }
    } catch (error) {
        console.error("Error al actualizar dashboard: ", error);
    }
}

document.addEventListener('DOMContentLoaded', dashboardUsuarios);
setInterval(dashboardUsuarios, 3000);
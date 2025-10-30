async function cargarProyectos() {
    try {
        const res = await fetch('http://127.0.0.1:8000/api/dashboard/proyectos');
        const { status, data } = await res.json();

        if (status === 'success') {
            document.getElementById('proy_activos').textContent = data.activos;
            document.getElementById('proy_completados').textContent = data.completados;
            document.getElementById('proy_pausa').textContent = data.pausa;
        }
    } catch (error) {
        console.error("Error al actualizar dashboard:", error);
    }
}

document.addEventListener('DOMContentLoaded', cargarProyectos);
setInterval(cargarProyectos, 30000);
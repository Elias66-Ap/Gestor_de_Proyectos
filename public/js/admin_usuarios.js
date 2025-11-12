$(document).ready(function () {
    $('#tablaColaboradores').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
        pageLength: 5,
        lengthChange: false,
        order: [[1, 'asc']]
    });
});

// Alternar tablas
const btnVerTodos = document.getElementById('btnVerTodos');
const btnVerSinPerfil = document.getElementById('btnVerSinPerfil');
const tablaUsuarios = document.getElementById('tablaUsuarios');
const tablaSinPerfil = document.getElementById('tablaSinPerfilContainer');

btnVerSinPerfil.addEventListener('click', () => {
    tablaUsuarios.classList.add('d-none');
    tablaSinPerfil.classList.remove('d-none');
});
btnVerTodos.addEventListener('click', () => {
    tablaUsuarios.classList.remove('d-none');
    tablaSinPerfil.classList.add('d-none');
});

// Filtros
const botones = document.querySelectorAll('.filtro');
const filas = document.querySelectorAll('#tablaColaboradores tbody tr');

botones.forEach(boton => {
    boton.addEventListener('click', () => {
        botones.forEach(b => b.classList.remove('active'));
        boton.classList.add('active');

        const filtro = boton.dataset.filtro;

        filas.forEach(fila => {
            const rol = fila.querySelector('td:nth-child(4)').textContent.trim().toLowerCase();
            const rendimiento = parseFloat(fila.querySelector('td:last-child small').textContent.replace('%','').trim());

            if (
                filtro === 'todos' ||
                (filtro === 'lider' && rol === 'lider') ||
                (filtro === 'colaborador' && rol === 'colaborador') ||
                (filtro === 'mejor' && rendimiento > 75)
            ) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });
});


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
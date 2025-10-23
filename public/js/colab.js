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


document.addEventListener('DOMContentLoaded', () => {
});

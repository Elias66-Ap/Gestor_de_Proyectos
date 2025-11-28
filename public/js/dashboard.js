async function cargarDashboard() {
    try {
        const res = await fetch('http://127.0.0.1:8000/api/dashboard/inicio');
        const { status, data } = await res.json();

        console.log({status,data});

        if (status === 'success') {
            /*document.getElementById('tar_pendientes').textContent = data.tareas.pendientes;*/
            document.getElementById('tar_completadas').textContent = data.tareas.completadas;
            document.getElementById('pro_activos').textContent = data.proyectos.activos;
            document.getElementById('pro_completados').textContent = data.proyectos.completados;
            document.getElementById('promedio_rendimiento').textContent = data.rendimiento.promedio;

            document.getElementById('tar_comp').textContent = data.tareas.nuevas;
            /*document.getElementById('tar_pend').textContent = data.tareas.hoy;*/
            document.getElementById('pro_act').textContent = data.proyectos.nuevos;
            document.getElementById('pro_com').textContent = data.proyectos.mes;
        }
    } catch (error) {
        console.error("Error al actualizar dashboard:", error);
    }
}

document.addEventListener('DOMContentLoaded', cargarDashboard);
setInterval(cargarDashboard, 30000);




// Usuarios por mes
async function cargarChartUsuarios() {
    try {
        const res = await fetch('http://127.0.0.1:8000/api/usuarios/por/mes');
        const json = await res.json();

        if (json.status === 'success') {
            const ctx = document.getElementById('usuariosChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: json.labels,
                    datasets: [{
                        label: 'Usuarios',
                        data: json.data,
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.2)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    } catch (error) {
        console.error('Error cargando chart:', error);
    }
}

document.addEventListener('DOMContentLoaded', cargarChartUsuarios);

// Proyectos activos vs terminados
async function cargarChartProyectos() {
    try {
        const res = await fetch('http://127.0.0.1:8000/api/dashboard/proyectos');
        const json = await res.json();

        if (json.status === 'success') {
            const ctx = document.getElementById('proyectosChart').getContext('2d');

            // Crear gradientes para los segmentos
            const gradActivos = ctx.createLinearGradient(0, 0, 0, 200);
            gradActivos.addColorStop(0, '#36b9cc');
            gradActivos.addColorStop(1, '#4fd1c5');

            const gradCompletados = ctx.createLinearGradient(0, 0, 0, 200);
            gradCompletados.addColorStop(0, '#1cc88a');
            gradCompletados.addColorStop(1, '#2ecc71');

            const gradPausa = ctx.createLinearGradient(0, 0, 0, 200);
            gradPausa.addColorStop(0, '#f6c23e');
            gradPausa.addColorStop(1, '#feca57');

            // Agregamos sombra al gráfico (efecto más visual)
            const originalDraw = Chart.controllers.doughnut.prototype.draw;
            Chart.controllers.doughnut.prototype.draw = function () {
                originalDraw.apply(this, arguments);
                const ctx = this.chart.ctx;
                ctx.save();
                ctx.shadowColor = 'rgba(0, 0, 0, 0.15)';
                ctx.shadowBlur = 10;
                ctx.shadowOffsetX = 3;
                ctx.shadowOffsetY = 3;
                ctx.restore();
            };

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Activos', 'Terminados', 'En pausa'],
                    datasets: [{
                        data: [
                            json.data.activos,
                            json.data.completados,
                            json.data.pausa
                        ],
                        backgroundColor: [gradActivos, gradCompletados, gradPausa],
                        borderWidth: 2,
                        borderColor: '#fff',
                        hoverOffset: 15
                    }]
                },
                options: {
                    cutout: '70%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.formattedValue || '';
                                    return `${label}: ${value} proyectos`;
                                }
                            },
                            backgroundColor: 'rgba(0,0,0,0.7)',
                            padding: 10,
                            titleFont: { size: 13 },
                            bodyFont: { size: 12 }
                        }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true
                    }
                }
            });
        }
    } catch (error) {
        console.error('Error cargando chart:', error);
    }
}

document.addEventListener('DOMContentLoaded', cargarChartProyectos);




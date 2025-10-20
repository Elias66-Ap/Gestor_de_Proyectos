@extends('layouts.app')

@section('content')
<div class="container-fluid bg-light min-vh-100 py-4">

    <div class="mb-4">
        <h2 class="fw-bold">Bienvenido, Administrador 👋</h2>
        <p class="text-muted">Visualiza un resumen gráfico de tus datos.</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 p-3">
                <h5 class="fw-bold mb-3">Usuarios Registrados por Mes</h5>
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 p-3">
                <h5 class="fw-bold mb-3">Distribución de Roles</h5>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4 p-3">
                <h5 class="fw-bold mb-3">Accesos al Sistema (Últimos 7 días)</h5>
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>

</div>

<style>
    body {
        background-color: #f4f6fa;
    }
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.12);
        transition: all 0.3s ease;
    }
</style>

{{-- Bootstrap JS (si no está en tu layout) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // 📊 Gráfico de Barras
    const ctxBar = document.getElementById('barChart');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Usuarios',
                data: [12, 19, 3, 5, 2, 3, 15],
                backgroundColor: '#4e73df'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    // 🥧 Gráfico de Pastel
    const ctxPie = document.getElementById('pieChart');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Administrador', 'Usuario', 'Invitado'],
            datasets: [{
                data: [5, 15, 7],
                backgroundColor: ['#4e73df', '#1cc88a', '#f6c23e']
            }]
        },
        options: {
            responsive: true
        }
    });

    // 📈 Gráfico de Línea
    const ctxLine = document.getElementById('lineChart');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
            datasets: [{
                label: 'Accesos',
                data: [10, 12, 8, 15, 18, 20, 25],
                borderColor: '#36b9cc',
                backgroundColor: '#36b9cc33',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
</script>
@endsection

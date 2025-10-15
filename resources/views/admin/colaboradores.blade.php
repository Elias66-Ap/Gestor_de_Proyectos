@extends('layouts.app')
@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/colaboradores.css') }}">
</head>

<style>
/* ==== VARIABLES GLOBALES ==== */
:root {
    --color-primario: #2563eb;
    --color-secundario: #16a34a;
    --color-texto: #2d2d2d;
    --color-bg: #f4f6fa;
    --color-card: #ffffff;
    --color-borde: #e2e8f0;
    --sombra: 0 4px 12px rgba(0, 0, 0, 0.05);
    --radio: 12px;
    --transicion: all 0.3s ease;
    --fuente: 'Segoe UI', Tahoma, sans-serif;
}

body {
    font-family: var(--fuente);
    background: var(--color-bg);
    color: var(--color-texto);
}

/* ==== TARJETAS RESUMEN ==== */
.resumen-cajas {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin: 30px auto;
    max-width: 1200px;
    padding: 0 15px;
}

.card-resumen {
    background: var(--color-card);
    border: 1px solid var(--color-borde);
    padding: 20px;
    border-radius: var(--radio);
    text-align: center;
    box-shadow: var(--sombra);
    transition: var(--transicion);
}

.card-resumen:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
}

.card-resumen h5 {
    color: #555;
    font-weight: 500;
}

.card-resumen h3 {
    font-size: 2rem;
    color: var(--color-primario);
    margin: 10px 0;
}

.card-resumen p {
    font-size: 0.9rem;
    color: #777;
}

.card-resumen button {
    margin-top: 20px;
    padding: 10px 15px;
    font-size: 0.95rem;
    background-color: var(--color-primario);
    color: #fff;
    border: none;
    border-radius: var(--radio);
    cursor: pointer;
    transition: var(--transicion);
}

.card-resumen button:hover {
    background-color: #1e40af;
}

/* ==== SECCIÓN COLABORADORES ==== */
.prueba {
    background: var(--color-card);
    border: 1px solid var(--color-borde);
    border-radius: var(--radio);
    max-width: 1200px;
    margin: 20px auto;
    padding: 25px;
    box-shadow: var(--sombra);
}

.prueba h1 {
    font-size: 1.8rem;
    margin-bottom: 20px;
}

.contenedor {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
}

.contenedor input[type="search"] {
    padding: 10px 15px;
    border-radius: var(--radio);
    border: 1px solid var(--color-borde);
    flex: 1;
    max-width: 300px;
}

.sub-contenedor a {
    margin-left: 10px;
    color: var(--color-primario);
    text-decoration: none;
    font-weight: 500;
    padding: 8px 12px;
    border-radius: var(--radio);
    transition: var(--transicion);
}

.sub-contenedor a:hover {
    background: var(--color-primario);
    color: white;
}

/* ==== TABLA ==== */
.tabla {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    padding: 12px 15px;
    align-items: center;
    border-bottom: 1px solid var(--color-borde);
}

.tabla:nth-child(even) {
    background-color: #f9fafb;
}

.tabla h3 {
    font-size: 1rem;
    font-weight: 600;
    color: #444;
}

.tabla h6 {
    margin: 0;
    font-size: 0.95rem;
    font-weight: 500;
}

.tabla p {
    font-size: 0.85rem;
    color: #777;
    margin: 2px 0 0;
}

/* ==== BOTÓN ESTADO ==== */
.btn {
    display: inline-block;
    padding: 6px 12px;
    background-color: var(--color-secundario);
    color: #fff;
    font-size: 0.85rem;
    text-align: center;
    border-radius: var(--radio);
    font-weight: 600;
}

/* ==== RESPONSIVE ==== */
@media (max-width: 768px) {
    .tabla {
        grid-template-columns: 1fr 1fr;
        row-gap: 8px;
    }
    .tabla h3 {
        display: none;
    }
}
</style>

<main>
    <div class="resumen-cajas">
        <div class="card-resumen">
            <h5>Tareas activas</h5>
            <h3>80</h3>
            <p>+15 esta semana</p>
        </div>
        <div class="card-resumen">
            <h5>Tareas completadas</h5>
            <h3>230</h3>
            <p>+30 este mes</p>
        </div>
        <div class="card-resumen">
            <button>Añadir<br>colaboradores</button>
        </div>
    </div>

    <div class="prueba">
        <h1>Colaboradores</h1>
        <div class="contenedor">
            <input type="search" placeholder="Buscar colaborador...">
            <div class="sub-contenedor">
                <a href="#">Líderes</a>
                <a href="#">Colaboradores</a>
            </div>
        </div>

        <div class="tabla encabezado">
            <h3>Nombre</h3>
            <h3>Rol</h3>
            <h3>Presente</h3>
            <h3>Rendimiento</h3>
        </div>

        @for ($i = 0; $i < 5; $i++)
        <div class="tabla">
            <div>
                <h6>Miguel Ignacio de las Casas</h6>
                <p>Miguel</p>
            </div>
            <div>
                <h6>Líder</h6>
            </div>
            <div>
                <h6>May 16, 2025</h6>
                <p>6:30</p>
            </div>
            <div class="btn">
                <p>Bueno</p>
            </div>
        </div>
        @endfor
    </div>
</main>
@endsection

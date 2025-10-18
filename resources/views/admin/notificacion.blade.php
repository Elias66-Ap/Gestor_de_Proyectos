@extends('layouts.app')

@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/notificaciones.css') }}">
</head>

<div class="notificaciones-wrapper">
    <div class="notificaciones-header">
        <h2>🔔 Notificaciones</h2>
        <button class="btn-marcar-leidas">Marcar todo como leído</button>
    </div>

    <div class="notificaciones-lista">
        <div class="notificacion-item no-leida">
            <div class="icono"><i class="bi bi-exclamation-circle-fill"></i></div>
            <div class="contenido">
                <h5>Nueva actualización disponible</h5>
                <p>Se ha implementado una nueva versión en el sistema.</p>
                <span class="fecha">Hace 2 minutos</span>
            </div>
            <button class="btn-accion">Ver</button>
        </div>

        <div class="notificacion-item leida">
            <div class="icono"><i class="bi bi-person-check-fill"></i></div>
            <div class="contenido">
                <h5>Colaborador agregado</h5>
                <p>Se ha unido Miguel Ignacio a tu equipo.</p>
                <span class="fecha">Hace 3 horas</span>
            </div>
            <button class="btn-accion">Ver</button>
        </div>

        <div class="notificacion-item no-leida">
            <div class="icono"><i class="bi bi-calendar-event-fill"></i></div>
            <div class="contenido">
                <h5>Reunión programada</h5>
                <p>Tienes una reunión mañana a las 9:00 AM.</p>
                <span class="fecha">Ayer</span>
            </div>
            <button class="btn-accion">Ver</button>
        </div>
    </div>
</div>



<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

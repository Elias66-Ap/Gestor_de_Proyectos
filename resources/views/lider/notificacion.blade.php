@extends('layouts.app_lider')

@section('content1')

<head>
    <link rel="stylesheet" href="{{ asset('css/notificaciones.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<div class="notificaciones-wrapper">
    <div class="notificaciones-header">
        <h2>Mensajes</h2>
        <button class="btn-marcar-leidas" data-bs-toggle="modal" data-bs-target="#modalMensaje">
            <i class="bi bi-envelope-plus me-2"></i>Nuevo mensaje
        </button>
    </div>

    {{-- Tabs Recibidos / Enviados --}}
    <ul class="nav nav-tabs mb-4" id="mensajeTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="recibidos-tab" data-bs-toggle="tab" data-bs-target="#recibidos" type="button" role="tab">
                📥 Recibidos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="enviados-tab" data-bs-toggle="tab" data-bs-target="#enviados" type="button" role="tab">
                📤 Enviados
            </button>
        </li>
    </ul>

    <div class="tab-content" id="mensajeTabsContent">
        {{-- Sección Recibidos --}}
        <div class="tab-pane fade show active" id="recibidos" role="tabpanel" aria-labelledby="recibidos-tab">
            <div class="notificaciones-lista">
                <div class="notificacion-item no-leida">
                    <div class="icono"><i class="bi bi-envelope-fill"></i></div>
                    <div class="contenido">
                        <h5>Nuevo mensaje de Amaya</h5>
                        <p>“Hola equipo, recuerden la reunión de mañana.”</p>
                        <span class="fecha">Hace 2 minutos</span>
                    </div>
                    <button class="btn-accion">Ver</button>
                </div>

                <div class="notificacion-item leida">
                    <div class="icono"><i class="bi bi-envelope-open-fill"></i></div>
                    <div class="contenido">
                        <h5>Mensaje de Sergio</h5>
                        <p>“Buen trabajo con el sprint 2 👏”</p>
                        <span class="fecha">Hace 1 hora</span>
                    </div>
                    <button class="btn-accion">Ver</button>
                </div>
            </div>
        </div>

        {{-- Sección Enviados --}}
        <div class="tab-pane fade" id="enviados" role="tabpanel" aria-labelledby="enviados-tab">
            <div class="notificaciones-lista">
                <div class="notificacion-item leida">
                    <div class="icono"><i class="bi bi-send-check-fill"></i></div>
                    <div class="contenido">
                        <h5>Mensaje enviado a Amaya</h5>
                        <p>“Revisar el avance del módulo de login.”</p>
                        <span class="fecha">Hace 30 minutos</span>
                    </div>
                    <button class="btn-accion">Ver</button>
                </div>

                <div class="notificacion-item leida">
                    <div class="icono"><i class="bi bi-send-check-fill"></i></div>
                    <div class="contenido">
                        <h5>Mensaje enviado a Sergio</h5>
                        <p>“Subí los cambios al repositorio.”</p>
                        <span class="fecha">Ayer</span>
                    </div>
                    <button class="btn-accion">Ver</button>
                </div>
            </div>
        </div>
    </div>
</div>
@include('lider.nuevo-mensaje')


{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection

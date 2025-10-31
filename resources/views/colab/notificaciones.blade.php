@extends('layouts.app_colab')

@section('content')

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
                @foreach ($recibidos as $rec)
                @php
                $fecha = \Carbon\Carbon::parse($rec['fecha_envio']);
                @endphp
                <div class="notificacion-item"> {{-- leida/no-leida --}}
                    <div class="icono"><i class="bi bi-envelope-fill"></i></div>
                    <div class="contenido">
                        <h5>{{ $rec['remitente']['nombre'] ?? " "}}
                            {{ $rec['remitente']['apellido'] ?? " "}}
                        </h5>
                        <p>{{ $rec['contenido'] }}</p>
                        <span class="fecha">{{ $fecha->locale('es')->diffForHumans();}}</span>
                    </div>
                    <button class="btn-accion">Ver</button>
                </div>

                @endforeach




            </div>
        </div>

        {{-- Sección Enviados --}}
        <div class="tab-pane fade" id="enviados" role="tabpanel" aria-labelledby="enviados-tab">
            <div class="notificaciones-lista">
                @foreach ( $enviados as $env )
                @php
                $fecha = \Carbon\Carbon::parse($env['fecha_envio']);
                @endphp
                <div class="notificacion-item leida">
                    <div class="icono"><i class="bi bi-send-check-fill"></i></div>
                    <div class="contenido">
                        <h5>Mensaje enviado a {{ $env['destinatario']['nombre'] }} {{ $env['destinatario']['apellido'] }}</h5>
                        <p>{{ $env['contenido'] ?? "" }}</p>
                        <span class="fecha">{{ $fecha->locale('es')->diffForHumans(); }}</span>
                    </div>
                    <button class="btn-accion">Ver</button>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@include('colab.nuevo-mensaje')
{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/notificaciones.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

@section('content')

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
                <button class="nav-link active" id="recibidos-tab" data-bs-toggle="tab" data-bs-target="#recibidos"
                    type="button" role="tab">
                    📥 Recibidos
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="enviados-tab" data-bs-toggle="tab" data-bs-target="#enviados" type="button"
                    role="tab">
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
                            $visto = $rec['visto'] ? "leida" : "no-leida";
                        @endphp
                        <div class="notificacion-item {{ $visto }}">
                            @php
                                $img = $rec['remitente']['imagen'] ?? null;

                                $nombre = $rec['remitente']['nombre'] ?? '';
                                $apellido = $rec['remitente']['apellido'] ?? '';

                                $inicial = strtoupper(substr($nombre, 0, 1) . substr($apellido, 0, 1));
                            @endphp
                            <div class="avatar-wrapper">
                                @if ($img)
                                    <img class="avatar-mini" src="{{ asset('storage/' . $img) }}">
                                @else
                                    <div class="avatar-text">{{ $inicial }}</div>
                                @endif
                            </div>
                            <div class="contenido">
                                <h5>{{ $rec['remitente']['nombre'] ?? "" }} {{ $rec['remitente']['apellido'] ?? "" }}</h5>
                                <p>{{ $rec['contenido'] }}</p>
                                <span class="fecha">{{ $fecha->locale('es')->diffForHumans() }}</span>
                            </div>

                            <button class="btn-accion" data-id="{{ $rec['id'] }}">Ver</button>
                        </div>

                    @endforeach

                </div>
            </div>
            {{-- Sección Enviados --}}
            <div class="tab-pane fade" id="enviados" role="tabpanel" aria-labelledby="enviados-tab">
                <div class="notificaciones-lista">

                    @foreach ($enviados as $env)
                        @php
                            $fecha = \Carbon\Carbon::parse($env['fecha_envio']);

                            $img = $env['destinatario']['imagen'] ?? null;

                            $nombre = $env['destinatario']['nombre'] ?? '';
                            $apellido = $env['destinatario']['apellido'] ?? '';

                            $inicial = strtoupper(substr($nombre, 0, 1) . substr($apellido, 0, 1));
                        @endphp

                        <div class="notificacion-item leida">
                            <div class="avatar-wrapper">
                                @if ($img)
                                    <img class="avatar-mini" src="{{ asset('storage/' . $img) }}">
                                @else
                                    <div class="avatar-text">{{ $inicial }}</div>
                                @endif
                            </div>

                            <div class="contenido">
                                <h5>Mensaje enviado a {{ $env['destinatario']['nombre'] }}
                                    {{ $env['destinatario']['apellido'] }}
                                </h5>
                                <p>{{ $env['contenido'] }}</p>
                                <span class="fecha">{{ $fecha->locale('es')->diffForHumans() }}</span>
                            </div>

                            <button class="btn-accion" data-id="{{ $env['id'] }}">Ver</button>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </div>

    @include('admin.nuevo-mensaje')
    @include('admin.ver-mensaje')
@endsection

@section('scrsection: ipts')
<script src="{{ asset('js/mensajes.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
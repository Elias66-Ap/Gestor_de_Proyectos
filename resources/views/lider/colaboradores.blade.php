@extends('layouts.app_lider')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/colab/usuarios.css') }}">
@endsection

@section('content1')
    <div class="usuarios-wrapper">

        <!-- Header con búsqueda y botones -->
        <div class="usuarios-header">
            <div class="buscador">
                <i class="bi bi-search"></i>
                <input type="text" id="buscadorUsuarios" placeholder="Buscar usuario...">
            </div>

            <div class="acciones-header">
                <button class="btn-filtrar">
                    <i class="bi bi-funnel"></i> Filtrar
                </button>
                {{--
                <button class="btn-nuevo">
                    <i class="bi bi-person-plus"></i> Nuevo Usuario
                </button>
                --}}
            </div>
        </div>

        <!-- Tabla moderna -->
        <div class="tabla-usuarios">

            <div class="tabla-header">
                <span>Usuario</span>
                <span>Rol</span>
                <span>Correo</span>
                <span>Rendimiento</span>
                <span>Acciones</span>
            </div>

            <!-- FILA -->
            @foreach ($usuarios as $index => $u)@php
                    $rendimiento = ($u['rendimiento']['rendimiento'] ?? 0) * 100;

                    $foto = $u['perfil']['imagen'] ?? null;
                    $nombre = $u['perfil']['nombre'];
                    $apellido = $u['perfil']['apellido'];
                    $iniciales = strtoupper(substr($nombre, 0, 1) . substr($apellido, 0, 1));

                    $colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#a855f7'];
                    $color = $colors[$index % count($colors)];
                @endphp
                <div class="fila-usuario"
                    data-busqueda="{{ strtolower($u['perfil']['nombre'] . ' ' . $u['perfil']['apellido'] . ' ' . $u['rol'] . ' ' . $u['correo']) }}">
                    <div class="user-info">
                        @if($foto)
                            <img src="{{ asset('storage/' . $foto) }}" class="user-avatar">
                        @else
                            <div class="user-avatar-inicial" style="background-color: {{ $color }};">
                                {{ $iniciales }}
                            </div>
                        @endif
                        <span class="user-name">{{ $u['perfil']['nombre'] }} {{ $u['perfil']['apellido'] }} </span>
                    </div>

                    <span class="user-role">{{ $u['rol'] }} </span>
                    <span class="user-email">{{ $u['correo'] }} </span>

                    <div class="user-progress">
                        <div class="progress-bar">
                            <div style="width: {{ $rendimiento }}%"></div>
                        </div>
                        <span>{{ $rendimiento }}%</span>
                    </div>

                    <a href="#" class="btn-ver">Ver Perfil</a>
                </div>

            @endforeach


            <!-- Repite esta estructura para cada usuario -->
        </div>

        <!-- Paginación -->
        <div class="paginacion">
            <button><i class="bi bi-chevron-left"></i></button>
            <button><i class="bi bi-chevron-right"></i></button>
        </div>

    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const buscador = document.getElementById("buscadorUsuarios");
            const filas = document.querySelectorAll(".fila-usuario");

            buscador.addEventListener("input", function () {
                let texto = buscador.value.toLowerCase().trim();

                filas.forEach(fila => {
                    let contenido = fila.dataset.busqueda;

                    if (contenido.includes(texto)) {
                        fila.classList.remove("oculto");
                    } else {
                        fila.classList.add("oculto");
                    }
                });
            });

        });

    </script>
@endsection
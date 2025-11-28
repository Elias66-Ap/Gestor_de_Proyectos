@extends('layouts.app_colab')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/colab/inicio.css') }}">
@endsection

@section('content')
    <div class="container-fluid py-5">

        {{-- Encabezado --}}
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold mb-1">👋 Hola, {{ auth()->guard('usuario')->user()->perfil()->nombre ?? 'Colaborador' }}
                </h2>
                <p class="text-muted mb-0">Este es tu resumen general de actividades.</p>
            </div>
        </div>

        {{-- Dashboard --}}
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card">
                    <span class="stat-badge">+2 esta semana</span>
                    <div class="stat-icon icon-blue">
                        <i class="bi bi-list-check"></i>
                    </div>
                    <div class="stat-value" id="tar_total">12</div>
                    <div class="stat-label">Tareas Totales</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card">
                    <span class="stat-badge">-1 desde ayer</span>
                    <div class="stat-icon icon-orange">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div class="stat-value" id="tar_pendientes">2</div>
                    <div class="stat-label">Pendientes</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card">
                    <span class="stat-badge">+4 este mes</span>
                    <div class="stat-icon icon-green">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stat-value" id="tar_completadas">4</div>
                    <div class="stat-label">Completadas</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon icon-pink">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                    <div class="stat-value" id="tar_hoy">0</div>
                    <div class="stat-label">Entrega hoy</div>
                </div>
            </div>
        </div>

        {{-- Contenido principal --}}
        <div class="row g-4">

            {{-- Proyectos Modernos --}}
            <div class="col-lg-8">
                <div class="section-head">
                    <div>
                        <h4 class="section-title">📁 Proyectos Activos</h4>
                        <span class="section-sub">Participas en {{ count($proyectos) }} proyectos</span>
                    </div>
                </div>

                <div class="pro-list">
                    @foreach ($proyectos as $p)
                        @php
                            $color = $p['color'] ?? '#4F46E5';
                        @endphp

                        <a href="{{ route('tablero.proyecto', ['id' => $p['id'], 'from' => url()->current()]) }}"
                            class="pro-card">

                            {{-- Header --}}
                            <div class="pro-card-header">
                                <span class="pro-dot" style="background: {{ $color }}"></span>
                                <span class="pro-name">{{ $p['nombre'] }}</span>
                            </div>

                            {{-- Progreso --}}
                            <div class="pro-progress">
                                <div class="pro-progress-bar" style="width: {{ $p['progreso'] }}%; background: {{ $color }}">
                                </div>
                            </div>

                            {{-- Footer con avatars --}}
                            <div class="pro-footer">
                                <span class="pro-percent">{{ $p['progreso'] }}% completado</span>

                                <div class="pro-avatars">

                                    {{-- Mostrar solo 3 perfiles --}}
                                    @foreach(array_slice($p['miembros'], 0, 3) as $m)
                                        @php
                                            $datos = $m['miembros'];
                                            $foto = $datos['imagen'] ?? null;
                                            $nombre = $datos['nombre'] ?? '?';
                                            $apellido = $datos['apellido'] ?? '?';
                                            $ini = strtoupper(substr($nombre, 0, 1) . substr($apellido, 0, 1));
                                        @endphp

                                        @if ($foto)
                                            <img src="{{ asset('storage/' . $foto) }}" class="avatar-img"
                                                title="{{ $nombre }} {{ $apellido }}">
                                        @else
                                            <div class="avatar-inicial" title="{{ $nombre }} {{ $apellido }}">
                                                {{ $ini }}
                                            </div>
                                        @endif
                                    @endforeach

                                    {{-- Mostrar contador de adicionales --}}
                                    @if(count($p['miembros']) > 3)
                                        <div class="avatar-extra">+{{ count($p['miembros']) - 3 }}</div>
                                    @endif
                                </div>
                            </div>


                        </a>

                    @endforeach
                </div>
            </div>



            {{-- Tareas Modernas --}}
            <div class="col-lg-4">

                <div class="section-head d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="section-title">🗂️ Tareas asignadas</h4>
                        <span class="section-sub">Próximas a vencer</span>
                    </div>
                    <a href="{{ route('colab.tareas') }}" class="see-more">Ver más →</a>
                </div>

                <div class="task-pro-list">
                    @foreach (collect($tareas)->take(5) as $t)
                        @php
                            $progreso = match ($t['estado']) {
                                'Por hacer' => 10,
                                'En proceso' => 50,
                                'Revision' => 75,
                                'Hecho' => 100,
                                default => 0
                            };

                            $badge = match ($t['prioridad']) {
                                'Alta' => 'hi',
                                'Media' => 'md',
                                'Baja' => 'lo'
                            };

                            $fecha = \Carbon\Carbon::parse($t['fecha_vencimiento'])->format('d M Y');
                        @endphp

                        <div class="task-pro-card">

                            <div class="tp-header">
                                <span class="tp-title">{{ $t['titulo'] }}</span>
                                <span class="tp-priority {{ $badge }}">{{ $t['prioridad'] }}</span>
                            </div>

                            <div class="tp-info">
                                <span><i class="bi bi-calendar"></i> {{ $fecha }}</span>
                                <span class="state">{{ $t['estado'] }}</span>
                            </div>

                            <div class="tp-progress">
                                <div class="tp-progress-bar" style="width: {{ $progreso }}%"></div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>



        </div>
    </div>

    <div id="user-info" data-id="{{ auth()->guard('usuario')->user()->id }}"></div>

@endsection

@section('scripts')
    <script src="{{ asset('js/dash_colab.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const taskList = document.querySelector('.task-list');

            taskList.addEventListener('wheel', (e) => {
                if (taskList.scrollHeight > taskList.clientHeight) {
                    taskList.scrollBy({
                        top: e.deltaY,
                        behavior: 'smooth'
                    });
                }
            }, { passive: true });
        });

    </script>
@endsection
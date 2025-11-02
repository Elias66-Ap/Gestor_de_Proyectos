@extends('layouts.app_colab')

@section('content')
<div class="container-fluid py-5" style="background-color: #f4f6fa;">

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-1">📋 Mis Tareas</h2>
            <p class="text-muted mb-0">Aquí puedes ver todas tus tareas asignadas y su progreso.</p>
        </div>

    </div>
    <div class="row g-4">
        @foreach ($tareas as $tar )

        @php
        $fecha = Carbon\Carbon::parse($tar['fecha_vencimiento'])->translatedFormat('d M Y'); 

        $prioridad = '';

        if ($tar['prioridad'] === 'Alta') {
        $prioridad = 'danger';
        } elseif ($tar['prioridad'] === 'Media') {
        $prioridad = 'warning text-dark';
        } elseif ($tar['prioridad'] === 'Baja') {
        $prioridad = 'info text-dark';
        } else {
        $prioridad = 'primary';
        }

        $progreso = 0;
        $prio_color='';

        if($tar['estado'] === 'Por hacer'){
        $progreso = 10;
        $prio_color = 'danger';
        }elseif($tar['estado'] === 'En proceso'){
        $progreso = 50;
        $prio_color = 'warning';
        }elseif($tar['estado'] === 'Revision'){
        $progreso = 75;
        $prio_color = 'primary';
        }elseif($tar['estado'] === 'Hecho'){
        $progreso=100;
        $prio_color = 'success';
        }

        @endphp

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 tarea-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-semibold">{{$tar['titulo']}}</span>
                    <span class="badge bg-{{$prioridad}}">{{$tar['prioridad']}}</span>
                </div>
                <div class="progress mb-2" style="height: 6px;">
                    <div class="progress-bar bg-{{ $prio_color }}" style="width: {{ $progreso }};"></div>
                </div>
                <div class="d-flex justify-content-between small text-muted-end">
                    <span>{{$progreso}}%</span>
                    <span><i class="bi bi-calendar3 me-1"></i>{{ $fecha }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
<style>
    .tarea-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
        transition: transform 0.3s, box-shadow 0.3s;
    }
</style>

@endsection
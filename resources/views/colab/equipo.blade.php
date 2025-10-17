@extends('layouts.app_colab')

@section('content')
<div class="container-fluid py-5" style="background-color: #f4f6fa;">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-1">👥 Mi Equipo</h2>
            <p class="text-muted mb-0">Aquí puedes ver a los miembros de tu equipo y sus roles.</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="bi bi-person-plus me-2"></i> Agregar miembro
        </button>
    </div>

    {{-- Tarjetas de miembros del equipo --}}
    <div class="row g-4">
        @foreach([
            ['name'=>'Ana Pérez','rol'=>'lider','estado'=>'online','tareas_count'=>5,'avatar'=>'https://i.pravatar.cc/150?img=3'],
            ['name'=>'Luis Gómez','rol'=>'colaborador','estado'=>'offline','tareas_count'=>3,'avatar'=>'https://i.pravatar.cc/150?img=5'],
            ['name'=>'María Torres','rol'=>'colaborador','estado'=>'online','tareas_count'=>4,'avatar'=>'https://i.pravatar.cc/150?img=7'],
            ['name'=>'Carlos Ruiz','rol'=>'lider','estado'=>'offline','tareas_count'=>2,'avatar'=>'https://i.pravatar.cc/150?img=9'],
        ] as $miembro)
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 text-center p-3 team-card" style="transition: transform 0.3s, box-shadow 0.3s;">
                <div class="position-relative d-inline-block mb-3">
                    <img src="{{ $miembro['avatar'] }}" 
                         class="rounded-circle" width="80" height="80" alt="{{ $miembro['name'] }}">
                    <span class="position-absolute bottom-0 end-0 rounded-circle border border-white" 
                        style="width: 15px; height: 15px; background-color: {{ $miembro['estado']=='online' ? '#28a745' : '#6c757d' }};"></span>
                </div>
                <h6 class="fw-bold mb-1">{{ $miembro['name'] }}</h6>
                <p class="text-muted mb-2 text-capitalize">{{ $miembro['rol'] }}</p>
                <div class="d-flex justify-content-center gap-3">
                    <span class="badge bg-primary">Tareas: {{ $miembro['tareas_count'] }}</span>
                    <span class="badge bg-{{ $miembro['estado']=='online' ? 'success' : 'secondary' }}">
                        {{ ucfirst($miembro['estado']) }}
                    </span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Hover effect --}}
<style>
.team-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.12);
}
</style>
@endsection

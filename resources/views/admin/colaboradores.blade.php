@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="m-0">Colaboradores, Equipos</h1>
    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modalAddColab">
        <i class="bi bi-person-plus"></i> Registrar Colaborador
    </button>
    @include('admin.registrar')
</div>

@endsection
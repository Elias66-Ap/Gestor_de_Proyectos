@extends('layouts.app')
@section('content')
<head>
    <link rel="stylesheet" href="../../css/proyecto.css">
</head>
<h1>Proyecto</h1>
<div class="cajas">
    <div class="tareas-activas">
        <h5>Tarea activas</h5>
        <h3>80</h3>
        <h5>+15 de esta semana</h5>
    </div>
    <div class="tareas-activas">
        <h5>Tarea completadas</h5>
        <h3>8</h3>
        <h5>+6 desde ayer</h5>
    </div>
    <div class="tareas-activas">
        <h5>Presupuesto</h5>
        <h3>S/2500</h3>
    </div>
    <div class="tareas-activas">
        <h5>Gastado</h5>
        <h3>S/500</h3>
    </div>
</div>
@endsection

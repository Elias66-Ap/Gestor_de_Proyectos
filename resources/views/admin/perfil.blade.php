@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Perfil - Hamid</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">

</head>
<body>
  <div class="perfil-header">
    <h1>Completa tu Perfil</h1>
    <p>Por favor, completa tus datos antes de continuar.</p>
  </div>

  <div class="perfil-container">
    <!-- FOTO -->
    <div class="perfil-foto">
      <img src="https://via.placeholder.com/150" alt="Foto de perfil" class="foto-preview" id="preview" />
      <input type="file" id="imagen" />
    </div>

    <!-- FORMULARIO -->
    <div class="perfil-form">
      <div class="campo">
        <label>Nombre *</label>
        <i class="fa fa-user"></i>
        <input type="text" placeholder="Tu nombre">
      </div>
      <div class="campo">
        <label>Apellido *</label>
        <i class="fa fa-user"></i>
        <input type="text" placeholder="Tu apellido">
      </div>
      <div class="campo">
        <label>Apodo</label>
        <i class="fa fa-smile"></i>
        <input type="text" placeholder="Tu apodo">
      </div>
      <div class="campo">
        <label>Teléfono</label>
        <i class="fa fa-phone"></i>
        <input type="text" placeholder="Tu número">
      </div>
      <div class="campo">
        <label>Correo</label>
        <i class="fa fa-envelope"></i>
        <input type="email" placeholder="tuemail@ejemplo.com">
      </div>
      <div class="campo">
        <label>Dirección</label>
        <i class="fa fa-map-marker-alt"></i>
        <input type="text" placeholder="Tu dirección">
      </div>
      <div class="campo">
        <label>Hobby</label>
        <i class="fa fa-gamepad"></i>
        <input type="text" placeholder="Tu dirección">
      </div>
      <div class="campo">
        <label>Habilidades</label>
        <i class="fa fa-tools"></i>
        <input type="text" placeholder="Tu dirección">
      </div>
      <button class="btn-guardar">
        <i class="fa fa-save"></i> Guardar Cambios
      </button>
    </div>
  </div>

  <script>
    document.getElementById('imagen').addEventListener('change', function (event) {
      const [file] = event.target.files;
      if (file) {
        document.getElementById('preview').src = URL.createObjectURL(file);
      }
    });
  </script>
</body>
</html>



@endsection

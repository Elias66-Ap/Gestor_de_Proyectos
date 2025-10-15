@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Perfil - Hamid</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primario: #2563eb;
      --primario-hover: #1e4fc1;
      --texto: #1e293b;
      --gris: #94a3b8;
      --bg: #f5f7fb;
      --blanco: #ffffff;
      --borde: #e2e8f0;
      --radio: 12px;
      --sombra: 0 8px 20px rgba(0, 0, 0, 0.06);
      --transicion: all 0.3s ease;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: var(--bg);
      margin: 0;
      padding: 0;
    }

    .perfil-header {
      text-align: center;
      margin-top: 2rem;
    }

    .perfil-header h1 {
      font-size: 1.8rem;
      color: var(--primario);
      margin-bottom: 5px;
    }

    .perfil-header p {
      color: var(--gris);
      font-size: 0.95rem;
    }

    .perfil-container {
      display: flex;
      gap: 2rem;
      background: var(--blanco);
      padding: 2.5rem;
      border-radius: var(--radio);
      box-shadow: var(--sombra);
      max-width: 950px;
      margin: 2.5rem auto;
      align-items: flex-start;
    }

    /* FOTO */
    .perfil-foto {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .foto-preview {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid var(--primario);
      margin-bottom: 1rem;
      transition: var(--transicion);
    }

    .foto-preview:hover {
      transform: scale(1.05);
      box-shadow: 0 0 15px rgba(37, 99, 235, 0.3);
    }

    .perfil-foto input[type="file"] {
      cursor: pointer;
      font-size: 0.9rem;
      color: var(--texto);
    }

    /* FORM */
    .perfil-form {
      flex: 2;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.2rem 1.5rem;
    }

    .campo {
      display: flex;
      flex-direction: column;
      position: relative;
    }

    .campo label {
      font-weight: 600;
      margin-bottom: 6px;
      color: var(--texto);
      font-size: 0.95rem;
    }

    .campo i {
      position: absolute;
      top: 37px;
      left: 10px;
      color: var(--gris);
      font-size: 0.9rem;
    }

    .campo input {
      padding: 0.7rem 0.7rem 0.7rem 2.2rem;
      border: 1px solid var(--borde);
      border-radius: var(--radio);
      font-size: 0.95rem;
      transition: var(--transicion);
      background: #f9fafb;
    }

    .campo input:focus {
      outline: none;
      border-color: var(--primario);
      box-shadow: 0 0 5px rgba(37, 99, 235, 0.3);
      background: #fff;
    }

    /* BOTÓN */
    .btn-guardar {
      grid-column: 1 / -1;
      background: var(--primario);
      color: white;
      padding: 0.9rem;
      border: none;
      border-radius: var(--radio);
      font-weight: 600;
      font-size: 1rem;
      cursor: pointer;
      transition: var(--transicion);
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 8px;
    }

    .btn-guardar:hover {
      background: var(--primario-hover);
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
    }

    @media (max-width: 768px) {
      .perfil-container {
        flex-direction: column;
      }
      .perfil-form {
        grid-template-columns: 1fr;
      }
    }
  </style>
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

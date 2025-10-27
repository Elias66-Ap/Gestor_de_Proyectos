<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Completa tu Perfil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #0f172a, #1e293b);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .profile-container {
      background-color: #ffffff;
      border-radius: 20px;
      overflow: hidden;
      display: flex;
      max-width: 1200px;
      width: 95%;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .profile-left {
      background: #162C6A;
      color: #fff;
      padding: 40px 30px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      width: 35%;
      text-align: center;
    }

    .profile-left img {
      width: 180px;
      height: 180px;
      object-fit: cover;
      border-radius: 50%;
      border: 4px solid #fff;
      margin-bottom: 15px;
    }

    .profile-left h3 {
      font-weight: bold;
      font-size: 1.5rem;
    }

    .profile-right {
      width: 65%;
      padding: 40px 40px;
    }

    .profile-right h2 {
      font-weight: 700;
      margin-bottom: 25px;
      color: #1e293b;
    }

    .form-label {
      font-weight: 600;
      color: #334155;
    }

    .form-control,
    textarea {
      border-radius: 10px;
    }

    .btn-custom {
      background: #162C6A;
      color: white;
      border: none;
      font-weight: 600;
      border-radius: 10px;
      padding: 12px;
      transition: all 0.3s ease;
    }

    .btn-custom:hover {
      background: #2563eb;
      transform: translateY(-2px);
    }

    @media (max-width: 992px) {
      .profile-container {
        flex-direction: column;
      }

      .profile-left,
      .profile-right {
        width: 100%;
      }
    }
  </style>
</head>

<body>
<form action="{{ route('perfil.guardar') }}" method="POST" enctype="multipart/form-data">
  <div class="profile-container">
    <!-- LADO IZQUIERDO -->
    <div class="profile-left">
      <img id="preview" src="{{ asset('images/default.jpeg') }}" alt="Perfil">
      <label for="imagen" class="btn btn-light btn-sm mt-2">Subir Foto</label>
      <input type="file" name="imagen" id="imagen" class="d-none" accept="image/*">
      <h3 class="mt-3">Tu Perfil</h3>
      <p class="text-light">Agrega tu información para continuar</p>
    </div>

    <!-- LADO DERECHO -->
    <div class="profile-right">
      <h2>Completa tu Perfil</h2>

      @if ($errors->any())
      <div class="alert alert-danger">
        <strong>Ups!</strong> Corrige los siguientes errores:
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
          <li>- {{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif


        @csrf
        <div class="row g-3">
          <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre *</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
          </div>
          <div class="col-md-6">
            <label for="apellido" class="form-label">Apellido *</label>
            <input type="text" name="apellido" class="form-control" value="{{ old('apellido') }}" required>
          </div>
          <div class="col-md-6">
            <label for="apodo" class="form-label">Alias</label>
            <input type="text" name="apodo" class="form-control" value="{{ old('apodo') }}">
          </div>
          <div class="col-md-6">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
          </div>
          <div class="col-md-6">
            <label for="passwordd" class="form-label">Contraseña</label>
            <input type="password" name="passwordd" class="form-control" rows="2">{{ old('passwordd') }}</input>
          </div>
          <div class="col-md-6">
            <label for="passwordd_confirmation" class="form-label">Confirmar contraseña</label>
            <input type="password" name="passwordd_confirmation" class="form-control" rows="2">{{ old('passwordd_confirmation') }}</input>
          </div>
          <div class="col-md-6">
            <label for="hobby" class="form-label">Hobby</label>
            <textarea name="hobby" class="form-control" rows="2">{{ old('hobby') }}</textarea>
          </div>
        </div>
        <div>
            <label class="form-label fw-semibold">Habilidades Técnicas</label>
            <div class="row">
              <!-- Lenguajes -->
              <div class="col-md-4">
                <p class="fw-semibold mb-2 text-primary">Lenguajes</p>
                @foreach(['JavaScript', 'Python', 'PHP', 'Java', 'C#', 'TypeScript'] as $lenguaje)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="habilidades[]" value="{{ $lenguaje }}"
                      id="{{ strtolower($lenguaje) }}"
                      {{ in_array($lenguaje, old('habilidades', explode(',', $user->perfil->habilidades ?? ''))) ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ strtolower($lenguaje) }}">{{ $lenguaje }}</label>
                  </div>
                @endforeach
              </div>

              <!-- Frameworks -->
              <div class="col-md-4">
                <p class="fw-semibold mb-2 text-primary">Frameworks</p>
                @foreach(['Laravel', 'Angular', 'React', 'Vue.js', 'Spring Boot'] as $fw)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="habilidades[]" value="{{ $fw }}"
                      id="{{ strtolower(str_replace(' ', '', $fw)) }}"
                      {{ in_array($fw, old('habilidades', explode(',', $user->perfil->habilidades ?? ''))) ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ strtolower(str_replace(' ', '', $fw)) }}">{{ $fw }}</label>
                  </div>
                @endforeach
              </div>

              <!-- Herramientas -->
              <div class="col-md-4">
                <p class="fw-semibold mb-2 text-primary">Herramientas</p>
                @foreach(['Git / GitHub', 'Docker', 'MySQL', 'Figma', 'Postman'] as $tool)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="habilidades[]" value="{{ $tool }}"
                      id="{{ strtolower(str_replace([' ', '/'], '', $tool)) }}"
                      {{ in_array($tool, old('habilidades', explode(',', $user->perfil->habilidades ?? ''))) ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ strtolower(str_replace([' ', '/'], '', $tool)) }}">{{ $tool }}</label>
                  </div>
                @endforeach
              </div>
            </div>
          </div>

        <div class="mt-4">
          <button type="submit" class="btn btn-custom w-100">Guardar Perfil</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const imgInput = document.getElementById('imagen');
    const previewImg = document.getElementById('preview');

    imgInput.addEventListener('change', (e) => {
      const file = e.target.files[0];
      if (file) {
        previewImg.src = URL.createObjectURL(file);
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

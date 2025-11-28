<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Completa tu Perfil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/crear_perfil.css') }}">
</head>

<body>

  <div class="profile-wrapper">
    <form action="{{ route('perfil.guardar') }}" method="POST" enctype="multipart/form-data" class="profile-card">
      @csrf

      <!-- Columna Foto -->
      <div class="profile-photo-section">
        <div class="photo-wrapper">
          <img id="preview" src="{{ asset('images/default.jpeg') }}" alt="Foto de Perfil">
        </div>

        <label for="imagen" class="btn-upload">Subir Foto</label>
        <input type="file" name="imagen" id="imagen" class="d-none" accept="image/*">

        <h3 class="profile-title">Tu Perfil</h3>
        <p class="profile-desc">Agrega tu información para continuar</p>
      </div>

      <!-- Columna Formulario -->
      <div class="profile-form-section">
        <h2 class="section-title">Completa tu Perfil</h2>

        @if ($errors->any())
          <div class="alert alert-danger custom-alert">
            <strong>Ups!</strong> Corrige los siguientes errores:
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nombre *</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Apellido *</label>
            <input type="text" name="apellido" class="form-control" value="{{ old('apellido') }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Alias</label>
            <input type="text" name="apodo" class="form-control" value="{{ old('apodo') }}">
          </div>

          <div class="col-md-6">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
          </div>

          <div class="col-md-6">
            <label class="form-label">Contraseña</label>
            <input type="password" name="passwordd" class="form-control">
          </div>

          <div class="col-md-6">
            <label class="form-label">Confirmar contraseña</label>
            <input type="password" name="passwordd_confirmation" class="form-control">
          </div>

          <div class="col-md-12">
            <label class="form-label">Hobby</label>
            <textarea name="hobby" class="form-control" rows="2">{{ old('hobby') }}</textarea>
          </div>
        </div>

        <!-- Habilidades -->
        <label class="form-label mt-4 fw-semibold">Habilidades Técnicas</label>

        <div class="skills-grid">
          <div>
            <p class="skill-title">Lenguajes</p>
            @foreach(['JavaScript', 'Python', 'PHP', 'Java', 'C#', 'TypeScript'] as $lenguaje)
              <label class="skill-check">
                <input type="checkbox" name="habilidades[]" value="{{ $lenguaje }}" {{ in_array($lenguaje, old('habilidades', explode(',', $user->perfil->habilidades ?? ''))) ? 'checked' : '' }}>
                {{ $lenguaje }}
              </label>
            @endforeach
          </div>

          <div>
            <p class="skill-title">Frameworks</p>
            @foreach(['Laravel', 'Angular', 'React', 'Vue.js', 'Spring Boot'] as $fw)
              <label class="skill-check">
                <input type="checkbox" name="habilidades[]" value="{{ $fw }}" {{ in_array($fw, old('habilidades', explode(',', $user->perfil->habilidades ?? ''))) ? 'checked' : '' }}>
                {{ $fw }}
              </label>
            @endforeach
          </div>

          <div>
            <p class="skill-title">Herramientas</p>
            @foreach(['Git / GitHub', 'Docker', 'MySQL', 'Figma', 'Postman'] as $tool)
              <label class="skill-check">
                <input type="checkbox" name="habilidades[]" value="{{ $tool }}" {{ in_array($tool, old('habilidades', explode(',', $user->perfil->habilidades ?? ''))) ? 'checked' : '' }}>
                {{ $tool }}
              </label>
            @endforeach
          </div>
        </div>

        <button type="submit" class="btn-save">Guardar Perfil</button>
      </div>
    </form>
  </div>

  <script>
    document.getElementById('imagen').addEventListener('change', (e) => {
      const file = e.target.files[0];
      if (file) {
        document.getElementById('preview').src = URL.createObjectURL(file);
      }
    });
  </script>
</body>


</html>
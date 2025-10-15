<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completa tu Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background-color: #4e73df;
            border: none;
        }

        .btn-primary:hover {
            background-color: #375ac2;
        }

        h3 {
            color: #4e73df;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="card p-4" style="width: 500px; max-width: 90%;">
        <h3 class="text-center mb-3">Completa tu Perfil</h3>
        <p class="text-muted text-center">Por favor, completa tus datos antes de continuar.</p>

        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups!</strong> Corrige los siguientes errores:<br><br>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('perfil.guardar') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3 text-center">
                <label for="imagen" class="form-label">Foto de Perfil</label>
                <div class="mb-2">
                    <!-- Previsualización -->
                    <img id="preview" src="{{ asset('images/default.jpeg') }}"
                        alt="Perfil" class="rounded-circle" style="width:100px; height:100px; object-fit:cover;">
                </div>
                <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
            </div>

            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                <input type="text" name="apellido" class="form-control" value="{{ old('apellido') }}" required>
            </div>

            <div class="mb-3">
                <label for="apodo" class="form-label">Apodo</label>
                <input type="text" name="apodo" class="form-control" value="{{ old('apodo') }}">
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
            </div>

            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}">
            </div>

            <div class="mb-3">
                <label for="hobby" class="form-label">Hobby</label>
                <textarea name="hobby" class="form-control" rows="2">{{ old('hobby') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="habilidades" class="form-label">Habilidades</label>
                <textarea name="habilidades" class="form-control" rows="2">{{ old('habilidades') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Guardar Perfil</button>
        </form>
    </div>
    
    <script>
        document.getElementById('preview').addEventListener('change', function(event){
            const [file] =event.target.files;
            if(file){
                document.getElementById('preview'.src) =URL.createObjectURL(file);
            }
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
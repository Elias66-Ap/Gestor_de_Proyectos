<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>

<body>

    <div class="login-container">
        <div class="left-panel">
            <h1>Hamid</h1>
            <p>Gestor de proyectos corporativo para equipos modernos</p>
        </div>

        <!-- Panel derecho -->
        <div class="right-panel">
            <div class="login-card">
                <h2>Iniciar Sesión</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3 input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" id="correo" name="correo" class="form-control" placeholder="Correo electrónico">
                    </div>
                    <div class="mb-3 input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" id="passwordd" name="passwordd" class="form-control" placeholder="Contraseña">
                    </div>
                    <button type="submit" class="btn btn-login w-100">Ingresar</button>
                </form>
                <div class="forgot">
                    <a href="#">¿Olvidaste tu contraseña?</a>
                </div>
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>

    <footer>© 2025 Hamid. Todos los derechos reservados.</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

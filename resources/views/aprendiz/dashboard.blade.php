<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Aprendiz</title>
</head>
<body>
    <h1>Bienvenido Aprendiz {{ Auth::user()->name }}</h1>
    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout" id="btnLogout">
                       
                        Cerrar sesión
                    </button>
                </form>
</body>
</html>
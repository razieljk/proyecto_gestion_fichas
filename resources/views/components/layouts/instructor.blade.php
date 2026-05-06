<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Panel Instructor' }} - SENA</title>
    @vite(['resources/css/app.css', 'resources/css/instructor.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-icon"><i class="bi bi-mortarboard-fill"></i></div>
            <div>
                <span>Gestión Académica</span>
                <small>SENA</small>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">Principal</div>
            <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>

            <div class="nav-section">Gestión</div>
            <a href="{{ route('instructor.fichas.index') }}" class="nav-item {{ request()->routeIs('instructor.fichas*') ? 'active' : '' }}">
                <i class="bi bi-folder2-open"></i> Mis Fichas
            </a>
            <a href="{{ route('instructor.trabajos.index') }}" class="nav-item {{ request()->routeIs('instructor.trabajos*') ? 'active' : '' }}">
                <i class="bi bi-journal-check"></i> Trabajos
            </a>
            <a href="{{ route('instructor.inasistencias.index') }}" class="nav-item {{ request()->routeIs('instructor.inasistencias*') ? 'active' : '' }}">
                <i class="bi bi-calendar-x"></i> Inasistencias
            </a>
            <a href="{{ route('instructor.evidencias.index') }}" class="nav-item {{ request()->routeIs('instructor.evidencias*') ? 'active' : '' }}">
                <i class="bi bi-paperclip"></i> Evidencias
            </a>

            <a href="{{ route('instructor.reportes.index') }}" class="nav-item {{ request()->routeIs('instructor.reportes*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line"></i> Reportes
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div>
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">Instructor</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-left"></i> Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    <div class="main">
        <div class="topbar">
            <div class="topbar-title">{{ $title ?? 'Dashboard' }}</div>
            <div class="topbar-right">
                <span><i class="bi bi-calendar3"></i> {{ now()->format('d/m/Y') }}</span>
            </div>
        </div>

        <div class="content">
            {{ $slot }}
        </div>
    </div>

</body>

</html>
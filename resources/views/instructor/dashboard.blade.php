<x-layouts.instructor title="Dashboard">

    <div class="bienvenida">
        <h2>Hola, {{ Auth::user()->name }}</h2>
        <p>Aquí tienes un resumen de tus fichas y actividad reciente.</p>
    </div>

    <div class="cards-grid">
        <div class="card">
            <div class="card-icon" style="background:#e8f5e1">
                <i class="bi bi-folder2-open" style="color:#39A900"></i>
            </div>
            <div class="card-info">
                <span class="card-numero">{{ $fichas }}</span>
                <span class="card-label">Fichas activas</span>
            </div>
        </div>

        <div class="card">
            <div class="card-icon" style="background:#fff4e0">
                <i class="bi bi-journal-check" style="color:#f0a500"></i>
            </div>
            <div class="card-info">
                <span class="card-numero">{{ $trabajos }}</span>
                <span class="card-label">Trabajos activos</span>
            </div>
        </div>

        <div class="card">
            <div class="card-icon" style="background:#fdecea">
                <i class="bi bi-calendar-x" style="color:#e53935"></i>
            </div>
            <div class="card-info">
                <span class="card-numero">{{ $inasistenciasHoy }}</span>
                <span class="card-label">Inasistencias hoy</span>
            </div>
        </div>

        <div class="card">
            <div class="card-icon" style="background:#e8f0fe">
                <i class="bi bi-clock-history" style="color:#1a73e8"></i>
            </div>
            <div class="card-info">
                <span class="card-numero">{{ $porCalificar }}</span>
                <span class="card-label">Entregas por calificar</span>
            </div>
        </div>
    </div>

</x-layouts.instructor>
<x-layouts.instructor title="Reportes">

    <div class="page-header">
        <div>
            <h2>Reportes</h2>
            <p>Genera reportes de asistencia y calificaciones por ficha</p>
        </div>
    </div>

    @if($fichas->isEmpty())
        <div class="empty-state">
            <i class="bi bi-bar-chart-line"></i>
            <h3>No tienes fichas activas</h3>
            <p>Crea una ficha para poder generar reportes</p>
        </div>
    @else
        <div class="fichas-grid">
            @foreach($fichas as $ficha)
                <div class="ficha-card">
                    <div class="ficha-card-header">
                        <span class="ficha-numero"># {{ $ficha->numero_ficha_curso }}</span>
                        <span class="badge-estado badge-activo">{{ $ficha->aprendices->count() }} aprendices</span>
                    </div>
                    <h3 class="ficha-nombre">{{ $ficha->nombre_ficha_curso }}</h3>
                    <p class="ficha-proyecto">{{ $ficha->nombre_proyecto_ficha ?? 'Sin proyecto asignado' }}</p>
                    <div class="ficha-acciones">
                        <a href="{{ route('instructor.reportes.asistencia', $ficha->idfichas_cursos) }}" class="btn-accion btn-ver">
                            <i class="bi bi-calendar-check"></i> Asistencia
                        </a>
                        <a href="{{ route('instructor.reportes.calificaciones', $ficha->idfichas_cursos) }}" class="btn-accion btn-editar">
                            <i class="bi bi-journal-check"></i> Calificaciones
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</x-layouts.instructor>
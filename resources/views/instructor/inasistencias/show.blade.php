<x-layouts.instructor title="Detalle Inasistencia">

    <div class="page-header">
        <div>
            <h2>Detalle de Inasistencia</h2>
            <p>{{ $inasistencia->aprendiz->nombres_aprendiz }} {{ $inasistencia->aprendiz->apellidos_aprendiz }}
               — {{ \Carbon\Carbon::parse($inasistencia->fecha_inasistencia)->format('d/m/Y') }}</p>
        </div>
        <a href="{{ route('instructor.inasistencias.index') }}" class="btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    @if(session('success'))
        <div class="alerta-exito">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="form-card" style="max-width:600px">
        <div class="detalle-fila">
            <span class="detalle-label">Aprendiz</span>
            <span>{{ $inasistencia->aprendiz->nombres_aprendiz }} {{ $inasistencia->aprendiz->apellidos_aprendiz }}</span>
        </div>
        <div class="detalle-fila">
            <span class="detalle-label">Ficha</span>
            <span>{{ $inasistencia->ficha->nombre_ficha_curso ?? '-' }}</span>
        </div>
        <div class="detalle-fila">
            <span class="detalle-label">Fecha</span>
            <span>{{ \Carbon\Carbon::parse($inasistencia->fecha_inasistencia)->format('d/m/Y') }}</span>
        </div>
        <div class="detalle-fila">
            <span class="detalle-label">Descripción</span>
            <span>{{ $inasistencia->descripcion_inasistencia ?? '—' }}</span>
        </div>
        <div class="detalle-fila">
            <span class="detalle-label">Excusa</span>
            <span>{{ $inasistencia->excusa_inasistencia ?? 'Sin excusa' }}</span>
        </div>
        <div class="detalle-fila">
            <span class="detalle-label">Estado excusa</span>
            <span class="badge-estado
                {{ $inasistencia->estado_excusa === 'aprobada' ? 'badge-activo' : '' }}
                {{ $inasistencia->estado_excusa === 'rechazada' ? 'badge-inactivo' : '' }}
                {{ $inasistencia->estado_excusa === 'pendiente' ? 'badge-pendiente' : '' }}
                {{ $inasistencia->estado_excusa === 'sin_excusa' ? 'badge-sin-excusa' : '' }}">
                {{ ucfirst(str_replace('_', ' ', $inasistencia->estado_excusa)) }}
            </span>
        </div>

        @if($inasistencia->estado_excusa === 'pendiente')
            <div class="form-actions" style="margin-top:24px">
                <form method="POST" action="{{ route('instructor.inasistencias.aprobar', $inasistencia->id_inasistencia) }}">
                    @csrf
                    <button type="submit" class="btn-primary">
                        <i class="bi bi-check-lg"></i> Aprobar excusa
                    </button>
                </form>
                <form method="POST" action="{{ route('instructor.inasistencias.rechazar', $inasistencia->id_inasistencia) }}">
                    @csrf
                    <button type="submit" class="btn-accion btn-eliminar" style="padding:9px 18px">
                        <i class="bi bi-x-lg"></i> Rechazar excusa
                    </button>
                </form>
            </div>
        @endif
    </div>

</x-layouts.instructor>
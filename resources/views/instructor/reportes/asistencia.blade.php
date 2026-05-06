<x-layouts.instructor title="Reporte de Asistencia">

    <div class="page-header">
        <div>
            <h2>Reporte de Asistencia</h2>
            <p># {{ $ficha->numero_ficha_curso }} — {{ $ficha->nombre_ficha_curso }}</p>
        </div>
        <div style="display:flex; gap:10px">
            <a href="{{ route('instructor.reportes.pdf.asistencia', $ficha->idfichas_cursos) }}" class="btn-primary">
                <i class="bi bi-file-pdf"></i> Exportar PDF
            </a>
            <a href="{{ route('instructor.reportes.index') }}" class="btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="tabla-wrapper" style="margin-bottom:28px">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Aprendiz</th>
                    <th>Total inasistencias</th>
                    <th>Justificadas</th>
                    <th>Injustificadas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resumen as $fila)
                <tr>
                    <td>{{ $fila['aprendiz']->nombres_aprendiz }} {{ $fila['aprendiz']->apellidos_aprendiz }}</td>
                    <td>
                        <span class="badge-estado {{ $fila['total'] > 0 ? 'badge-inactivo' : 'badge-activo' }}">
                            {{ $fila['total'] }}
                        </span>
                    </td>
                    <td><span class="badge-estado badge-activo">{{ $fila['justificadas'] }}</span></td>
                    <td><span class="badge-estado badge-inactivo">{{ $fila['injustificadas'] }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; color:#aaa; padding:30px">
                        No hay aprendices en esta ficha
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="seccion-header">
        <h3>Detalle de inasistencias <span class="badge-count">{{ $inasistencias->count() }}</span></h3>
    </div>

    @if($inasistencias->isEmpty())
    <div class="empty-state">
        <i class="bi bi-calendar-check"></i>
        <h3>Sin inasistencias registradas</h3>
    </div>
    @else
    <div class="tabla-wrapper">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Aprendiz</th>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Estado excusa</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inasistencias as $inasistencia)
                <tr>
                    <td>{{ $inasistencia->aprendiz->nombres_aprendiz }} {{ $inasistencia->aprendiz->apellidos_aprendiz }}</td>
                    <td>{{ \Carbon\Carbon::parse($inasistencia->fecha_inasistencia)->format('d/m/Y') }}</td>
                    <td>{{ $inasistencia->descripcion_inasistencia ?? '—' }}</td>
                    <td>
                        <span class="badge-estado
                                    {{ $inasistencia->estado_excusa === 'aprobada' ? 'badge-activo' : '' }}
                                    {{ $inasistencia->estado_excusa === 'rechazada' ? 'badge-inactivo' : '' }}
                                    {{ $inasistencia->estado_excusa === 'pendiente' ? 'badge-pendiente' : '' }}
                                    {{ $inasistencia->estado_excusa === 'sin_excusa' ? 'badge-sin-excusa' : '' }}">
                            {{ ucfirst(str_replace('_', ' ', $inasistencia->estado_excusa)) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

</x-layouts.instructor>
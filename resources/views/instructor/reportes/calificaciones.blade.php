<x-layouts.instructor title="Reporte de Calificaciones">

    <div class="page-header">
        <div>
            <h2>Reporte de Calificaciones</h2>
            <p># {{ $ficha->numero_ficha_curso }} — {{ $ficha->nombre_ficha_curso }}</p>
        </div>
        <div style="display:flex; gap:10px">
            <a href="{{ route('instructor.reportes.pdf.calificaciones', $ficha->idfichas_cursos) }}" class="btn-primary">
                <i class="bi bi-file-pdf"></i> Exportar PDF
            </a>
            <a href="{{ route('instructor.reportes.index') }}" class="btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    @if($trabajos->isEmpty())
    <div class="empty-state">
        <i class="bi bi-journal-x"></i>
        <h3>No hay trabajos en esta ficha</h3>
    </div>
    @else
    @foreach($trabajos as $trabajo)
    <div style="margin-bottom:32px">
        <div class="seccion-header">
            <h3>{{ $trabajo->nombre_trabajo }}
                <span class="badge-estado {{ $trabajo->estado_trabajo === 'activo' ? 'badge-activo' : 'badge-pendiente' }}" style="font-size:11px">
                    {{ ucfirst($trabajo->estado_trabajo) }}
                </span>
            </h3>
            <span style="color:#aaa; font-size:13px">
                Límite: {{ \Carbon\Carbon::parse($trabajo->fecha_limite_trabajo)->format('d/m/Y') }}
            </span>
        </div>

        <div class="tabla-wrapper">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Aprendiz</th>
                        <th>Estado entrega</th>
                        <th>Fecha entrega</th>
                        <th>Calificación</th>
                        <th>Observación</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trabajo->aprendices as $aprendiz)
                    <tr>
                        <td>{{ $aprendiz->nombres_aprendiz }} {{ $aprendiz->apellidos_aprendiz }}</td>
                        <td>
                            <span class="badge-estado
                                            {{ $aprendiz->pivot->estado_entrega === 'entregado' ? 'badge-activo' : '' }}
                                            {{ $aprendiz->pivot->estado_entrega === 'pendiente' ? 'badge-pendiente' : '' }}
                                            {{ $aprendiz->pivot->estado_entrega === 'calificado' ? 'badge-calificado' : '' }}">
                                {{ ucfirst($aprendiz->pivot->estado_entrega) }}
                            </span>
                        </td>
                        <td>{{ $aprendiz->pivot->fecha_entrega ? \Carbon\Carbon::parse($aprendiz->pivot->fecha_entrega)->format('d/m/Y H:i') : '—' }}</td>
                        <td>{{ $aprendiz->pivot->calificacion_obtenida ?? '—' }}</td>
                        <td>{{ $aprendiz->pivot->observacion_entrega ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center; color:#aaa; padding:20px">
                            No hay aprendices asignados
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
    @endif

</x-layouts.instructor>
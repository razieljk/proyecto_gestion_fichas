<x-layouts.instructor title="Detalle Trabajo">

    <div class="page-header">
        <div>
            <h2>{{ $trabajo->nombre_trabajo }}</h2>
            <p>{{ $trabajo->ficha->nombre_ficha_curso ?? '' }} — Fecha límite: {{ \Carbon\Carbon::parse($trabajo->fecha_limite_trabajo)->format('d/m/Y H:i') }}</p>
        </div>
        <a href="{{ route('instructor.trabajos.index') }}" class="btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    @if(session('success'))
        <div class="alerta-exito">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="tabla-wrapper">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Aprendiz</th>
                    <th>Estado</th>
                    <th>Fecha entrega</th>
                    <th>Calificación</th>
                    <th>Calificar</th>
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
                        <td>
                            <form method="POST" action="{{ route('instructor.trabajos.calificar', $trabajo->id_trabajos) }}">
                                @csrf
                                <input type="hidden" name="aprendiz_id" value="{{ $aprendiz->id_aprendices }}">
                                <div style="display:flex; gap:6px; align-items:center">
                                    <input type="text" name="calificacion" placeholder="Nota"
                                           value="{{ $aprendiz->pivot->calificacion_obtenida }}"
                                           style="width:70px; padding:5px 8px; border:1px solid #ddd; border-radius:6px; font-size:13px">
                                    <input type="text" name="observacion_entrega" placeholder="Observación"
                                           value="{{ $aprendiz->pivot->observacion_entrega }}"
                                           style="width:150px; padding:5px 8px; border:1px solid #ddd; border-radius:6px; font-size:13px">
                                    <button type="submit" class="btn-accion btn-ver">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; color:#aaa; padding:30px">
                            No hay aprendices asignados a este trabajo
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-layouts.instructor>
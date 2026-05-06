<x-layouts.instructor title="Inasistencias">

    <div class="page-header">
        <div>
            <h2>Inasistencias</h2>
            <p>Registro de inasistencias por ficha</p>
        </div>
        <a href="{{ route('instructor.inasistencias.create') }}" class="btn-primary">
            <i class="bi bi-plus-lg"></i> Registrar
        </a>
    </div>

    @if(session('success'))
        <div class="alerta-exito">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($inasistencias->isEmpty())
        <div class="empty-state">
            <i class="bi bi-calendar-check"></i>
            <h3>No hay inasistencias registradas</h3>
            <p>Registra una inasistencia cuando un aprendiz falte</p>
        </div>
    @else
        <div class="tabla-wrapper">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Aprendiz</th>
                        <th>Ficha</th>
                        <th>Fecha</th>
                        <th>Excusa</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inasistencias as $inasistencia)
                        <tr>
                            <td>{{ $inasistencia->aprendiz->nombres_aprendiz }} {{ $inasistencia->aprendiz->apellidos_aprendiz }}</td>
                            <td>{{ $inasistencia->ficha->nombre_ficha_curso ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($inasistencia->fecha_inasistencia)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge-estado
                                    {{ $inasistencia->estado_excusa === 'aprobada' ? 'badge-activo' : '' }}
                                    {{ $inasistencia->estado_excusa === 'rechazada' ? 'badge-inactivo' : '' }}
                                    {{ $inasistencia->estado_excusa === 'pendiente' ? 'badge-pendiente' : '' }}
                                    {{ $inasistencia->estado_excusa === 'sin_excusa' ? 'badge-sin-excusa' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $inasistencia->estado_excusa)) }}
                                </span>
                            </td>
                            <td>
                                <div class="ficha-acciones">
                                    <a href="{{ route('instructor.inasistencias.show', $inasistencia->id_inasistencia) }}" class="btn-accion btn-ver">
                                        <i class="bi bi-eye"></i> Ver
                                    </a>
                                    <form method="POST" action="{{ route('instructor.inasistencias.destroy', $inasistencia->id_inasistencia) }}"
                                          onsubmit="return confirm('¿Eliminar esta inasistencia?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-accion btn-eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</x-layouts.instructor>
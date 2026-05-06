<x-layouts.instructor title="Trabajos">

    <div class="page-header">
        <div>
            <h2>Trabajos</h2>
            <p>Gestiona los trabajos asignados a tus fichas</p>
        </div>
        <a href="{{ route('instructor.trabajos.create') }}" class="btn-primary">
            <i class="bi bi-plus-lg"></i> Nuevo Trabajo
        </a>
    </div>

    @if(session('success'))
        <div class="alerta-exito">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($trabajos->isEmpty())
        <div class="empty-state">
            <i class="bi bi-journal-x"></i>
            <h3>No hay trabajos aún</h3>
            <p>Crea tu primer trabajo para asignarlo a una ficha</p>
            <a href="{{ route('instructor.trabajos.create') }}" class="btn-primary">
                <i class="bi bi-plus-lg"></i> Crear trabajo
            </a>
        </div>
    @else
        <div class="tabla-wrapper">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Trabajo</th>
                        <th>Ficha</th>
                        <th>Fecha límite</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trabajos as $trabajo)
                        <tr>
                            <td>
                                <strong>{{ $trabajo->nombre_trabajo }}</strong>
                                @if($trabajo->descripcion_trabajo)
                                    <br><small style="color:#aaa">{{ Str::limit($trabajo->descripcion_trabajo, 50) }}</small>
                                @endif
                            </td>
                            <td>{{ $trabajo->ficha->nombre_ficha_curso ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($trabajo->fecha_limite_trabajo)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge-estado
                                    {{ $trabajo->estado_trabajo === 'activo' ? 'badge-activo' : '' }}
                                    {{ $trabajo->estado_trabajo === 'pendiente' ? 'badge-pendiente' : '' }}
                                    {{ $trabajo->estado_trabajo === 'cerrado' ? 'badge-inactivo' : '' }}">
                                    {{ ucfirst($trabajo->estado_trabajo) }}
                                </span>
                            </td>
                            <td>
                                <div class="ficha-acciones">
                                    <a href="{{ route('instructor.trabajos.show', $trabajo->id_trabajos) }}" class="btn-accion btn-ver">
                                        <i class="bi bi-eye"></i> Ver
                                    </a>
                                    <a href="{{ route('instructor.trabajos.edit', $trabajo->id_trabajos) }}" class="btn-accion btn-editar">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    <form method="POST" action="{{ route('instructor.trabajos.destroy', $trabajo->id_trabajos) }}"
                                          onsubmit="return confirm('¿Eliminar este trabajo?')">
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
<x-layouts.instructor title="Evidencias">

    <div class="page-header">
        <div>
            <h2>Evidencias</h2>
            <p>Archivos subidos por los aprendices</p>
        </div>
    </div>

    @if($evidencias->isEmpty())
        <div class="empty-state">
            <i class="bi bi-paperclip"></i>
            <h3>No hay evidencias aún</h3>
            <p>Las evidencias aparecerán aquí cuando los aprendices suban archivos</p>
        </div>
    @else
        <div class="tabla-wrapper">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Evidencia</th>
                        <th>Aprendiz</th>
                        <th>Trabajo</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evidencias as $evidencia)
                        <tr>
                            <td><strong>{{ $evidencia->nombre_evidencia }}</strong></td>
                            <td>{{ $evidencia->aprendiz->nombres_aprendiz }} {{ $evidencia->aprendiz->apellidos_aprendiz }}</td>
                            <td>{{ $evidencia->trabajo->nombre_trabajo ?? '-' }}</td>
                            <td>
                                <span class="badge-estado badge-pendiente">
                                    {{ ucfirst($evidencia->tipo_evidencia) }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($evidencia->fecha_subida)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('instructor.evidencias.show', $evidencia->id_evidencia) }}" class="btn-accion btn-ver">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</x-layouts.instructor>
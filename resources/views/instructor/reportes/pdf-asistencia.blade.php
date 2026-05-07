<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Asistencia</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #39A900; padding-bottom: 16px; }
        .header h1 { font-size: 20px; color: #39A900; margin: 0 0 6px; }
        .header p { margin: 2px 0; color: #666; font-size: 12px; }
        .seccion { margin-bottom: 24px; }
        .seccion h2 { font-size: 14px; color: #333; border-bottom: 1px solid #eee; padding-bottom: 6px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #39A900; color: white; padding: 8px 10px; text-align: left; font-size: 12px; }
        td { padding: 7px 10px; border-bottom: 1px solid #f0f0f0; font-size: 12px; }
        tr:nth-child(even) { background: #f9f9f9; }
        .badge { padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: 600; }
        .verde { background: #e8f5e1; color: #39A900; }
        .rojo { background: #fdecea; color: #e53935; }
        .gris { background: #f0f0f0; color: #888; }
        .footer { text-align: center; font-size: 11px; color: #aaa; margin-top: 40px; border-top: 1px solid #eee; padding-top: 12px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Reporte de Asistencia</h1>
        <p><strong>Ficha:</strong> #{{ $ficha->numero_ficha_curso }} — {{ $ficha->nombre_ficha_curso }}</p>
        <p><strong>Proyecto:</strong> {{ $ficha->nombre_proyecto_ficha ?? 'Sin proyecto asignado' }}</p>
        <p><strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="seccion">
        <h2>Resumen por aprendiz</h2>
        <table>
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
                        <td><span class="badge {{ $fila['total'] > 0 ? 'rojo' : 'verde' }}">{{ $fila['total'] }}</span></td>
                        <td><span class="badge verde">{{ $fila['justificadas'] }}</span></td>
                        <td><span class="badge rojo">{{ $fila['injustificadas'] }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;color:#aaa">Sin aprendices</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="seccion">
        <h2>Detalle de inasistencias</h2>
        <table>
            <thead>
                <tr>
                    <th>Aprendiz</th>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Estado excusa</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inasistencias as $inasistencia)
                    <tr>
                        <td>{{ $inasistencia->aprendiz->nombres_aprendiz }} {{ $inasistencia->aprendiz->apellidos_aprendiz }}</td>
                        <td>{{ \Carbon\Carbon::parse($inasistencia->fecha_inasistencia)->format('d/m/Y') }}</td>
                        <td>{{ $inasistencia->descripcion_inasistencia ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $inasistencia->estado_excusa === 'aprobada' ? 'verde' : ($inasistencia->estado_excusa === 'rechazada' ? 'rojo' : 'gris') }}">
                                {{ ucfirst(str_replace('_', ' ', $inasistencia->estado_excusa)) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;color:#aaa">Sin inasistencias</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        Generado por Plataforma de Gestión Académica SENA — {{ now()->format('d/m/Y') }}
    </div>

</body>
</html>
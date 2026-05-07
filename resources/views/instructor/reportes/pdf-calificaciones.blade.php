<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Calificaciones</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #39A900; padding-bottom: 16px; }
        .header h1 { font-size: 20px; color: #39A900; margin: 0 0 6px; }
        .header p { margin: 2px 0; color: #666; font-size: 12px; }
        .trabajo { margin-bottom: 28px; }
        .trabajo-titulo { font-size: 13px; font-weight: 700; color: #333; margin-bottom: 8px; padding: 8px 12px; background: #f4f6f4; border-left: 3px solid #39A900; }
        .trabajo-titulo span { color: #888; font-size: 11px; font-weight: 400; margin-left: 8px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        th { background: #39A900; color: white; padding: 8px 10px; text-align: left; font-size: 12px; }
        td { padding: 7px 10px; border-bottom: 1px solid #f0f0f0; font-size: 12px; }
        tr:nth-child(even) { background: #f9f9f9; }
        .badge { padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: 600; }
        .verde { background: #e8f5e1; color: #39A900; }
        .amarillo { background: #fff4e0; color: #f0a500; }
        .azul { background: #e8f0fe; color: #1a73e8; }
        .footer { text-align: center; font-size: 11px; color: #aaa; margin-top: 40px; border-top: 1px solid #eee; padding-top: 12px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Reporte de Calificaciones</h1>
        <p><strong>Ficha:</strong> #{{ $ficha->numero_ficha_curso }} — {{ $ficha->nombre_ficha_curso }}</p>
        <p><strong>Proyecto:</strong> {{ $ficha->nombre_proyecto_ficha ?? 'Sin proyecto asignado' }}</p>
        <p><strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    @forelse($trabajos as $trabajo)
        <div class="trabajo">
            <div class="trabajo-titulo">
                {{ $trabajo->nombre_trabajo }}
                <span>Límite: {{ \Carbon\Carbon::parse($trabajo->fecha_limite_trabajo)->format('d/m/Y') }}</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Aprendiz</th>
                        <th>Estado</th>
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
                                <span class="badge {{ $aprendiz->pivot->estado_entrega === 'calificado' ? 'azul' : ($aprendiz->pivot->estado_entrega === 'entregado' ? 'verde' : 'amarillo') }}">
                                    {{ ucfirst($aprendiz->pivot->estado_entrega) }}
                                </span>
                            </td>
                            <td>{{ $aprendiz->pivot->fecha_entrega ? \Carbon\Carbon::parse($aprendiz->pivot->fecha_entrega)->format('d/m/Y') : '—' }}</td>
                            <td>{{ $aprendiz->pivot->calificacion_obtenida ?? '—' }}</td>
                            <td>{{ $aprendiz->pivot->observacion_entrega ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align:center;color:#aaa">Sin aprendices</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @empty
        <p style="text-align:center;color:#aaa">No hay trabajos en esta ficha</p>
    @endforelse

    <div class="footer">
        Generado por Plataforma de Gestión Académica SENA — {{ now()->format('d/m/Y') }}
    </div>

</body>
</html>
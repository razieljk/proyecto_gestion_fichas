<x-layouts.instructor title="Detalle Evidencia">

    <div class="page-header">
        <div>
            <h2>{{ $evidencia->nombre_evidencia }}</h2>
            <p>Subida por {{ $evidencia->aprendiz->nombres_aprendiz }} {{ $evidencia->aprendiz->apellidos_aprendiz }}</p>
        </div>
        <a href="{{ route('instructor.evidencias.index') }}" class="btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="form-card" style="max-width:600px">
        <div class="detalle-fila">
            <span class="detalle-label">Nombre</span>
            <span>{{ $evidencia->nombre_evidencia }}</span>
        </div>
        <div class="detalle-fila">
            <span class="detalle-label">Descripción</span>
            <span>{{ $evidencia->descripcion_evidencia ?? '—' }}</span>
        </div>
        <div class="detalle-fila">
            <span class="detalle-label">Tipo</span>
            <span>{{ ucfirst($evidencia->tipo_evidencia) }}</span>
        </div>
        <div class="detalle-fila">
            <span class="detalle-label">Trabajo</span>
            <span>{{ $evidencia->trabajo->nombre_trabajo ?? '—' }}</span>
        </div>
        <div class="detalle-fila">
            <span class="detalle-label">Aprendiz</span>
            <span>{{ $evidencia->aprendiz->nombres_aprendiz }} {{ $evidencia->aprendiz->apellidos_aprendiz }}</span>
        </div>
        <div class="detalle-fila">
            <span class="detalle-label">Fecha subida</span>
            <span>{{ \Carbon\Carbon::parse($evidencia->fecha_subida)->format('d/m/Y H:i') }}</span>
        </div>
        <div class="detalle-fila">
            <span class="detalle-label">Archivo</span>
            <a href="{{ asset('storage/' . $evidencia->archivo_url) }}" target="_blank" class="btn-accion btn-ver">
                <i class="bi bi-download"></i> Descargar
            </a>
        </div>
    </div>

</x-layouts.instructor>
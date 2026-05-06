<x-layouts.instructor title="Editar Trabajo">

    <div class="page-header">
        <div>
            <h2>Editar Trabajo</h2>
            <p>Modifica los datos del trabajo</p>
        </div>
        <a href="{{ route('instructor.trabajos.index') }}" class="btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('instructor.trabajos.update', $trabajo->id_trabajos) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre_trabajo">Nombre del trabajo</label>
                <input type="text" id="nombre_trabajo" name="nombre_trabajo"
                       value="{{ old('nombre_trabajo', $trabajo->nombre_trabajo) }}">
                @error('nombre_trabajo')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="descripcion_trabajo">Descripción <span class="opcional">(opcional)</span></label>
                <textarea id="descripcion_trabajo" name="descripcion_trabajo"
                          rows="3">{{ old('descripcion_trabajo', $trabajo->descripcion_trabajo) }}</textarea>
                @error('descripcion_trabajo')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="fecha_limite_trabajo">Fecha límite</label>
                <input type="datetime-local" id="fecha_limite_trabajo" name="fecha_limite_trabajo"
                       value="{{ old('fecha_limite_trabajo', \Carbon\Carbon::parse($trabajo->fecha_limite_trabajo)->format('Y-m-d\TH:i')) }}">
                @error('fecha_limite_trabajo')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="estado_trabajo">Estado</label>
                <select id="estado_trabajo" name="estado_trabajo">
                    <option value="pendiente" {{ $trabajo->estado_trabajo === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="activo" {{ $trabajo->estado_trabajo === 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="cerrado" {{ $trabajo->estado_trabajo === 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                </select>
                @error('estado_trabajo')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('instructor.trabajos.index') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-lg"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>

</x-layouts.instructor>
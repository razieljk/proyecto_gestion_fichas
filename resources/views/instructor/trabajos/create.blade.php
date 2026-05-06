<x-layouts.instructor title="Nuevo Trabajo">

    <div class="page-header">
        <div>
            <h2>Nuevo Trabajo</h2>
            <p>Completa los datos para crear un trabajo</p>
        </div>
        <a href="{{ route('instructor.trabajos.index') }}" class="btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('instructor.trabajos.store') }}">
            @csrf

            <div class="form-group">
                <label for="nombre_trabajo">Nombre del trabajo</label>
                <input type="text" id="nombre_trabajo" name="nombre_trabajo"
                       value="{{ old('nombre_trabajo') }}">
                @error('nombre_trabajo')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="descripcion_trabajo">Descripción <span class="opcional">(opcional)</span></label>
                <textarea id="descripcion_trabajo" name="descripcion_trabajo"
                          rows="3">{{ old('descripcion_trabajo') }}</textarea>
                @error('descripcion_trabajo')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="fecha_limite_trabajo">Fecha límite</label>
                <input type="datetime-local" id="fecha_limite_trabajo" name="fecha_limite_trabajo"
                       value="{{ old('fecha_limite_trabajo') }}">
                @error('fecha_limite_trabajo')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="fichas_cursos_idfichas_cursos">Ficha</label>
                <select id="fichas_cursos_idfichas_cursos" name="fichas_cursos_idfichas_cursos">
                    <option value="">Selecciona una ficha</option>
                    @foreach($fichas as $ficha)
                        <option value="{{ $ficha->idfichas_cursos }}" {{ old('fichas_cursos_idfichas_cursos') == $ficha->idfichas_cursos ? 'selected' : '' }}>
                            #{{ $ficha->numero_ficha_curso }} - {{ $ficha->nombre_ficha_curso }}
                        </option>
                    @endforeach
                </select>
                @error('fichas_cursos_idfichas_cursos')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="estado_trabajo">Estado</label>
                <select id="estado_trabajo" name="estado_trabajo">
                    <option value="pendiente" {{ old('estado_trabajo') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="activo" {{ old('estado_trabajo') === 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="cerrado" {{ old('estado_trabajo') === 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                </select>
                @error('estado_trabajo')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('instructor.trabajos.index') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-lg"></i> Crear Trabajo
                </button>
            </div>
        </form>
    </div>

</x-layouts.instructor>
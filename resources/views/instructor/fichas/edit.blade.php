<x-layouts.instructor title="Editar Ficha">

    <div class="page-header">
        <div>
            <h2>Editar Ficha</h2>
            <p>Modifica los datos de la ficha</p>
        </div>
        <a href="{{ route('instructor.fichas.index') }}" class="btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('instructor.fichas.update', $ficha->idfichas_cursos) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="numero_ficha_curso">Número de ficha</label>
                <input type="text" id="numero_ficha_curso" name="numero_ficha_curso"
                       value="{{ old('numero_ficha_curso', $ficha->numero_ficha_curso) }}">
                @error('numero_ficha_curso')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nombre_ficha_curso">Nombre del programa</label>
                <input type="text" id="nombre_ficha_curso" name="nombre_ficha_curso"
                       value="{{ old('nombre_ficha_curso', $ficha->nombre_ficha_curso) }}">
                @error('nombre_ficha_curso')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nombre_proyecto_ficha">Nombre del proyecto <span class="opcional">(opcional)</span></label>
                <input type="text" id="nombre_proyecto_ficha" name="nombre_proyecto_ficha"
                       value="{{ old('nombre_proyecto_ficha', $ficha->nombre_proyecto_ficha) }}">
                @error('nombre_proyecto_ficha')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="estado_ficha_curso">Estado</label>
                <select id="estado_ficha_curso" name="estado_ficha_curso">
                    <option value="activo" {{ $ficha->estado_ficha_curso === 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ $ficha->estado_ficha_curso === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
                @error('estado_ficha_curso')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('instructor.fichas.index') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-lg"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>

</x-layouts.instructor>
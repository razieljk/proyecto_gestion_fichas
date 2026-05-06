<x-layouts.instructor title="Registrar Inasistencia">

    <div class="page-header">
        <div>
            <h2>Registrar Inasistencia</h2>
            <p>Selecciona la ficha y los aprendices que faltaron</p>
        </div>
        <a href="{{ route('instructor.inasistencias.index') }}" class="btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="form-card" style="max-width:700px">
        <form method="POST" action="{{ route('instructor.inasistencias.store') }}">
            @csrf

            <div class="form-group">
                <label for="fecha_inasistencia">Fecha de inasistencia</label>
                <input type="date" id="fecha_inasistencia" name="fecha_inasistencia"
                       value="{{ old('fecha_inasistencia', date('Y-m-d')) }}">
                @error('fecha_inasistencia')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="fichas_cursos_idfichas_cursos">Ficha</label>
                <select id="fichas_cursos_idfichas_cursos" name="fichas_cursos_idfichas_cursos"
                        data-fichas="{{ json_encode($fichas->map(function($f) {
                            return [
                                'id' => $f->idfichas_cursos,
                                'aprendices' => $f->aprendices->map(function($a) {
                                    return [
                                        'id' => $a->id_aprendices,
                                        'nombre' => $a->nombres_aprendiz . ' ' . $a->apellidos_aprendiz
                                    ];
                                })->values()
                            ];
                        })->keyBy('id')) }}">
                    <option value="">Selecciona una ficha</option>
                    @foreach($fichas as $ficha)
                        <option value="{{ $ficha->idfichas_cursos }}"
                            {{ old('fichas_cursos_idfichas_cursos') == $ficha->idfichas_cursos ? 'selected' : '' }}>
                            #{{ $ficha->numero_ficha_curso }} - {{ $ficha->nombre_ficha_curso }}
                        </option>
                    @endforeach
                </select>
                @error('fichas_cursos_idfichas_cursos')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="descripcion_inasistencia">Descripción <span class="opcional">(opcional)</span></label>
                <input type="text" id="descripcion_inasistencia" name="descripcion_inasistencia"
                       value="{{ old('descripcion_inasistencia') }}">
            </div>

            <div class="form-group" id="aprendices-container" style="display:none">
                <label>Aprendices que faltaron</label>
                <div class="aprendices-lista" id="aprendices-lista"></div>
                @error('aprendices')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('instructor.inasistencias.index') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-lg"></i> Registrar
                </button>
            </div>
        </form>
    </div>
@vite('resources/js/inasistencias.js')
</x-layouts.instructor>
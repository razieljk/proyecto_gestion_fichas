<x-layouts.instructor title="Detalle Ficha">

    <div class="page-header">
        <div>
            <h2># {{ $ficha->numero_ficha_curso }} — {{ $ficha->nombre_ficha_curso }}</h2>
            <p>{{ $ficha->nombre_proyecto_ficha ?? 'Sin proyecto asignado' }}</p>
        </div>
        <a href="{{ route('instructor.fichas.index') }}" class="btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    @if(session('success'))
        <div class="alerta-exito">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alerta-error">
            <i class="bi bi-x-circle"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Buscador de aprendices -->
    <div class="form-card" style="max-width:100%; margin-bottom:24px">
        <h3 style="font-size:15px; font-weight:700; margin-bottom:16px">Agregar aprendiz a la ficha</h3>
        <div class="buscador-wrapper">
            <input type="text" id="buscar-aprendiz" placeholder="Busca por nombre o documento..."
                   autocomplete="off">
            <div id="resultados-busqueda" class="resultados-busqueda"></div>
        </div>
        <form id="form-agregar" method="POST" action="{{ route('instructor.fichas.aprendices.agregar', $ficha->idfichas_cursos) }}">
            @csrf
            <input type="hidden" name="aprendiz_id" id="aprendiz-seleccionado">
        </form>
    </div>

    <!-- Lista de aprendices -->
    <div class="seccion-aprendices">
        <div class="seccion-header">
            <h3>Aprendices <span class="badge-count">{{ $aprendices->count() }}</span></h3>
        </div>

        @if($aprendices->isEmpty())
            <div class="empty-state">
                <i class="bi bi-people"></i>
                <h3>No hay aprendices en esta ficha</h3>
                <p>Usa el buscador de arriba para agregar aprendices</p>
            </div>
        @else
            <div class="tabla-wrapper">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Correo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aprendices as $aprendiz)
                            <tr>
                                <td>{{ $aprendiz->nombres_aprendiz }} {{ $aprendiz->apellidos_aprendiz }}</td>
                                <td>{{ $aprendiz->numdoc_aprendiz }}</td>
                                <td>{{ $aprendiz->correo_aprendiz }}</td>
                                <td>
                                    <form method="POST" action="{{ route('instructor.fichas.aprendices.quitar', [$ficha->idfichas_cursos, $aprendiz->id_aprendices]) }}"
                                          onsubmit="return confirm('¿Quitar este aprendiz de la ficha?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-accion btn-eliminar">
                                            <i class="bi bi-person-dash"></i> Quitar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @vite('resources/js/fichas-show.js')
    <script>
        window.buscarUrl = "{{ route('instructor.fichas.aprendices.buscar', $ficha->idfichas_cursos) }}";
    </script>

</x-layouts.instructor>
<x-layouts.instructor title="Mis Fichas">

    <div class="page-header">
        <div>
            <h2>Mis Fichas</h2>
            <p>Administra tus fichas de formación</p>
        </div>
        <a href="{{ route('instructor.fichas.create') }}" class="btn-primary">
            <i class="bi bi-plus-lg"></i> Nueva Ficha
        </a>
    </div>

    @if(session('success'))
        <div class="alerta-exito">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($fichas->isEmpty())
        <div class="empty-state">
            <i class="bi bi-folder2-open"></i>
            <h3>No tienes fichas aún</h3>
            <p>Crea tu primera ficha para empezar</p>
            <a href="{{ route('instructor.fichas.create') }}" class="btn-primary">
                <i class="bi bi-plus-lg"></i> Crear ficha
            </a>
        </div>
    @else
        <div class="fichas-grid">
            @foreach($fichas as $ficha)
                <div class="ficha-card">
                    <div class="ficha-card-header">
                        <span class="ficha-numero"># {{ $ficha->numero_ficha_curso }}</span>
                        <span class="badge-estado {{ $ficha->estado_ficha_curso === 'activo' ? 'badge-activo' : 'badge-inactivo' }}">
                            {{ ucfirst($ficha->estado_ficha_curso) }}
                        </span>
                    </div>
                    <h3 class="ficha-nombre">{{ $ficha->nombre_ficha_curso }}</h3>
                    <p class="ficha-proyecto">{{ $ficha->nombre_proyecto_ficha ?? 'Sin proyecto asignado' }}</p>
                    <div class="ficha-meta">
                        <span><i class="bi bi-people"></i> {{ $ficha->aprendices_count }} aprendices</span>
                    </div>
                    <div class="ficha-acciones">
                        <a href="{{ route('instructor.fichas.show', $ficha->idfichas_cursos) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('instructor.fichas.edit', $ficha->idfichas_cursos) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form method="POST" action="{{ route('instructor.fichas.destroy', $ficha->idfichas_cursos) }}"
                              onsubmit="return confirm('¿Seguro que quieres eliminar esta ficha?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-accion btn-eliminar">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</x-layouts.instructor>
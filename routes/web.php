<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas instructor
Route::middleware(['auth'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/dashboard', function () {
        $instructor = Auth::user()->instructor;

        $fichas = $instructor->fichas()->where('estado_ficha_curso', 'activo')->count();
        $trabajos = \App\Models\Trabajo::where('instructores_id_instructor', $instructor->id_instructor)
            ->where('estado_trabajo', 'activo')->count();
        $inasistenciasHoy = \App\Models\Inasistencia::where('instructores_id_instructor', $instructor->id_instructor)
            ->where('fecha_inasistencia', today())->count();
        $porCalificar = \App\Models\Trabajo::where('instructores_id_instructor', $instructor->id_instructor)
            ->whereHas('aprendices', function ($q) {
                $q->where('estado_entrega', 'entregado');
            })->count();

        return view('instructor.dashboard', compact('fichas', 'trabajos', 'inasistenciasHoy', 'porCalificar'));
    })->name('dashboard');

    Route::resource('fichas', \App\Http\Controllers\Instructor\FichaController::class);
    Route::resource('trabajos', \App\Http\Controllers\Instructor\TrabajoController::class);
    Route::post('trabajos/{id}/calificar', [\App\Http\Controllers\Instructor\TrabajoController::class, 'calificar'])->name('trabajos.calificar');
    Route::resource('inasistencias', \App\Http\Controllers\Instructor\InasistenciaController::class)->except(['edit', 'update']);
    Route::post('inasistencias/{id}/aprobar', [\App\Http\Controllers\Instructor\InasistenciaController::class, 'aprobarExcusa'])->name('inasistencias.aprobar');
    Route::post('inasistencias/{id}/rechazar', [\App\Http\Controllers\Instructor\InasistenciaController::class, 'rechazarExcusa'])->name('inasistencias.rechazar');
    Route::post('fichas/{id}/aprendices', [\App\Http\Controllers\Instructor\FichaController::class, 'agregarAprendiz'])->name('fichas.aprendices.agregar');
    Route::delete('fichas/{id}/aprendices/{aprendiz_id}', [\App\Http\Controllers\Instructor\FichaController::class, 'quitarAprendiz'])->name('fichas.aprendices.quitar');
    Route::get('fichas/{id}/aprendices/buscar', [\App\Http\Controllers\Instructor\FichaController::class, 'buscarAprendices'])->name('fichas.aprendices.buscar');
    Route::resource('evidencias', \App\Http\Controllers\Instructor\EvidenciaController::class)->only(['index', 'show']);
    Route::get('reportes', [\App\Http\Controllers\Instructor\ReporteController::class, 'index'])->name('reportes.index');
    Route::get('reportes/asistencia/{ficha_id}', [\App\Http\Controllers\Instructor\ReporteController::class, 'asistencia'])->name('reportes.asistencia');
    Route::get('reportes/calificaciones/{ficha_id}', [\App\Http\Controllers\Instructor\ReporteController::class, 'calificaciones'])->name('reportes.calificaciones');
    Route::get('reportes/pdf-asistencia/{ficha_id}', [\App\Http\Controllers\Instructor\ReporteController::class, 'pdfAsistencia'])->name('reportes.pdf.asistencia');
    Route::get('reportes/pdf-calificaciones/{ficha_id}', [\App\Http\Controllers\Instructor\ReporteController::class, 'pdfCalificaciones'])->name('reportes.pdf.calificaciones');
});

// Rutas aprendiz
Route::middleware(['auth'])->prefix('aprendiz')->name('aprendiz.')->group(function () {
    Route::get('/dashboard', function () {
        return view('aprendiz.dashboard');
    })->name('dashboard');
});

// Rutas admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

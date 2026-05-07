<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Reporte;
use App\Models\FichaCurso;
use App\Models\Inasistencia;
use App\Models\Trabajo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
    public function index()
    {
        $instructor = Auth::user()->instructor;
        $fichas = $instructor->fichas()->with('aprendices')->get();

        return view('instructor.reportes.index', compact('fichas'));
    }

    public function asistencia($ficha_id)
    {
        $instructor = Auth::user()->instructor;
        $ficha = $instructor->fichas()->with('aprendices')->findOrFail($ficha_id);

        $inasistencias = Inasistencia::where('instructores_id_instructor', $instructor->id_instructor)
            ->where('fichas_cursos_idfichas_cursos', $ficha_id)
            ->with('aprendiz')
            ->orderBy('fecha_inasistencia', 'desc')
            ->get();

        // Agrupar inasistencias por aprendiz
        $resumen = $ficha->aprendices->map(function ($aprendiz) use ($inasistencias) {
            $misInasistencias = $inasistencias->where('aprendices_id_aprendices', $aprendiz->id_aprendices);
            return [
                'aprendiz' => $aprendiz,
                'total' => $misInasistencias->count(),
                'justificadas' => $misInasistencias->where('estado_excusa', 'aprobada')->count(),
                'injustificadas' => $misInasistencias->where('estado_excusa', '!=', 'aprobada')->count(),
            ];
        });

        return view('instructor.reportes.asistencia', compact('ficha', 'resumen', 'inasistencias'));
    }

    public function calificaciones($ficha_id)
    {
        $instructor = Auth::user()->instructor;
        $ficha = $instructor->fichas()->with('aprendices')->findOrFail($ficha_id);

        $trabajos = Trabajo::where('instructores_id_instructor', $instructor->id_instructor)
            ->where('fichas_cursos_idfichas_cursos', $ficha_id)
            ->with(['aprendices'])
            ->get();

        return view('instructor.reportes.calificaciones', compact('ficha', 'trabajos'));
    }
    public function pdfAsistencia($ficha_id)
    {
        $instructor = Auth::user()->instructor;
        $ficha = $instructor->fichas()->with('aprendices')->findOrFail($ficha_id);

        $inasistencias = Inasistencia::where('instructores_id_instructor', $instructor->id_instructor)
            ->where('fichas_cursos_idfichas_cursos', $ficha_id)
            ->with('aprendiz')
            ->orderBy('fecha_inasistencia', 'desc')
            ->get();

        $resumen = $ficha->aprendices->map(function ($aprendiz) use ($inasistencias) {
            $misInasistencias = $inasistencias->where('aprendices_id_aprendices', $aprendiz->id_aprendices);
            return [
                'aprendiz' => $aprendiz,
                'total' => $misInasistencias->count(),
                'justificadas' => $misInasistencias->where('estado_excusa', 'aprobada')->count(),
                'injustificadas' => $misInasistencias->where('estado_excusa', '!=', 'aprobada')->count(),
            ];
        });

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('instructor.reportes.pdf-asistencia', compact('ficha', 'resumen', 'inasistencias'));
        return $pdf->download('reporte-asistencia-' . $ficha->numero_ficha_curso . '.pdf');
    }

    public function pdfCalificaciones($ficha_id)
    {
        $instructor = Auth::user()->instructor;
        $ficha = $instructor->fichas()->with('aprendices')->findOrFail($ficha_id);

        $trabajos = Trabajo::where('instructores_id_instructor', $instructor->id_instructor)
            ->where('fichas_cursos_idfichas_cursos', $ficha_id)
            ->with(['aprendices'])
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('instructor.reportes.pdf-calificaciones', compact('ficha', 'trabajos'));
        return $pdf->download('reporte-calificaciones-' . $ficha->numero_ficha_curso . '.pdf');
    }
}

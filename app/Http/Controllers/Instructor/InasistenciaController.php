<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Inasistencia;
use App\Models\FichaCurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InasistenciaController extends Controller
{
    public function index()
    {
        $instructor = Auth::user()->instructor;
        $inasistencias = Inasistencia::where('instructores_id_instructor', $instructor->id_instructor)
            ->with(['aprendiz', 'ficha'])
            ->orderBy('fecha_inasistencia', 'desc')
            ->get();

        return view('instructor.inasistencias.index', compact('inasistencias'));
    }

    public function create()
    {
        $instructor = Auth::user()->instructor;
        $fichas = $instructor->fichas()->where('estado_ficha_curso', 'activo')
            ->with('aprendices')
            ->get();

        return view('instructor.inasistencias.create', compact('fichas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_inasistencia'          => 'required|date',
            'descripcion_inasistencia'    => 'nullable|string|max:100',
            'fichas_cursos_idfichas_cursos' => 'required|exists:fichas_cursos,idfichas_cursos',
            'aprendices'                  => 'required|array|min:1',
        ]);

        $instructor = Auth::user()->instructor;

        foreach ($request->aprendices as $aprendiz_id) {
            Inasistencia::create([
                'fecha_inasistencia'            => $request->fecha_inasistencia,
                'descripcion_inasistencia'      => $request->descripcion_inasistencia,
                'estado_excusa'                 => 'sin_excusa',
                'instructores_id_instructor'    => $instructor->id_instructor,
                'aprendices_id_aprendices'      => $aprendiz_id,
                'fichas_cursos_idfichas_cursos' => $request->fichas_cursos_idfichas_cursos,
            ]);
        }

        return redirect()->route('instructor.inasistencias.index')
            ->with('success', 'Inasistencias registradas correctamente.');
    }

    public function show($id)
    {
        $instructor = Auth::user()->instructor;
        $inasistencia = Inasistencia::where('instructores_id_instructor', $instructor->id_instructor)
            ->with(['aprendiz', 'ficha'])
            ->findOrFail($id);

        return view('instructor.inasistencias.show', compact('inasistencia'));
    }

    public function aprobarExcusa($id)
    {
        $instructor = Auth::user()->instructor;
        $inasistencia = Inasistencia::where('instructores_id_instructor', $instructor->id_instructor)
            ->findOrFail($id);
        $inasistencia->update(['estado_excusa' => 'aprobada']);

        return back()->with('success', 'Excusa aprobada.');
    }

    public function rechazarExcusa($id)
    {
        $instructor = Auth::user()->instructor;
        $inasistencia = Inasistencia::where('instructores_id_instructor', $instructor->id_instructor)
            ->findOrFail($id);
        $inasistencia->update(['estado_excusa' => 'rechazada']);

        return back()->with('success', 'Excusa rechazada.');
    }

    public function destroy($id)
    {
        $instructor = Auth::user()->instructor;
        $inasistencia = Inasistencia::where('instructores_id_instructor', $instructor->id_instructor)
            ->findOrFail($id);
        $inasistencia->delete();

        return redirect()->route('instructor.inasistencias.index')
            ->with('success', 'Inasistencia eliminada.');
    }
}

<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Trabajo;
use App\Models\FichaCurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrabajoController extends Controller
{
    public function index()
    {
        $instructor = Auth::user()->instructor;
        $trabajos = Trabajo::where('instructores_id_instructor', $instructor->id_instructor)
                           ->with('ficha')
                           ->orderBy('created_at', 'desc')
                           ->get();

        return view('instructor.trabajos.index', compact('trabajos'));
    }

    public function create()
    {
        $instructor = Auth::user()->instructor;
        $fichas = $instructor->fichas()->where('estado_ficha_curso', 'activo')->get();

        return view('instructor.trabajos.create', compact('fichas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_trabajo'              => 'required|string|max:45',
            'descripcion_trabajo'         => 'nullable|string|max:400',
            'fecha_limite_trabajo'        => 'required|date|after:today',
            'estado_trabajo'              => 'required|in:pendiente,activo,cerrado',
            'fichas_cursos_idfichas_cursos' => 'required|exists:fichas_cursos,idfichas_cursos',
        ]);

        $instructor = Auth::user()->instructor;

        $trabajo = Trabajo::create([
            'nombre_trabajo'                => $request->nombre_trabajo,
            'descripcion_trabajo'           => $request->descripcion_trabajo,
            'fecha_limite_trabajo'          => $request->fecha_limite_trabajo,
            'estado_trabajo'                => $request->estado_trabajo,
            'instructores_id_instructor'    => $instructor->id_instructor,
            'fichas_cursos_idfichas_cursos' => $request->fichas_cursos_idfichas_cursos,
        ]);

        // Asignar trabajo a todos los aprendices de la ficha
        $ficha = FichaCurso::find($request->fichas_cursos_idfichas_cursos);
        foreach ($ficha->aprendices as $aprendiz) {
            $trabajo->aprendices()->attach($aprendiz->id_aprendices, [
                'estado_entrega' => 'pendiente'
            ]);
        }

        return redirect()->route('instructor.trabajos.index')
                         ->with('success', 'Trabajo creado correctamente.');
    }

    public function show($id)
    {
        $instructor = Auth::user()->instructor;
        $trabajo = Trabajo::where('instructores_id_instructor', $instructor->id_instructor)
                          ->with(['ficha', 'aprendices'])
                          ->findOrFail($id);

        return view('instructor.trabajos.show', compact('trabajo'));
    }

    public function edit($id)
    {
        $instructor = Auth::user()->instructor;
        $trabajo = Trabajo::where('instructores_id_instructor', $instructor->id_instructor)
                          ->findOrFail($id);
        $fichas = $instructor->fichas()->where('estado_ficha_curso', 'activo')->get();

        return view('instructor.trabajos.edit', compact('trabajo', 'fichas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_trabajo'       => 'required|string|max:45',
            'descripcion_trabajo'  => 'nullable|string|max:400',
            'fecha_limite_trabajo' => 'required|date',
            'estado_trabajo'       => 'required|in:pendiente,activo,cerrado',
        ]);

        $instructor = Auth::user()->instructor;
        $trabajo = Trabajo::where('instructores_id_instructor', $instructor->id_instructor)
                          ->findOrFail($id);

        $trabajo->update($request->only([
            'nombre_trabajo',
            'descripcion_trabajo',
            'fecha_limite_trabajo',
            'estado_trabajo',
        ]));

        return redirect()->route('instructor.trabajos.index')
                         ->with('success', 'Trabajo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $instructor = Auth::user()->instructor;
        $trabajo = Trabajo::where('instructores_id_instructor', $instructor->id_instructor)
                          ->findOrFail($id);
        $trabajo->delete();

        return redirect()->route('instructor.trabajos.index')
                         ->with('success', 'Trabajo eliminado correctamente.');
    }

    public function calificar(Request $request, $id)
    {
        $request->validate([
            'aprendiz_id'         => 'required',
            'calificacion'        => 'required|string|max:45',
            'observacion_entrega' => 'nullable|string|max:400',
        ]);

        $instructor = Auth::user()->instructor;
        $trabajo = Trabajo::where('instructores_id_instructor', $instructor->id_instructor)
                          ->findOrFail($id);

        $trabajo->aprendices()->updateExistingPivot($request->aprendiz_id, [
            'calificacion_obtenida' => $request->calificacion,
            'observacion_entrega'   => $request->observacion_entrega,
            'estado_entrega'        => 'calificado',
        ]);

        return back()->with('success', 'Calificación guardada.');
    }
}
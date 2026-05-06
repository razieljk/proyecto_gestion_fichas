<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\FichaCurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FichaController extends Controller
{
    public function index()
    {
        $instructor = Auth::user()->instructor;
        $fichas = $instructor->fichas()->withCount('aprendices')->get();

        return view('instructor.fichas.index', compact('fichas'));
    }

    public function create()
    {
        return view('instructor.fichas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_ficha_curso'    => 'required|string|max:45',
            'nombre_ficha_curso'    => 'required|string|max:100',
            'nombre_proyecto_ficha' => 'nullable|string|max:200',
            'estado_ficha_curso'    => 'required|in:activo,inactivo',
        ]);

        $ficha = FichaCurso::create($request->only([
            'numero_ficha_curso',
            'nombre_ficha_curso',
            'nombre_proyecto_ficha',
            'estado_ficha_curso',
        ]));

        $instructor = Auth::user()->instructor;
        $instructor->fichas()->attach($ficha->idfichas_cursos);

        return redirect()->route('instructor.fichas.index')
            ->with('success', 'Ficha creada correctamente.');
    }

    public function show($id)
    {
        $instructor = Auth::user()->instructor;
        $ficha = $instructor->fichas()->withCount('aprendices')->findOrFail($id);
        $aprendices = $ficha->aprendices;

        return view('instructor.fichas.show', compact('ficha', 'aprendices'));
    }

    public function edit($id)
    {
        $instructor = Auth::user()->instructor;
        $ficha = $instructor->fichas()->findOrFail($id);

        return view('instructor.fichas.edit', compact('ficha'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numero_ficha_curso'    => 'required|string|max:45',
            'nombre_ficha_curso'    => 'required|string|max:100',
            'nombre_proyecto_ficha' => 'nullable|string|max:200',
            'estado_ficha_curso'    => 'required|in:activo,inactivo',
        ]);

        $instructor = Auth::user()->instructor;
        $ficha = $instructor->fichas()->findOrFail($id);
        $ficha->update($request->only([
            'numero_ficha_curso',
            'nombre_ficha_curso',
            'nombre_proyecto_ficha',
            'estado_ficha_curso',
        ]));

        return redirect()->route('instructor.fichas.index')
            ->with('success', 'Ficha actualizada correctamente.');
    }

    public function destroy($id)
    {
        $instructor = Auth::user()->instructor;
        $ficha = $instructor->fichas()->findOrFail($id);
        $instructor->fichas()->detach($id);
        $ficha->delete();

        return redirect()->route('instructor.fichas.index')
            ->with('success', 'Ficha eliminada correctamente.');
    }
    public function agregarAprendiz(Request $request, $id)
    {
        $request->validate([
            'aprendiz_id' => 'required|exists:aprendices,id_aprendices',
        ]);

        $instructor = Auth::user()->instructor;
        $ficha = $instructor->fichas()->findOrFail($id);

        // Verificar que no esté ya en la ficha
        if ($ficha->aprendices()->where('aprendices_id_aprendices', $request->aprendiz_id)->exists()) {
            return back()->with('error', 'El aprendiz ya está en esta ficha.');
        }

        $ficha->aprendices()->attach($request->aprendiz_id);

        return back()->with('success', 'Aprendiz agregado correctamente.');
    }

    public function quitarAprendiz(Request $request, $id, $aprendiz_id)
    {
        $instructor = Auth::user()->instructor;
        $ficha = $instructor->fichas()->findOrFail($id);
        $ficha->aprendices()->detach($aprendiz_id);

        return back()->with('success', 'Aprendiz removido de la ficha.');
    }
    public function buscarAprendices(Request $request, $id)
    {
        $query = $request->get('q');
        $instructor = Auth::user()->instructor;
        $ficha = $instructor->fichas()->findOrFail($id);

        $aprendicesEnFicha = $ficha->aprendices()->pluck('aprendices_id_aprendices');

        $aprendices = \App\Models\Aprendiz::where(function ($q) use ($query) {
            $q->where('nombres_aprendiz', 'like', "%$query%")
                ->orWhere('apellidos_aprendiz', 'like', "%$query%")
                ->orWhere('numdoc_aprendiz', 'like', "%$query%");
        })
            ->whereNotIn('id_aprendices', $aprendicesEnFicha)
            ->limit(5)
            ->get();

        return response()->json($aprendices);
    }
}

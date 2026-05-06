<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Evidencia;
use App\Models\Trabajo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvidenciaController extends Controller
{
    public function index()
    {
        $instructor = Auth::user()->instructor;
        $evidencias = Evidencia::whereHas('trabajo', function($q) use ($instructor) {
                $q->where('instructores_id_instructor', $instructor->id_instructor);
            })
            ->with(['aprendiz', 'trabajo'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('instructor.evidencias.index', compact('evidencias'));
    }

    public function show($id)
    {
        $instructor = Auth::user()->instructor;
        $evidencia = Evidencia::whereHas('trabajo', function($q) use ($instructor) {
                $q->where('instructores_id_instructor', $instructor->id_instructor);
            })
            ->with(['aprendiz', 'trabajo'])
            ->findOrFail($id);

        return view('instructor.evidencias.show', compact('evidencia'));
    }
}
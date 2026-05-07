<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FichaCurso extends Model
{
    protected $table = 'fichas_cursos';
    protected $primaryKey = 'idfichas_cursos';

    protected $fillable = [
        'numero_ficha_curso',
        'nombre_ficha_curso',
        'nombre_proyecto_ficha',
        'estado_ficha_curso',
        'cantidad_aprendices_ficha'
    ];

    public function instructores()
    {
        return $this->belongsToMany(Instructor::class, 'instructores_has_fichas',
            'fichas_cursos_idfichas_cursos', 'instructores_id_instructor');
    }

    public function aprendices()
    {
        return $this->belongsToMany(Aprendiz::class, 'fichas_has_aprendices',
            'fichas_cursos_idfichas_cursos', 'aprendices_id_aprendices');
    }

    public function trabajos()
    {
        return $this->hasMany(Trabajo::class, 'fichas_cursos_idfichas_cursos');
    }

    public function inasistencias()
    {
        return $this->hasMany(Inasistencia::class, 'fichas_cursos_idfichas_cursos');
    }
}
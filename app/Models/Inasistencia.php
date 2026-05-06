<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inasistencia extends Model
{
    protected $table = 'inasistencias';
    protected $primaryKey = 'id_inasistencia';

    protected $fillable = [
        'fecha_inasistencia',
        'descripcion_inasistencia',
        'excusa_inasistencia',
        'estado_excusa',
        'instructores_id_instructor',
        'aprendices_id_aprendices',
        'fichas_cursos_idfichas_cursos'
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructores_id_instructor');
    }

    public function aprendiz()
    {
        return $this->belongsTo(Aprendiz::class, 'aprendices_id_aprendices');
    }

    public function ficha()
    {
        return $this->belongsTo(FichaCurso::class, 'fichas_cursos_idfichas_cursos');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $table = 'reportes';
    protected $primaryKey = 'id_reporte';

    protected $fillable = [
        'fecha_reporte',
        'nombre_reporte',
        'tipo_reporte',
        'instructores_id_instructor',
        'fichas_cursos_idfichas_cursos'
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructores_id_instructor');
    }

    public function ficha()
    {
        return $this->belongsTo(FichaCurso::class, 'fichas_cursos_idfichas_cursos');
    }
}
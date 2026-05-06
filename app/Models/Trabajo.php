<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    protected $table = 'trabajos';
    protected $primaryKey = 'id_trabajos';

    protected $fillable = [
        'nombre_trabajo',
        'descripcion_trabajo',
        'fecha_publicacion_trabajo',
        'fecha_limite_trabajo',
        'estado_trabajo',
        'calificacion_trabajo',
        'observacion_trabajo',
        'comentario_trabajo',
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

    public function aprendices()
    {
        return $this->belongsToMany(Aprendiz::class, 'aprendices_has_trabajos',
            'trabajos_id_trabajos', 'aprendices_id_aprendices')
            ->withPivot('fecha_entrega', 'archivo_entrega', 'calificacion_obtenida',
                       'estado_entrega', 'observacion_entrega')
            ->withTimestamps();
    }

    public function evidencias()
    {
        return $this->hasMany(Evidencia::class, 'trabajos_id_trabajos');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aprendiz extends Model
{
    protected $table = 'aprendices';
    protected $primaryKey = 'id_aprendices';

    protected $fillable = [
        'numdoc_aprendiz',
        'nombres_aprendiz',
        'apellidos_aprendiz',
        'correo_aprendiz',
        'fecha_nacimiento_aprendiz',
        'users_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function fichas()
    {
        return $this->belongsToMany(FichaCurso::class, 'fichas_has_aprendices',
            'aprendices_id_aprendices', 'fichas_cursos_idfichas_cursos');
    }

    public function trabajos()
    {
        return $this->belongsToMany(Trabajo::class, 'aprendices_has_trabajos',
            'aprendices_id_aprendices', 'trabajos_id_trabajos')
            ->withPivot('fecha_entrega', 'archivo_entrega', 'calificacion_obtenida', 
                       'estado_entrega', 'observacion_entrega')
            ->withTimestamps();
    }

    public function inasistencias()
    {
        return $this->hasMany(Inasistencia::class, 'aprendices_id_aprendices');
    }

    public function evidencias()
    {
        return $this->hasMany(Evidencia::class, 'aprendices_id_aprendices');
    }
}
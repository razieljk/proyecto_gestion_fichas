<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $table = 'instructores';
    protected $primaryKey = 'id_instructor';

    protected $fillable = [
        'numdoc_instructor',
        'nombres_instructor',
        'apellidos_instructor',
        'correo_instructor',
        'fecha_nacimiento_instructor',
        'users_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function fichas()
    {
        return $this->belongsToMany(FichaCurso::class, 'instructores_has_fichas', 
            'instructores_id_instructor', 'fichas_cursos_idfichas_cursos');
    }

    public function trabajos()
    {
        return $this->hasMany(Trabajo::class, 'instructores_id_instructor');
    }

    public function inasistencias()
    {
        return $this->hasMany(Inasistencia::class, 'instructores_id_instructor');
    }
}
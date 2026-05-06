<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
    protected $table = 'evidencias';
    protected $primaryKey = 'id_evidencia';

    protected $fillable = [
        'nombre_evidencia',
        'descripcion_evidencia',
        'archivo_url',
        'tipo_evidencia',
        'fecha_subida',
        'aprendices_id_aprendices',
        'trabajos_id_trabajos'
    ];

    public function aprendiz()
    {
        return $this->belongsTo(Aprendiz::class, 'aprendices_id_aprendices');
    }

    public function trabajo()
    {
        return $this->belongsTo(Trabajo::class, 'trabajos_id_trabajos');
    }
}
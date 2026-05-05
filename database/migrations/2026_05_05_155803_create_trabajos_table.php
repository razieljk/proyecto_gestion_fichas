<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trabajos', function (Blueprint $table) {
            $table->id('id_trabajos');
            $table->string('nombre_trabajo', 45);
            $table->string('descripcion_trabajo', 400)->nullable();
            $table->datetime('fecha_publicacion_trabajo')->useCurrent();
            $table->datetime('fecha_limite_trabajo');
            $table->string('estado_trabajo', 45)->default('pendiente');
            $table->string('calificacion_trabajo', 45)->nullable();
            $table->string('observacion_trabajo', 400)->nullable();
            $table->string('comentario_trabajo', 400)->nullable();
            $table->unsignedBigInteger('instructores_id_instructor');
            $table->unsignedBigInteger('fichas_cursos_idfichas_cursos');
            $table->timestamps();

            $table->foreign('instructores_id_instructor')
                  ->references('id_instructor')
                  ->on('instructores')
                  ->onDelete('cascade');

            $table->foreign('fichas_cursos_idfichas_cursos')
                  ->references('idfichas_cursos')
                  ->on('fichas_cursos')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trabajos');
    }
};
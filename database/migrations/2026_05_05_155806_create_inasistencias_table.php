<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inasistencias', function (Blueprint $table) {
            $table->id('id_inasistencia');
            $table->date('fecha_inasistencia');
            $table->string('descripcion_inasistencia', 100)->nullable();
            $table->string('excusa_inasistencia', 300)->nullable();
            $table->string('estado_excusa', 45)->default('sin_excusa');
            $table->unsignedBigInteger('instructores_id_instructor');
            $table->unsignedBigInteger('aprendices_id_aprendices');
            $table->unsignedBigInteger('fichas_cursos_idfichas_cursos');
            $table->timestamps();

            $table->foreign('instructores_id_instructor')
                  ->references('id_instructor')
                  ->on('instructores')
                  ->onDelete('cascade');

            $table->foreign('aprendices_id_aprendices')
                  ->references('id_aprendices')
                  ->on('aprendices')
                  ->onDelete('cascade');

            $table->foreign('fichas_cursos_idfichas_cursos')
                  ->references('idfichas_cursos')
                  ->on('fichas_cursos')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inasistencias');
    }
};
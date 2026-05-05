<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id('id_reporte');
            $table->date('fecha_reporte')->useCurrent();
            $table->string('nombre_reporte', 45);
            $table->string('tipo_reporte', 45);
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
        Schema::dropIfExists('reportes');
    }
};
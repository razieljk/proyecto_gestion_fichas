<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fichas_has_aprendices', function (Blueprint $table) {
            $table->unsignedBigInteger('fichas_cursos_idfichas_cursos');
            $table->unsignedBigInteger('aprendices_id_aprendices');
            $table->primary(['fichas_cursos_idfichas_cursos', 'aprendices_id_aprendices']);

            $table->foreign('fichas_cursos_idfichas_cursos')
                  ->references('idfichas_cursos')
                  ->on('fichas_cursos')
                  ->onDelete('cascade');

            $table->foreign('aprendices_id_aprendices')
                  ->references('id_aprendices')
                  ->on('aprendices')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fichas_has_aprendices');
    }
};
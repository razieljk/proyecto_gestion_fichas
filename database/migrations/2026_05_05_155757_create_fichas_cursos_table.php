<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fichas_cursos', function (Blueprint $table) {
            $table->id('idfichas_cursos');
            $table->string('numero_ficha_curso', 45);
            $table->string('nombre_ficha_curso', 100);
            $table->string('nombre_proyecto_ficha', 200)->nullable();
            $table->string('estado_ficha_curso', 45)->default('activo');
            $table->integer('cantidad_aprendices_ficha')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fichas_cursos');
    }
};
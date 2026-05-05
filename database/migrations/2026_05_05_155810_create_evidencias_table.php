<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evidencias', function (Blueprint $table) {
            $table->id('id_evidencia');
            $table->string('nombre_evidencia', 100);
            $table->string('descripcion_evidencia', 300)->nullable();
            $table->string('archivo_url', 300);
            $table->string('tipo_evidencia', 45);
            $table->datetime('fecha_subida')->useCurrent();
            $table->unsignedBigInteger('aprendices_id_aprendices');
            $table->unsignedBigInteger('trabajos_id_trabajos');
            $table->timestamps();

            $table->foreign('aprendices_id_aprendices')
                  ->references('id_aprendices')
                  ->on('aprendices')
                  ->onDelete('cascade');

            $table->foreign('trabajos_id_trabajos')
                  ->references('id_trabajos')
                  ->on('trabajos')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evidencias');
    }
};
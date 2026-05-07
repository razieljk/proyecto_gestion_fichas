<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aprendices_has_trabajos', function (Blueprint $table) {
            $table->unsignedBigInteger('aprendices_id_aprendices');
            $table->unsignedBigInteger('trabajos_id_trabajos');
            $table->primary(['aprendices_id_aprendices', 'trabajos_id_trabajos']);
            $table->datetime('fecha_entrega')->nullable();
            $table->string('archivo_entrega', 300)->nullable();
            $table->string('calificacion_obtenida', 45)->nullable();
            $table->string('estado_entrega', 45)->default('pendiente');
            $table->string('observacion_entrega', 400)->nullable();
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
        Schema::dropIfExists('aprendices_has_trabajos');
    }
};
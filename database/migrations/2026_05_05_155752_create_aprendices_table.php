<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aprendices', function (Blueprint $table) {
            $table->id('id_aprendices');
            $table->string('numdoc_aprendiz', 50)->unique();
            $table->string('nombres_aprendiz', 45);
            $table->string('apellidos_aprendiz', 45);
            $table->string('correo_aprendiz', 45);
            $table->date('fecha_nacimiento_aprendiz')->nullable();
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aprendices');
    }
};
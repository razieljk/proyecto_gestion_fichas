<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instructores', function (Blueprint $table) {
            $table->id('id_instructor');
            $table->string('numdoc_instructor', 100)->unique();
            $table->string('nombres_instructor', 45);
            $table->string('apellidos_instructor', 45);
            $table->string('correo_instructor', 45);
            $table->date('fecha_nacimiento_instructor')->nullable();
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instructores');
    }
};
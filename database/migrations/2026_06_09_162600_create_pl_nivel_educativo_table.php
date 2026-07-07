<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pl_nivel_educativo', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ficha_empleado');
            $table->string('nivel_educativo');
            $table->string('titulo')->nullable();
            $table->string('especialidad')->nullable();
            $table->string('instituto')->nullable();
            $table->boolean('graduado')->default(false);
            $table->integer('fecha_culminado')->nullable();
            $table->boolean('ultimo_nivel')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pl_nivel_educativo');
    }
};

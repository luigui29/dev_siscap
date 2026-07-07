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
        Schema::create('pl_experiencia_laboral', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ficha_empleado');
            $table->string('cargo_desempeñado');
            $table->string('empresa')->nullable();
            $table->timestamp('desde');
            $table->timestamp('hasta')->nullable();
            $table->string('observacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pl_experiencia_laboral');
    }
};

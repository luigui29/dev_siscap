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
        Schema::create('pl_programaciones', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('programacion_id');
            $table->bigInteger('ficha_empleado');
            $table->boolean('estatus')->nullable();
            $table->string('causa')->nullable();
            $table->timestamps();

            $table->foreign('programacion_id')->references('id')->on('tbl_programaciones')->onDelete('cascade');

            $table->unique(['programacion_id', 'ficha_empleado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pl_programaciones');
    }
};

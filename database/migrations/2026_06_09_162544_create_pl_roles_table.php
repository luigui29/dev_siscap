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
        Schema::create('pl_roles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ficha_empleado');
            $table->bigInteger('rol_id');
            $table->timestamp('fecha_asignado');
            $table->boolean('estatus')->default('true');
            $table->timestamps();

            $table->foreign('rol_id')->references('id')->on('roles')->onDelete('cascade');

            $table->unique(['ficha_empleado', 'rol_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pl_roles');
    }
};

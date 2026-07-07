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
        Schema::create('tbl_programaciones', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('actividad_id');
            $table->bigInteger('subactividad_id')->nullable();
            $table->bigInteger('facilitador_id');
            $table->string('institucion')->default("VENPRECAR, C.A.");
            $table->timestamp('fecha');
            $table->string('lugar');
            $table->time('desde');
            $table->time('hasta');
            $table->float('duracion');
            $table->boolean('extra')->default('false');
            $table->boolean('aprobado')->nullable();
            $table->boolean('ejecutado')->nullable();
            $table->timestamps();

            $table->foreign('actividad_id')->references('id')->on('tbl_actividades')->onDelete('cascade');
            $table->foreign('subactividad_id')->references('id')->on('tbl_subactividades')->onDelete('cascade');
            $table->foreign('facilitador_id')->references('id')->on('tbl_facilitadores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_programaciones');
    }
};

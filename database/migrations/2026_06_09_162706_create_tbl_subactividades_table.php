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
        Schema::create('tbl_subactividades', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('actividad_id');
            $table->string('nombre');
            $table->string('objetivo')->nullable();
            $table->timestamps();

            $table->foreign('actividad_id')->references('id')->on('tbl_actividades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_subactividades');
    }
};

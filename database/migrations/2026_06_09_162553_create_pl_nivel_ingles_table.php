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
        Schema::create('pl_nivel_ingles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ficha_empleado');
            $table->boolean('i1')->default(false);
            $table->boolean('i2')->default(false);
            $table->boolean('bb')->default(false);
            $table->boolean('ba')->default(false);
            $table->boolean('ib')->default(false);
            $table->boolean('ia')->default(false);
            $table->boolean('ab')->default(false);
            $table->boolean('aa')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pl_nivel_ingles');
    }
};

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
       Schema::create('alimentos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre'); // Ej: Avena
        $table->float('kcal_100g');
        $table->float('proteinas_100g');
        $table->float('carbohidratos_100g');
        $table->float('grasas_100g');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alimentos');
    }
};

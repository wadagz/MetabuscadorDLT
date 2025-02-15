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
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', length: 100);
            $table->decimal('latitud', 10, 8);
            $table->decimal('longitud', 11, 8);
            $table->foreignId('id_tipo_vialidad')->constrained('tipos_vialidad');
            $table->foreignId('id_asentamiento')->constrained('asentamientos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};

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
        Schema::create('itinerarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_viaje_id')->constrained('planes_viaje')->onDelete('cascade');
            $table->foreignId('ruta_transporte_id')->constrained('rutas_transporte')->onDelete('cascade');
            $table->tinyInteger('orden');
            $table->enum('tipo', ['ida', 'regreso']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerarios');
    }
};

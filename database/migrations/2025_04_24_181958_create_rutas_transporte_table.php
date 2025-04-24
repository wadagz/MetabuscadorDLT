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
        Schema::create('rutas_transporte', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_transporte_id')->constrained('empresas_transporte')->onDelete('cascade');
            $table->foreignId('destino_origen_id')->constrained('destinos')->onDelete('cascade');
            $table->foreignId('destino_target_id')->constrained('destinos')->onDelete('cascade');
            $table->string('tipo');
            $table->float('distancia_km', 2);
            $table->integer('duracion_min');
            $table->float('precio', 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rutas_transporte');
    }
};

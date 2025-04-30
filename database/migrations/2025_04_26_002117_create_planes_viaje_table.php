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
        Schema::create('planes_viaje', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('hospedaje_id')->constrained('hospedajes')->onDelete('cascade');
            $table->string('punto_partida');
            $table->string('destino');
            $table->date('fecha_comienzo');
            $table->date('fecha_fin');
            $table->float('precio', precision: 2);
            $table->boolean('viaje_redondo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planes_viaje');
    }
};

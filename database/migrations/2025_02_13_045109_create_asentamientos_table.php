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
        Schema::create('asentamientos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', length: 100);
            $table->unsignedInteger('id_tipo_asentamiento');
            $table->unsignedInteger('id_codigo_postal');
            $table->unsignedInteger('id_municipio');
            $table->unsignedTinyInteger('id_estado');

            $table->foreign('id_tipo_asentamiento')->references('id')->on('tipos_asentamiento');
            $table->foreign('id_codigo_postal')->references('id')->on('codigos_postales');
            $table->foreign('id_municipio')->references('id')->on('municipios');
            $table->foreign('id_estado')->references('id')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asentamientos');
    }
};

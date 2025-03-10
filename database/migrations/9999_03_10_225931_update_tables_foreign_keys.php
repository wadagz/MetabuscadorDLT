<?php

/**
 * Este archivo esta hecho para agregar las columnas y restricciones de llaves
 * foráneas en las tablas.
 * Esto con el propósito de evitar problemas de que
 * las tablan a las cuales se hace referencia no han sido creadas.
 */

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
        Schema::table('asentamientos', function (Blueprint $table) {
            $table->foreign('id_tipo_asentamiento')->references('id')->on('tipos_asentamiento');
            $table->foreign('id_municipio')->references('id')->on('municipios');
            $table->foreign('id_estado')->references('id')->on('estados');
        });

        Schema::table('destinos', function (Blueprint $table) {
            $table->foreign('id_municipio')->references('id')->on('municipios')->cascadeOnDelete();
            $table->foreign('id_estado')->references('id')->on('estados')->cascadeOnDelete();
        });

        Schema::table('municipios', function (Blueprint $table) {
            $table->foreign('id_estado')->references('id')->on('estados');
        });

        Schema::table('direcciones', function (Blueprint $table) {
            $table->foreignId('id_tipo_vialidad')->constrained('tipos_vialidad');
            $table->foreignId('id_asentamiento')->constrained('asentamientos');
        });

        Schema::table('hospedajes', function (Blueprint $table) {
            // Agregar atributos para almacenar llaves foráneas
            // $table->foreignId('direccion_id')->constrained('direcciones');
            $table->foreignId('tipo_hospedaje_id')->constrained('tipo_hospedajes');
            $table->foreignId('propietario_id')->constrained('propietarios');
            $table->foreignId('destino_id')->constrained('destinos')->onDelete('cascade');
        });

        Schema::table('favoritos_hospedaje_usuario', function (Blueprint $table) {
            $table->foreignId('hospedaje_id')->constrained('hospedajes')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        });

        Schema::table('actividades', function (Blueprint $table) {
            $table->foreignId('destino_id')->constrained('destinos')->onDelete('cascade');
            $table->foreignId('direccion_id')->constrained('direcciones')->onDelete('cascade');
            $table->foreignId('tipo_actividad_id')->constrained('tipos_actividad')->onDelete('cascade');
        });

        Schema::table('horarios_semanales', function (Blueprint $table) {
            $table->foreignId('actividad_id')->constrained('actividades')->onDelete('cascade');
        });

        Schema::table('horarios_eventuales', function (Blueprint $table) {
            $table->foreignId('actividad_id')->constrained('actividades')->onDelete('cascade');
        });

        Schema::table('preferencias_usuarios', function (Blueprint $table) {
            $table->foreignId('usuario_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('preferencia_id')->constrained('preferencias', 'id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

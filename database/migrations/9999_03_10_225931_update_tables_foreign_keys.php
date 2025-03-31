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
            // Remove this line since you're using enums
            // $table->foreign('id_tipo_asentamiento')->references('id')->on('tipos_asentamiento');
            
            $table->foreign('id_municipio')->references('id')->on('municipios');
            $table->foreign('id_estado')->references('id')->on('estados');
        });

        Schema::table('municipios', function (Blueprint $table) {
            $table->foreign('id_estado')->references('id')->on('estados');
        });

        // Remove this entire block since you're using enums for these columns
        // Schema::table('direcciones', function (Blueprint $table) {
        //     $table->foreign('id_tipo_vialidad')->references('id')->on('tipos_vialidad');
        //     $table->foreign('id_asentamiento')->references('id')->on('asentamientos');
        // });

        Schema::table('hospedajes', function (Blueprint $table) {
            // You'll need to add the direccion_id column if it doesn't exist
            if (!Schema::hasColumn('hospedajes', 'direccion_id')) {
                $table->unsignedBigInteger('direccion_id')->nullable()->after('destino_id');
                $table->foreign('direccion_id')->references('id')->on('direcciones');
            }
            
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
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('preferencia_id')->constrained('preferencias', 'id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Since you're planning to use this with existing tables, 
        // I've kept the down method empty as dropping constraints 
        // might cause issues if they don't exist
    }
};
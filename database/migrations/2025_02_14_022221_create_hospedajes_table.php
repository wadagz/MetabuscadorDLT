<?php

use App\Http\Controllers\TipoHospedaje;
use App\Models\Propietario;
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
        Schema::create('hospedajes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', length: 100);
            $table->float('precio', precision: 2);
            $table->string('url', length: 500);
            // Agregar atributos para almacenar llaves foráneas
            $table->foreignId('tipo_hospedaje_id')->constrained('tipo_hospedajes');
            $table->foreignId('propietario_id')->constrained('propietarios');
            $table->foreignId('destino_id')->constrained('destinos')->onDelete('cascade');
            // $table->foreignId('direccion_id')->constrained('direcciones');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospedajes');
    }
};

<?php

use App\Enums\TipoHospedajeEnum;
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
            $table->enum('tipo_hospedaje', TipoHospedajeEnum::values());
            $table->text('descripcion')->nullable();
            $table->string('img_path');
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

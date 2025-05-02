<?php

use App\Enums\TipoActividadEnum;
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
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', length: 100);
            $table->text('descripcion');
            $table->float('precio', precision: 2);
            $table->enum('categoria', TipoActividadEnum::toArray());
            $table->enum('tipo', ['recurrente', 'eventual']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};

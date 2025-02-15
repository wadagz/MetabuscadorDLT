<?php

use App\Models\Amenidad;
use App\Models\Hospedaje;
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
        Schema::create('amenidad_hospedaje', function (Blueprint $table) {
            $table->foreignIdFor(Hospedaje::class)->constrained(table: 'hospedajes');
            $table->foreignIdFor(Amenidad::class)->constrained(table: 'amenidades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amenidad_hospedaje');
    }
};

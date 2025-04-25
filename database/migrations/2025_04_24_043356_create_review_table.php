<?php

use App\Models\Hospedaje;
use App\Models\User;
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
        Schema::create('resenas_hospedaje', function (Blueprint $table) {
            $table->id();
            $table->text('comentario')->nullable();
            $table->enum('calificacion', [1, 2, 3, 4 ,5]);
            $table->foreignId('user_id')->constrained(table: 'users')->onDelete('cascade');
            $table->foreignId('hospedaje_id')->constrained(table: 'hospedajes')->onDelete('cascade');
            $table->date('fecha');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resenas_hospedaje');
    }
};

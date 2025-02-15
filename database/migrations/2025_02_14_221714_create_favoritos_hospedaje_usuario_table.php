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
        Schema::create('favoritos_hospedaje_usuario', function (Blueprint $table) {
            $table->foreignIdFor(Hospedaje::class)
                ->constrained(table: 'hospedajes')
                ->onDelete('cascade');
            $table->foreignIdFor(User::class)
                ->constrained(table: 'users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favoritos_hospedaje_usuario');
    }
};

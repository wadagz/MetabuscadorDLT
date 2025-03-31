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
        // Add columns for tipo_vialidad and asentamiento to direcciones table
        // without foreign key constraints
        Schema::table('direcciones', function (Blueprint $table) {
            $table->unsignedBigInteger('id_tipo_vialidad')->after('longitud');
            $table->unsignedBigInteger('id_asentamiento')->after('id_tipo_vialidad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the columns if needed
        Schema::table('direcciones', function (Blueprint $table) {
            $table->dropColumn('id_tipo_vialidad');
            $table->dropColumn('id_asentamiento');
        });
    }
};
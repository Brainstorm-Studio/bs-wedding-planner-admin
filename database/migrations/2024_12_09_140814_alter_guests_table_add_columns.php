<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->integer('name')->default(0)->after('whit_plus_one');
            $table->unsignedBigInteger('country_id')->nullable()->after('id');
        });

        // Actualizar registros existentes con un valor por defecto
        DB::table('guests')->update(['country_id' => 1]); // Cambia 1 por el valor por defecto que desees

        // Cambiar la columna para que no permita valores nulos
        Schema::table('guests', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->integer('plus_one_count')->nullable()->change();
            $table->integer('total_confirmed')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
            $table->integer('plus_one_count')->nullable(false)->change();
        });
    }
};

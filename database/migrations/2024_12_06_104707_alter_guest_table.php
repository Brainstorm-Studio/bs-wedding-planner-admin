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
        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn('last_name');
            $table->renameColumn('name', 'guest_name');
            $table->string('email')->nullable()->change();
            $table->dateTime('rsvp_date')->nullable();
            $table->boolean('has_allergies')->default(false)->after('allergies');
            $table->longText('note')->nullable()->after('has_allergies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->unsignedBigInteger('wedding_id')->nullable();
            $table->string('last_name')->nullable();
            $table->renameColumn('guest_name', 'name');
            $table->dropColumn('rsvp_date');
            $table->dropColumn('has_allergies');
            $table->dropColumn('note');
        });
    }
};

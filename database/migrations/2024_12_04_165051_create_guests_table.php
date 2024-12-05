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
        Schema::create('guests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wedding_id');
            $table->unsignedBigInteger('guest_type_id');
            $table->string('name');
            $table->string('last_name');
            $table->string('couple_name')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->boolean('rsvp')->default(false);
            $table->boolean('with_plus_one')->default(false);
            $table->text('allergies')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest');
    }
};

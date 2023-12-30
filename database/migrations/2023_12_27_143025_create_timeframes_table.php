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
        Schema::create('timeframes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('field_id');
            $table->dateTime('datetime');
            $table->string('status');
            $table->timestamps();

            $table->foreign('field_id')->references('id')->on('fields');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeframes');
    }
};

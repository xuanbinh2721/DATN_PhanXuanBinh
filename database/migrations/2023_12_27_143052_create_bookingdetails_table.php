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
        Schema::create('bookingdetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('field_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('time_frame_id');
            $table->string('name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('note')->nullable();
            $table->enum('status', [0,1,2])->default(0); 
            $table->enum('payment_method', [0,1,2])->default(0); 
            $table->timestamps();

            $table->foreign('field_id')->references('id')->on('fields');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('time_frame_id')->references('id')->on('timeframes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookingdetails');
    }
};

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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feedback_id');
            $table->unsignedBigInteger('user_id');
            $table->text('comment');
            $table->enum('status', [0, 1])->default(0); 
            $table->unsignedBigInteger('parent_comment')->nullable();
            $table->timestamps();

            $table->foreign('feedback_id')->references('id')->on('feedbacks');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('parent_comment')->references('id')->on('comments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};

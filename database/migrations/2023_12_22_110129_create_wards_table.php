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
        Schema::create('wards', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('prefix')->nullable();
            $table->unsignedBigInteger('province_id')->nullable(); // Foreign key for province
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->unsignedBigInteger('district_id')->nullable(); // Foreign key for district
            $table->foreign('district_id')->references('id')->on('districts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wards');
    }
};

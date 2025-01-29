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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('name')->nullable();
            $table->date('arriving')->nullable();
            $table->date('departing')->nullable();
            $table->longText('about_trip')->nullable();
            $table->enum('is_private',['0','1'])->default('0');
            $table->longText('link')->nullable();
            $table->longText('destinations')->nullable();
            $table->longText('verticals')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};

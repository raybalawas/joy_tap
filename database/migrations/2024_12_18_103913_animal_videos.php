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
        Schema::create('animal_videos', function (Blueprint $table) {
            $table->id();
            $table->string('scene_name');
            $table->string('animal_type');
            $table->string('video_link');
            $table->string('language');
            $table->timestamps();

            // $table->foreign('scene_name')->references('id')->on('scenes')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_videos');
    }
};

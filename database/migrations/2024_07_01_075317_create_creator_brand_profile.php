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
        Schema::create('creator_brand_profile', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('profile_image')->nullable();
            $table->string('profile_img_second')->nullable();
            $table->string('profile_img_third')->nullable();
            $table->string('bio')->nullable();
            $table->string('instagram_username')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender',['male','female','other'])->nullable();
            $table->json('vertical_ids')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creator_brand_profile');
    }
};


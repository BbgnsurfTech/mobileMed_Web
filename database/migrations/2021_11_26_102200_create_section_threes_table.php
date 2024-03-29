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
        Schema::create('section_threes', function (Blueprint $table) {
            $table->id();
            $table->string('text_main', 30);
            $table->string('text_secondary', 160);
            $table->string('img_url');
            $table->string('text_one', 50);
            $table->string('text_two', 50);
            $table->string('text_three', 50)->nullable();
            $table->string('text_four', 50)->nullable();
            $table->string('text_five', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_threes');
    }
};

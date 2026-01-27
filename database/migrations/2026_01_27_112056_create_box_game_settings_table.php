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
Schema::create('box_game_settings', function (Blueprint $table) {
    $table->id();
    $table->unsignedTinyInteger('rank')->unique(); // 1〜5等
    $table->unsignedTinyInteger('probability');   // %（0〜100）
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('box_game_settings');
    }
};

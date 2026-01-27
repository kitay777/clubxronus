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
        Schema::create('blogs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cast_id')->constrained('casts')->onDelete('cascade');
        $table->string('title')->nullable(); // タイトル任意
        $table->string('image_path')->nullable(); // 画像
        $table->text('body'); // 本文
        $table->timestamp('published_at')->nullable(); // 投稿日付
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};

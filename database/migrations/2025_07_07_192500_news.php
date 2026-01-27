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
        //
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cast_id')->nullable()->constrained('casts')->onDelete('set null'); // 個別キャスト向け用
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // 投稿者（運営/キャスト）
            $table->string('title');
            $table->string('image_path')->nullable();
            $table->text('body');
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_all')->default(false); // 全キャスト向けフラグ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('news');
    }
};

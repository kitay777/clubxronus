<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('coupons', function (Blueprint $table) {
        $table->id();
        $table->foreignId('shop_id')->constrained('shops')->onDelete('cascade');
        $table->string('title');           // クーポン名
        $table->string('image_path')->nullable(); // クーポン画像
        $table->text('description')->nullable();  // 説明文
        $table->date('valid_until')->nullable();  // 有効期限
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};

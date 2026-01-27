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
    Schema::create('system_prices', function (Blueprint $table) {
        $table->id();
        $table->string('title');      // 項目名（例：SET料金）
        $table->string('value');      // 内容（例：60分 6000円）
        $table->string('type')->nullable(); // 種別（例：set, 指名, card, info など分けてもOK）
        $table->integer('order')->default(0); // 表示順
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_prices');
    }
};

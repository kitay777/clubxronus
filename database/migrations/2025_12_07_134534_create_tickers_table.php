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
    Schema::create('tickers', function (Blueprint $table) {
        $table->id();
        $table->string('text');     // テロップ内容
        $table->integer('order')->default(0); // 並び順
        $table->boolean('is_active')->default(true); // ON/OFF
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickers');
    }
};

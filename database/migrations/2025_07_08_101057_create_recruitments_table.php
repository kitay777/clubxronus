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
    Schema::create('recruitments', function (Blueprint $table) {
        $table->id();
        $table->string('category');     // 職種（キャスト／メンズ等）
        $table->string('job_type');     // 正社員／バイト／ドライバーなど
        $table->text('content')->nullable();    // 仕事内容説明
        $table->string('time')->nullable();     // 勤務時間
        $table->string('salary')->nullable();   // 給与
        $table->string('benefit')->nullable();  // 待遇・福利厚生
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitments');
    }
};

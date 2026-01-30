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
Schema::create('point_events', function (Blueprint $table) {
    $table->id();

    $table->string('name')
        ->comment('イベント名');

    // イベント期間
    $table->dateTime('start_at')
        ->comment('イベント開始日時');
    $table->dateTime('end_at')
        ->comment('イベント終了日時');

    // イベント時のポイント付加率（%）
    $table->decimal('rate', 5, 2)
        ->comment('イベントポイント付加率（%）');

    // 有効フラグ
    $table->boolean('is_active')
        ->default(true)
        ->comment('有効フラグ');

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_events');
    }
};

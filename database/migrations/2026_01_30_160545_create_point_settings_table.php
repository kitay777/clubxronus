<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('point_settings', function (Blueprint $table) {
            $table->id();

            // 通常ポイント付加率（%）
            $table->decimal('base_rate', 5, 2)->default(0)
                ->comment('通常ポイント付加率（%）');

            // イベント用追加付加率（%）
            $table->decimal('event_bonus_rate', 5, 2)->default(0)
                ->comment('イベント時の追加ポイント付加率（%）');

            // イベント時間帯（19:00 〜 翌6:00 など）
            $table->time('event_start_time')->nullable()
                ->comment('イベント開始時間');
            $table->time('event_end_time')->nullable()
                ->comment('イベント終了時間（翌日跨ぎ可）');

            // イベント有効フラグ
            $table->boolean('event_enabled')->default(false)
                ->comment('イベントポイント有効フラグ');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('point_settings');
    }
};

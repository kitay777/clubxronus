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
Schema::create('point_base_settings', function (Blueprint $table) {
    $table->id();

    // 通常ポイント付加率（%）
    $table->decimal('rate', 5, 2)
        ->comment('通常ポイント付加率（%）');

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_base_settings');
    }
};

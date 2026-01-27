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
Schema::table('box_game_results', function (Blueprint $table) {
    $table->boolean('redeemed')
          ->default(false)
          ->comment('景品引換済み');
    $table->timestamp('redeemed_at')
          ->nullable();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('box_game_results', function (Blueprint $table) {
            //
        });
    }
};

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
Schema::table('user_visits', function (Blueprint $table) {
    $table->integer('point')->nullable()->after('amount')
        ->comment('この来店で付与したポイント');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_visits', function (Blueprint $table) {
            //
            $table->dropColumn('point');
        });
    }
};

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
    Schema::table('casts', function (Blueprint $table) {
        $table->date('birthday')->nullable()->after('name'); // 生年月日
        $table->integer('height')->nullable()->after('birthday'); // 身長（cm単位推奨）
        $table->string('style')->nullable()->after('height'); // スタイル
        $table->string('area')->nullable()->after('style'); // 出身地
        $table->string('blood_type', 3)->nullable()->after('area'); // 血液型
    });
}

public function down()
{
    Schema::table('casts', function (Blueprint $table) {
        $table->dropColumn(['birthday', 'height', 'style', 'area', 'blood_type']);
    });
}

};

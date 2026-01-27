@@ -0,0 +1,38 @@
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
Schema::create('user_profiles', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

    $table->string('nickname')->nullable();
    $table->unsignedTinyInteger('age')->nullable();
    $table->string('blood_type', 3)->nullable();
    $table->date('birthday')->nullable();
    $table->string('residence')->nullable(); // 住まい
    $table->string('referrer')->nullable();  // 紹介者
    $table->text('features')->nullable();    // 特徴
    $table->text('memo')->nullable();        // その他

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};

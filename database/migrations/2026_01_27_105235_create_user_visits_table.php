@@ -0,0 +1,36 @@
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
Schema::create('user_visits', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();

    $table->date('visit_date');                // 来店日
    $table->integer('amount')->nullable();     // 会計額
    $table->string('cast_name')->nullable();   // 指名
    $table->string('time_slot')->nullable();   // 時間帯
    $table->text('memo')->nullable();           // メモ

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_visits');
    }
};

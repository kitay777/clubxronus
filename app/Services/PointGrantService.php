<?php

namespace App\Services;

use App\Models\User;
use App\Models\PointHistory;
use App\Services\PointRateService;
use Illuminate\Support\Facades\DB;

class PointGrantService
{
    /**
     * 購入金額から付与ポイントを計算（DBは触らない）
     */
    public static function calculateForPurchase(int $amount): int
    {
        if ($amount <= 0) {
            return 0;
        }

        // 現在有効なポイント付加率（%）
        $rate = PointRateService::currentRate();

        // 小数切り捨て
        return (int) floor($amount * $rate / 100);
    }

    /**
     * 計算済みポイントを実際に付与（履歴付き）
     */
    public static function grantCalculatedPoint(
        User $user,
        int $point,
        string $reason
    ): void {
        if ($point <= 0) {
            return;
        }

        DB::transaction(function () use ($user, $point, $reason) {
            // 残高更新
            $user->increment('point', $point);

            // 履歴追加
            PointHistory::create([
                'user_id' => $user->id,
                'change'  => $point,
                'reason'  => $reason,
                'balance' => $user->fresh()->point,
            ]);
        });
    }
}

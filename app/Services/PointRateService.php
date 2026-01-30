<?php
// app/Services/PointRateService.php

namespace App\Services;

use App\Models\PointBaseSetting;
use App\Models\PointEvent;

class PointRateService
{
    /**
     * 現在有効なポイント付加率（%）を返す
     */
    public static function currentRate(): float
    {
        $event = PointEvent::activeNow()
            ->orderBy('start_at')
            ->first();

        if ($event) {
            return (float) $event->rate;
        }

        return (float) PointBaseSetting::current()->rate;
    }
}

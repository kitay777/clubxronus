<?php

namespace App\Http\Controllers;

use App\Models\SystemPrice;

class SystemPriceController extends Controller
{
    public function index()
    {
        // すべてをorder順で取得
        $prices = SystemPrice::orderBy('order')->get();
        // 表示種別ごとにまとめる例（SET, 指名, カード, info, ...）
        $setPrices = $prices->where('type', 'set');
        $nominatePrices = $prices->where('type', 'nominate');
        $cardPrices = $prices->where('type', 'card');
        $infos = $prices->where('type', 'info');
        return view('system_prices.index', compact('setPrices', 'nominatePrices', 'cardPrices', 'infos', 'prices'));
    }
}

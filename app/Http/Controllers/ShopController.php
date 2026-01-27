<?php

namespace App\Http\Controllers;

use App\Models\Shop;

class ShopController extends Controller
{
    // 店舗一覧
    public function index()
    {
        $shops = Shop::orderBy('id')->get();
        return view('shops.index', compact('shops'));
    }

    // 店舗詳細
    public function show(Shop $shop)
    {
        $shop->load('coupons');
        return view('shops.show', compact('shop'));
    }
}


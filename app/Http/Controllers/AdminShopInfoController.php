<?php

// app/Http/Controllers/AdminShopInfoController.php

namespace App\Http\Controllers;

use App\Models\ShopInfo;
use Illuminate\Http\Request;

class AdminShopInfoController extends Controller
{
    // 管理画面で表示
    public function index()
    {
        $shopInfo = ShopInfo::first(); // 最初のレコードを取得（1つだけの場合）
        return view('admin.shop_info.index', compact('shopInfo'));
    }

    // 編集フォームの表示
    public function edit()
    {
        $shopInfo = ShopInfo::first(); // 最初のレコードを取得（1つだけの場合）
        return view('admin.shop_info.edit', compact('shopInfo'));
    }

    // 編集内容の保存
    public function update(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'nearest_station' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
        ]);

        // 最初のレコードを取得して更新
        $shopInfo = ShopInfo::first();
        $shopInfo->update($validated);

        return redirect()->route('admin.shop_info.index')->with('success', '店舗情報が更新されました');
    }
}

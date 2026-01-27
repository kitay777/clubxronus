<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemPrice;

class AdminSystemPriceController extends Controller
{
    // 一覧表示
    public function index()
    {
        $systemPrices = SystemPrice::orderBy('order')->get();
        return view('admin.system_prices.index', compact('systemPrices'));
    }

    // 編集画面表示
    public function edit(SystemPrice $systemPrice)
    {
        return view('admin.system_prices.edit', compact('systemPrice'));
    }

    // 更新処理
    public function update(Request $request, SystemPrice $systemPrice)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $systemPrice->update($validated);

        return redirect()->route('admin.system_prices.index')->with('success', '設定が更新されました');
    }
}


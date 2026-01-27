<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;          // ← 必須
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;            // ← 必須

class AdminBoxGameController extends Controller
{
    /**
     * 当選確率編集画面
     */
    public function edit()
    {
        $settings = DB::table('box_game_settings')
            ->orderBy('rank')
            ->get();

        return view('admin.box_game.edit', compact('settings'));
    }

    /**
     * 当選確率更新
     */
    public function update(Request $request)
    {
        $request->validate([
            'probability.*' => 'required|integer|min:0|max:100',
        ]);

        $total = array_sum($request->probability);

        if ($total !== 100) {
            return back()
                ->withErrors(['total' => '合計は100%にしてください'])
                ->withInput();
        }

        foreach ($request->probability as $rank => $probability) {
            DB::table('box_game_settings')
                ->where('rank', $rank)
                ->update([
                    'probability' => $probability,
                    'updated_at'  => now(),
                ]);
        }

        return back()->with('success', '当選確率を更新しました');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sale;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function create()
    {
        $users = User::orderBy('id')->get();
        return view('sales.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|integer|min:1',
            'point_rate' => 'required|integer|min:1',
            'memo' => 'nullable|string',
        ]);

        $user = User::findOrFail($data['user_id']);

        // ポイント計算（切り捨て）
        $point = floor($data['amount'] * $data['point_rate'] / 100);

        // 売上記録
        $sale = Sale::create([
            'user_id' => $user->id,
            'amount' => $data['amount'],
            'point_rate' => $data['point_rate'],
            'point_added' => $point,
            'memo' => $data['memo'] ?? null,
        ]);

        // ポイント加算
        $user->point += $point;
        $user->save();

        // ポイント履歴
        $user->pointHistories()->create([
            'change' => $point,
            'reason' => "売上ポイント付与（売上:{$data['amount']}円,率:{$data['point_rate']}%）",
            'balance' => $user->point,
        ]);

        return redirect()->route('sales.create')->with('success', "ユーザーに{$point}pt付与しました");
    }
}

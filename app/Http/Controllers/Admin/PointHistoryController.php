<?php

// app/Http/Controllers/Admin/PointHistoryController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PointHistory;
use Illuminate\Http\Request;

class PointHistoryController extends Controller
{
    // ポイント履歴の一覧表示
    public function index(Request $request)
    {
        // ユーザー名で検索
        $query = PointHistory::query();
        
        if ($request->has('user_name') && $request->input('user_name') != '') {
            $user = \App\Models\User::where('name', 'like', '%' . $request->input('user_name') . '%')->first();
            if ($user) {
                $query->where('user_id', $user->id);
            }
        }

        // ページネーションで表示
        $pointHistories = $query
            ->with('user')
            ->orderByDesc('created_at') // ★追加
            ->paginate(50);
;

        return view('admin.point_histories.index', compact('pointHistories'));
    }

    // 削除処理
    public function destroy($id)
    {
        // 履歴の削除
        $pointHistory = PointHistory::findOrFail($id);
        $pointHistory->delete();

        return redirect()->route('admin.point_histories.index')->with('success', 'ポイント履歴が削除されました');
    }
}


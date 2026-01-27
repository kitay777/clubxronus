<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserVisit;

class AdminUserVisitController extends Controller
{
    /**
     * 来店履歴一覧
     */
    public function index(User $user)
    {
        $visits = UserVisit::where('user_id', $user->id)
            ->orderByDesc('visit_date')
            ->get();

        return view('admin.users.visits', compact('user', 'visits'));
    }

    /**
     * 来店履歴追加
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'visit_date' => 'required|date',
            'amount'     => 'nullable|integer|min:0',
            'cast_name'  => 'nullable|string|max:255',
            'time_slot'  => 'nullable|string|max:255',
            'memo'       => 'nullable|string',
        ]);

        UserVisit::create([
            'user_id'    => $user->id,
            'visit_date' => $request->visit_date,
            'amount'     => $request->amount,
            'cast_name'  => $request->cast_name,
            'time_slot'  => $request->time_slot,
            'memo'       => $request->memo,
        ]);

        return redirect()
            ->route('admin.users.visits.index', $user)
            ->with('success', '来店履歴を追加しました');
    }

    /**
     * 来店履歴削除
     */
    public function destroy(User $user, UserVisit $visit)
    {
        // 念のためユーザー一致チェック
        abort_unless($visit->user_id === $user->id, 403);

        $visit->delete();

        return back()->with('success', '来店履歴を削除しました');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBoxGameResultController extends Controller
{
    /**
     * 当選一覧
     */
    public function index(Request $request)
    {
        $results = DB::table('box_game_results')
            ->join('users', 'users.id', '=', 'box_game_results.user_id')
            ->select(
                'box_game_results.*',
                'users.name',
                'users.email'
            )
            ->orderByDesc('box_game_results.created_at')
            ->paginate(30);

        return view('admin.box_game.results', compact('results'));
    }

    /**
     * 引換済みにする
     */
    public function redeem($id)
    {
        DB::table('box_game_results')
            ->where('id', $id)
            ->update([
                'redeemed' => true,
                'redeemed_at' => now(),
            ]);

        return back()->with('success', '引換済みにしました');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;


class BoxGameController extends Controller
{
    /**
     * ゲーム画面表示
     */
    public function index()
    {
        return view('game.box');
    }

    /**
     * 抽選処理（1人1回）
     */
    public function play(Request $request)
    {
        $user = $request->user();

        // ▼ すでにプレイ済みか（物理的1回制限）
        $alreadyPlayed = DB::table('box_game_results')
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyPlayed) {
            return response()->json([
                'error' => 'already_played'
            ], 403);
        }
Log::info('box game play');
        // ▼ cadminで設定された確率を取得
        $settings = DB::table('box_game_settings')
            ->orderBy('rank') // 1等 → 5等
            ->get();
Log::info('settings: '. $settings->count());
        if ($settings->isEmpty()) {
            abort(500, 'BOX GAME 設定が存在しません');
        }

        // ▼ 抽選（1〜100）
        $rand = rand(1, 100);
        $cursor = 0;
        $rank = null;

        foreach ($settings as $s) {
            $cursor += $s->probability;
            if ($rand <= $cursor) {
                $rank = $s->rank;
                break;
            }
        }

        // 念のための保険
        if ($rank === null) {
            abort(500, 'BOX GAME 確率設定が不正です（合計100%か確認）');
        }

        // ▼ 結果保存（1人1回は UNIQUE(user_id) で保証）
        DB::table('box_game_results')->insert([
            'user_id'    => $user->id,
            'rank'       => $rank,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'rank' => $rank
        ]);
    }

    /**
     * 結果表示
     */
    public function result(Request $request)
    {
        $result = DB::table('box_game_results')
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$result) {
            // 未プレイはゲームへ
            return redirect()->route('game.box');
        }

        return view('game.box_result', [
            'rank' => $result->rank,
            'redeemed'    => (bool) $result->redeemed,
            'redeemed_at' => $result->redeemed_at,
        ]);
    }
}

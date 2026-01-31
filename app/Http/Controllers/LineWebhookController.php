<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class LineWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $events = $request->input('events', []);

        foreach ($events as $event) {
            $type = $event['type'] ?? null;
            $lineUserId = $event['source']['userId'] ?? null;

            if (!$lineUserId) {
                continue;
            }

            // 友だち追加
            if ($type === 'follow') {
                User::where('line_user_id', $lineUserId)
                    ->update(['is_line_friend' => true]);

                Log::info('LINE follow', ['userId' => $lineUserId]);
            }

            // ブロック（友だち解除）
            if ($type === 'unfollow') {
                User::where('line_user_id', $lineUserId)
                    ->update(['is_line_friend' => false]);

                Log::info('LINE unfollow', ['userId' => $lineUserId]);
            }
        }

        return response()->json(['status' => 'ok']);
    }
}

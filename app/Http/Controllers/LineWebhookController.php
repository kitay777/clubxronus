<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

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


    public function checkLineFriend(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        if (!$user || !$user->line_user_id) {
            return response()->json([
                'is_line_friend' => false,
            ]);
        }

        $response = Http::withToken(config('services.line.channel_access_token'))
            ->get("https://api.line.me/v2/bot/profile/{$user->line_user_id}");

        if ($response->successful()) {
            $user->update(['is_line_friend' => true]);
        } else {
            // 404 / 401 / 403 など
            $user->update(['is_line_friend' => false]);
        }

        return response()->json([
            'is_line_friend' => $user->fresh()->is_line_friend,
        ]);
    }
}

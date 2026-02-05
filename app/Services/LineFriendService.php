<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LineFriendService
{
    public function isFriend(User $user): bool
    {
        if (!$user->line_user_id) {
            return false;
        }

        // 🔴 verify を絶対に指定しない
        $response = Http::withOptions([
            'verify' => false,
        ])->withToken(
            config('services.line.channel_access_token')
        )->get("https://api.line.me/v2/bot/profile/{$user->line_user_id}");
        if ($response->successful()) {
            Log::info('LINE isFriend check', ['userId' => $user->line_user_id]);
            $user->update(['is_line_friend' => true]);
        } else {
            Log::info('LINE isFriend check -false-', ['userId' => $user->line_user_id]);
            // 404 / 401 / 403 など
            $user->update(['is_line_friend' => false]);
        }
        return $response->successful();
    }



    public function sync(User $user): void
    {
        $user->update([
            'is_line_friend' => $this->isFriend($user),
        ]);
    }
}

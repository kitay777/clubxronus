<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LineMessageService
{
    public static function push(string $lineUserId, string $message): void
    {
        $user = \App\Models\User::where('line_user_id', $lineUserId)->first();

        if (!$user || !$user->is_line_friend) {
            return; // 送信不可
        }

        Http::withOptions([
            'verify' => '/etc/ssl/certs/cacert.pem',
        ])
            ->withToken(config('services.line.channel_access_token'))
            ->post('https://api.line.me/v2/bot/message/push', [
                'to' => $lineUserId,
                'messages' => [
                    ['type' => 'text', 'text' => $message],
                ],
            ]);
    }
}

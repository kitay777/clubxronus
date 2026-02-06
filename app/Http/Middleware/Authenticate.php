<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
protected function redirectTo(Request $request): ?string
{
    // JSONリクエストは対象外
    if ($request->expectsJson()) {
        return null;
    }

    // 管理画面は管理者ログインへ
    if ($request->is('admin') || $request->is('admin/*')) {
        return route('admin.login');
    }

    // ★ キャスト登録は LINEログインへ
    if ($request->is('cast/register')) {
        return route('auth.line.redirect');
    }

    // その他の未ログインも LINEログインへ
    return route('auth.line.redirect');
}



}

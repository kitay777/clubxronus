<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle(Request $request, Closure $next, ...$guards)
{
    foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {

            // ★ キャスト登録はログイン後でも通す
            if ($request->is('cast/register*')) {
                return $next($request);
            }

            // 管理画面
            if ($request->is('admin') || $request->is('admin/*')) {
                return redirect()->route('admin.dashboard');
            }

            // 一般ユーザー
            return redirect()->route('dashboard');
        }
    }

    return $next($request);
}

}

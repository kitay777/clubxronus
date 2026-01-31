<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LineAuthController extends Controller
{
    /** LINEにリダイレクト */
    public function redirect()
    {
        $query = http_build_query([
            'response_type' => 'code',
            'client_id'     => config('services.line_login.client_id'),
            'redirect_uri'  => route('auth.line.callback'),
            'state'         => csrf_token(),
            'scope'         => 'profile openid',
        ]);


        return redirect("https://access.line.me/oauth2/v2.1/authorize?$query");
    }

    /** コールバック */
public function callback(Request $request)
{
    // ① code → token
    $token = Http::withOptions([
            'verify' => '/etc/ssl/certs/cacert.pem',
        ])
        ->asForm()
        ->post('https://api.line.me/oauth2/v2.1/token', [
            'grant_type'    => 'authorization_code',
            'code'          => $request->code,
            'redirect_uri'  => route('auth.line.callback'),
            'client_id'     => config('services.line_login.client_id'),
            'client_secret'=> config('services.line_login.client_secret'),
        ])
        ->json();

    if (!isset($token['access_token'])) {
        abort(500, 'LINE token error');
    }

    // ② プロフィール取得（★ここが重要）
    $profile = Http::withOptions([
            'verify' => '/etc/ssl/certs/cacert.pem',
        ])
        ->withToken($token['access_token'])
        ->get('https://api.line.me/v2/profile')
        ->json();

    /**
     * $profile の中身例:
     * [
     *   "userId" => "U9B5eb2c92106a31b11c934aaf3d687",
     *   "displayName" => "北山 武士",
     *   "pictureUrl" => "https://profile.line-scdn.net/..."
     * ]
     */

    $lineUserId = $profile['userId'];
    $name       = $profile['displayName'] ?? 'LINEユーザー';

    // ③ ユーザー保存（確実版）
    $user = User::where('line_user_id', $lineUserId)->first();

    if (!$user) {
        $user = new User();
        $user->line_user_id = $lineUserId;
    }

    $user->name = $name;
    $user->save();

    Auth::login($user);

    return redirect('/');
}

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cast; // Castモデルをインポート
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Userモデルをインポート
use Illuminate\Support\Facades\Storage;
use App\Models\ShopInfo; // ShopInfoモデルをインポート
use App\Models\TopImage; // TopImageモデルをインポート
use App\Models\Ticker; // Tickerモデルをインポート
use App\Models\News; // Newsモデルをインポート
use App\Services\LineFriendService; // LineFriendServiceをインポート
use Illuminate\Support\Facades\Session;
use App\Models\Blog; // Blogモデルをインポート
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;


class CastController extends Controller
{
    //

public function dashboard(LineFriendService $lineFriend)
{
    // 🔴 すでにブロック中なら何もしない（最重要）
    if (Session::has('line_blocked')) {
        return $this->renderDashboard();
    }

    $user = Auth::user();

    if ($user && $user->line_user_id) {
        $status = $lineFriend->check($user);
        if ($status === 'blocked') {
            Auth::logout();

            Session::put('line_blocked', true);

            // 🔴 redirect するが、次回は上で弾かれる
            return redirect()->route('dashboard');
        }

        if ($status === 'friend') {
            $user->update(['is_line_friend' => true]);
            Session::forget('line_blocked');
        }
    }

    if($user->is_cast == 0){
            $hasPlayed = \DB::table('box_game_results')
        ->where('user_id', $user->id)
        ->exists();

        if (! $hasPlayed) {
            return redirect()->route('game.box');
        }
    
    }
    return $this->renderDashboard();
}

    /**
     * dashboard 描画専用（切り出し）
     */
    private function renderDashboard()
    {
        $casts = Cast::orderBy('id')->get();
        $shopInfo = ShopInfo::first();
        $topImages = TopImage::orderBy('order')->get();
        $tickers = Ticker::where('is_active', true)->orderBy('order')->pluck('text');
        $latestNews = News::where('is_active', true)
            ->orderByDesc('published_at')
            ->take(5)
            ->get();
        $latestBlogs = Blog::orderByDesc('published_at')->take(6)->get();

        return view('casts.dashboard', compact(
            'casts',
            'shopInfo',
            'topImages',
            'tickers',
            'latestNews',
            'latestBlogs'
        ));
    }
    public function list()
    {
        $user = Auth::user();
        $casts = \App\Models\Cast::orderBy('id')->get();
        return view('casts.list', compact('casts', 'user'));
    }

    // 一覧表示
    public function index()
    {
        $casts = Cast::all();
        return view('casts.index', compact('casts'));
    }

    // 詳細表示
    public function show(Cast $cast)
    {
        $blogs = $cast->blogs()->orderByDesc('published_at')->paginate(5);

        // ニュース一覧（そのキャスト専用＋全体向け）
        $news = \App\Models\News::where(function ($q) use ($cast) {
            $q->where('is_all', true)
                ->orWhere('cast_id', $cast->id);
        })->orderByDesc('published_at')->paginate(5);

        return view('casts.show', compact('cast', 'blogs', 'news'));
    }


    // 作成フォーム
    public function create()
    {
        return view('casts.create');
    }

    // 登録処理
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'birthday' => 'nullable|date',
            'height' => 'nullable|integer',
            'style' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:3',
            'role' => 'nullable|string|max:255',
            'profile' => 'nullable|string|max:1000',
            'image_path' => 'nullable|image|max:2048',
        ]);

        // 画像保存処理
        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('cast_images', 'public');
        }

        Cast::create($data);

        return redirect()->route('casts.index')->with('success', '登録しました');
    }

    // 編集フォーム
    public function edit(Cast $cast)
    {
        return view('casts.edit', compact('cast'));
    }

    // 更新処理
    public function update(Request $request, Cast $cast)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'birthday' => 'nullable|date',
            'height' => 'nullable|integer',
            'style' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:3',
            'role' => 'nullable|string|max:255',
            'profile' => 'nullable|string|max:1000',
            'image_path' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('cast_images', 'public');
        }

        $cast->update($data);

        return redirect()->route('casts.index')->with('success', '更新しました');
    }




    // 自分のキャスト編集
    public function editMine()
    {
        $user = Auth::user();
        $cast = $user->cast; // 1ユーザー1キャスト
        return view('casts.edit-mine', compact('cast'));
    }

    // 更新
    public function updateMine(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'birthday' => 'nullable|date',
            'height' => 'nullable|integer',
            'style' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:3',
            'role' => 'nullable|string|max:255',
            'profile' => 'nullable|string|max:1000',
            'image_path' => 'nullable|image|max:204800',
        ]);

        // 新規 or 既存
        $cast = $user->cast ?: new Cast(['user_id' => $user->id]);
        $cast->fill($data);

        if ($request->hasFile('image_path')) {
            $cast->image_path = $request->file('image_path')->store('cast_images', 'public');
        }
        $cast->user_id = $user->id;

        $cast->update();
        return redirect()->route('casts.edit.mine')->with('success', 'プロフィールを更新しました');
    }
}

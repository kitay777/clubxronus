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

class CastController extends Controller
{
    //

    public function dashboard(LineFriendService $lineFriend)
    {
        $user = Auth::user();

        if ($user && $user->line_user_id) {
            // 🔴 毎回 LINE に事実確認
            $isFriend = $lineFriend->isFriend($user);

            // キャッシュとしてDB更新（任意だがおすすめ）
            $user->update([
                'is_line_friend' => $isFriend,
            ]);
        }
        $casts = \App\Models\Cast::orderBy('id')->get();
        $shopInfo = ShopInfo::first(); // 最初のレコードを取得（1つだけの場合）
        $topImages = TopImage::orderBy('order')->get();
        $tickers = Ticker::where('is_active', true)->orderBy('order')->pluck('text');
        $latestNews = News::where('is_active', true)
            ->orderByDesc('published_at')
            ->take(5)
            ->get();
        $latestBlogs = \App\Models\Blog::orderByDesc('published_at')->take(6)->get();

        return view('casts.dashboard', compact('casts', 'user', 'shopInfo', 'topImages', 'tickers', 'latestNews', 'latestBlogs'));
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

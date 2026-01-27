<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cast;
use App\Models\News;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class NewsController extends Controller
{
    // キャストページ用ニュース一覧
    public function castNews(Cast $cast)
    {
        $news = News::where(function ($q) use ($cast) {
            $q->where('is_all', true)
            ->orWhere('cast_id', $cast->id);
        })->orderByDesc('published_at')->paginate(10);

        return view('news.cast-index', compact('cast', 'news'));
    }

    // ニュース投稿フォーム
    public function create()
    {
        $casts = [];
        if (auth()->user()->is_admin) {
            $casts = \App\Models\Cast::all();
        }
        return view('news.create', compact('casts'));
    }
    
    public function index()
    {
        $news = \App\Models\News::orderByDesc('published_at')->paginate(10);
        return view('news.index', compact('news'));
    }

    // 保存処理
    public function store(Request $request)
    {
        $user = auth()->user();
        $is_admin = $user->is_admin ?? false;

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image_path' => 'nullable|image|max:4096',
            'published_at' => 'nullable|date',
            'cast_id' => 'nullable|exists:casts,id',
            'is_all' => 'nullable|boolean',
        ]);
        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('news_images', 'public');
        }
        $data['user_id'] = $user->id;
        $data['published_at'] = $data['published_at'] ?? now();

        // 一般キャストユーザーは自分しか指定できない
        if (!$is_admin) {
            $data['cast_id'] = $user->cast->id;
            $data['is_all'] = false;
        } else {
            // 運営で全体指定ならcast_idをnullに
            if (!empty($data['is_all'])) {
                $data['cast_id'] = null;
                $data['is_all'] = true;
            } else {
                $data['is_all'] = false;
            }
        }

        News::create($data);

        return redirect()->route('news.index')->with('success', '投稿しました');
    }
    public function toggle(News $news)
    {
        $news->is_active = !$news->is_active;
        $news->save();

        return back()->with('success', '表示状態を更新しました');
    }


}

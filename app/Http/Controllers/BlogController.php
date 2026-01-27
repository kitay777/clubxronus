<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Blog;
use App\Models\Cast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class BlogController extends Controller
{
    // 全体ブログ一覧
    public function index()
    {
        $blogs = Blog::with('cast')->orderByDesc('published_at')->paginate(20);
        return view('blogs.index', compact('blogs'));
    }

    // キャストごと一覧
    public function castBlogs(Cast $cast)
    {
        $blogs = $cast->blogs()->orderByDesc('published_at')->paginate(10);
        return view('blogs.cast-index', compact('cast', 'blogs'));
    }

    // 投稿フォーム（自分のキャストのみ）
    public function create()
    {
        $cast = Auth::user()->cast;
        return view('blogs.create', compact('cast'));
    }

    // 保存処理
    public function store(Request $request)
    {
        $cast = Auth::user()->cast;

        $data = $request->validate([
            'title' => 'nullable|string|max:100',
            'image_path' => 'nullable|image|max:4096',
            'body' => 'required|string',
            'published_at' => 'nullable|date',
        ]);
        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('blog_images', 'public');
        }
        $data['cast_id'] = $cast->id;
        $data['published_at'] = $data['published_at'] ?? now();

        Blog::create($data);

        return redirect()->route('casts.blogs', $cast)->with('success', '投稿しました');
    }
}

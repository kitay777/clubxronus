<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Cast;
use Illuminate\Http\Request;

class NewsAdminController extends Controller
{
    // ニュース一覧
    public function index()
    {
        $news = News::orderByDesc('published_at')->paginate(20);

        return view('admin.news.index', compact('news'));
    }

    // 表示/非表示の切り替え
    public function toggle(News $news)
    {
        $news->is_active = !$news->is_active;
        $news->save();

        return back()->with('success', '表示状態を更新しました');
    }

    // 削除
    public function destroy(News $news)
    {
        // 画像も削除
        if ($news->image_path) {
            \Storage::disk('public')->delete($news->image_path);
        }

        $news->delete();

        return back()->with('success', '削除しました');
    }
}

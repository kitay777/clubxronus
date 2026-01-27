<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopImage;
use Illuminate\Http\Request;

class TopImageController extends Controller
{
    /**
     * 一覧表示（トップ画像管理画面）
     */
    public function index()
    {
        $images = TopImage::orderBy('order')->get();

        return view('admin.top_images.index', compact('images'));
    }

    /**
     * 新規登録（画像アップロード）
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:4096',
        ]);

        // 画像保存
        $path = $request->file('image')->store('top_images', 'public');

        // 並び順は最大値＋1
        TopImage::create([
            'image_path' => $path,
            'order' => TopImage::max('order') + 1,
        ]);

        return redirect()->back()->with('success', 'トップ画像を追加しました。');
    }

    /**
     * 削除
     */
    public function destroy(TopImage $topImage)
    {
        // ストレージから削除
        \Storage::disk('public')->delete($topImage->image_path);

        // DB から削除
        $topImage->delete();

        return redirect()->back()->with('success', '画像を削除しました。');
    }
}

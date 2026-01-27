<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Shop;

class CouponController extends Controller
{
       // クーポン一覧
    public function index()
    {
        // クーポン一覧を取得
        $coupons = Coupon::all();
        // ビューに渡す
        return view('admin.coupons.index', compact('coupons'));
    }

     public function create()
    {
        $shops = Shop::all(); // Shopを全て取得
        return view('admin.coupons.create', compact('shops'));
    }

    // クーポン編集
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }


    // クーポン削除
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'クーポンが削除されました');
    }
    // クーポン追加
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'type' => 'nullable|string|max:255',
            'value' => 'nullable',
            'shop_id' => 'nullable|exists:shops,id',
            'title' => 'nullable|string|max:255',
            'image_path' => 'nullable|image',  // 画像ファイル制限
        ]);

        // 画像アップロード処理
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = 'coupon_' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('storage/coupon_images/' . $imageName);  // 新しいパスに変更

            // 画像をリサイズ（1024x1024にアスペクト比保持）
            $img = Image::make($image)->resize(1024, 1024, function ($constraint) {
                $constraint->aspectRatio();
            });

            // 画像を保存
            $img->save($imagePath);

            // クーポンの作成
            $validated['image_path'] = 'coupon_images/' . $imageName;  // 新しいパスに変更
        }

        // クーポン作成
        Coupon::create($validated);

        return redirect()->route('admin.coupons.index')->with('success', 'クーポンが追加されました');
    }

    // クーポン更新
    public function update(Request $request, Coupon $coupon)
    {
        // バリデーション
        $validated = $request->validate([
            'type' => 'nullable|string|max:255',
            'value' => 'nullable',
            'shop_id' => 'nullable|exists:shops,id',
            'title' => 'nullable|string|max:255',
            'image_path' => 'nullable|image',  // 画像ファイル制限
        ]);

        // 画像アップロード処理
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = 'coupon_' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('storage/coupon_images/' . $imageName);  // 新しいパスに変更

            // 画像をリサイズ（1024x1024にアスペクト比保持）
            $img = Image::make($image)->resize(1024, 1024, function ($constraint) {
                $constraint->aspectRatio();
            });

            // 画像を保存
            $img->save($imagePath);

            // 既存の画像を削除（もし存在していれば）
            if ($coupon->image_path) {
                $oldImagePath = public_path('storage/' . $coupon->image_path);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // 新しい画像のパスを設定
            $validated['image_path'] = 'coupon_images/' . $imageName;  // 新しいパスに変更
        }

        // クーポン情報を更新
        $coupon->update($validated);

        return redirect()->route('admin.coupons.index')->with('success', 'クーポンが更新されました');
    }
}

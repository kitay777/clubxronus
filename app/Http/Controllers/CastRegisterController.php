<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cast;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;

class CastRegisterController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        // すでに申請済み・キャストの場合は弾く
        dd( $user );
        if ($user->is_cast) {
            return redirect('/')->with('message', 'すでにキャスト申請済みです');
        }

    session(['cast_register' => true]);
    dd(session('cast_register'));
        return view('cast.register');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->is_cast) {
            return redirect('/');
        }

        $validated = $request->validate([
            'nickname'   => 'required|string|max:255',
            'birthday'   => 'nullable|date',
            'height'     => 'nullable|string|max:50',
            'style'      => 'nullable|string|max:255',
            'area'       => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:10',
            'role'       => 'nullable|string|max:255',
            'profile'    => 'required|string',
            'image'      => 'nullable|image|max:5120', // ★ 画像（最大5MB）
        ]);

        DB::transaction(function () use ($user, $validated, $request) {

            // キャスト申請状態にする
            $user->update([
                'is_cast'     => 1,
                'is_approved' => 0, // 承認待ち
            ]);

            $cast = Cast::create([
                'user_id'    => $user->id,
                'name'       => $validated['nickname'],
                'birthday'   => $validated['birthday'] ?? null,
                'height'     => $validated['height'] ?? null,
                'style'      => $validated['style'] ?? null,
                'area'       => $validated['area'] ?? null,
                'blood_type' => $validated['blood_type'] ?? null,
                'role'       => $validated['role'] ?? null,
                'profile'    => $validated['profile'],
            ]);

            // ★ 画像保存
            if ($request->hasFile('image')) {
                $filename = 'cast_' . time() . '.' . $request->image->getClientOriginalExtension();

                Image::make($request->image)
                    ->resize(1024, 1024, fn($c) => $c->aspectRatio())
                    ->save(public_path('storage/cast_images/' . $filename));

                $cast->image_path = 'cast_images/' . $filename;
                $cast->save();
            }
        });

        return redirect('/')
            ->with('message', 'キャスト登録を申請しました。承認をお待ちください。');
    }
}

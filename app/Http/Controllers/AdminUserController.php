<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cast; // Cast モデルのインポート
use Intervention\Image\Facades\Image;
use App\Models\UserProfile;
use App\Models\UserVisit;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
    public function toggleApproval(User $user)
    {
        // 自分自身を操作させないなどの制御（任意）
        if ($user->id === auth()->id()) {
            return back();
        }

        $user->update([
            'is_approved' => ! $user->is_approved,
        ]);

        return back();
    }
    public function index(Request $request)
    {
        $query = User::query()
            ->with(['profile', 'visits']);

        // 名前
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // 年齢 範囲
        if ($request->filled('age_from') || $request->filled('age_to')) {
            $query->whereHas('profile', function ($q) use ($request) {
                if ($request->filled('age_from')) {
                    $q->where('age', '>=', $request->age_from);
                }
                if ($request->filled('age_to')) {
                    $q->where('age', '<=', $request->age_to);
                }
            });
        }

        // 住まい
        if ($request->filled('residence')) {
            $query->whereHas('profile', function ($q) use ($request) {
                $q->where('residence', 'like', '%' . $request->residence . '%');
            });
        }

        // 来店日 範囲
        if ($request->filled('visit_from') || $request->filled('visit_to')) {
            $query->whereHas('visits', function ($q) use ($request) {
                if ($request->filled('visit_from')) {
                    $q->whereDate('visit_date', '>=', $request->visit_from);
                }
                if ($request->filled('visit_to')) {
                    $q->whereDate('visit_date', '<=', $request->visit_to);
                }
            });
        }

        // 指名
        if ($request->filled('cast_name')) {
            $query->whereHas('visits', function ($q) use ($request) {
                $q->where('cast_name', 'like', '%' . $request->cast_name . '%');
            });
        }

        $users = $query->orderByDesc('id')->paginate(20);

        return view('admin.users.index', compact('users'));
    }



    // ユーザー編集画面
    public function edit(User $user)
    {
        $cast = null;
        if ($user->is_cast == 1) {
            $cast = Cast::where('user_id', $user->id)->first();
        }

        // ★ 追加：顧客プロフィール & 来店履歴
        $profile = UserProfile::where('user_id', $user->id)->first();
        $visits  = UserVisit::where('user_id', $user->id)
            ->orderByDesc('visit_date')
            ->get();

        return view('admin.users.edit', compact(
            'user',
            'cast',
            'profile',
            'visits'
        ));
    }

    // ユーザー情報更新
    public function update(Request $request, User $user)
    {
        // バリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'point' => 'nullable|numeric',
            'profile_photo_path' => 'nullable|image',  // 画像ファイル制限
            'is_cast' => 'nullable|boolean',
        ]);

        // 画像アップロード処理
        if ($request->hasFile('profile_photo_path')) {
            $image = $request->file('profile_photo_path');
            $imageName = 'profile_' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('storage/profile-photos/' . $imageName);

            // 画像をリサイズ（1024x1024にアスペクト比保持）
            $img = Image::make($image)->resize(1024, 1024, function ($constraint) {
                $constraint->aspectRatio();
            });

            // 画像を保存
            $img->save($imagePath);

            // プロフィール画像のパスを更新（`storage/profile-photos/`をつける）
            $validated['profile_photo_path'] = 'profile-photos/' . $imageName;
        }

        // ユーザー情報を更新
        $user->update($validated);

        // キャスト情報の更新（is_castが1の場合）
        if ($user->is_cast == 1) {
            // Cast テーブルのデータを取得
            $cast = Cast::where('user_id', $user->id)->first();

            // もしキャストデータが存在しない場合は新しく作成
            if (!$cast) {
                $cast = new Cast();
                $cast->user_id = $user->id;
            }

            // キャスト情報を更新
            $cast->name = $request->input('cast_name');
            $cast->profile = $request->input('cast_profile');
            $cast->blood_type = $request->input('cast_blood_type');
            $cast->role = $request->input('cast_role');
            $cast->birthday = $request->input('cast_birthday');
            $cast->height = $request->input('cast_height');
            $cast->style = $request->input('cast_style');
            $cast->area = $request->input('cast_area');

            // キャスト画像がアップロードされている場合
            if ($request->hasFile('cast_image_path')) {
                $castImage = $request->file('cast_image_path');
                $castImageName = 'cast_' . time() . '.' . $castImage->getClientOriginalExtension();
                $castImagePath = public_path('storage/cast_images/' . $castImageName);

                // 画像をリサイズ（1024x1024にアスペクト比保持）
                $cimg = Image::make($castImage)->resize(1024, 1024, function ($constraint) {
                    $constraint->aspectRatio();
                });

                // 画像を保存
                $cimg->save($castImagePath);

                // プロフィール画像のパスを更新（`storage/profile-photos/`をつける）
                $cast->image_path = 'cast_images/' . $castImageName;
            }

            if ($cast->name == null) {
                $cast->name = $user->name; // ユーザー名をキャスト名に設定
            }
            // 更新または新規保存
            $cast->save();
        }
        // ===== 顧客プロフィール（1対1）保存 =====
        UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nickname'   => $request->input('nickname'),
                'age'        => $request->input('age'),
                'blood_type' => $request->input('blood_type'),
                'birthday'   => $request->input('birthday'),
                'residence'  => $request->input('residence'),
                'referrer'   => $request->input('referrer'),
                'features'   => $request->input('features'),
                'memo'       => $request->input('memo'),
            ]
        );

        // ===== 来店履歴（追加のみ） =====
        if ($request->filled('visit_date')) {
            UserVisit::create([
                'user_id'    => $user->id,
                'visit_date' => $request->input('visit_date'),
                'amount'     => $request->input('amount'),
                'cast_name'  => $request->input('visit_cast'),
                'time_slot'  => $request->input('time_slot'),
                'memo'       => $request->input('visit_memo'),
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'ユーザー情報とキャスト情報が更新されました');
    }
}

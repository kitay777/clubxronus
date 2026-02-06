<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cast;
use App\Models\UserProfile;
use App\Models\UserVisit;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
    /**
     * 承認トグル
     */
    public function toggleApproval(User $user)
    {
        if ($user->id === auth()->id()) {
            return back();
        }

        $user->update([
            'is_approved' => ! $user->is_approved,
        ]);

        return back();
    }

    /**
     * ユーザー一覧・検索
     */
    public function index(Request $request)
    {
        $query = User::query()->with(['profile', 'visits']);

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

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

        if ($request->filled('residence')) {
            $query->whereHas('profile', function ($q) use ($request) {
                $q->where('residence', 'like', '%' . $request->residence . '%');
            });
        }

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

        if ($request->filled('cast_name')) {
            $query->whereHas('visits', function ($q) use ($request) {
                $q->where('cast_name', 'like', '%' . $request->cast_name . '%');
            });
        }

        $users = $query->orderByDesc('id')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * 編集画面
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user'    => $user,
            'cast'    => $user->is_cast ? $user->cast : null,
            'profile' => $user->profile,
            'visits'  => $user->visits()->orderByDesc('visit_date')->get(),
        ]);
    }

    /**
     * 更新処理（完全版）
     */
    public function update(Request $request, User $user)
    {
        // ✅ email は必須ではない
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'email'              => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'point'              => 'nullable|numeric',
            'profile_photo_path' => 'nullable|image',
        ]);

        // ✅ checkbox は明示的に boolean 化
        $isCast = $request->boolean('is_cast');
        $validated['is_cast'] = $isCast;

        DB::transaction(function () use ($request, $user, $validated, $isCast) {

            /**
             * ===== User 更新 =====
             */
            if ($request->hasFile('profile_photo_path')) {
                $validated['profile_photo_path'] =
                    $this->saveImage(
                        $request->file('profile_photo_path'),
                        'profile-photos',
                        'profile_'
                    );
            }

            $user->update($validated);

            /**
             * ===== Cast 処理 =====
             */
            if ($isCast) {
                // is_cast = 1 → 必ず Cast を持つ
                $cast = $user->cast()->firstOrCreate(
                    [],
                    ['name' => $user->name]
                );

                $cast->fill([
                    'name'       => $request->input('cast_name') ?: $user->name,
                    'profile'    => $request->input('cast_profile'),
                    'blood_type' => $request->input('cast_blood_type'),
                    'role'       => $request->input('cast_role'),
                    'birthday'   => $request->input('cast_birthday'),
                    'height'     => $request->input('cast_height'),
                    'style'      => $request->input('cast_style'),
                    'area'       => $request->input('cast_area'),
                ]);

                if ($request->hasFile('cast_image_path')) {
                    $cast->image_path =
                        $this->saveImage(
                            $request->file('cast_image_path'),
                            'cast_images',
                            'cast_'
                        );
                }

                $cast->save();
            } else {
                // is_cast = 0 → キャスト解除
                $user->cast()?->delete();
            }

            /**
             * ===== UserProfile =====
             */
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

            /**
             * ===== 来店履歴（追加）=====
             */
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
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'ユーザー情報とキャスト情報が更新されました');
    }

    /**
     * 画像保存共通処理
     */
    private function saveImage($file, string $dir, string $prefix): string
    {
        $name = $prefix . time() . '.' . $file->getClientOriginalExtension();

        Image::make($file)
            ->resize(1024, 1024, fn ($c) => $c->aspectRatio())
            ->save(public_path("storage/{$dir}/{$name}"));

        return "{$dir}/{$name}";
    }
}

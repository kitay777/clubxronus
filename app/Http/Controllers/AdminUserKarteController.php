<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;

class AdminUserKarteController extends Controller
{
    public function edit(User $user)
    {
        $profile = UserProfile::firstOrCreate(
            ['user_id' => $user->id]
        );

        return view('admin.users.karte', compact('user', 'profile'));
    }
    public function update(Request $request, User $user)
{
    UserProfile::updateOrCreate(
        ['user_id' => $user->id],
        [
            'nickname'   => $request->nickname,
            'age'        => $request->age,
            'blood_type' => $request->blood_type,
            'birthday'   => $request->birthday,
            'residence'  => $request->residence,
            'referrer'   => $request->referrer,
            'features'   => $request->features,
            'memo'       => $request->memo,
        ]
    );

    return redirect()
        ->route('admin.users.karte.edit', $user)
        ->with('success', 'カルテを更新しました');
}
}

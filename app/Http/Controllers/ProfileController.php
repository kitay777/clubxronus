<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;
use App\Models\User;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; 




class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }


public function update(Request $request)
{
    $user = $request->user();

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'profile_photo' => ['nullable', 'image', 'max:3072'],
    ]);

    if ($request->hasFile('profile_photo')) {
        $uploaded = $request->file('profile_photo');

        // ImageManagerの生成
        $manager = new ImageManager(new Driver());

        // 1024x1024正方形に中央トリミング
        $avatar = $manager->read($uploaded->getRealPath())->cover(1024, 1024);


        // 外側を透明で塗る
        // GDでは直接マスクできないため、「アルファ付き」合成
        $mask = imagecreatetruecolor(1024, 1024);
        imagesavealpha($mask, true);
        $trans_colour = imagecolorallocatealpha($mask, 0, 0, 0, 127);
        imagefill($mask, 0, 0, $trans_colour);
        imagefilledellipse($mask, 512, 512, 1024, 1024, imagecolorallocatealpha($mask, 0, 0, 0, 0));
        // PNGのバイナリで保存
        $maskPath = storage_path('app/temp_mask.png');
        imagepng($mask, $maskPath);

        // Interventionでマスク画像を読み込み
        $avatarPng = $avatar->toPng();
        $maskImage = $manager->read($maskPath);


        // 保存
        $filename = uniqid('profile_') . '.png';
        $avatarPng->save(storage_path('app/public/profile-photos/' . $filename));

        // 片付け
        unlink($maskPath);

        // 古い画像削除
        if ($user->profile_photo_path) {
            \Storage::disk('public')->delete($user->profile_photo_path);
        }

        $validated['profile_photo_path'] = 'profile-photos/' . $filename;
    }

    $user->update($validated);

    return back()->with('status', 'profile-updated');
}




    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

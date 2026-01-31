<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\LineMessageService;

class AdminUserMessageController extends Controller
{
    public function create(User $user)
    {
        return view('admin.users.message', compact('user'));
    }

    public function send(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        LineMessageService::push(
            $user->line_user_id,
            $request->message
        );

        return redirect()
            ->route('admin.users.edit', $user)
            ->with('success', 'LINEメッセージを送信しました');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// app/Http/Controllers/Admin/AdminLoginHistoryController.php
use App\Models\LoginHistory;

class AdminLoginHistoryController extends Controller
{
    public function index()
    {
        $histories = LoginHistory::with('user')
            ->orderByDesc('logged_in_at')
            ->paginate(50);

        return view('admin.login_histories.index', compact('histories'));
    }
}


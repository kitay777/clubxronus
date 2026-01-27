<?php

// app/Http/Controllers/AdminRecruitmentController.php
namespace App\Http\Controllers;

use App\Models\Recruitment;
use Illuminate\Http\Request;

class AdminRecruitmentController extends Controller
{
    // 一覧表示
    public function index()
    {
        $recruitments = Recruitment::all();
        return view('admin.recruitments.index', compact('recruitments'));
    }

    // 作成画面表示
    public function create()
    {
        return view('admin.recruitments.create');
    }

    // 作成処理
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'job_type' => 'required|string|max:255',
            'content' => 'nullable|string',
            'time' => 'nullable|string',
            'salary' => 'nullable|string',
            'benefit' => 'nullable|string',
        ]);

        Recruitment::create($validated);

        return redirect()->route('admin.recruitments.index')->with('success', '求人情報が追加されました');
    }

    // 編集画面表示
    public function edit(Recruitment $recruitment)
    {
        return view('admin.recruitments.edit', compact('recruitment'));
    }

    // 更新処理
    public function update(Request $request, Recruitment $recruitment)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'job_type' => 'required|string|max:255',
            'content' => 'nullable|string',
            'time' => 'nullable|string',
            'salary' => 'nullable|string',
            'benefit' => 'nullable|string',
        ]);

        $recruitment->update($validated);

        return redirect()->route('admin.recruitments.index')->with('success', '求人情報が更新されました');
    }

    // 削除処理
    public function destroy(Recruitment $recruitment)
    {
        $recruitment->delete();
        return redirect()->route('admin.recruitments.index')->with('success', '求人情報が削除されました');
    }
}

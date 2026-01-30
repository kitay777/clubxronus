<?php

// app/Http/Controllers/Admin/PointBaseSettingController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PointBaseSetting;
use Illuminate\Http\Request;

class PointBaseSettingController extends Controller
{
    public function edit()
    {
        $setting = PointBaseSetting::current();
        return view('admin.points.base', compact('setting'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'rate' => 'required|numeric|min:0',
        ]);

        PointBaseSetting::current()->update($data);

        return back()->with('success', '通常ポイント付加率を更新しました');
    }
}

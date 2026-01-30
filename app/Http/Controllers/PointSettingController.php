<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PointSetting;

class PointSettingController extends Controller
{
    public function edit()
    {
        $setting = PointSetting::firstOrCreate([]);

        return view('admin.point-settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'base_rate'         => 'required|numeric|min:0',
            'event_bonus_rate'  => 'nullable|numeric|min:0',
            'event_start_time'  => 'nullable',
            'event_end_time'    => 'nullable',
            'event_enabled'     => 'boolean',
        ]);

        $setting = PointSetting::first();
        $setting->update($data);

        return back()->with('success', 'ポイント付加率を更新しました');
    }
}

@extends('layouts.admin')

@section('title', 'ポイント付加率設定')

@section('content')
<h1 class="text-2xl font-bold mb-6">ポイント付加率設定</h1>

<form method="POST" action="{{ route('admin.point-settings.update') }}"
      class="bg-white p-6 rounded shadow max-w-xl">
    @csrf
    @method('PUT')

    {{-- 通常 --}}
    <div class="mb-4">
        <label class="block font-bold mb-1">通常ポイント付加率（%）</label>
        <input type="number" step="0.1" name="base_rate"
               value="{{ old('base_rate', $setting->base_rate) }}"
               class="w-full border rounded p-2">
    </div>

    <hr class="my-6">

    {{-- イベント --}}
    <div class="mb-4">
        <label class="inline-flex items-center">
            <input type="checkbox" name="event_enabled" value="1"
                   {{ $setting->event_enabled ? 'checked' : '' }}>
            <span class="ml-2 font-bold">イベントポイントを有効にする</span>
        </label>
    </div>

    <div class="mb-4">
        <label class="block font-bold mb-1">イベント追加付加率（%）</label>
        <input type="number" step="0.1" name="event_bonus_rate"
               value="{{ old('event_bonus_rate', $setting->event_bonus_rate) }}"
               class="w-full border rounded p-2">
    </div>

    <div class="flex gap-4">
        <div class="flex-1">
            <label class="block font-bold mb-1">開始時間</label>
            <input type="time" name="event_start_time"
                   value="{{ $setting->event_start_time }}"
                   class="w-full border rounded p-2">
        </div>

        <div class="flex-1">
            <label class="block font-bold mb-1">終了時間</label>
            <input type="time" name="event_end_time"
                   value="{{ $setting->event_end_time }}"
                   class="w-full border rounded p-2">
        </div>
    </div>

    <button class="mt-6 px-4 py-2 bg-blue-600 text-white rounded">
        保存
    </button>
</form>
@endsection

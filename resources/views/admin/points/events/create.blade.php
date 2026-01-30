{{-- resources/views/admin/points/events/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'イベントポイント追加')

@section('content')
<h1 class="text-2xl font-bold mb-6">イベントポイント追加</h1>

<form method="POST" action="{{ route('admin.points.events.store') }}"
      class="bg-white p-6 rounded shadow max-w-lg">
    @csrf

    <div class="mb-4">
        <label class="block font-bold mb-1">イベント名</label>
        <input name="name" class="w-full border rounded p-2">
    </div>

<div class="mb-4">
    <label class="block font-bold mb-1">イベント日</label>
    <input type="date" name="event_date"
           class="w-full border rounded p-2">
</div>

<div class="mb-4">
    <label class="block font-bold mb-1">開始時刻</label>
    <input type="time" name="start_time"
           value="19:00"
           class="w-full border rounded p-2">
</div>

<div class="mb-4">
    <label class="block font-bold mb-1">終了時刻（30時まで）</label>
    <input type="number" name="end_hour"
           min="0" max="30" value="30"
           class="w-full border rounded p-2">
    <p class="text-xs text-gray-500 mt-1">
        ※ 24以上は翌日扱いになります
    </p>
</div>

    <div class="mb-4">
        <label class="block font-bold mb-1">付加率（%）</label>
        <input type="number" step="0.1" name="rate"
               class="w-full border rounded p-2">
    </div>

    <label class="inline-flex items-center">
        <input type="checkbox" name="is_active" value="1" checked>
        <span class="ml-2">有効</span>
    </label>

    <button class="mt-6 px-4 py-2 bg-blue-600 text-white rounded">
        登録
    </button>
</form>
@endsection

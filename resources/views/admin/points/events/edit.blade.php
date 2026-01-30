@extends('layouts.admin')

@section('title', 'イベント編集')

@section('content')
<h1 class="text-2xl font-bold mb-6">イベント編集</h1>

<form method="POST"
      action="{{ route('admin.points.events.update', $event) }}"
      class="bg-white p-6 rounded shadow max-w-lg">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block font-bold mb-1">イベント名</label>
        <input type="text" name="name"
               value="{{ old('name', $event->name) }}"
               class="w-full border p-2">
    </div>

    <div class="mb-4">
        <label class="block font-bold mb-1">イベント日</label>
        <input type="date" name="event_date"
               value="{{ $eventDate }}"
               class="w-full border p-2">
    </div>

    <div class="mb-4">
        <label class="block font-bold mb-1">開始時刻</label>
        <input type="time" name="start_time"
               value="{{ $startTime }}"
               class="w-full border p-2">
    </div>

    <div class="mb-4">
        <label class="block font-bold mb-1">終了時刻（30時まで）</label>
        <input type="number" name="end_hour"
               min="0" max="30"
               value="{{ $endHour }}"
               class="w-full border p-2">
    </div>

    <div class="mb-4">
        <label class="block font-bold mb-1">付加率（%）</label>
        <input type="number" step="0.1" name="rate"
               value="{{ old('rate', $event->rate) }}"
               class="w-full border p-2">
    </div>

    <label class="inline-flex items-center">
        <input type="checkbox" name="is_active" value="1"
               {{ $event->is_active ? 'checked' : '' }}>
        <span class="ml-2">有効</span>
    </label>

    <button class="mt-6 px-4 py-2 bg-blue-600 text-white rounded">
        更新
    </button>
</form>
@endsection

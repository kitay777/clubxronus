{{-- resources/views/admin/points/base.blade.php --}}
@extends('layouts.admin')

@section('title', '通常ポイント設定')

@section('content')
<h1 class="text-2xl font-bold mb-6">通常ポイント付加率</h1>

@if (session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.points.base.update') }}"
      class="bg-white p-6 rounded shadow max-w-md">
    @csrf
    @method('PUT')

    <label class="block font-bold mb-1">付加率（%）</label>
    <input type="number" step="0.1" name="rate"
           value="{{ old('rate', $setting->rate) }}"
           class="w-full border rounded p-2">

    <button class="mt-6 px-4 py-2 bg-blue-600 text-white rounded">
        保存
    </button>
</form>
@endsection

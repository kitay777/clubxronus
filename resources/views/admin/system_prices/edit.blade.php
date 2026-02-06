@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-6">設定の編集</h2>

    <form action="{{ route('admin.system_prices.update', $systemPrice) }}" method="POST"
        class="bg-white p-6 rounded shadow max-w-xl">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">タイトル</label>
            <input type="text" name="title" id="title" value="{{ old('title', $systemPrice->title) }}"
                class="mt-1 w-full border border-gray-300 rounded p-2" required>
        </div>

        <div class="mb-4">
            <label for="value" class="block text-sm font-medium text-gray-700">値</label>
            <textarea name="value" id="value" rows="5" class="mt-1 w-full border border-gray-300 rounded p-2" required>{{ old('value', $systemPrice->value) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="type" class="block text-sm font-medium text-gray-700">タイプ</label>
            <input type="text" name="type" id="type" value="{{ old('type', $systemPrice->type) }}"
                class="mt-1 w-full border border-gray-300 rounded p-2" required>
        </div>

        <div class="mb-4">
            <label for="order" class="block text-sm font-medium text-gray-700">順番</label>
            <input type="number" name="order" id="order" value="{{ old('order', $systemPrice->order) }}"
                class="mt-1 w-full border border-gray-300 rounded p-2">
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">保存</button>
    </form>
@endsection

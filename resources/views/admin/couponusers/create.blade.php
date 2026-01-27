@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">クーポン作成</h2>

    <form action="{{ route('admin.coupons.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">タイトル</label>
            <input type="text" name="title" id="title" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="type" class="block text-sm font-medium text-gray-700">タイプ</label>
            <input type="text" name="type" id="type" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="value" class="block text-sm font-medium text-gray-700">値</label>
            <input type="number" name="value" id="value" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="shop_id" class="block text-sm font-medium text-gray-700">ショップ</label>
            <select name="shop_id" id="shop_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                <option value="">選択してください</option>
                @foreach($shops as $shop)
                    <option value="{{ $shop->id }}" {{ old('shop_id') == $shop->id ? 'selected' : '' }}>{{ $shop->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="image_path" class="block text-sm font-medium text-gray-700">画像</label>
            <input type="file" name="image_path" id="image_path" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">作成</button>
    </form>
@endsection

@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">店舗情報編集</h2>

    <form action="{{ route('admin.shop_info.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">住所</label>
            <input type="text" name="address" id="address" value="{{ old('address', $shopInfo->address) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="nearest_station" class="block text-sm font-medium text-gray-700">最寄駅</label>
            <input type="text" name="nearest_station" id="nearest_station" value="{{ old('nearest_station', $shopInfo->nearest_station) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">電話</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $shopInfo->phone) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">保存</button>
    </form>
@endsection

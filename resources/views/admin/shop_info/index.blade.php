@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">店舗情報</h2>

    <div class="mb-4">
        <div><strong>住所：</strong> {{ $shopInfo->address }}</div>
        <div><strong>最寄駅：</strong> {{ $shopInfo->nearest_station }}</div>
        <div><strong>電話：</strong> {{ $shopInfo->phone }}</div>
    </div>

    <a href="{{ route('admin.shop_info.edit') }}" class="px-4 py-2 bg-blue-500 text-white rounded">編集</a>
@endsection

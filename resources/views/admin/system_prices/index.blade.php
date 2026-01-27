@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-6">システム設定一覧</h2>

    @if (session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif

    <table class="min-w-full table-auto bg-white shadow rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">タイトル</th>
                <th class="px-4 py-2 text-left">値</th>
                <th class="px-4 py-2 text-left">タイプ</th>
                <th class="px-4 py-2 text-left">順番</th>
                <th class="px-4 py-2 text-left">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($systemPrices as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $item->title }}</td>
                    <td class="px-4 py-2">{{ $item->value }}</td>
                    <td class="px-4 py-2">{{ $item->type }}</td>
                    <td class="px-4 py-2">{{ $item->order }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.system_prices.edit', $item) }}" class="text-blue-500 hover:underline">編集</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

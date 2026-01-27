@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-6">クーポン一覧</h2>

    <a href="{{ route('admin.coupons.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded mb-4">クーポン追加</a>

    <table class="min-w-full table-auto border-collapse">
        <thead>
            <tr>
                <th class="border p-2">ID</th>
                <th class="border p-2">タイプ</th>
                <th class="border p-2">値段</th>
                <th class="border p-2">タイトル</th>
                <th class="border p-2">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($coupons as $coupon)
                <tr>
                    <td class="border p-2">{{ $coupon->id }}</td>
                    <td class="border p-2">{{ $coupon->type }}</td>
                    <td class="border p-2">{{ $coupon->value }}</td>
                    <td class="border p-2">{{ $coupon->title }}</td>
                    <td class="border p-2">
                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="text-blue-500">編集</a>
                        |
                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

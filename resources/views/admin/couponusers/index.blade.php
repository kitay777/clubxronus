@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">クーポン配布管理</h2>

    <!-- クーポン配布フォーム -->
    <form action="{{ route('admin.couponusers.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="user_id" class="block text-sm font-medium text-gray-700">ユーザー</label>
            <select name="user_id" id="user_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                <option value="">選択してください</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="coupon_id" class="block text-sm font-medium text-gray-700">クーポン</label>
            <select name="coupon_id" id="coupon_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                <option value="">選択してください</option>
                @foreach($coupons as $coupon)
                    <option value="{{ $coupon->id }}">{{ $coupon->title }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">配布</button>
    </form>

    <h3 class="mt-8 text-xl">配布されたクーポン一覧</h3>

    <table class="min-w-full mt-4 border-collapse">
        <thead>
            <tr>
                <th class="px-4 py-2 border">ユーザー名</th>
                <th class="px-4 py-2 border">クーポン名</th>
                <th class="px-4 py-2 border">配布日時</th>
                <th class="px-4 py-2 border">削除</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($couponUsers as $couponUser)
                <tr>
                    <td class="px-4 py-2 border">{{ $couponUser->user->name }}</td>
                    <td class="px-4 py-2 border">{{ $couponUser->coupon->title }}</td>
                    <td class="px-4 py-2 border">{{ $couponUser->issued_at }}</td>
                    <td class="px-4 py-2 border">
                        <form action="{{ route('admin.couponusers.destroy', $couponUser) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ページネーションリンク -->
    <div class="mt-4">
        {{ $couponUsers->links() }}
    </div>
@endsection

<!-- resources/views/admin/point_histories/index.blade.php -->
@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">ポイント履歴</h2>

    <!-- 検索フォーム -->
    <form method="GET" action="{{ route('admin.point_histories.index') }}" class="mb-4">
        <div class="flex space-x-4">
            <div class="flex-1">
                <label for="user_name" class="block text-sm font-medium text-gray-700">ユーザー名</label>
                <input type="text" name="user_name" id="user_name" value="{{ request()->input('user_name') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
            </div>
            <button type="submit" class="mt-6 px-4 py-2 bg-blue-500 text-white rounded">検索</button>
        </div>
    </form>

    <!-- 履歴一覧 -->
    <table class="min-w-full bg-white shadow-md rounded-md overflow-hidden">
        <thead>
            <tr>
                <th class="py-2 px-4 text-left">ユーザー名</th>
                <th class="py-2 px-4 text-left">ポイント変更</th>
                <th class="py-2 px-4 text-left">変更日時</th>
                <th class="py-2 px-4 text-left">理由</th>
                <th class="py-2 px-4 text-left">アクション</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pointHistories as $pointHistory)
                <tr>
                    <td class="py-2 px-4">{{ $pointHistory->user->name }}</td>
                    <td class="py-2 px-4">{{ $pointHistory->change }}</td>
                    <td class="py-2 px-4">{{ $pointHistory->created_at->format('Y-m-d H:i') }}</td>
                    <td class="py-2 px-4">{{ $pointHistory->reason }}
                    @if(Str::contains($pointHistory->reason, '来店ID'))
                        <a href="{{ route('admin.users.visits.index', $pointHistory->user_id) }}">
                            来店履歴
                        </a>
                    @endif
                    
                    <td class="py-2 px-4">
                        <form action="{{ route('admin.point_histories.destroy', $pointHistory->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <div class="mt-6">
                {{ $pointHistories->links() }}
            </div>
        </tbody>
    </table>

    <!-- ページネーション -->
    <div class="mt-4">
        {{ $pointHistories->links() }}
    </div>
@endsection

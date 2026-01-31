@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">ユーザー管理</h2>

    <form method="GET" class="mb-6 p-4 border rounded bg-gray-50">
        <div class="grid grid-cols-3 gap-4">
            <input type="text" name="name" value="{{ request('name') }}" placeholder="名前" class="border p-2 rounded">

            <input type="number" name="age" value="{{ request('age') }}" placeholder="年齢" class="border p-2 rounded">

            <input type="text" name="residence" value="{{ request('residence') }}" placeholder="住まい"
                class="border p-2 rounded">

            <input type="date" name="visit_date" value="{{ request('visit_date') }}" class="border p-2 rounded">

            <input type="text" name="cast_name" value="{{ request('cast_name') }}" placeholder="指名"
                class="border p-2 rounded">
        </div>

        <div class="mt-4">
            <button class="px-4 py-2 bg-black text-white rounded">検索</button>
            <a href="{{ route('admin.users.index') }}" class="ml-3 text-sm text-gray-600">リセット</a>
        </div>
    </form>

    <table class="min-w-full table-auto border-collapse">
        <thead>
            <tr>
                <th class="border px-2 py-1">ID</th>
                <th class="border px-2 py-1">名前</th>
                <th class="border px-2 py-1">年齢</th>
                <th class="border px-2 py-1">住まい</th>
                <th class="border px-2 py-1">最終来店日</th>
                <th class="border px-2 py-1">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="border px-2 py-1">{{ $user->id }}</td>
                    <td class="border px-2 py-1">{{ $user->name }}</td>
                    <td class="border px-2 py-1">{{ $user->profile->age ?? '—' }}</td>
                    <td class="border px-2 py-1">{{ $user->profile->residence ?? '—' }}</td>
                    <td class="border px-2 py-1">
                        {{ optional($user->visits->first())->visit_date ?? '—' }}
                    </td>
                    <td class="border px-2 py-1">
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600">編集</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
@endsection

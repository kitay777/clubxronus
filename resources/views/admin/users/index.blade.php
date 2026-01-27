@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">ユーザー管理</h2>

    <table class="min-w-full table-auto border-collapse">
        <thead>
            <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">名前</th>
                <th class="px-4 py-2 border">メールアドレス</th>
                <th class="px-4 py-2 border">アクション</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="px-4 py-2 border">{{ $user->id }}</td>
                    <td class="px-4 py-2 border">{{ $user->name }}</td>
                    <td class="px-4 py-2 border">{{ $user->email }}</td>
                    <td class="px-4 py-2 border">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500">編集</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

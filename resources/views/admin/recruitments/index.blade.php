@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-6">求人一覧</h2>

    @if (session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.recruitments.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded mb-4 inline-block">新規求人追加</a>

    <table class="min-w-full table-auto bg-white shadow rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">カテゴリー</th>
                <th class="px-4 py-2 text-left">職種</th>
                <th class="px-4 py-2 text-left">内容</th>
                <th class="px-4 py-2 text-left">給与</th>
                <th class="px-4 py-2 text-left">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recruitments as $recruitment)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $recruitment->category }}</td>
                    <td class="px-4 py-2">{{ $recruitment->job_type }}</td>
                    <td class="px-4 py-2">{{ $recruitment->content }}</td>
                    <td class="px-4 py-2">{{ $recruitment->salary }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.recruitments.edit', $recruitment) }}" class="text-blue-500 hover:underline">編集</a>
                        |
                        <form action="{{ route('admin.recruitments.destroy', $recruitment) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

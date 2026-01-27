@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-bold mb-4">ニュース管理</h1>

<table class="w-full bg-white rounded shadow text-sm">
    <thead>
        <tr class="border-b bg-gray-100">
            <th class="p-2">公開</th>
            <th class="p-2">タイトル</th>
            <th class="p-2">公開日</th>
            <th class="p-2">対象</th>
            <th class="p-2 text-right">操作</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($news as $n)
        <tr class="border-b">
            <td class="p-2">
                @if ($n->is_active)
                    <span class="text-green-600 font-bold">公開</span>
                @else
                    <span class="text-red-500 font-bold">非公開</span>
                @endif
            </td>

            <td class="p-2">{{ $n->title }}</td>

            <td class="p-2">{{ $n->published_at?->format('Y/m/d') }}</td>

            <td class="p-2">
                @if ($n->is_all)
                    全体
                @else
                    {{ $n->cast?->name ?? '不明' }}
                @endif
            </td>

            <td class="p-2 text-right whitespace-nowrap">

                {{-- ON/OFF --}}
                <form action="{{ route('admin.news.toggle', $n) }}" 
                      method="post" 
                      class="inline-block">
                    @csrf @method('PATCH')
                    <button class="px-3 py-1 bg-blue-500 text-white rounded">
                        切替
                    </button>
                </form>

                {{-- 削除 --}}
                <form action="{{ route('admin.news.destroy', $n) }}"
                      method="post"
                      class="inline-block"
                      onsubmit="return confirm('削除しますか？')">
                    @csrf @method('DELETE')
                    <button class="px-3 py-1 bg-red-500 text-white rounded">
                        削除
                    </button>
                </form>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $news->links() }}
</div>

@endsection

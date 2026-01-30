{{-- resources/views/admin/points/events/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'イベントポイント設定')

@section('content')
    <h1 class="text-2xl font-bold mb-6">イベントポイント一覧</h1>

    <a href="{{ route('admin.points.events.create') }}" class="inline-flex mb-4 px-4 py-2 bg-blue-600 text-white rounded">
        ＋ イベント追加
    </a>

    <table class="w-full bg-white shadow rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">イベント名</th>
                <th class="p-2">期間</th>
                <th class="p-2">付加率</th>
                <th class="p-2">状態</th>
                <th class="p-2">編集</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
                <tr class="border-t">
                    <td class="p-2">{{ $event->name }}</td>
                    <td class="p-2 text-sm">
                        {{ $event->start_at }}<br>
                        {{ $event->end_at }}
                    </td>
                    <td class="p-2">{{ $event->rate }}%</td>
                    <td class="p-2">
                        @if ($event->is_active)
                            <span class="text-green-600 font-bold">有効</span>
                        @else
                            <span class="text-gray-400">無効</span>
                        @endif
                    </td>
                    <td class="p-2">
                        <a href="{{ route('admin.points.events.edit', $event) }}"
                            class="inline-flex px-3 py-1 bg-black text-white rounded">
                            編集
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

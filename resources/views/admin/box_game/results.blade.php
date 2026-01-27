{{-- resources/views/admin/box_game/results.blade.php --}}
@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-bold mb-6">BOX GAME 当選一覧</h2>

@if(session('success'))
    <div class="mb-4 text-green-600">
        {{ session('success') }}
    </div>
@endif

<table class="w-full border text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-2 border">日時</th>
            <th class="p-2 border">ユーザー</th>
            <th class="p-2 border">等級</th>
            <th class="p-2 border">状態</th>
            <th class="p-2 border">操作</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $r)
        <tr>
            <td class="p-2 border">
                {{ $r->created_at }}
            </td>
            <td class="p-2 border">
                {{ $r->name }}<br>
                <span class="text-xs text-gray-500">{{ $r->email }}</span>
            </td>
            <td class="p-2 border text-center font-bold">
                {{ $r->rank }} 等
            </td>
            <td class="p-2 border text-center">
                @if($r->redeemed)
                    <span class="text-green-600 font-bold">
                        引換済
                    </span><br>
                    <span class="text-xs text-gray-500">
                        {{ $r->redeemed_at }}
                    </span>
                @else
                    <span class="text-red-500 font-bold">
                        未引換
                    </span>
                @endif
            </td>
            <td class="p-2 border text-center">
                @if(!$r->redeemed)
                    <form method="POST"
                          action="{{ route('admin.box_game.redeem', $r->id) }}">
                        @csrf
                        <button class="px-3 py-1 bg-black text-yellow-400 rounded">
                            引換済にする
                        </button>
                    </form>
                @else
                    —
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $results->links() }}
</div>
@endsection

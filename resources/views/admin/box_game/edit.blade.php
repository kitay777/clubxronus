{{-- resources/views/admin/box_game/edit.blade.php --}}
@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-bold mb-6">BOX GAME 当選確率設定</h2>

@if ($errors->any())
    <div class="mb-4 text-red-600">
        {{ $errors->first() }}
    </div>
@endif

@if (session('success'))
    <div class="mb-4 text-green-600">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.box_game.update') }}">
    @csrf

    <table class="w-full border mb-4">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 border">等級</th>
                <th class="p-2 border">確率（%）</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($settings as $s)
                <tr>
                    <td class="p-2 border text-center">
                        {{ $s->rank }} 等
                    </td>
                    <td class="p-2 border text-center">
                        <input type="number"
                               name="probability[{{ $s->rank }}]"
                               value="{{ $s->probability }}"
                               class="w-24 text-center border rounded">
                        %
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button class="px-6 py-2 bg-black text-yellow-400 font-bold rounded">
        保存
    </button>
</form>
@endsection

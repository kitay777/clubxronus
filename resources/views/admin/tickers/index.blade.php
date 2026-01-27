@extends('layouts.admin')

@section('content')
    <h1 class="text-xl font-bold mb-4">テロップ管理</h1>

    <form action="{{ route('tickers.store') }}" method="post" class="p-4 bg-white rounded shadow mb-6">
        @csrf
        <label class="block mb-2">テロップ内容</label>
        <input type="text" name="text" class="w-full border p-2 mb-4" required>

        <button class="px-4 py-2 bg-blue-500 text-white rounded">追加</button>
    </form>

    <table class="w-full bg-white rounded shadow">
        <tbody>
            @foreach($tickers as $ticker)
                <tr class="border-b">
                    <td class="p-4">{{ $ticker->text }}</td>
                    <td class="p-4 text-right">
                        <form action="{{ route('tickers.destroy', $ticker) }}" method="post">
                            @csrf @method('DELETE')
                            <button class="px-4 py-2 bg-red-500 text-white rounded">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection

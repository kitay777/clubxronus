<x-app-layout>
    <x-slot name="header">
        <h2>売上ポイント付与</h2>
    </x-slot>
    <div class="max-w-md mx-auto mt-8 bg-white rounded shadow p-6">
        <form method="POST" action="{{ route('sales.store') }}">
            @csrf
            <div class="mb-2">
                <label>対象ユーザー</label>
                <select name="user_id" class="w-full border rounded px-2 py-1">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} (ID:{{ $user->id }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-2">
                <label>売上金額（円）</label>
                <input type="number" name="amount" class="w-full border rounded px-2 py-1" required>
            </div>
            <div class="mb-2">
                <label>付与ポイント割合（％）</label>
                <input type="number" name="point_rate" class="w-full border rounded px-2 py-1" value="10" required>
            </div>
            <div class="mb-2">
                <label>メモ</label>
                <input type="text" name="memo" class="w-full border rounded px-2 py-1">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">ポイント付与</button>
        </form>
    </div>
</x-app-layout>

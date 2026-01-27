<x-app-layout>
    <x-slot name="header">
        <h2>ポイント使用確認</h2>
    </x-slot>
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow p-6 mt-8">
@if (session('error'))
    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

        <div class="text-lg font-bold mb-2">{{ $user->name }} 様</div>
        <div class="mb-4">
            <span class="font-semibold">現在保有ポイント：</span>
            <span class="text-blue-700 text-xl font-mono">{{ $user->point ?? 0 }} pt</span>
        </div>

        <form method="POST" action="{{ route('mypage.use_point') }}">
            @csrf
            <div class="mb-4">
                <label for="point" class="font-semibold">何pt使用しますか？</label>
                <input type="number" name="point" id="point" min="1" max="{{ $user->point }}" required
                    class="ml-2 border rounded px-2 py-1 w-32 text-right">
                pt
            </div>
            <button type="submit" class="px-5 py-2 bg-pink-600 text-white rounded shadow hover:bg-pink-700">
                使用を確定
            </button>
            <a href="{{ route('mypage') }}" class="ml-4 text-blue-500 hover:underline">キャンセル</a>
        </form>
    </div>
</x-app-layout>

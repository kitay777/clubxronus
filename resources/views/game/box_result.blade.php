{{-- resources/views/game/box_result.blade.php --}}
<x-app-layout>
<div class="max-w-xl mx-auto py-12 text-center">

    <h2 class="text-2xl font-bold mb-6">
        🎉 あなたの当選商品
    </h2>

    @php
        $prizes = [
            1 => ['name' => '1等', 'desc' => '当選'],
            2 => ['name' => '2等', 'desc' => '当選'],
            3 => ['name' => '3等', 'desc' => '当選'],
            4 => ['name' => '4等', 'desc' => '当選'],
            5 => ['name' => '5等', 'desc' => '当選'],
        ];
        $prize = $prizes[$rank];
    @endphp

    <div class="bg-black border-2 border-yellow-500 rounded-xl p-8">
        <div class="text-yellow-400 text-xl font-bold mb-4">
            当選！　🎉🎉🎉🎉🎉
        </div>

        <div class="text-white text-2xl font-bold mb-2">
            {{ $prize['name'] }}
        </div>

        {{-- 引換状態 --}}
        @if($redeemed)
            <div class="mt-4 text-green-400 font-bold text-lg">
                ✅ 引換済み
            </div>
            <div class="text-sm text-gray-400 mt-1">
                引換日時：{{ \Carbon\Carbon::parse($redeemed_at)->format('Y/m/d H:i') }}
            </div>
        @else
            <div class="mt-4 text-red-400 font-bold text-lg">
                ⏳ 未引換
            </div>
            <div class="text-sm text-gray-400 mt-1">
                店舗スタッフに画面をお見せください
            </div>
        @endif

    </div>

    <div class="mt-8">
        <a href="{{ route('dashboard') }}"
           class="inline-block px-10 py-3
                  bg-black border border-yellow-500
                  text-yellow-400 font-bold rounded-full
                  hover:bg-yellow-500 hover:text-black transition">
            ← ダッシュボードへ戻る
        </a>
    </div>

</div>
</x-app-layout>

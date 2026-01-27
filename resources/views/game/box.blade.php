{{-- resources/views/game/box.blade.php --}}
<x-app-layout>
<div class="max-w-xl mx-auto py-12 text-center relative">

    {{-- タイトル --}}
    <h2 class="text-2xl font-bold mb-4 tracking-widest">
        BOX GAME
    </h2>

    {{-- 説明 --}}
    <div id="gameMessage"
         class="mb-8 text-lg font-bold text-yellow-800 tracking-wide animate-pulse">
        🎁 ボックスを1つ選んでください（※一人一回限り）
    </div>

    {{-- BOX 選択 --}}
    <div id="boxArea" class="flex justify-center gap-8 mb-10">
        @for ($i = 0; $i < 3; $i++)
            <img src="/assets/imgs/box.png"
                 class="w-32 cursor-pointer box hover:scale-105 transition"
                 data-index="{{ $i }}">
        @endfor
    </div>

    {{-- VIDEO --}}
    <div id="videoArea" class="hidden">
        <video id="boxVideo"
               src="/assets/box.mp4"
               class="mx-auto w-full rounded shadow-lg"
               playsinline></video>
    </div>

    {{-- RESULT --}}
    <div id="result"
         class="mt-8 text-2xl font-bold hidden"></div>

    {{-- 戻るボタン --}}
    <div id="backBtn" class="mt-8 hidden">
        <a href="{{ route('dashboard') }}"
           class="inline-block px-10 py-3
                  bg-black border-2 border-yellow-500
                  text-yellow-400 font-bold rounded-full
                  hover:bg-yellow-500 hover:text-black transition">
            ← ダッシュボードに戻る
        </a>
    </div>

</div>

<script>
const boxes       = document.querySelectorAll('.box');
const video       = document.getElementById('boxVideo');
const videoArea   = document.getElementById('videoArea');
const result      = document.getElementById('result');
const backBtn     = document.getElementById('backBtn');
const gameMessage = document.getElementById('gameMessage');
const boxArea     = document.getElementById('boxArea');

// 等級メッセージ
const rankText = {
    1: '🎉🎉🎉【1等 当選！！】🎉🎉🎉',
    2: '🎉【2等 当選！】🎉',
    3: '✨【3等】✨',
    4: '🎁【4等】',
    5: '🙂【5等】'
};

// BOXクリック
boxes.forEach(box => {
    box.addEventListener('click', () => {

        // 二度押し防止
        boxes.forEach(b => b.style.pointerEvents = 'none');

        // 表示切替
        gameMessage.classList.add('hidden');
        boxArea.classList.add('hidden');
        videoArea.classList.remove('hidden');

        video.play();
    });
});

// 動画終了後
video.addEventListener('ended', async () => {

    const res = await fetch("{{ route('game.box.play') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        }
    });

    // すでにプレイ済み
    if (res.status === 403) {
        result.innerText = '⚠️ このゲームはすでにプレイ済みです';
        result.classList.remove('hidden');
        backBtn.classList.remove('hidden');
        return;
    }

    const data = await res.json();

    // 結果表示
    result.innerText = rankText[data.rank] ?? '結果取得エラー';
    result.classList.remove('hidden');

    // 戻る
    backBtn.classList.remove('hidden');
});
</script>
</x-app-layout>

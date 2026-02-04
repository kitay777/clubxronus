@if (Auth::check() && Auth::user()->shimei === null)
<div
    x-show="showProfileModal"
    x-transition.opacity
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/70"
>
    <div class="bg-white w-full max-w-lg rounded-lg p-6 shadow-xl text-black mx-4">
        <h2 class="text-xl font-bold text-red-600 mb-1">
            初回プロフィール登録（必須）
        </h2>
        <p class="text-sm text-gray-600 mb-4">
            入力後、管理者の承認をお待ちください。
        </p>

        <form method="POST" action="{{ route('profile.initial.store') }}" class="space-y-3">
            @csrf

            <input
                name="shimei"
                required
                class="w-full border rounded p-2"
                placeholder="名前 or ニックネーム"
            >

            <input
                name="age"
                type="number"
                required
                class="w-full border rounded p-2"
                placeholder="年齢"
            >

            <input
                name="blood_type"
                class="w-full border rounded p-2"
                placeholder="血液型（任意）"
            >

            <input
                name="residence"
                class="w-full border rounded p-2"
                placeholder="住まい（任意）"
            >

            <button
                type="submit"
                class="w-full bg-black text-white py-2 rounded font-bold"
            >
                送信
            </button>
        </form>
    </div>
</div>
@endif
@if (
    Auth::check() &&
    filled(Auth::user()->shimei) &&
    !Auth::user()->is_approved
)
<div
    x-data="{ open: true }"
    x-show="open"
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/70"
>
    <div class="bg-white w-full max-w-md rounded-lg p-6 text-center shadow-xl">
        <h2 class="text-xl font-bold text-red-600 mb-3">
            管理者の承認待ちです
        </h2>

        <p class="text-gray-700 mb-4">
            入力内容を確認後、管理者が承認します。
        </p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="mt-4 px-6 py-2 bg-black text-white rounded">
                OK
            </button>
        </form>
    </div>
</div>
@endif

<x-app-layout>
    <div class="w-full">
        @if ($tickers->count())
            <div x-data='tickerComponent({!! json_encode($tickers) !!})' x-init="start()"
                class="w-full bg-black border-y border-yellow-500 overflow-hidden py-2 relative" x-ref="container">
                <div class="absolute top-0 left-0 h-full flex items-center whitespace-nowrap" x-ref="ticker"
                    :style="{ transform: `translateX(${x}px)` }">
                    <template x-for="(text, i) in displayItems" :key="i">
                        <span class="text-white text-lg mx-6" x-text="text"></span>
                    </template>
                </div>
            </div>
        @endif



        <script>
            document.addEventListener('alpine:init', () => {

                Alpine.data('tickerComponent', (items) => ({
                    baseItems: items,
                    displayItems: [],
                    x: 0,

                    start() {
                        this.$nextTick(() => {

                            const containerWidth = this.$refs.container.offsetWidth;

                            this.displayItems = [...this.baseItems];

                            while (this.calcWidth() < containerWidth * 2) {
                                this.displayItems = this.displayItems.concat(this.baseItems);
                                if (this.displayItems.length > 50) break;
                            }

                            this.animate();
                        });
                    },

                    animate() {
                        const ticker = this.$refs.ticker;

                        const loop = () => {
                            this.x -= 1;

                            if (this.x <= -(ticker.scrollWidth / 2)) {
                                this.x = 0;
                            }

                            requestAnimationFrame(loop);
                        };

                        loop();
                    },

                    calcWidth() {
                        const span = document.createElement('span');
                        span.style.visibility = 'hidden';
                        span.style.whiteSpace = 'nowrap';
                        span.innerText = this.displayItems.join('　　');

                        document.body.appendChild(span);
                        const w = span.offsetWidth;
                        document.body.removeChild(span);

                        return w;
                    }
                }));

            });
        </script>
        @if (Auth::check())
        {{ Auth::user()->id }}
        {{ Auth::user()->is_line_friend }}
            @if (!Auth::user()->is_line_friend)
                @if (Auth::check() && !Auth::user()->is_line_friend)
                    <div class="mt-4 p-4 border rounded bg-yellow-100 text-black">
                        <p class="font-bold">お知らせを受け取るには</p>
                        <p class="mt-2">
                            公式LINEを友だち追加してください。
                        </p>
                        <a href="https://line.me/R/ti/p/@758nctis"
                        target="_blank"
                        rel="noopener"
                        class="inline-block mt-3 px-4 py-2 bg-green-600 text-white rounded">
                            LINE友だち追加
                        </a>
                    </div>
                @endif

            @endif
        @endif
        @if ($topImages->count())
            <div x-data="carousel" x-init="start()" class="relative w-full overflow-hidden"
                style="aspect-ratio: 16 / 9;">


                <!-- 画像 -->
                <template x-for="(item, index) in items" :key="index">
                    <div x-show="current === index" class="absolute inset-0 transition-opacity duration-700"
                        x-transition.opacity>
                        <img :src="item" class="w-full h-auto object-cover">
                    </div>
                </template>

                <!-- 左右ボタン -->
                <button @click="prev"
                    class="absolute left-3 top-1/2 -translate-y-1/2 
                   text-white bg-black/40 p-2 rounded-full">‹</button>

                <button @click="next"
                    class="absolute right-3 top-1/2 -translate-y-1/2 
                   text-white bg-black/40 p-2 rounded-full">›</button>

                <!-- ドット -->
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                    <template x-for="(item, index) in items" :key="'dot-' + index">
                        <button @click="go(index)" class="w-3 h-3 rounded-full"
                            :class="current === index ? 'bg-white' : 'bg-gray-400'">
                        </button>
                    </template>
                </div>

            </div>

            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('carousel', () => ({
                        current: 0,
                        timer: null,
                        items: @json($topImages->map(fn($img) => asset('storage/' . $img->image_path))),

                        start() {
                            // 自動スライド
                            this.timer = setInterval(() => this.next(), 4000);

                            // スワイプ
                            let startX = 0;
                            this.$el.addEventListener('touchstart', e => {
                                startX = e.touches[0].clientX;
                            });
                            this.$el.addEventListener('touchend', e => {
                                let endX = e.changedTouches[0].clientX;
                                if (endX < startX - 50) this.next();
                                if (endX > startX + 50) this.prev();
                            });
                        },

                        next() {
                            this.current = (this.current + 1) % this.items.length;
                        },

                        prev() {
                            this.current = (this.current - 1 + this.items.length) % this.items.length;
                        },

                        go(i) {
                            this.current = i;
                        }
                    }))
                })
            </script>
        @endif


        <div class="mt-8">

            <div class="flex justify-between items-center px-2">
                <h2 class="text-xl font-bold text-yellow-500 tracking-wide">CAST LIST</h2>

                <a href="{{ route('casts.index') }}" class="text-white text-sm hover:text-yellow-400 transition">
                    もっと見る
                </a>
            </div>

            <!-- 金ライン -->
            <div class="border-t border-yellow-500 my-2"></div>

            <!-- 横スクロールコンテナ -->
            <div class="overflow-x-auto whitespace-nowrap pb-4">

                @foreach ($casts as $cast)
                    <div class="inline-block mr-4 bg-white rounded-lg shadow overflow-hidden align-top"
                        style="width: 180px">

                        <a href="{{ route('casts.show', $cast) }}">

                            <div class="relative w-full" style="aspect-ratio: 1/1;">
                                @if ($cast->image_path)
                                    <img src="{{ asset('storage/' . $cast->image_path) }}"
                                        class="object-cover w-full h-full">
                                @else
                                    <div class="w-full h-full bg-gray-300"></div>
                                @endif

                                <div
                                    class="absolute bottom-0 left-0 w-full bg-white/60 text-black text-center font-bold py-1">
                                    {{ $cast->name }}
                                </div>
                            </div>

                        </a>

                    </div>
                @endforeach

            </div>
            <!-- リクルートバナー -->
            <div class="border-t border-yellow-500 my-4 py-6 flex flex-col items-center space-y-3">

                <!-- 上のテキスト -->
                <div class="text-white font-bold text-lg text-center">
                    ーフロアレディ・スタッフ募集中ー
                </div>

                <!-- 下のバナー -->
                <a href="/recruit" class="block">
                    <img src="/assets/imgs/recruite.png" alt="リクルートバナー"
                        class="w-[30%] min-w-[180px] max-w-[300px] h-auto mx-auto" />
                </a>

            </div>


        </div>
        <!-- ↓↓↓ ここから下にバナー・アドレス・Google Map ↓↓↓ -->
        @if ($tickers->count())
            <div x-data='tickerComponent({!! json_encode($tickers) !!})' x-init="start()"
                class="w-full bg-black border-y border-yellow-500 overflow-hidden py-2 relative" x-ref="container">
                <div class="absolute top-0 left-0 h-full flex items-center whitespace-nowrap" x-ref="ticker"
                    :style="{ transform: `translateX(${x}px)` }">
                    <template x-for="(text, i) in displayItems" :key="i">
                        <span class="text-white text-lg mx-6" x-text="text"></span>
                    </template>
                </div>
            </div>
        @endif
        <!-- NEWS -->
        <div class="mt-10">

            <div class="flex justify-between items-center px-2">
                <h2 class="text-xl font-bold text-yellow-500 tracking-wide">NEWS</h2>

                <a href="{{ route('news.index') }}" class="text-white text-sm hover:text-yellow-400 transition">
                    もっと見る
                </a>
            </div>

            <!-- 金ライン -->
            <div class="border-t border-yellow-500 my-2"></div>

            <div class="bg-black text-white">

                @foreach ($latestNews as $n)
                    @php
                        $isNew = $n->published_at >= now()->subDays(3);
                    @endphp

                    <div x-data="{ open: false }" class="border-b border-gray-700">
                        <button @click="open = !open"
                            class="w-full flex items-center px-3 py-3 hover:bg-gray-800 transition">
                            <!-- アイコン -->
                            <span class="mr-3 text-lg">▶</span>

                            <!-- New -->
                            @if ($isNew)
                                <span class="text-red-500 font-bold mr-3">New</span>
                            @endif

                            <!-- 日付 -->
                            <span class="font-bold text-lg mr-3">
                                {{ $n->published_at->format('Y/m/d') }}
                            </span>

                            <!-- タイトル -->
                            <span class="truncate">
                                {{ $n->title }}
                            </span>
                        </button>

                        <!-- 本文（開閉エリア） -->
                        <div x-show="open" x-collapse class="px-4 py-3 bg-gray-900 text-sm text-gray-200">
                            {!! nl2br(e($n->body)) !!}

                            @if ($n->image_path)
                                <div class="mt-3">
                                    <img src="{{ asset('storage/' . $n->image_path) }}" class="w-full rounded">
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
        <!-- BLOG -->
        <div class="mt-10">

            <div class="flex justify-between items-center px-2">
                <h2 class="text-xl font-bold text-yellow-500 tracking-wide">BLOG</h2>

                <a href="{{ route('blogs.index') }}" class="text-white text-sm hover:text-yellow-400 transition">
                    もっと見る
                </a>
            </div>

            <!-- 金ライン -->
            <div class="border-t border-yellow-500 my-2"></div>

            <!-- カード一覧（横3 or ページいっぱい） -->
            <div class="grid grid-cols-3 gap-4 px-2">

                @foreach ($latestBlogs as $blog)
                    <div class="bg-white rounded shadow overflow-hidden">

                        <!-- 上段：キャスト名 -->
                        <div class="px-3 py-1 font-bold text-gray-700">
                            {{ $blog->cast->name ?? 'Name' }}
                        </div>

                        <!-- サムネイル -->
                        <div class="w-full" style="aspect-ratio: 1/1;">
                            @if ($blog->image_path)
                                <img src="{{ asset('storage/' . $blog->image_path) }}"
                                    class="object-cover w-full h-full" />
                            @else
                                <div class="bg-blue-200 w-full h-full"></div>
                            @endif
                        </div>

                        <!-- 下段：題名 + 日付 -->
                        <div class="flex justify-between items-center px-3 py-2 text-sm font-bold text-gray-800">
                            <span>{{ $blog->title }}</span>
                            <span>{{ $blog->published_at->format('Y/m/d') }}</span>
                        </div>

                        <!-- 本文冒頭 -->
                        <div class="px-3 pb-3 text-gray-600 text-sm">
                            {{ \Illuminate\Support\Str::limit(strip_tags($blog->body), 20, '…') }}
                        </div>

                    </div>
                @endforeach

            </div>

        </div>


        <!-- ACCESS -->
        <div class="mt-12 bg-black text-white py-6 px-4">

            <!-- タイトル -->
            <h2 class="text-xl font-bold text-yellow-500 tracking-wide mb-3">
                ACCESS
            </h2>
            <div class="border-t border-yellow-500 my-2"></div>
            <!-- 上段：住所 ＋ Google Map ボタン -->
            <div class="flex justify-between items-center mb-4">

                <!-- 住所 -->
                <div class="text-lg font-semibold">
                    {{ $shopInfo->address }}
                </div>

                <!-- Google Map ボタン -->
                <a href="https://www.google.com/maps?q={{ urlencode($shopInfo->address) }}" target="_blank"
                    class="bg-gray-300 text-black px-4 py-1 rounded-full font-bold shadow hover:bg-gray-400 transition">
                    Google map
                </a>
            </div>

            <!-- 地図領域（添付画像風の枠） -->
            <div class="w-full rounded-lg overflow-hidden border border-yellow-500">

                {{-- カスタム地図画像を使う場合 --}}
                {{-- <img src="/assets/imgs/custom_map.png" class="w-full h-auto" /> --}}

                {{-- Google Maps iframe（埋め込み） --}}
                <iframe src="https://www.google.com/maps?q={{ urlencode($shopInfo->address) }}&z=17&output=embed"
                    class="w-full" height="350" style="border:0;" allowfullscreen loading="lazy">
                </iframe>
            </div>

        </div>

                    <!-- タイトル -->
        <h2 class="text-xl font-bold text-yellow-500 tracking-wide mb-3">
            OFFICIAL SNS
        </h2>
        <div class="border-t border-yellow-500 my-2"></div>
        <div class="w-full py-8 flex justify-center items-center gap-12 bg-blacks mt-10">
            <a href="https://facebook.com/yourpage" target="_blank" class="hover:scale-110 transition">
                <img src="/images/facebook.svg" alt="Facebook" class="w-10 h-10" />
            </a>
            <a href="https://instagram.com/yourpage" target="_blank" class="hover:scale-110 transition">
                <img src="/images/instagram.svg" alt="Instagram" class="w-10 h-10" />
            </a>
            <a href="https://www.tiktok.com/@yourpage" target="_blank" class="hover:scale-110 transition">
                <img src="/images/tiktok.svg" alt="TikTok" class="w-10 h-10" />
            </a>
        </div>
    </div>
</x-app-layout>

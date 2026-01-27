<x-app-layout>

    <!-- タイトル -->
    <div class="text-center mt-8">
        <h2 class="text-2xl font-bold text-yellow-500 tracking-wide">
            紹介店舗
        </h2>
        <div class="border-t border-yellow-500 mt-2 w-full"></div>
    </div>

    <div class="max-w-3xl mx-auto mt-10 px-4 text-white">

        @foreach($shops as $shop)
            <a href="{{ route('shops.show', $shop) }}"
               class="block py-6">

                <!-- 上の飾り＋店舗名 -->
                @if($loop->iteration % 2 == 1)
                    {{-- 左側に装飾があるパターン --}}
                    <div class="flex items-center justify-start gap-3 mb-2">

                        <!-- 左飾り -->
                        <div class="flex gap-1">
                            <div class="w-4 h-4 border border-yellow-500"></div>
                            <div class="w-3 h-3 border border-yellow-500"></div>
                        </div>

                        <!-- 店舗名 -->
                        <span class="text-lg font-bold tracking-wide">
                            店舗　<span class="text-white text-xl">{{ $shop->name }}</span>
                        </span>
                    </div>

                @else
                    {{-- 右側に装飾があるパターン --}}
                    <div class="flex items-center justify-between mb-2">
                        <!-- 店舗名 -->
                        <span class="text-lg font-bold tracking-wide">
                            店舗　<span class="text-white text-xl">{{ $shop->name }}</span>
                        </span>

                        <!-- 右飾り -->
                        <div class="flex gap-1">
                            <div class="w-3 h-3 border border-yellow-500"></div>
                            <div class="w-4 h-4 border border-yellow-500"></div>
                        </div>
                    </div>
                @endif

                <!-- 下の金ライン -->
                <div class="border-t border-yellow-500 opacity-80 mt-2"></div>

            </a>
        @endforeach

    </div>

</x-app-layout>

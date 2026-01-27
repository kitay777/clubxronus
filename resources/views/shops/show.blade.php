<x-app-layout>

    <div class="min-h-screen w-full bg-black text-white px-4 py-8 
                bg-[url('/assets/imgs/bg_pattern.png')] bg-repeat">

        <!-- タイトル -->
        <h2 class="text-center text-2xl font-bold text-yellow-500 tracking-wide">
            紹介店舗
        </h2>
        <div class="border-t border-yellow-500 w-full mt-2 mb-8"></div>

        <!-- ★ 中央パネル ★ -->
        <div class="max-w-3xl mx-auto rounded-2xl border border-yellow-600 
                    p-6 sm:p-10 bg-black/70">

            <!-- ===================== 写真枠 ===================== -->
            <div class="relative bg-black border-2 border-yellow-600 rounded-lg 
                        w-full mx-auto mb-10"
                 style="aspect-ratio: 16/9;">

                {{-- 装飾：右上 --}}
                <div class="absolute top-0 right-0 flex flex-col items-end mr-1 mt-1">
                    <div class="w-8 h-8 border border-yellow-500"></div>
                    <div class="w-6 h-6 border border-yellow-500 mt-1"></div>
                </div>

                {{-- 装飾：左下 --}}
                <div class="absolute bottom-0 left-0 flex flex-col ml-1 mb-1">
                    <div class="w-6 h-6 border border-yellow-500 mb-1"></div>
                    <div class="w-8 h-8 border border-yellow-500"></div>
                </div>

                {{-- 写真表示 --}}
                @if ($shop->image_path)
                    <img src="{{ asset('storage/' . $shop->image_path) }}"
                         class="absolute inset-0 w-full h-full object-cover rounded-lg opacity-90">
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-white text-xl">
                        写真
                    </div>
                @endif
            </div>

            <!-- ===================== 情報一覧 ===================== -->

            {{-- 店名 --}}
            <div class="mb-6">
                <div class="text-lg font-bold tracking-wide">店名</div>
                <div class="border-t border-yellow-500 mt-1 opacity-60"></div>
                <div class="mt-2 text-gray-200 text-lg">
                    {{ $shop->name }}
                </div>
            </div>

            {{-- 住所 --}}
            <div class="mb-6">
                <div class="text-lg font-bold tracking-wide">住所</div>
                <div class="border-t border-yellow-500 mt-1 opacity-60"></div>
                <div class="mt-2 text-gray-200">
                    {{ $shop->address ?? '未登録' }}
                </div>
            </div>

            {{-- TEL --}}
            <div class="mb-6">
                <div class="text-lg font-bold tracking-wide">TEL</div>
                <div class="border-t border-yellow-500 mt-1 opacity-60"></div>
                <div class="mt-2 text-gray-200">
                    {{ $shop->tel ?? '未登録' }}
                </div>
            </div>

            {{-- 紹介文 --}}
            <div class="mb-10">
                <div class="text-lg font-bold tracking-wide">紹介文</div>
                <div class="border-t border-yellow-500 mt-1 opacity-60"></div>
                <div class="mt-2 text-gray-200 leading-relaxed">
                    {!! nl2br(e($shop->description ?? '')) !!}
                </div>
            </div>

            <!-- ★ クーポン一覧（豪華デザイン版） -->
            @if ($shop->coupons->count())
                <h3 class="text-xl font-bold text-yellow-500 mb-4">クーポン一覧</h3>

                @foreach ($shop->coupons as $coupon)
                    <div class="mb-6 p-4 border border-yellow-600 rounded-xl bg-black/50">
                        @if ($coupon->image_path)
                            <img src="{{ asset('storage/' . $coupon->image_path) }}"
                                 class="w-full h-40 object-cover rounded mb-3">
                        @endif

                        <div class="text-lg font-bold">{{ $coupon->title }}</div>
                        <div class="text-gray-300 text-sm mb-2">
                            {!! nl2br(e($coupon->description)) !!}
                        </div>
                        <div class="text-yellow-400 text-sm">
                            有効期限：{{ $coupon->valid_until }}
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>

</x-app-layout>

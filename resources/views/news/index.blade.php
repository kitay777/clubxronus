<x-app-layout>
    <div class="w-full bg-black text-white py-6 px-4">

        <!-- 見出し -->
        <h1 class="text-2xl font-bold text-yellow-500 tracking-wide text-center">
            NEWS
        </h1>

        <div class="border-t border-yellow-500 mt-2 mb-6 w-full"></div>

        <!-- NEWS一覧コンテンツ -->
        <div class="max-w-4xl mx-auto bg-white text-black p-4 rounded shadow">

            @foreach ($news as $n)
                @php
                    $isNew = $n->published_at >= now()->subDays(3);
                @endphp

                <div class="mb-6 pb-6 border-b border-gray-400">

                    <!-- サムネイル -->
                    <div class="w-full mb-3" style="aspect-ratio: 16/9;">
                        @if ($n->image_path)
                            <img src="{{ asset('storage/' . $n->image_path) }}"
                                 class="object-cover w-full h-full rounded">
                        @else
                            <div class="w-full h-full bg-blue-200 rounded"></div>
                        @endif
                    </div>

                    <!-- タイトル行 -->
                    <div class="flex justify-between items-center mb-1">

                        <div class="flex items-center gap-2">
                            @if ($isNew)
                                <span class="text-red-500 font-bold">New</span>
                            @else
                                <span class="text-black text-lg">▶</span>
                            @endif

                            <span class="font-bold text-lg">
                                {{ $n->title }}
                            </span>
                        </div>

                        <span class="text-sm text-gray-700">
                            {{ $n->published_at->format('Y/m/d') }}
                        </span>
                    </div>

                    <!-- 本文冒頭 -->
                    <div class="text-gray-700">
                        {!! nl2br(e(Str::limit($n->body, 50, '…'))) !!}
                    </div>

                </div>
            @endforeach

            <!-- ページネーション -->
            <div class="mt-6">
                {{ $news->links() }}
            </div>

        </div>
    </div>
</x-app-layout>

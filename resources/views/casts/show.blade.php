<x-app-layout>
    <x-slot name="header">
        <h2>キャスト詳細</h2>
    </x-slot>
    <div class="p-4 max-w-lg mx-auto">
        <a href="/cast/list" class="text-blue-500 mb-4 inline-block">戻る</a>
        @if($cast->image_path)
            <img src="{{ asset('storage/' . $cast->image_path) }}" alt="" class="w-full h-64 object-cover rounded">
        @endif
        <div class="mt-4">
            <div><strong>名前:</strong> {{ $cast->name }}</div>
            <div><strong>生年月日:</strong> {{ $cast->birthday }}</div>
            <div><strong>身長:</strong> {{ $cast->height }} cm</div>
            <div><strong>スタイル:</strong> {{ $cast->style }}</div>
            <div><strong>出身地:</strong> {{ $cast->area }}</div>
            <div><strong>血液型:</strong> {{ $cast->blood_type }}</div>
            <div><strong>役割:</strong> {{ $cast->role }}</div>
            <div><strong>プロフィール:</strong> {{ $cast->profile }}</div>
        </div>

        {{-- ブログ一覧 --}}
        <div class="mt-8">
            <h3 class="text-lg font-bold mb-4">{{ $cast->name }}さんのブログ</h3>
            @foreach($blogs as $blog)
                <div class="mb-6 bg-white p-4 rounded shadow">
                    <div class="text-xs text-gray-500">{{ $blog->published_at }}</div>
                    @if($blog->image_path)
                        <img src="{{ asset('storage/'.$blog->image_path) }}" class="my-2 w-full max-h-64 object-contain rounded">
                    @endif
                    <div class="font-bold text-lg">{{ $blog->title }}</div>
                    <div class="mt-2 whitespace-pre-line">{{ $blog->body }}</div>
                </div>
            @endforeach

            {{-- ページネーション --}}
            <div>
                {{ $blogs->links() }}
            </div>
        </div>
        <div class="mt-8">
            <h3 class="text-lg font-bold mb-4">{{ $cast->name }}さんのニュース</h3>
            @foreach($news as $item)
                <div class="mb-6 bg-white p-4 rounded shadow">
                    <div class="text-xs text-gray-500">
                        {{ $item->published_at }}
                        @if($item->is_all) <span class="text-pink-500 font-bold ml-2">全体ニュース</span>@endif
                    </div>
                    @if($item->image_path)
                        <img src="{{ asset('storage/'.$item->image_path) }}" class="my-2 w-full max-h-64 object-contain rounded">
                    @endif
                    <div class="font-bold text-lg">{{ $item->title }}</div>
                    <div class="mt-2 whitespace-pre-line">{{ $item->body }}</div>
                </div>
            @endforeach
            <div>
                {{ $news->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

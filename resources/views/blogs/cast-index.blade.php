<x-app-layout>
    <x-slot name="header">
        <h2>{{ $cast->name }}さんのブログ</h2>
    </x-slot>
    <div class="max-w-2xl mx-auto mt-6">
        {{-- キャストプロフィール表示 --}}
        <div class="flex items-center gap-4 bg-white rounded shadow p-4 mb-8">
            @if($cast->image_path)
                <img src="{{ asset('storage/' . $cast->image_path) }}" alt="画像" class="w-24 h-24 object-cover rounded">
            @endif
            <div>
                <div class="font-bold text-lg">{{ $cast->name }}</div>
                <div class="text-sm text-gray-600">役割: {{ $cast->role }}</div>
                <div class="text-xs text-gray-500">
                    生年月日: {{ $cast->birthday }}<br>
                    身長: {{ $cast->height }}cm<br>
                    スタイル: {{ $cast->style }}<br>
                    出身地: {{ $cast->area }}<br>
                    血液型: {{ $cast->blood_type }}
                </div>
            </div>
        </div>

        {{-- ブログ一覧 --}}
        <div>
            @foreach ($blogs as $blog)
                <div class="mb-8 bg-white p-4 rounded shadow">
                    <div class="text-xs text-gray-500">{{ $blog->published_at }}</div>
                    @if($blog->image_path)
                        <img src="{{ asset('storage/'.$blog->image_path) }}" class="my-2 w-full max-h-64 object-contain rounded">
                    @endif
                    <div class="font-bold text-lg">{{ $blog->title }}</div>
                    <div class="mt-2 whitespace-pre-line">{{ $blog->body }}</div>
                </div>
            @endforeach
            {{ $blogs->links() }} {{-- ページネーション --}}
        </div>
    </div>
</x-app-layout>

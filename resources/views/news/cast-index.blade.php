<x-app-layout>
    <x-slot name="header">
        <h2>{{ $cast->name }}さんのニュース</h2>
    </x-slot>
    <div class="max-w-2xl mx-auto mt-6">
        @foreach ($news as $item)
            <div class="mb-6 bg-white p-4 rounded shadow">
                <div class="text-xs text-gray-500">{{ $item->published_at }} @if($item->is_all)（全体ニュース）@endif</div>
                @if($item->image_path)
                    <img src="{{ asset('storage/'.$item->image_path) }}" class="my-2 w-full max-h-64 object-contain rounded">
                @endif
                <div class="font-bold text-lg">{{ $item->title }}</div>
                <div class="mt-2 whitespace-pre-line">{{ $item->body }}</div>
            </div>
        @endforeach
        {{ $news->links() }}
    </div>
</x-app-layout>

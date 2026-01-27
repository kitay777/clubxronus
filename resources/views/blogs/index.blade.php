<x-app-layout>
    <x-slot name="header">
        <h2>全体ブログ一覧</h2>
    </x-slot>
    <div class="p-4">
        @foreach($blogs as $blog)
            <div class="mb-6 bg-white p-4 rounded shadow">
                <div class="text-xs text-gray-600">{{ $blog->published_at }} / {{ $blog->cast->name }}</div>
                @if($blog->image_path)
                    <img src="{{ asset('storage/'.$blog->image_path) }}" class="my-2 w-full max-h-64 object-contain rounded">
                @endif
                <div class="font-bold text-lg">{{ $blog->title }}</div>
                <div>{{ $blog->body }}</div>
            </div>
        @endforeach
        {{ $blogs->links() }}
    </div>
</x-app-layout>

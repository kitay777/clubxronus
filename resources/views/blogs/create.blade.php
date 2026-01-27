<x-app-layout>
    <x-slot name="header">
        <h2>ブログ投稿</h2>
    </x-slot>
    <div class="p-4 max-w-lg mx-auto">
        <form method="POST" action="{{ route('blogs.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-2"><input type="text" name="title" class="w-full" placeholder="タイトル"></div>
            <div class="mb-2"><input type="file" name="image_path" class="w-full"></div>
            <div class="mb-2"><textarea name="body" class="w-full" rows="6" placeholder="本文" required></textarea></div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">投稿</button>
        </form>
    </div>
</x-app-layout>

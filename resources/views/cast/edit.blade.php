<x-app-layout>
    <x-slot name="header">
        <h2>キャスト編集</h2>
    </x-slot>
    <div class="p-4 max-w-lg mx-auto">
        <a href="{{ route('casts.show', $cast) }}" class="text-blue-500 mb-4 inline-block">戻る</a>
        <form method="POST" action="{{ route('casts.update', $cast) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-2"><input type="text" name="name" class="w-full" value="{{ old('name', $cast->name) }}" required></div>
            <div class="mb-2"><input type="date" name="birthday" class="w-full" value="{{ old('birthday', $cast->birthday) }}"></div>
            <div class="mb-2"><input type="number" name="height" class="w-full" value="{{ old('height', $cast->height) }}"></div>
            <div class="mb-2"><input type="text" name="style" class="w-full" value="{{ old('style', $cast->style) }}"></div>
            <div class="mb-2"><input type="text" name="area" class="w-full" value="{{ old('area', $cast->area) }}"></div>
            <div class="mb-2"><input type="text" name="blood_type" class="w-full" value="{{ old('blood_type', $cast->blood_type) }}"></div>
            <div class="mb-2"><input type="text" name="role" class="w-full" value="{{ old('role', $cast->role) }}"></div>
            <div class="mb-2"><textarea name="profile" class="w-full">{{ old('profile', $cast->profile) }}</textarea></div>
            <div class="mb-2"><input type="file" name="image_path" class="w-full"></div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
        </form>
    </div>
</x-app-layout>

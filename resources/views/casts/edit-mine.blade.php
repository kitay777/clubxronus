<x-app-layout>
    <x-slot name="header">
        <h2>マイキャストプロフィール編集</h2>
    </x-slot>
    <div class="p-4 max-w-lg mx-auto">
        <a href="/cast/list" class="text-blue-500 mb-4 inline-block">戻る</a>
        <form method="POST" action="{{ route('casts.update.mine') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-2"><input type="text" name="name" class="w-full" value="{{ old('name', $cast->name ?? '') }}" placeholder="名前" required></div>
            <div class="mb-2"><input type="date" name="birthday" class="w-full" value="{{ old('birthday', $cast->birthday ?? '') }}"></div>
            <div class="mb-2"><input type="number" name="height" class="w-full" value="{{ old('height', $cast->height ?? '') }}" placeholder="身長(cm)"></div>
            <div class="mb-2"><input type="text" name="style" class="w-full" value="{{ old('style', $cast->style ?? '') }}" placeholder="スタイル"></div>
            <div class="mb-2"><input type="text" name="area" class="w-full" value="{{ old('area', $cast->area ?? '') }}" placeholder="出身地"></div>
            <div class="mb-2"><input type="text" name="blood_type" class="w-full" value="{{ old('blood_type', $cast->blood_type ?? '') }}" placeholder="血液型"></div>
            <div class="mb-2"><input type="text" name="role" class="w-full" value="{{ old('role', $cast->role ?? '') }}" placeholder="役割"></div>
            <div class="mb-2"><textarea name="profile" class="w-full">{{ old('profile', $cast->profile ?? '') }}</textarea></div>
            <div class="mb-2"><input type="file" name="image_path" class="w-full"></div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
        </form>
    </div>
</x-app-layout>

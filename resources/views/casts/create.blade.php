<x-app-layout>
    <x-slot name="header">
        <h2>キャスト新規登録</h2>
    </x-slot>
    <div class="p-4 max-w-lg mx-auto">
        <form method="POST" action="{{ route('casts.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-2"><input type="text" name="name" class="w-full" placeholder="名前" required></div>
            <div class="mb-2"><input type="date" name="birthday" class="w-full" placeholder="生年月日"></div>
            <div class="mb-2"><input type="number" name="height" class="w-full" placeholder="身長(cm)"></div>
            <div class="mb-2"><input type="text" name="style" class="w-full" placeholder="スタイル"></div>
            <div class="mb-2"><input type="text" name="area" class="w-full" placeholder="出身地"></div>
            <div class="mb-2"><input type="text" name="blood_type" class="w-full" placeholder="血液型"></div>
            <div class="mb-2"><input type="text" name="role" class="w-full" placeholder="役割"></div>
            <div class="mb-2"><textarea name="profile" class="w-full" placeholder="自己紹介"></textarea></div>
            <div class="mb-2"><input type="file" name="image_path" class="w-full"></div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">登録</button>
        </form>
    </div>
</x-app-layout>

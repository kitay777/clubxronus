@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">ユーザー編集</h2>
    <div class="mt-6 flex gap-4">
        <a href="{{ route('admin.users.karte.edit', $user) }}"
            class="inline-flex items-center px-4 py-2 bg-black text-white rounded hover:bg-gray-800">
            カルテを見る
        </a>

        <a href="{{ route('admin.users.visits.index', $user) }}"
            class="inline-flex items-center px-4 py-2 bg-black text-white rounded hover:bg-gray-800">
            来店履歴
        </a>
        
        @if ($user->line_user_id)
            <a href="{{ route('admin.users.message.create', $user) }}"
            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                LINEメッセージ送信
            </a>
        @endif

    </div>
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @if ($user->is_cast && $cast)
            <div class="mb-4">
                <label class="block mb-1 font-bold">評価（★）</label>
                <select name="cast_stars" class="border rounded px-2 py-1">
                    @for ($i = 0; $i <= 5; $i++)
                        <option value="{{ $i }}" @selected(($cast->stars ?? 0) == $i)>
                            {{ $i }} ★
                        </option>
                    @endfor
                </select>
            </div>
        @endif
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">名前</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">メールアドレス</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        </div>

        <div class="mb-4">
            <label for="point" class="block text-sm font-medium text-gray-700">ポイント</label>
            <input type="number" name="point" id="point" value="{{ old('point', $user->point) }}"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="profile_photo_path" class="block text-sm font-medium text-gray-700">プロフィール画像</label>
            @if ($user->profile_photo_path)
                <img src="/storage/{{ $user->profile_photo_path }}" alt="Profile Photo"
                    class="h-32 w-32 object-cover rounded-full mb-2">
            @endif
            <input type="file" name="profile_photo_path" id="profile_photo_path"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        </div>

        <div class="mb-4">
            <label for="is_cast" class="block text-sm font-medium text-gray-700">キャスト</label>
            <input type="checkbox" name="is_cast" id="is_cast" value="1"
                {{ old('is_cast', $user->is_cast) ? 'checked' : '' }} class="mt-1">
        </div>

        @if ($user->is_cast)
            <h3 class="text-xl font-semibold mb-2">キャスト情報</h3>

            <div class="mb-4">
                <label for="cast_name" class="block text-sm font-medium text-gray-700">キャスト名</label>
                <input type="text" name="cast_name" id="cast_name" value="{{ old('cast_name', $cast->name ?? '') }}"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label for="cast_profile" class="block text-sm font-medium text-gray-700">キャストプロフィール</label>
                <textarea name="cast_profile" id="cast_profile" rows="4"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md">{{ old('cast_profile', $cast->profile ?? '') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="cast_blood_type" class="block text-sm font-medium text-gray-700">血液型</label>
                <input type="text" name="cast_blood_type" id="cast_blood_type"
                    value="{{ old('cast_blood_type', $cast->blood_type ?? '') }}"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label for="cast_role" class="block text-sm font-medium text-gray-700">役割</label>
                <input type="text" name="cast_role" id="cast_role" value="{{ old('cast_role', $cast->role ?? '') }}"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label for="cast_birthday" class="block text-sm font-medium text-gray-700">誕生日</label>
                <input type="date" name="cast_birthday" id="cast_birthday"
                    value="{{ old('cast_birthday', $cast->birthday ?? '') }}"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label for="cast_height" class="block text-sm font-medium text-gray-700">身長</label>
                <input type="text" name="cast_height" id="cast_height"
                    value="{{ old('cast_height', $cast->height ?? '') }}"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label for="cast_style" class="block text-sm font-medium text-gray-700">スタイル</label>
                <input type="text" name="cast_style" id="cast_style"
                    value="{{ old('cast_style', $cast->style ?? '') }}"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label for="cast_area" class="block text-sm font-medium text-gray-700">エリア</label>
                <input type="text" name="cast_area" id="cast_area" value="{{ old('cast_area', $cast->area ?? '') }}"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label for="image_path" class="block text-sm font-medium text-gray-700">画像</label>
                @if ($cast && $cast->image_path)
                    <img src="/storage/{{ $cast->image_path }}" alt="Cast Image"
                        class="h-32 w-32 object-cover rounded-full mb-2">
                @endif
                <input type="file" name="cast_image_path" id="cast_image_path"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
            </div>
        @endif


        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">保存</button>
    </form>
@endsection

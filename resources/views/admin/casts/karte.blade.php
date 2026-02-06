{{-- resources/views/admin/users/karte.blade.php --}}
@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold mb-6">
    顧客カルテ
</h2>

{{-- ユーザー概要 --}}
<div class="mb-6 p-4 border rounded bg-white">
    <div class="font-bold text-lg">
        {{ $user->name }}
    </div>
    <div class="text-sm text-gray-600">
        {{ $user->email }}
    </div>

    <div class="mt-3 flex gap-3">
        <a href="{{ route('admin.users.edit', $user) }}"
           class="px-3 py-1 bg-gray-600 text-white rounded">
            ユーザー編集へ戻る
        </a>

        <a href="{{ route('admin.users.visits.index', $user) }}"
           class="px-3 py-1 bg-blue-600 text-white rounded">
            来店履歴
        </a>
    </div>
</div>

{{-- カルテ編集 --}}
<form method="POST"
      action="{{ route('admin.users.karte.update', $user) }}"
      class="bg-gray-50 p-6 border rounded">
    @csrf
    @method('PUT')

    <h3 class="text-xl font-bold mb-4">基本情報</h3>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">ニックネーム</label>
            <input type="text" name="nickname"
                   value="{{ old('nickname', $profile->nickname ?? '') }}"
                   class="mt-1 block w-full border p-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium">年齢</label>
            <input type="number" name="age"
                   value="{{ old('age', $profile->age ?? '') }}"
                   class="mt-1 block w-full border p-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium">血液型</label>
            <input type="text" name="blood_type"
                   value="{{ old('blood_type', $profile->blood_type ?? '') }}"
                   class="mt-1 block w-full border p-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium">生年月日</label>
            <input type="date" name="birthday"
                   value="{{ old('birthday', $profile->birthday ?? '') }}"
                   class="mt-1 block w-full border p-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium">住まい</label>
            <input type="text" name="residence"
                   value="{{ old('residence', $profile->residence ?? '') }}"
                   class="mt-1 block w-full border p-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium">紹介者</label>
            <input type="text" name="referrer"
                   value="{{ old('referrer', $profile->referrer ?? '') }}"
                   class="mt-1 block w-full border p-2 rounded">
        </div>
    </div>

    <div class="mt-6">
        <label class="block text-sm font-medium">特徴</label>
        <textarea name="features"
                  rows="3"
                  class="mt-1 block w-full border p-2 rounded">{{ old('features', $profile->features ?? '') }}</textarea>
    </div>

    <div class="mt-4">
        <label class="block text-sm font-medium">メモ</label>
        <textarea name="memo"
                  rows="4"
                  class="mt-1 block w-full border p-2 rounded">{{ old('memo', $profile->memo ?? '') }}</textarea>
    </div>

    <div class="mt-6 flex gap-4">
        <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded">
            保存
        </button>

        <a href="{{ route('admin.users.edit', $user) }}"
           class="px-6 py-2 bg-gray-500 text-white rounded">
            キャンセル
        </a>
    </div>
</form>
@endsection

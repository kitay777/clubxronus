@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-6">求人情報の追加</h2>

    <form action="{{ route('admin.recruitments.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="category" class="block text-sm font-medium text-gray-700">カテゴリー</label>
            <input type="text" name="category" id="category" value="{{ old('category') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="job_type" class="block text-sm font-medium text-gray-700">職種</label>
            <input type="text" name="job_type" id="job_type" value="{{ old('job_type') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="content" class="block text-sm font-medium text-gray-700">内容</label>
            <textarea name="content" id="content" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">{{ old('content') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="salary" class="block text-sm font-medium text-gray-700">給与</label>
            <input type="text" name="salary" id="salary" value="{{ old('salary') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        </div>

        <div class="mb-4">
            <label for="benefit" class="block text-sm font-medium text-gray-700">待遇・福利厚生</label>
            <input type="text" name="benefit" id="benefit" value="{{ old('benefit') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">保存</button>
    </form>
@endsection

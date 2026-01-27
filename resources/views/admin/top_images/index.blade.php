@extends('layouts.admin')

@section('content')
    <h1 class="text-xl font-bold mb-4">トップ画像管理</h1>

    <form action="{{ route('top-images.store') }}" method="post" enctype="multipart/form-data"
          class="p-4 bg-white rounded shadow mb-6">
        @csrf
        <input type="file" name="image" class="mb-4" required>
        <button class="px-4 py-2 bg-blue-500 text-white rounded">登録する</button>
    </form>

    <div class="grid grid-cols-3 gap-4">
        @foreach ($images as $img)
            <div class="border rounded p-2">
                <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-auto mb-2">
                <form action="{{ route('top-images.destroy', $img) }}" method="post">
                    @csrf @method('DELETE')
                    <button class="px-4 py-2 bg-red-500 text-white rounded w-full">削除</button>
                </form>
            </div>
        @endforeach
    </div>

@endsection

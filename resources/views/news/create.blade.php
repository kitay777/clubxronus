@extends('layouts.admin')

@section('content')
    <x-slot name="header">
        <h2>ニュース投稿</h2>
    </x-slot>
    <div class="p-4 max-w-lg mx-auto">
        <form method="POST" action="{{ route('news.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-2"><input type="text" name="title" class="w-full" placeholder="タイトル" required></div>
            <div class="mb-2"><input type="file" name="image_path" class="w-full"></div>
            <div class="mb-2"><textarea name="body" class="w-full" rows="6" placeholder="本文" required></textarea></div>
            <div class="mb-2"><input type="date" name="published_at" class="w-full"></div>
            @if(auth()->user()->is_admin)
                <div class="mb-2">
                    <label><input type="checkbox" name="is_all" value="1"> 全キャストへのニュース</label>
                </div>
                <div class="mb-2">
                    <select name="cast_id" class="w-full">
                        <option value="">指定しない（全体ニュースにチェック推奨）</option>
                        @foreach($casts as $cast)
                            <option value="{{ $cast->id }}">{{ $cast->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">投稿</button>
        </form>
    </div>
@endsection

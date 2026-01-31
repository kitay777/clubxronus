@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold mb-4">
    {{ $user->name }} さんへメッセージ送信
</h2>

@if(!$user->line_user_id)
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        このユーザーは LINE と連携していません。
    </div>
@else
    <form method="POST" action="{{ route('admin.users.message.send', $user) }}">
        @csrf

        <div class="mb-4">
            <label class="block font-bold mb-2">メッセージ内容</label>
            <textarea name="message"
                      rows="5"
                      class="w-full border p-3 rounded"
                      placeholder="例：ご来店ありがとうございました。次回使える特典があります。"
                      required></textarea>
        </div>

        <button class="px-4 py-2 bg-black text-white rounded">
            LINEに送信
        </button>
    </form>
@endif
@endsection

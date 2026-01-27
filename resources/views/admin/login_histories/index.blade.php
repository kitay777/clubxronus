@extends('layouts.admin')

@section('content')
<div class="p-6">

    <h1 class="text-xl font-bold mb-4">ログイン履歴</h1>

    <table class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">ユーザー</th>
                <th class="p-2 border">IP</th>
                <th class="p-2 border">端末</th>
                <th class="p-2 border">日時</th>
            </tr>
        </thead>
        <tbody>
            @foreach($histories as $h)
            <tr>
                <td class="p-2 border">
                    {{ $h->user->email ?? '削除済み' }}
                </td>
                <td class="p-2 border">{{ $h->ip_address }}</td>
                <td class="p-2 border max-w-xs truncate">
                    {{ $h->user_agent }}
                </td>
                <td class="p-2 border">
                    {{ $h->logged_in_at->format('Y-m-d H:i:s') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $histories->links() }}
    </div>

</div>
@endsection

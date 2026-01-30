@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">
        来店履歴
    </h2>

    {{-- ユーザー概要 --}}
    <div class="mb-6 p-4 border rounded bg-white">
        <div class="font-bold text-lg">{{ $user->name }}</div>
        <div class="text-sm text-gray-600">{{ $user->email }}</div>

        <div class="mt-3 flex gap-3">
            <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-1 bg-gray-600 text-white rounded">
                ユーザー編集
            </a>
            <a href="{{ route('admin.users.karte.edit', $user) }}" class="px-3 py-1 bg-blue-600 text-white rounded">
                カルテ
            </a>
        </div>
    </div>

    {{-- 追加フォーム --}}
    <div class="mb-8 p-4 border rounded bg-blue-50">
        <h3 class="text-lg font-bold mb-4">来店履歴追加</h3>

        <form method="POST" action="{{ route('admin.users.visits.store', $user) }}">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm">来店日</label>
                    <input type="date" name="visit_date" class="w-full border p-2 rounded" required>
                </div>

                <div>
                    <label class="block text-sm">会計額</label>
                    <input type="number" name="amount" class="w-full border p-2 rounded">
                </div>

                <div>
                    <label class="block text-sm">指名</label>
                    <input type="text" name="cast_name" class="w-full border p-2 rounded">
                </div>

                <div>
                    <label class="block text-sm">時間帯</label>
                    <input type="text" name="time_slot" class="w-full border p-2 rounded">
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm">メモ</label>
                <textarea name="memo" class="w-full border p-2 rounded" rows="3"></textarea>
            </div>

            <button class="mt-4 px-6 py-2 bg-black text-white rounded">
                追加
            </button>
        </form>
    </div>

    {{-- 一覧 --}}
    <h3 class="text-lg font-bold mb-3">来店履歴一覧</h3>

    @if (session('success'))
        <div class="mb-3 text-green-600">
            {{ session('success') }}
        </div>
    @endif

    @if ($visits->count())
        @foreach ($visits as $v)
            <div class="mb-3 p-4 border rounded bg-white">
                <div class="font-semibold">
                    {{ $v->visit_date }}
                    @if ($v->amount)
                        / ¥{{ number_format($v->amount) }}
                    @endif

                    @if ($v->point)
                        <span class="ml-2 text-sm text-green-600">
                            +{{ $v->point }}pt
                        </span>
                    @endif
                </div>

                <div class="text-sm text-gray-700">
                    指名：{{ $v->cast_name ?? '—' }}
                    ／ 時間帯：{{ $v->time_slot ?? '—' }}
                </div>

                @if ($v->memo)
                    <div class="text-xs text-gray-600 mt-1">
                        {{ $v->memo }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.users.visits.destroy', [$user, $v]) }}" class="mt-2"
                    onsubmit="return confirm('削除しますか？');">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 text-sm">
                        削除
                    </button>
                </form>
            </div>
        @endforeach
    @else
        <div class="text-gray-500">
            来店履歴はまだありません。
        </div>
    @endif
@endsection

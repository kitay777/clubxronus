<x-app-layout>

<div class="min-h-screen w-full bg-black text-white px-4 py-10 
            bg-[url('/assets/imgs/bg_pattern.png')] bg-cover">

    <!-- タイトル -->
    <h2 class="text-center text-2xl font-bold text-yellow-500 tracking-wide">
        マイページ
    </h2>
    <div class="border-t border-yellow-500 mt-2 mb-10 w-full"></div>

    <!-- 中央パネル -->
    <div class="max-w-3xl mx-auto bg-black/80 border border-yellow-600 
                rounded-2xl p-6 sm:p-10 shadow-xl">

        <!-- ===================== ユーザー情報 ===================== -->
        <div class="mb-10">
            <div class="text-xl font-bold text-yellow-400 mb-4">
                {{ $user->name }} 様
            </div>

            <div class="flex items-center gap-3">
                <span class="text-lg text-yellow-500">保有ポイント：</span>
                <span class="text-3xl font-mono text-white tracking-wide">
                    {{ $user->point ?? 0 }} <span class="text-yellow-400">pt</span>
                </span>
            </div>

            <form method="GET" action="{{ route('mypage.use_point_form') }}">
                <button 
                    type="submit"
                    class="mt-6 px-6 py-3 border border-yellow-500 text-white 
                           rounded hover:bg-yellow-500 hover:text-black transition">
                    ポイントを使用する
                </button>
            </form>
        </div>


        <!-- ===================== クーポン一覧 ===================== -->
        <h3 class="text-xl font-bold text-yellow-400 mb-3">保有クーポン</h3>
        <div class="border-t border-yellow-600 opacity-50 mb-6"></div>

        <div class="space-y-5">

            @forelse($coupons as $coupon)
                <div class="bg-black/50 border border-yellow-700 rounded-xl p-4 flex gap-4">

                    @if($coupon->image_path)
                        <img src="{{ asset('storage/'.$coupon->image_path) }}"
                             class="w-20 h-20 object-cover rounded border border-yellow-600">
                    @else
                        <div class="w-20 h-20 bg-gray-700 flex items-center justify-center text-sm rounded">
                            No Image
                        </div>
                    @endif

                    <div class="flex-1">
                        <div class="font-bold text-lg text-yellow-400">
                            {{ $coupon->title }}
                        </div>

                        <div class="text-gray-300 text-sm mb-1">
                            {{ $coupon->description }}
                        </div>

                        @if($coupon->pivot->acquired_at)
                            <div class="text-xs text-yellow-300">
                                取得日: {{ $coupon->pivot->acquired_at }}
                            </div>
                        @endif

                        @if($coupon->pivot->used_at)
                            <div class="text-xs text-red-400 mt-1">
                                使用済み: {{ $coupon->pivot->used_at }}
                            </div>
                        @endif
                    </div>

                </div>
            @empty
                <div class="text-gray-400">クーポンはありません</div>
            @endforelse

        </div>


        <!-- ===================== ポイント履歴 ===================== -->
        <h3 class="text-xl font-bold text-yellow-400 mt-12 mb-3">ポイント履歴</h3>
        <div class="border-t border-yellow-600 opacity-50 mb-6"></div>

        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="bg-black border border-yellow-700 text-yellow-400">
                    <th class="p-3">日時</th>
                    <th class="p-3">内容</th>
                    <th class="p-3">増減</th>
                    <th class="p-3">残高</th>
                </tr>
            </thead>

            <tbody>
                @foreach($pointHistories as $history)
                    <tr class="border border-yellow-800 text-gray-200">
                        <td class="p-3">{{ $history->created_at }}</td>
                        <td class="p-3">{{ $history->reason }}</td>
                        <td class="p-3 {{ $history->change > 0 ? 'text-green-400' : 'text-red-400' }}">
                            {{ $history->change > 0 ? '+' : '' }}{{ $history->change }}
                        </td>
                        <td class="p-3">{{ $history->balance }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

</x-app-layout>

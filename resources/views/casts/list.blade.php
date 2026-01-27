<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            cast一覧
        </h2>
    </x-slot>

    <h2 class="text-xl font-bold mb-4">キャスト一覧</h2>
    <div>
        @if($user->is_cast)
            <p class="text-green-600">あなたはキャストとして登録されています。</p>
            <div class="text-right mb-4">
                <a href="/mycast/edit" class="bg-blue-500 text-white px-4 py-2 rounded">自分のデータを編集</a>
            </div>
        @endif
    </div>

    <div class="w-full">
        <div class="grid grid-cols-4 gap-1">
            @foreach ($casts as $cast)
                <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col items-stretch">
                    <div class="relative w-full" style="aspect-ratio:1/1;">
                        <a href="{{ route('casts.show', $cast) }}" class="absolute inset-0">
                        @if($cast->image_path)
                            <img src="{{ asset('storage/' . $cast->image_path) }}"
                                 alt="キャスト画像"
                                 class="object-cover w-full h-full">
                        @else
                            <div class="w-full h-full bg-gray-300"></div>
                        @endif
                        <div class="absolute bottom-0 left-0 w-full bg-white/40 text-black text-center text-base font-bold py-2">
                            {{ $cast->name }}
                        </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2>キャスト一覧</h2>
    </x-slot>
    <div class="p-4">
        <div class="grid grid-cols-4 gap-1 mt-6">
            @foreach ($casts as $cast)
                <div class="bg-white rounded shadow p-2 flex flex-col items-center">
                    @if($cast->image_path)
                        <img src="{{ asset('storage/' . $cast->image_path) }}" alt="" class="w-full h-40 object-cover rounded">
                    @endif
                    <div class="font-bold mt-2">{{ $cast->name }}</div>
                    <div class="text-xs text-gray-600">{{ $cast->role }}</div>
                    <a href="{{ route('casts.show', $cast) }}" class="text-blue-500 text-xs mt-2">詳細</a>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

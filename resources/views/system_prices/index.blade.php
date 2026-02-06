<x-app-layout>
    <x-slot name="header">
        <h2>システム料金・アクセス</h2>
    </x-slot>
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow p-6 mt-8" style="color: black;">

        <h3 class="font-bold text-lg mb-2">SET料金</h3>
        <table class="w-full mb-4">
            @foreach($setPrices as $item)
                <tr>
                    <td class="font-semibold">{{ $item->title }}</td>
                    <td class="align-top">{!! nl2br(e($item->value)) !!}</td>
                </tr>
            @endforeach
        </table>

        <h3 class="font-bold text-lg mb-2">指名料</h3>
        <table class="w-full mb-4">
            @foreach($nominatePrices as $item)
                <tr>
                    <td class="font-semibold">{{ $item->title }}</td>
                    <td class="align-top">{!! nl2br(e($item->value)) !!}</td>
                </tr>
            @endforeach
        </table>

        <h3 class="font-bold text-lg mb-2">クレジットカード</h3>
        <table class="w-full mb-4">
            @foreach($cardPrices as $item)
                <tr>
                    <td class="font-semibold">{{ $item->title }}</td>
                    <td class="align-top">{!! nl2br(e($item->value)) !!}</td>
                </tr>
            @endforeach
        </table>

        <h3 class="font-bold text-lg mb-2">アクセス・店舗情報</h3>
        <table class="w-full mb-4">
            @foreach($infos as $item)
                <tr>
                    <td class="font-semibold">{{ $item->title }}</td>
                    <td class="align-top">{!! nl2br(e($item->value)) !!}</td>
                </tr>
            @endforeach
        </table>

        <div class="mt-6">
            <h4 class="font-bold mb-2">Googleマップ</h4>
            <iframe src="https://www.google.com/maps?q=35.6895,139.6917&z=15&output=embed"
                width="100%" height="280" style="border:0; border-radius: 12px;" allowfullscreen loading="lazy"></iframe>
        </div>
    </div>
</x-app-layout>

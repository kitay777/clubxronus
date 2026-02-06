{{-- resources/views/admin/qr/register.blade.php --}}
@extends('layouts.admin')

@section('title', 'ユーザー登録QR発行')

@section('content')
    <h1 class="text-2xl font-bold mb-6">キャスト登録用 QRコード</h1>

    <div class="bg-white p-6 rounded shadow w-fit">
        <div class="mb-4 text-center">
            {!! QrCode::size(240)->generate($url) !!}
        </div>

        <div class="text-center">
            <p class="text-black mb-1">
                LINEの仕様でQRでキャスト登録<br>
                できない場合は、以下のURLにア<br>
                クセスしてください
            </p>
            <p class=" text-black break-all">
                {{ $url }}
            </p>
        </div>
        <div class="text-center">
            <p class="text-sm text-gray-600 mt-2">
                以下のURLにアクセスします
            </p>
            <p class="text-xs text-gray-500 break-all">
                {{ $url }}
            </p>
        </div>
    </div>
@endsection

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-black text-white 
             bg-[url('/assets/imgs/bg_pattern.png')] bg-cover">

    <!-- 中央パネルの白背景を消す -->
    <div class="min-h-screen flex flex-col justify-center">

        <!-- 子コンテンツ（ここに login が入る） -->
        <div class="w-full">
            {{ $slot }}
        </div>

    </div>

</body>
</html>

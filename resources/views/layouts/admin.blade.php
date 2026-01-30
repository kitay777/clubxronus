{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', '管理画面')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900 font-sans antialiased">

    {{-- ✅ 上部ナビ --}}
    <header class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center shadow">
        <div class="text-lg font-bold">
            <a href="{{ route('admin.dashboard') }}">Admin Panel</a>
        </div>
        <nav class="flex items-center space-x-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-red-300 hover:text-red-500">ログアウト</button>
            </form>
        </nav>
    </header>

    {{-- ✅ 下：左右2カラム --}}
    <div class="flex h-screen">
        {{-- ✅ 左サイドメニュー --}}
        <aside class="w-64 bg-black text-white p-4 space-y-4">
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-2 rounded
                    {{ request()->routeIs('admin.dashboard')
                        ? 'bg-gray-800 text-white'
                        : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="block px-4 py-2 rounded
                    {{ request()->routeIs('admin.users.*')
                        ? 'bg-gray-800 text-white'
                        : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    ユーザー管理
                </a>
                <li>
                    <a href="{{ route('admin.qr.register') }}"
                    class="block px-4 py-2 hover:bg-gray-100">
                        📱 ユーザー登録QR
                    </a>
                </li>
                <a href="{{ route('admin.shop_info.index') }}"
                    class="block px-4 py-2 rounded
                    {{ request()->routeIs('admin.shop_info.*')
                        ? 'bg-gray-800 text-white'
                        : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    ショップ管理
                </a>
                <a href="/admin/top-images"
                    class="block px-4 py-2 rounded {{ request()->routeIs('admin.top-images.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    告知など画像
                </a>
                <a href="/admin/tickers"
                    class="block px-4 py-2 rounded {{ request()->routeIs('admin.tickers.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    テロップ管理
                </a>
                <a href="/admin/news/create"
                    class="block px-4 py-2 rounded {{ request()->routeIs('admin.news.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    NEWS投稿
                </a>
                <!-- layouts/admin.blade.php の aside 内 -->
                <a href="{{ route('admin.system_prices.index') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs('admin.system_prices.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    システム設定
                </a>
                <a href="{{ route('admin.login-histories') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs('admin.system_prices.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    login履歴
                </a>
                <a href="{{ route('admin.box_game.results') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs('admin.system_prices.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    BOX GAME 当選管理
                </a>
                <a href="{{ route('admin.box_game.edit') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs('admin.system_prices.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    ゲーム当選確率設定
                </a>
                <a href="{{ route('admin.recruitments.index') }}"
                    class="block px-4 py-2 rounded
                    {{ request()->routeIs('admin.recruitments.*')
                        ? 'bg-gray-800 text-white'
                        : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    リクルート情報
                </a>
                <a href="{{ route('admin.coupons.index') }}"
                    class="block px-4 py-2 rounded
                    {{ request()->routeIs('admin.coupons.*')
                        ? 'bg-gray-800 text-white'
                        : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    クーポン管理
                </a>
                <a href="{{ route('admin.couponusers.index') }}"
                    class="block px-4 py-2 rounded
                    {{ request()->routeIs('admin.couponusers.*')
                        ? 'bg-gray-800 text-white'
                        : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    クーポン配布管理
                </a>
                <a href="{{ route('admin.point_histories.index') }}"
                    class="block px-4 py-2 rounded
                    {{ request()->routeIs('admin.point_histories.*')
                        ? 'bg-gray-800 text-white'
                        : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    ポイント履歴
                </a>
                <a href="{{ route('admin.points.base.edit') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs('admin.points.base.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">

                通常ポイント設定</a>
                <a href="{{ route('admin.points.events.index') }}" 
                    class="block px-4 py-2 rounded {{ request()->routeIs('admin.points.events.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    イベントポイント設定</a>
            </nav>
        </aside>

        

        {{-- ✅ メインコンテンツ --}}
        <main class="flex-1 p-6 bg-gray-100 overflow-y-auto">
            @yield('content')
        </main>
    </div>

</body>

</html>

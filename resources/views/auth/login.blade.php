<x-guest-layout>

<div class="max-w-md mx-auto py-10 px-6">

    <!-- タイトル -->
    <h2 class="text-center text-2xl font-bold text-yellow-800 tracking-wide mb-2">
        ログイン
    </h2>
    <div class="border-t border-yellow-800 w-full mb-10"></div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login') }}">

        @csrf

        <!-- ID -->
        <div class="mb-6">
            <label for="email" class="block text-lg mb-2 text-yellow-400">ID</label>

            <input id="email" type="email" name="email"
                   class="w-full bg-black border border-yellow-500 text-white 
                          p-3 rounded focus:ring-yellow-500"
                   value="{{ old('email') }}" required autofocus />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>


        <!-- Password -->
        <div class="mb-6">
            <label for="password" class="block text-lg mb-2 text-yellow-400">password</label>

            <input id="password" type="password" name="password"
                   class="w-full bg-black border border-yellow-500 text-white 
                          p-3 rounded focus:ring-yellow-500" required />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-sm text-blue-300 block mt-2 text-right">
                    パスワードをお忘れの場合
                </a>
            @endif
        </div>


        <!-- LOGIN BUTTON -->
        <div class="text-center mt-10">
            <button type="submit"
                class="px-16 py-3 text-lg font-bold text-white 
                       bg-black border border-yellow-500 rounded
                       hover:bg-yellow-500 hover:text-black transition">
                LOGIN
            </button>
        </div>


        <!-- 
        <div class="flex items-center mt-10 mb-6">
            <div class="flex-1 border-t border-gray-600"></div>
            <span class="mx-4 text-gray-400">または</span>
            <div class="flex-1 border-t border-gray-600"></div>
        </div>
 
        
        <div class="text-center">
            <a href=""
               class="inline-block px-10 py-3 text-lg font-bold text-white 
                      bg-black border border-yellow-500 rounded
                      hover:bg-yellow-500 hover:text-black transition">
                新規登録
            </a>
        </div>
        -->
    </form>

</div>

</x-guest-layout>

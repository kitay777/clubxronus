<x-app-layout>

<div class="min-h-screen w-full bg-black text-white px-4 py-10 
            bg-[url('/assets/imgs/bg_pattern.png')] bg-cover">

    <!-- タイトル -->
    <h2 class="text-center text-2xl font-bold text-yellow-500 tracking-wide">
        PROFILE
    </h2>
    <div class="border-t border-yellow-500 w-full mt-2 mb-10"></div>

    <!-- 中央パネル -->
    <div class="max-w-3xl mx-auto bg-black/80 border border-yellow-600 
                rounded-2xl p-6 sm:p-10 shadow-xl space-y-12">


        <!-- ===================== プロフィール画像アップロード ===================== -->
        <div>
            <h3 class="text-xl font-bold text-yellow-400 mb-3">プロフィール画像</h3>
            <div class="border-t border-yellow-600 opacity-50 mb-6"></div>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                @if (auth()->user()->profile_photo_path)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}"
                         class="w-32 h-32 object-cover rounded border border-yellow-500 mb-4">
                @endif

                <label for="profile_photo" class="block text-yellow-300 mb-2">画像を選択</label>
                <input type="file" name="profile_photo" id="profile_photo"
                       class="w-full bg-black border border-yellow-600 p-3 rounded">

                @error('profile_photo')
                    <div class="text-red-400 mt-1">{{ $message }}</div>
                @enderror

                <button type="submit"
                    class="mt-6 px-6 py-3 border border-yellow-500 text-white 
                           rounded hover:bg-yellow-500 hover:text-black transition">
                    更新
                </button>
            </form>
        </div>


        <!-- ===================== 基本情報更新 ===================== -->
        <div>
            <h3 class="text-xl font-bold text-yellow-400 mb-3">基本情報</h3>
            <div class="border-t border-yellow-600 opacity-50 mb-6"></div>

            <div class="bg-black/40 border border-yellow-700 rounded-xl p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>


        <!-- ===================== パスワード更新 ===================== -->
        <div>
            <h3 class="text-xl font-bold text-yellow-400 mb-3">パスワード変更</h3>
            <div class="border-t border-yellow-600 opacity-50 mb-6"></div>

            <div class="bg-black/40 border border-yellow-700 rounded-xl p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>


        <!-- ===================== 退会（アカウント削除） ===================== -->
        <div>
            <h3 class="text-xl font-bold text-yellow-400 mb-3">退会</h3>
            <div class="border-t border-yellow-600 opacity-50 mb-6"></div>

            <div class="bg-black/40 border border-yellow-700 rounded-xl p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</div>

</x-app-layout>

<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow" style="color: black;">

        <h2 class="text-xl font-bold mb-4">キャスト登録申請</h2>

        <form method="POST" action="{{ route('cast.register.store') }}" enctype="multipart/form-data">
            @csrf

            <input name="nickname" class="w-full border rounded p-2 mb-3" placeholder="ニックネーム" required>

            <input type="date" name="birthday" class="w-full border rounded p-2 mb-3">

            <input name="height" class="w-full border rounded p-2 mb-3" placeholder="身長">

            <input name="style" class="w-full border rounded p-2 mb-3" placeholder="スタイル">

            <input name="area" class="w-full border rounded p-2 mb-3" placeholder="エリア">

            <input name="blood_type" class="w-full border rounded p-2 mb-3" placeholder="血液型">

            <input name="role" class="w-full border rounded p-2 mb-3" placeholder="ロール">

            <textarea name="profile" rows="5" class="w-full border rounded p-2 mb-4" placeholder="プロフィール" required></textarea>

            <!-- ★ イメージ -->
            <input type="file" name="image" class="mb-4">

            <button class="w-full bg-black text-white py-2 rounded">
                申請する
            </button>
        </form>


    </div>
</x-app-layout>

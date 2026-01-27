<x-app-layout>
    <div class="min-h-screen w-full bg-black 
                bg-[url('/assets/imgs/bg_pattern.png')] bg-repeat text-white py-10 px-4">

        <!-- 中央の大きな丸角パネル -->
        <div class="max-w-4xl mx-auto bg-black/85 border border-[#f5c96b] 
                    rounded-[2rem] px-6 sm:px-10 py-10 relative overflow-hidden">

            {{-- 上部タイトル --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold tracking-[0.2em] text-[#f5c96b]">
                    RECRUIT
                </h1>
                <div class="mt-2 border-t border-[#f5c96b] w-full"></div>
            </div>

            {{-- ================= floor lady ================= --}}
<section 
    class="relative mb-16 
           bg-[url('/assets/imgs/recruit_lady.png')] 
           bg-no-repeat 
           bg-left-bottom 
           bg-contain">

    <!-- 文章ブロック -->
    <div class="
        bg-black/70 rounded-xl px-6 py-8

        max-w-lg ml-48       {{-- スマホ：中央揃えになる --}}
        sm:ml-48                {{-- PC：左側基準に戻す --}}
        sm:ml-48               {{-- PC：lady画像を避けて右へ移動 --}}
        sm:max-w-none          {{-- PC：幅を自由にする --}}
    ">

        <!-- 見出し -->
        <h2 class="text-3xl italic text-[#f5c96b] mb-6 text-center sm:text-left">
            floor lady
        </h2>

        <div class="space-y-6 text-sm leading-relaxed text-[#f5e6b3]">

            <div>
                <h3 class="text-lg font-bold text-[#f5c96b] mb-2 border-l-4 border-[#f5c96b] pl-3">
                    資格
                </h3>
                <ul class="space-y-1 pl-3">
                    <li>18歳以上（高校生不可）〜35歳位迄の方</li>
                    <li>経験者さん・お友達同士歓迎</li>
                    <li>学生さん・Wワーク・フリーターさん歓迎</li>
                    <li>週1からOK！終電上がりOK！</li>
                    <li>フリーシフト制で出勤時間優遇有等</li>
                    <li>アフター強制は致しません</li>
                    <li>お酒が飲めなくてもOK</li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-bold text-[#f5c96b] mb-2 border-l-4 border-[#f5c96b] pl-3">
                    定休日
                </h3>
                <div class="pl-3">
                    <p>日曜日</p>
                    <p>体験時給：3,500円〜</p>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-bold text-[#f5c96b] mb-2 border-l-4 border-[#f5c96b] pl-3">
                    待遇
                </h3>
                <ul class="space-y-1 pl-3">
                    <li>入店時に制服貸与・面接交通費支給</li>
                    <li>完全個室待機、送迎有り</li>
                    <li>日払い応相談、月払いOK、罰金・ノルマ無</li>
                    <li>貸付金制度有り、ネイル・髪型・アクセ自由</li>
                    <li>鍵付きロッカー完備、髪色自由、ピアスOK</li>
                </ul>
            </div>

        </div>
    </div>

</section>




            {{-- 区切り線 --}}
            <div class="border-t border-[#f5c96b]/60 mb-10"></div>

            {{-- ================= hall staff ================= --}}
<section 
    class="relative mb-16 bg-[url('/assets/imgs/recruit_man.png')] 
           bg-no-repeat bg-right-bottom bg-contain">

    <div class="bg-black/70 p-6 rounded-xl sm:mr-40">
        <h2 class="text-3xl italic text-[#f5c96b] mb-6">hall staff</h2>

        <div class="space-y-6 text-sm leading-relaxed text-[#f5e6b3]">
                        hall staff
                    </h2>

                    <div class="space-y-6 text-sm leading-relaxed text-[#f5e6b3]">

                        {{-- 資格 --}}
                        <div>
                            <h3 class="text-lg font-bold text-[#f5c96b] mb-2 border-l-4 border-[#f5c96b] pl-3">
                                資格
                            </h3>
                            <div class="pl-3">
                                <p>20歳以上</p>
                            </div>
                        </div>

                        {{-- 給与系 --}}
                        <div class="pl-3 space-y-1">
                            <p class="text-lg font-bold text-[#f5c96b]">保証給制度</p>
                            <p>月給45万円〜　19:00〜</p>

                            <p class="mt-3 text-lg font-bold text-[#f5c96b]">社員</p>
                            <p>月給32万〜35万円　19:00〜</p>

                            <p class="mt-3 text-lg font-bold text-[#f5c96b]">アルバイト</p>
                            <p>時給1300円〜1500円　シフト制</p>

                            <p class="mt-3 text-lg font-bold text-[#f5c96b]">エスコート</p>
                            <p>時給1500円〜　フリー制</p>

                            <p class="mt-3 text-lg font-bold text-[#f5c96b]">ヘアメイク</p>
                            <p>時給1800円〜　19:30〜</p>
                        </div>

                        {{-- 待遇 --}}
                        <div>
                            <h3 class="text-lg font-bold text-[#f5c96b] mb-2 border-l-4 border-[#f5c96b] pl-3">
                                待遇
                            </h3>
                            <ul class="space-y-1 pl-3">
                                <li>研修有り（キャスト教育担当、利益歩合、その他役職あり）</li>
                                <li>交通費（物販手当、距離制度手当、人気手当、住宅手当）</li>
                                <li>日払い応相談、月払いOK</li>
                                <li>目標達成報酬、系列店でトレセン参加できます</li>
                                <li>店内備品充実、日曜定休、私服出勤OK</li>
                                <li>ワイシャツ・ネクタイ支給</li>
                                <li>独立支援制度有り</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </section>

        </div>
    </div>

</x-app-layout>

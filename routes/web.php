<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CastController;
use App\Models\Cast;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\NewsController;
use App\Models\News;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\SystemPriceController;
use App\Models\SystemPrice;

use App\Http\Controllers\RecruitmentController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminShopInfoController;
use App\Http\Controllers\AdminSystemPriceController;
use App\Http\Controllers\AdminRecruitmentController;
// routes/web.php
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CouponUserController;
// routes/web.php
use App\Http\Controllers\Admin\PointHistoryController;
use App\Http\Controllers\Admin\TopImageController;
use App\Http\Controllers\Admin\TickerController;
use App\Http\Controllers\Admin\AdminLoginHistoryController;
use App\Http\Controllers\BoxGameController;
use App\Http\Controllers\Admin\AdminCastController;
use App\Http\Controllers\Admin\AdminBoxGameController;
use App\Http\Controllers\Admin\AdminBoxGameResultController;
use App\Http\Controllers\AdminUserKarteController;
use App\Http\Controllers\AdminUserVisitController;
use App\Http\Controllers\Admin\QrController;
// routes/admin.php（または web.php の admin group）

use App\Http\Controllers\Admin\PointBaseSettingController;
use App\Http\Controllers\Admin\PointEventController;
use App\Http\Controllers\Auth\LineAuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\Admin\AdminUserMessageController;
use App\Http\Controllers\LineWebhookController;

use App\Http\Controllers\ProfileInitialController;
use App\Http\Controllers\CastRegisterController;

use App\Http\Middleware\RedirectIfAuthenticated;


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::patch('/users/{user}/toggle-approval', [
        AdminUserController::class,
        'toggleApproval'
    ])->name('users.toggleApproval');
});

Route::middleware('auth')->post(
    '/profile/initial',
    [ProfileInitialController::class, 'store']
)->name('profile.initial.store');


Route::post('/line/webhook', [LineWebhookController::class, 'handle']);

// LINE友だち再確認（ログインユーザー用）
Route::post('/line/check-friend', [LineWebhookController::class, 'checkLineFriend'])
    ->middleware('auth');


Route::middleware(['auth', 'admin'])
    ->prefix('admin/users/{user}')
    ->group(function () {
        Route::get('/message', [AdminUserMessageController::class, 'create'])
            ->name('admin.users.message.create');

        Route::post('/message', [AdminUserMessageController::class, 'send'])
            ->name('admin.users.message.send');
    });

Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('admin.login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::get('/login', fn () => redirect()->route('auth.line.redirect'));
Route::get('/register', fn () => redirect()->route('auth.line.redirect'));

Route::get('/auth/line/redirect', [LineAuthController::class, 'redirect'])
    ->name('auth.line.redirect');

Route::get('/auth/line/callback', [LineAuthController::class, 'callback'])
    ->name('auth.line.callback');


Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        // 通常ポイント設定（1件）
        Route::get('/points/base', [PointBaseSettingController::class, 'edit'])
            ->name('admin.points.base.edit');
        Route::put('/points/base', [PointBaseSettingController::class, 'update'])
            ->name('admin.points.base.update');

        // イベントポイント

        Route::get('/points/events', [PointEventController::class, 'index'])
            ->name('admin.points.events.index');

        Route::get('/points/events/create', [PointEventController::class, 'create'])
            ->name('admin.points.events.create');

        Route::post('/points/events', [PointEventController::class, 'store'])
            ->name('admin.points.events.store');

        // ★ これが無いと編集できない
        Route::get('/points/events/{event}/edit', [PointEventController::class, 'edit'])
            ->name('admin.points.events.edit');

        Route::put('/points/events/{event}', [PointEventController::class, 'update'])
            ->name('admin.points.events.update');

        // （任意）
        Route::patch('/points/events/{event}/toggle', [PointEventController::class, 'toggle'])
            ->name('admin.points.events.toggle');
    });


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/qr/register', [QrController::class, 'register'])
        ->name('admin.qr.register');
});
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/qr/cast_register', [QrController::class, 'castRegister'])
        ->name('admin.qr.cast_register');
});


Route::middleware(['auth', 'admin'])
    ->prefix('admin/users/{user}')
    ->group(function () {

        Route::get('/karte', [AdminUserKarteController::class, 'edit'])
            ->name('admin.users.karte.edit');

        Route::put('/karte', [AdminUserKarteController::class, 'update'])
            ->name('admin.users.karte.update');

        Route::get('/visits', [AdminUserVisitController::class, 'index'])
            ->name('admin.users.visits.index');

        Route::post('/visits', [AdminUserVisitController::class, 'store'])
            ->name('admin.users.visits.store');
        Route::delete('/visits/{visit}',
            [AdminUserVisitController::class, 'destroy']
        )->name('admin.users.visits.destroy');
    });

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/box-game/results',
            [AdminBoxGameResultController::class, 'index']
        )->name('admin.box_game.results');

        Route::post('/box-game/results/{result}/redeem',
            [AdminBoxGameResultController::class, 'redeem']
        )->name('admin.box_game.redeem');
    });

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/box-game', [AdminBoxGameController::class, 'edit'])
            ->name('admin.box_game.edit');

        Route::post('/box-game', [AdminBoxGameController::class, 'update'])
            ->name('admin.box_game.update');
    });
Route::middleware(['auth'])->group(function () {
    Route::get('/game/box', [BoxGameController::class, 'index'])->name('game.box');
    Route::post('/game/box/play', [BoxGameController::class, 'play'])->name('game.box.play');
    Route::get('/game/box/result', [BoxGameController::class, 'result'])
        ->name('game.box.result');
});

Route::middleware(['auth', 'can:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::post('/casts/{cast}/stars', [AdminCastController::class, 'updateStars'])
            ->name('admin.casts.stars');
    });

Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/login-histories', [AdminLoginHistoryController::class, 'index'])
            ->name('admin.login-histories');
    });

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/coupons/used',[CouponController::class, 'used']
    )->name('admin.coupons.used');
});

Route::post('/mypage/coupons/{coupon}/use',
    [MypageController::class, 'useCoupon']
)->name('mypage.coupons.use');



Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/news', [\App\Http\Controllers\Admin\NewsAdminController::class, 'index'])->name('admin.news.index');
    Route::patch('/news/{news}/toggle', [\App\Http\Controllers\Admin\NewsAdminController::class, 'toggle'])->name('admin.news.toggle');
    Route::delete('/news/{news}', [\App\Http\Controllers\Admin\NewsAdminController::class, 'destroy'])->name('admin.news.destroy');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/point_histories', [PointHistoryController::class, 'index'])->name('admin.point_histories.index');
    Route::delete('/point_histories/{pointHistory}', [PointHistoryController::class, 'destroy'])->name('admin.point_histories.destroy');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // クーポン配布管理画面
    Route::get('/couponusers', [CouponUserController::class, 'index'])->name('admin.couponusers.index');
    // クーポン配布処理
    Route::post('/couponusers', [CouponUserController::class, 'store'])->name('admin.couponusers.store');
    Route::delete('/couponusers/{couponUser}', [CouponUserController::class, 'destroy'])->name('admin.couponusers.destroy');

    Route::resource('/top-images', TopImageController::class);
    Route::resource('/tickers', TickerController::class);
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/coupons', [CouponController::class, 'index'])->name('admin.coupons.index');
    Route::get('/coupons/create', [CouponController::class, 'create'])->name('admin.coupons.create');
    Route::get('/coupons/{coupon}/edit', [CouponController::class, 'edit'])->name('admin.coupons.edit');
    Route::post('/coupons', [CouponController::class, 'store'])->name('admin.coupons.store');
    Route::put('/coupons/{coupon}', [CouponController::class, 'update'])->name('admin.coupons.update');
    Route::delete('/coupons/{coupon}', [CouponController::class, 'destroy'])->name('admin.coupons.destroy');
});
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/recruitments', [AdminRecruitmentController::class, 'index'])->name('admin.recruitments.index');
    Route::get('/recruitments/create', [AdminRecruitmentController::class, 'create'])->name('admin.recruitments.create');
    Route::post('/recruitments', [AdminRecruitmentController::class, 'store'])->name('admin.recruitments.store');
    Route::get('/recruitments/{recruitment}/edit', [AdminRecruitmentController::class, 'edit'])->name('admin.recruitments.edit');
    Route::put('/recruitments/{recruitment}', [AdminRecruitmentController::class, 'update'])->name('admin.recruitments.update');
    Route::delete('/recruitments/{recruitment}', [AdminRecruitmentController::class, 'destroy'])->name('admin.recruitments.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/system-prices', [AdminSystemPriceController::class, 'index'])->name('admin.system_prices.index');
    Route::get('/system-prices/{systemPrice}/edit', [AdminSystemPriceController::class, 'edit'])->name('admin.system_prices.edit');
    Route::put('/system-prices/{systemPrice}', [AdminSystemPriceController::class, 'update'])->name('admin.system_prices.update');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/shop-info', [AdminShopInfoController::class, 'index'])->name('admin.shop_info.index');
    Route::get('/shop-info/edit', [AdminShopInfoController::class, 'edit'])->name('admin.shop_info.edit');
    Route::put('/shop-info', [AdminShopInfoController::class, 'update'])->name('admin.shop_info.update');
});

// routes/web.php
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', fn () => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/casts', [AdminUserController::class, 'castindex'])->name('admin.casts.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');

});


Route::middleware('auth')->group(function () {
Route::get('/sales/create', [SalesController::class, 'create'])->name('sales.create');
Route::post('/sales/store', [SalesController::class, 'store'])->name('sales.store');

Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
Route::post('/mypage/use-point', [MypageController::class, 'usePoint'])->name('mypage.use_point');
Route::get('/mypage/use-point', [MypageController::class, 'usePointForm'])->name('mypage.use_point_form');
Route::post('/mypage/use-point', [MypageController::class, 'usePoint'])->name('mypage.use_point');


Route::get('/shops', [ShopController::class, 'index'])->name('shops.index');
Route::get('/shops/{shop}', [ShopController::class, 'show'])->name('shops.show');

Route::get('/recruit', [RecruitmentController::class, 'index'])->name('recruit.index');


});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// routes/web.php
Route::middleware(['auth'])
    ->withoutMiddleware([RedirectIfAuthenticated::class])
    ->group(function () {
        Route::get('/cast/register', [CastRegisterController::class, 'create'])
            ->name('cast.register');

        Route::post('/cast/register', [CastRegisterController::class, 'store'])
            ->name('cast.register.store');
    });

Route::get('/price', [SystemPriceController::class, 'index'])->name('system_prices.index');

Route::get('/casts/{cast}/news', [NewsController::class, 'castNews'])->name('casts.news');

// ニュース投稿画面（運営のみ全体フラグON可）
Route::middleware(['auth'])->group(function () {
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
});

// 投稿画面（ログイン＆自分のキャストのみ許可推奨）
Route::middleware(['auth', 'can:edit-cast'])->group(function () {
    Route::get('/mycast/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('/mycast/blogs', [BlogController::class, 'store'])->name('blogs.store');
});


Route::middleware('auth')->group(function () {
Route::get('/casts', [CastController::class, 'index'])->name('casts.index');
Route::get('/casts/create', [CastController::class, 'create'])->name('casts.create');
Route::post('/casts', [CastController::class, 'store'])->name('casts.store');
Route::get('/casts/{cast}/edit', [CastController::class, 'edit'])->name('casts.edit');
Route::put('/casts/{cast}', [CastController::class, 'update'])->name('casts.update');
Route::get('/casts/{cast}', [CastController::class, 'show'])->name('casts.show');
Route::get('/cast/list', [CastController::class, 'list'])->name('cast.list');

// 全体ブログ一覧
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
// キャストごとのブログ一覧
Route::get('/casts/{cast}/blogs', [BlogController::class, 'castBlogs'])->name('casts.blogs');
});
// 投稿画面（ログイン＆自分のキャストのみ許可推奨）
Route::middleware(['auth', 'can:edit-cast'])->group(function () {
    Route::get('/mycast/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('/mycast/blogs', [BlogController::class, 'store'])->name('blogs.store');
});


Route::middleware(['auth', 'can:edit-cast'])->group(function() {
    Route::get('/mycast/edit', [CastController::class, 'editMine'])->name('casts.edit.mine');
    Route::post('/mycast/update', [CastController::class, 'updateMine'])->name('casts.update.mine');
});
/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', [CastController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard', [CastController::class, 'dashboard'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

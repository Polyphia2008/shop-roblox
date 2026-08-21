<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AccountRbController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\CatalogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepositController as AdminDepositController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\DepositController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\PurchaseController;
use App\Http\Controllers\Client\TicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ĐỊNH TUYẾN WEB
|--------------------------------------------------------------------------
| Toàn bộ URL của bản gốc (.htaccess + router.php) được giữ nguyên để
| không phá liên kết cũ và SEO:
|
|   /                       /auth/login          /auth/register
|   /auth/logout            /auth/profile        /auth/deposit
|   /auth/transaction       /auth/nick-game      /auth/history-nick
|   /auth/history-order     /orders/{magd}       /DownloadFile/{magd}
|   /warranty-policy        /use-bot             /use-report      /2fa
|   /botcheck               /botcheck/notification
|   /client/{action}        /admin/{action}      /admin/{action}/{id}
|
| KHÁC BIỆT QUAN TRỌNG VỀ BẢO MẬT so với bản gốc:
|  - Trang admin được chặn bằng middleware `admin` ở TẦNG SERVER.
|    Bản gốc chỉ dùng `echo '<script>location.href="/"</script>'` nên
|    tắt JS là xem được toàn bộ dữ liệu admin.
|  - Mọi route POST đều yêu cầu CSRF token (bản gốc không có).
|  - Route ghi dữ liệu đều dùng POST/PATCH/DELETE, không dùng GET như
|    bản gốc (GET xoá dữ liệu rất dễ bị CSRF qua thẻ <img>).
*/

/* ==================================================================
 * KHÁCH — KHÔNG CẦN ĐĂNG NHẬP
 * ================================================================== */
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/warranty-policy', [HomeController::class, 'warrantyPolicy'])->name('warranty-policy');
Route::get('/use-bot', [HomeController::class, 'useBot'])->name('use-bot');
Route::get('/use-report', [HomeController::class, 'useReport'])->name('use-report');
Route::get('/2fa', [HomeController::class, 'twoFactor'])->name('2fa');
Route::get('/botcheck', [HomeController::class, 'checkBot'])->name('botcheck');
Route::get('/botcheck/notification', [HomeController::class, 'checkBot'])->name('botcheck.notification');

/* Danh mục + danh sách nick (xem được khi chưa đăng nhập) */
Route::get('/auth/nick-game', [HomeController::class, 'nickGame'])->name('nick-game');
Route::get('/client/nick-game', [HomeController::class, 'nickGame']);
Route::get('/client/buy/{code}', [HomeController::class, 'category'])->name('category');

/* ==================================================================
 * XÁC THỰC
 * ================================================================== */
Route::middleware('guest')->group(function (): void {
    Route::get('/auth/login', [LoginController::class, 'show'])->name('login');
    Route::post('/auth/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/auth/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/auth/register', [RegisterController::class, 'store'])->name('register.store');
});

/* Đăng xuất phải là POST — chống CSRF ép đăng xuất */
Route::post('/auth/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/* ==================================================================
 * KHU VỰC ĐÃ ĐĂNG NHẬP
 * ------------------------------------------------------------------
 *  `not.banned` tự động đăng xuất user bị khoá. Bản gốc chỉ kiểm tra
 *  `banned` ở vài chỗ rời rạc nên user bị ban vẫn dùng được nhiều trang.
 * ================================================================== */
Route::middleware(['auth', 'not.banned'])->group(function (): void {

    /* ---------------------------- Tài khoản --------------------------- */
    Route::get('/auth/profile', [ProfileController::class, 'show'])->name('profile');
    Route::patch('/auth/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/auth/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    /* ----------------------------- Nạp tiền --------------------------- */
    Route::get('/auth/deposit', [DepositController::class, 'index'])->name('deposit');
    Route::post('/auth/deposit/bank', [DepositController::class, 'bankTransfer'])->name('deposit.bank');
    Route::post('/auth/deposit/card', [DepositController::class, 'card'])->name('deposit.card');
    Route::get('/auth/transaction', [DepositController::class, 'transaction'])->name('transaction');

    /* ---------------------------- Mua hàng ---------------------------- */
    Route::post('/purchase/robux', [PurchaseController::class, 'robuxAccount'])->name('purchase.robux');
    Route::post('/purchase/nick', [PurchaseController::class, 'categoryNicks'])->name('purchase.nick');

    /* --------------------------- Lịch sử đơn -------------------------- */
    Route::get('/auth/history-nick', [OrderController::class, 'historyNick'])->name('history-nick');
    Route::get('/auth/history-order', [OrderController::class, 'historyOrder'])->name('history-order');

    /* {magd} giới hạn ký tự chữ-số để không nhận payload lạ vào route */
    Route::get('/orders/{magd}', [OrderController::class, 'show'])
        ->where('magd', '[A-Za-z0-9-]+')
        ->name('orders.show');

    Route::get('/DownloadFile/{magd}', [OrderController::class, 'download'])
        ->where('magd', '[A-Za-z0-9-]+')
        ->name('orders.download');

    /* ------------------------ Báo cáo / bảo hành ---------------------- */
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
});

/* ==================================================================
 * KHU VỰC ADMIN
 * ------------------------------------------------------------------
 *  Chặn ở tầng server bằng middleware `admin` (EnsureUserIsAdmin).
 *  Người không phải admin nhận 403 và KHÔNG nhận được HTML admin.
 * ================================================================== */
Route::middleware(['auth', 'not.banned', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {

        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::get('/home', [DashboardController::class, 'index']);
        Route::get('/security-log', [DashboardController::class, 'securityLog'])->name('security-log');

        /* ---------------------------- Người dùng -------------------------- */
        Route::get('/ListUsers', [UserController::class, 'index'])->name('users.index');
        Route::get('/user-edit/{user}', [UserController::class, 'edit'])->name('users.edit');
        Route::patch('/user-edit/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        /* --------------------------- Nick Robux --------------------------- */
        Route::get('/nick-robux', [AccountRbController::class, 'index'])->name('accountrb.index');
        Route::get('/add-nick-robux', [AccountRbController::class, 'create'])->name('accountrb.create');
        Route::post('/add-nick-robux', [AccountRbController::class, 'store'])->name('accountrb.store');
        Route::get('/edit-nick-robux/{account}', [AccountRbController::class, 'edit'])->name('accountrb.edit');
        Route::patch('/edit-nick-robux/{account}', [AccountRbController::class, 'update'])->name('accountrb.update');
        Route::delete('/nick-robux/{account}', [AccountRbController::class, 'destroy'])->name('accountrb.destroy');

        /* Đơn order robux */
        Route::get('/order-robux', [AccountRbController::class, 'orders'])->name('accountrb.orders');
        Route::get('/edit-order-robux/{order}', [AccountRbController::class, 'editOrder'])->name('accountrb.orders.edit');
        Route::patch('/edit-order-robux/{order}', [AccountRbController::class, 'updateOrder'])->name('accountrb.orders.update');

        /* ------------------------ Chuyên mục + kho nick ------------------- */
        Route::get('/chuyen-muc', [CatalogController::class, 'categories'])->name('categories.index');
        Route::post('/chuyen-muc', [CatalogController::class, 'storeCategory'])->name('categories.store');
        Route::patch('/chuyen-muc/{category}', [CatalogController::class, 'updateCategory'])->name('categories.update');
        Route::delete('/chuyen-muc/{category}', [CatalogController::class, 'destroyCategory'])->name('categories.destroy');

        Route::get('/product', [CatalogController::class, 'nicks'])->name('nicks.index');
        Route::post('/product', [CatalogController::class, 'storeNicks'])->name('nicks.store');
        Route::delete('/product/{nick}', [CatalogController::class, 'destroyNick'])->name('nicks.destroy');

        /* ---------------------------- Ngân hàng --------------------------- */
        Route::get('/ListBank', [BankController::class, 'index'])->name('banks.index');
        Route::post('/ListBank', [BankController::class, 'store'])->name('banks.store');
        Route::get('/bank-edit/{bank}', [BankController::class, 'edit'])->name('banks.edit');
        Route::patch('/bank-edit/{bank}', [BankController::class, 'update'])->name('banks.update');
        Route::delete('/ListBank/{bank}', [BankController::class, 'destroy'])->name('banks.destroy');

        /* ------------------------------ Nạp tiền -------------------------- */
        Route::get('/don-hang', [AdminDepositController::class, 'index'])->name('deposits.index');
        Route::post('/don-hang/{deposit}/approve', [AdminDepositController::class, 'approve'])->name('deposits.approve');
        Route::post('/don-hang/{deposit}/reject', [AdminDepositController::class, 'reject'])->name('deposits.reject');
        Route::post('/cards/{card}/approve', [AdminDepositController::class, 'approveCard'])->name('cards.approve');

        /* ------------------------------ Ticket ---------------------------- */
        Route::get('/ticket', [AdminTicketController::class, 'index'])->name('tickets.index');
        Route::post('/ticket/{ticket}/resolve', [AdminTicketController::class, 'resolve'])->name('tickets.resolve');
        Route::delete('/ticket/{ticket}', [AdminTicketController::class, 'destroy'])->name('tickets.destroy');
        Route::get('/ticket-order', [AdminTicketController::class, 'index'])->name('tickets.orders');

        /* --------------------------- Lịch sử đơn -------------------------- */
        Route::get('/history-order', [AdminTicketController::class, 'orderHistory'])->name('orders.index');
        Route::get('/history-rb', [AccountRbController::class, 'orders'])->name('orders.robux');
        Route::post('/orders/{order}/toggle', [AdminTicketController::class, 'hideOrder'])->name('orders.toggle');

        /* ---------------------------- Cấu hình ---------------------------- */
        Route::get('/Setting', [SettingController::class, 'index'])->name('settings.index');
        Route::patch('/Setting', [SettingController::class, 'update'])->name('settings.update');

        Route::get('/muc-rate', [SettingController::class, 'index'])->name('rates.index');
        Route::post('/muc-rate', [SettingController::class, 'storeRateLevel'])->name('rates.store');
        Route::delete('/muc-rate/{rate}', [SettingController::class, 'destroyRateLevel'])->name('rates.destroy');

        Route::get('/order-rate', [SettingController::class, 'index'])->name('rateorders.index');
        Route::post('/order-rate', [SettingController::class, 'storeRateOrder'])->name('rateorders.store');
        Route::delete('/order-rate/{rate}', [SettingController::class, 'destroyRateOrder'])->name('rateorders.destroy');
    });

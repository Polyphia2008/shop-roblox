<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountRb;
use App\Models\Card;
use App\Models\DepositRequest;
use App\Models\Order;
use App\Models\ProductNick;
use App\Models\SecurityEvent;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Contracts\View\View;

/**
 * ==================================================================
 *  BẢNG ĐIỀU KHIỂN ADMIN
 * ==================================================================
 *  BẢN GỐC (core/is_user.php) "bảo vệ" trang admin như sau:
 *
 *      function CheckAdmin() {
 *          if ($user['level'] != 1) {
 *              echo '<script>location.href="/"</script>';
 *          }
 *      }
 *
 *  Đây KHÔNG phải bảo vệ. Server vẫn render và gửi TOÀN BỘ HTML admin
 *  về máy khách; chỉ có JavaScript chuyển trang. Chỉ cần tắt JS, hoặc
 *  dùng curl, là đọc trọn dữ liệu admin.
 *
 *  Nay: middleware `admin` (EnsureUserIsAdmin) chặn ở tầng server, trả
 *  403 và KHÔNG bao giờ render nội dung admin cho người không có quyền.
 * ==================================================================
 */
class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.home', [
            'stats' => [
                'users'        => User::query()->count(),
                'users_today'  => User::query()->whereDate('created_at', today())->count(),
                'banned'       => User::query()->where('banned', true)->count(),
                'accounts'     => AccountRb::query()->where('status', AccountRb::STATUS_ON_SALE)->count(),
                'nicks'        => ProductNick::query()->where('status', 'live')->count(),
                'orders_today' => Order::query()->whereDate('created_at', today())->count(),
                'revenue_today' => (int) Order::query()->whereDate('created_at', today())->sum('money'),
                'revenue_month' => (int) Order::query()
                    ->whereYear('created_at', now()->year)
                    ->whereMonth('created_at', now()->month)
                    ->sum('money'),
                'tickets_open'  => Ticket::query()->where('status', '0')->count(),
                'deposits_open' => DepositRequest::query()->where('status', '0')->count(),
                'cards_pending' => Card::query()->where('status', 'pending')->count(),
            ],

            /* Nhật ký tấn công — do middleware DetectSqlInjection ghi lại */
            'securityEvents' => SecurityEvent::query()
                ->latest('id')
                ->limit(15)
                ->get(),

            'recentOrders' => Order::query()->latest('id')->limit(10)->get(),
        ]);
    }

    /** Trang xem toàn bộ nhật ký bảo mật */
    public function securityLog(): View
    {
        return view('admin.security-log', [
            'events' => SecurityEvent::query()->latest('id')->paginate(50),
        ]);
    }
}

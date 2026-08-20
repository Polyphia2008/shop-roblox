<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\AccountOrder;
use App\Models\AccountRb;
use App\Models\Order;
use App\Models\ProductNick;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * ==================================================================
 *  LỊCH SỬ ĐƠN HÀNG + TẢI FILE NICK ĐÃ MUA
 * ==================================================================
 *  BẢN GỐC (views/client/orders.php, DownloadFile.php):
 *
 *      $magd = $_GET['magd'];
 *      SELECT * FROM `orders` WHERE `magd` = '$magd'
 *
 *  Hai lỗ hổng nghiêm trọng:
 *   1. SQL injection qua $magd.
 *   2. IDOR — KHÔNG kiểm tra đơn hàng có thuộc user đang đăng nhập hay
 *      không. Chỉ cần đổi mã trên URL là xem/tải được nick của người khác.
 *      Nay mọi truy vấn đều kèm điều kiện `username = user hiện tại`.
 * ==================================================================
 */
class OrderController extends Controller
{
    /** Lịch sử mua nick thường */
    public function historyNick(Request $request): View
    {
        return view('client.history-nick', [
            'orders' => Order::query()
                ->where('username', $request->user()->email)
                ->where('type', 'product_nick')
                ->where('display', 'show')
                ->latest('id')
                ->paginate(20),
        ]);
    }

    /** Lịch sử mua nick Robux */
    public function historyOrder(Request $request): View
    {
        return view('client.history-order', [
            'accounts' => AccountRb::query()
                ->where('username', $request->user()->email)
                ->whereIn('status', [AccountRb::STATUS_SOLD, AccountRb::STATUS_WARRANTY])
                ->latest('id')
                ->paginate(20),

            'orders' => AccountOrder::query()
                ->where('username', $request->user()->email)
                ->latest('id')
                ->paginate(20, ['*'], 'order_page'),
        ]);
    }

    /** Chi tiết một đơn hàng theo mã giao dịch */
    public function show(Request $request, string $magd): View
    {
        /* CHỐNG IDOR: bắt buộc đơn phải thuộc user hiện tại */
        $order = Order::query()
            ->where('magd', $magd)                              // binding
            ->where('username', $request->user()->email)        // ownership
            ->firstOrFail();

        $nicks = ProductNick::query()
            ->where('magd', $order->magd)
            ->where('username', $request->user()->email)
            ->get();

        return view('client.orders', compact('order', 'nicks'));
    }

    /**
     * Tải danh sách nick của một đơn dưới dạng .txt
     * Dùng StreamedResponse để không nạp toàn bộ vào RAM.
     */
    public function download(Request $request, string $magd): StreamedResponse
    {
        $order = Order::query()
            ->where('magd', $magd)
            ->where('username', $request->user()->email)   // CHỐNG IDOR
            ->firstOrFail();

        $filename = 'don-hang-'.$order->magd.'.txt';

        return response()->streamDownload(function () use ($order, $request) {
            ProductNick::query()
                ->where('magd', $order->magd)
                ->where('username', $request->user()->email)
                ->orderBy('id')
                ->chunk(500, function ($chunk) {
                    foreach ($chunk as $nick) {
                        echo $nick->code."|".($nick->note ?? '')."\n";
                    }
                });
        }, $filename, [
            'Content-Type'        => 'text/plain; charset=UTF-8',
            /* Ép tải về, không cho trình duyệt render -> chặn XSS qua file */
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountRb;
use App\Models\Log;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use App\Security\SqlInjectionGuard;
use App\Services\BalanceService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * ==================================================================
 *  XỬ LÝ TICKET BẢO HÀNH + LỊCH SỬ ĐƠN HÀNG
 * ==================================================================
 *  BẢN GỐC (views/admin/ticket.php, ticket-order.php,
 *  ajaxs/admin/remove_ticket.php, views/admin/history-order.php):
 *
 *      SELECT * FROM ticket WHERE status = '" . $_GET['status'] . "'
 *      DELETE FROM ticket WHERE id = '" . $_POST['id'] . "'
 *      SELECT * FROM orders ORDER BY $sort $dir
 *
 *  Lỗ hổng: status/id/sort/dir đều nối chuỗi.
 *  Ngoài ra hoàn tiền bảo hành làm bằng UPDATE money trực tiếp, không
 *  transaction và không ghi log -> nay đi qua BalanceService::refund().
 * ==================================================================
 */
class TicketController extends Controller
{
    private const SORTABLE = ['id', 'money', 'soluong', 'created_at'];

    public function __construct(private readonly BalanceService $balance) {}

    public function index(Request $request): View
    {
        $tickets = Ticket::query()
            /* status ép về '0'/'1'/'2' — không cho chuỗi tuỳ ý vào truy vấn */
            ->when($request->filled('status'), function ($q) use ($request) {
                $status = (string) $request->query('status');
                $q->where('status', in_array($status, ['0', '1', '2'], true) ? $status : '0');
            })
            ->when($request->filled('type'), fn ($q) => $q->where('type', (string) $request->query('type')))
            ->latest('id')
            ->paginate(30)
            ->withQueryString();

        /* Nạp kèm thông tin nick để admin xem nhanh, tránh N+1 query */
        $accounts = AccountRb::query()
            ->whereIn('id', $tickets->pluck('nickrb')->filter()->map(fn ($v) => (int) $v)->all())
            ->get()
            ->keyBy('id');

        return view('admin.tickets.index', compact('tickets', 'accounts'));
    }

    /** Duyệt ticket: có thể kèm hoàn tiền cho khách */
    public function resolve(Request $request, Ticket $ticket): RedirectResponse
    {
        $data = $request->validate([
            'action'  => ['required', 'in:approve,reject'],
            'refund'  => ['nullable', 'integer', 'min:0', 'max:1000000000'],
            'note'    => ['nullable', 'string', 'max:1000'],
        ]);

        if ($ticket->status !== '0') {
            return back()->with('error', 'Ticket này đã được xử lý.');
        }

        try {
            DB::transaction(function () use ($ticket, $data, $request): void {
                /* Khoá ticket, đọc lại trạng thái -> chống xử lý 2 lần */
                $fresh = Ticket::query()->whereKey($ticket->id)->lockForUpdate()->first();

                if ($fresh === null || $fresh->status !== '0') {
                    throw new \RuntimeException('Ticket này đã được xử lý.');
                }

                $refund = (int) ($data['refund'] ?? 0);

                if ($data['action'] === 'approve' && $refund > 0) {
                    $account = AccountRb::query()->whereKey((int) $fresh->nickrb)->first();

                    if ($account === null) {
                        throw new \RuntimeException('Không tìm thấy tài khoản của ticket.');
                    }

                    $user = User::query()->where('email', $account->username)->first();

                    if ($user === null) {
                        throw new \RuntimeException('Không tìm thấy người dùng sở hữu nick.');
                    }

                    /* Hoàn tiền qua service: transaction + lock + ghi log */
                    $this->balance->refund(
                        $user,
                        $refund,
                        "Hoàn tiền bảo hành nick #{$account->id} (ticket #{$fresh->id})",
                    );

                    /* Đánh dấu nick đang bảo hành */
                    $account->update(['status' => AccountRb::STATUS_WARRANTY]);
                }

                $fresh->update([
                    'status' => $data['action'] === 'approve' ? '1' : '2',
                    'lydo'   => trim(($fresh->lydo ?? '')."\n[Admin] ".($data['note'] ?? '')),
                ]);

                Log::query()->create([
                    'user_id'     => $request->user()->id,
                    'ip'          => $request->ip(),
                    'device'      => $request->userAgent(),
                    'action'      => "Xử lý ticket #{$fresh->id} ({$data['action']}), hoàn {$refund}đ",
                    'create_date' => now(),
                ]);
            });
        } catch (Throwable $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Đã xử lý ticket.');
    }

    public function destroy(Ticket $ticket): RedirectResponse
    {
        $ticket->delete();

        return back()->with('success', 'Đã xoá ticket.');
    }

    /** Lịch sử toàn bộ đơn hàng */
    public function orderHistory(Request $request): View
    {
        $column    = SqlInjectionGuard::column($request->query('sort'), self::SORTABLE, 'id');
        $direction = SqlInjectionGuard::direction($request->query('dir'), 'desc');

        $orders = Order::query()
            ->when($request->filled('type'), fn ($q) => $q->where('type', (string) $request->query('type')))
            ->when($request->filled('keyword'), function ($q) use ($request) {
                $safe = addcslashes($request->string('keyword')->trim()->value(), '%_\\');
                $q->where(function ($sub) use ($safe) {
                    $sub->where('magd', 'like', "%{$safe}%")
                        ->orWhere('username', 'like', "%{$safe}%");
                });
            })
            ->when($request->filled('from'), fn ($q) => $q->whereDate('created_at', '>=', $request->date('from')))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('created_at', '<=', $request->date('to')))
            ->orderBy($column, $direction)
            ->paginate(40)
            ->withQueryString();

        return view('admin.orders.index', [
            'orders'    => $orders,
            'column'    => $column,
            'direction' => $direction,
            'total'     => (int) (clone $orders)->getCollection()->sum('money'),
        ]);
    }

    /** Ẩn đơn khỏi giao diện khách (không xoá dữ liệu để còn đối soát) */
    public function hideOrder(Order $order): RedirectResponse
    {
        $order->update(['display' => $order->display === 'show' ? 'hide' : 'show']);

        return back()->with('success', 'Đã đổi trạng thái hiển thị đơn.');
    }
}

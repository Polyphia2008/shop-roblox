<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\AccountRb;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

/**
 * ==================================================================
 *  BÁO CÁO / BẢO HÀNH NICK (ticket)
 * ==================================================================
 *  BẢN GỐC (ajaxs/client/Report.php, HuyReport.php):
 *
 *      INSERT INTO ticket (nickrb, lydo) VALUES ('$nickrb', '$lydo')
 *      DELETE FROM ticket WHERE id = '" . $_POST['id'] . "'
 *
 *  Lỗ hổng:
 *   1. Nối chuỗi cả khi INSERT và DELETE -> inject được.
 *   2. HuyReport.php xoá ticket theo id mà KHÔNG kiểm tra chủ sở hữu
 *      -> user A huỷ được ticket của user B.
 *   3. Không chống spam -> có thể tạo hàng nghìn ticket.
 * ==================================================================
 */
class TicketController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'account_id' => ['required', 'integer', 'min:1'],
            'dichvu'     => ['required', 'string', 'in:baohanh,doipass,khac'],
            'lydo'       => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'dichvu.in' => 'Loại dịch vụ không hợp lệ.',
            'lydo.min'  => 'Vui lòng mô tả lý do ít nhất 10 ký tự.',
        ]);

        $user = $request->user();

        /* Nick phải thuộc user hiện tại — chống báo cáo nick người khác */
        $account = AccountRb::query()
            ->whereKey((int) $data['account_id'])
            ->where('username', $user->email)
            ->first();

        if ($account === null) {
            return back()->with('error', 'Tài khoản này không thuộc quyền sở hữu của bạn.');
        }

        /* Chống spam: mỗi nick chỉ 1 ticket đang mở */
        $open = Ticket::query()
            ->where('nickrb', (string) $account->id)
            ->where('status', '0')
            ->exists();

        if ($open) {
            return back()->with('error', 'Tài khoản này đã có yêu cầu đang xử lý.');
        }

        Ticket::query()->create([
            'type'   => 'accountrb',
            'lydo'   => $data['lydo'],       // binding — không nối chuỗi
            'nickrb' => (string) $account->id,
            'dichvu' => $data['dichvu'],
            'status' => '0',
            'time'   => now(),
        ]);

        return back()->with('success', 'Đã gửi yêu cầu, vui lòng chờ xử lý.');
    }

    /** Huỷ ticket — chỉ khi ticket gắn với nick của chính user */
    public function destroy(Request $request, Ticket $ticket): RedirectResponse
    {
        $user = $request->user();

        /* CHỐNG IDOR: xác minh quyền sở hữu qua nick liên kết */
        $owns = AccountRb::query()
            ->whereKey((int) $ticket->nickrb)
            ->where('username', $user->email)
            ->exists();

        if (! $owns) {
            abort(403, 'Bạn không có quyền huỷ yêu cầu này.');
        }

        if ($ticket->status !== '0') {
            return back()->with('error', 'Yêu cầu đã được xử lý, không thể huỷ.');
        }

        $ticket->delete();

        return back()->with('success', 'Đã huỷ yêu cầu.');
    }
}

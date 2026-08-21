<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\DepositRequest;
use App\Models\Log;
use App\Models\User;
use App\Services\BalanceService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * ==================================================================
 *  DUYỆT NẠP TIỀN (chuyển khoản + thẻ cào)
 * ==================================================================
 *  BẢN GỐC (views/admin/don-hang.php) cộng tiền như sau:
 *
 *      UPDATE users SET money = money + '$amount' WHERE id = '$userid'
 *      UPDATE don_nap SET status = '1' WHERE id = '$id'
 *
 *  Ba lỗi:
 *   1. Nối chuỗi -> inject cả amount và id.
 *   2. Hai câu UPDATE riêng biệt, KHÔNG transaction. Nếu câu 2 lỗi thì
 *      tiền đã cộng mà đơn vẫn "chờ" -> admin duyệt lại là CỘNG 2 LẦN.
 *   3. Không khoá bản ghi -> hai admin bấm cùng lúc là cộng nhân đôi.
 *
 *  Nay: đổi trạng thái + cộng tiền nằm trong CÙNG một transaction, đơn
 *  được lockForUpdate và kiểm tra lại trạng thái sau khi khoá (chống
 *  double-spend / duyệt trùng).
 * ==================================================================
 */
class DepositController extends Controller
{
    public function __construct(private readonly BalanceService $balance) {}

    public function index(Request $request): View
    {
        return view('admin.deposits.index', [
            'requests' => DepositRequest::query()
                ->when($request->filled('status'), fn ($q) => $q->where('status', (string) $request->query('status')))
                ->latest('id')
                ->paginate(30)
                ->withQueryString(),

            'cards' => Card::query()
                ->when($request->filled('card_status'), fn ($q) => $q->where('status', (string) $request->query('card_status')))
                ->latest('id')
                ->paginate(30, ['*'], 'card_page')
                ->withQueryString(),
        ]);
    }

    /** Duyệt yêu cầu nạp chuyển khoản và cộng tiền */
    public function approve(Request $request, DepositRequest $deposit): RedirectResponse
    {
        $data = $request->validate([
            'amount' => ['required', 'integer', 'min:1000', 'max:500000000'],
        ], [
            'amount.min' => 'Số tiền duyệt tối thiểu 1.000đ.',
        ]);

        try {
            DB::transaction(function () use ($deposit, $data, $request): void {
                /* Khoá đơn rồi ĐỌC LẠI trạng thái — chống duyệt 2 lần */
                $fresh = DepositRequest::query()
                    ->whereKey($deposit->id)
                    ->lockForUpdate()
                    ->first();

                if ($fresh === null || $fresh->status !== '0') {
                    throw new \RuntimeException('Đơn này đã được xử lý.');
                }

                $user = User::query()->whereKey($fresh->userid)->first();

                if ($user === null) {
                    throw new \RuntimeException('Không tìm thấy người dùng của đơn này.');
                }

                /* Cộng tiền qua service: có lock user + ghi log dòng tiền */
                $this->balance->credit(
                    $user,
                    (int) $data['amount'],
                    'Nạp tiền chuyển khoản (duyệt tay #'.$fresh->id.')',
                );

                $fresh->update(['status' => '1']);

                Log::query()->create([
                    'user_id'     => $request->user()->id,
                    'ip'          => $request->ip(),
                    'device'      => $request->userAgent(),
                    'action'      => "Duyệt nạp #{$fresh->id} cho user #{$user->id}: +{$data['amount']}",
                    'create_date' => now(),
                ]);
            });
        } catch (Throwable $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Đã duyệt và cộng tiền.');
    }

    public function reject(DepositRequest $deposit): RedirectResponse
    {
        if ($deposit->status !== '0') {
            return back()->with('error', 'Đơn này đã được xử lý.');
        }

        $deposit->update(['status' => '2']);

        return back()->with('success', 'Đã từ chối đơn nạp.');
    }

    /** Duyệt thẻ cào — thực nhận do admin nhập (sau khi đối chiếu) */
    public function approveCard(Request $request, Card $card): RedirectResponse
    {
        $data = $request->validate([
            'thucnhan' => ['required', 'integer', 'min:0', 'max:500000000'],
            'note'     => ['nullable', 'string', 'max:255'],
        ]);

        try {
            DB::transaction(function () use ($card, $data, $request): void {
                $fresh = Card::query()->whereKey($card->id)->lockForUpdate()->first();

                if ($fresh === null || $fresh->status !== 'pending') {
                    throw new \RuntimeException('Thẻ này đã được xử lý.');
                }

                $user = User::query()->where('email', $fresh->username)->first();

                if ($user === null) {
                    throw new \RuntimeException('Không tìm thấy người dùng của thẻ này.');
                }

                $amount = (int) $data['thucnhan'];

                if ($amount > 0) {
                    $this->balance->credit($user, $amount, "Nạp thẻ {$fresh->loaithe} (#{$fresh->id})");
                }

                $fresh->update([
                    'thucnhan' => $amount,
                    'status'   => $amount > 0 ? 'success' : 'failed',
                    'note'     => $data['note'] ?? null,
                ]);

                Log::query()->create([
                    'user_id'     => $request->user()->id,
                    'ip'          => $request->ip(),
                    'device'      => $request->userAgent(),
                    'action'      => "Duyệt thẻ #{$fresh->id}: +{$amount}",
                    'create_date' => now(),
                ]);
            });
        } catch (Throwable $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Đã xử lý thẻ.');
    }
}

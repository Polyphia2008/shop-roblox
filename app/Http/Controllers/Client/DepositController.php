<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Card;
use App\Models\DepositRequest;
use App\Models\MoneyFlow;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * ==================================================================
 *  NẠP TIỀN (chuyển khoản bank + thẻ cào)
 * ==================================================================
 *  BẢN GỐC (views/client/deposit.php + ajaxs/client/updatebank.php):
 *
 *      foreach ($VCD->get_list("SELECT * FROM `bank`") as $bank_auto)
 *      // và
 *      INSERT INTO cards (seri, pin) VALUES ('$seri', '$pin')
 *
 *  Vấn đề:
 *   1. seri/pin nối chuỗi -> inject được.
 *   2. Mã thẻ lưu PLAINTEXT trong DB -> ai đọc được DB là dùng được thẻ.
 *      Nay model Card cast 'seri'/'pin' sang 'encrypted'.
 *   3. Không chống nạp trùng -> nay unique theo seri đang chờ xử lý.
 * ==================================================================
 */
class DepositController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('client.deposit', [
            'banks' => Bank::query()->orderBy('id')->get(),

            /* Nội dung chuyển khoản gắn với user, tránh nhầm lẫn đối soát */
            'transferCode' => 'NAP'.$user->id,

            'cards' => Card::query()
                ->where('username', $user->email)   // binding
                ->latest('id')
                ->limit(20)
                ->get(),

            'requests' => DepositRequest::query()
                ->where('userid', $user->id)
                ->latest('id')
                ->limit(20)
                ->get(),
        ]);
    }

    /** Gửi yêu cầu đối soát chuyển khoản thủ công */
    public function bankTransfer(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'amount'  => ['required', 'integer', 'min:10000', 'max:500000000'],
            'note'    => ['nullable', 'string', 'max:255'],
        ], [
            'amount.min' => 'Số tiền nạp tối thiểu 10.000đ.',
            'amount.max' => 'Số tiền nạp quá lớn, vui lòng liên hệ hỗ trợ.',
        ]);

        DepositRequest::query()->create([
            'userid'  => $request->user()->id,
            'noidung' => sprintf(
                'Chuyển khoản %sđ. %s',
                number_format((int) $data['amount'], 0, ',', '.'),
                $data['note'] ?? '',
            ),
            'status'  => '0',   // chờ admin duyệt — KHÔNG tự cộng tiền
        ]);

        return back()->with('success', 'Đã gửi yêu cầu. Vui lòng chờ admin đối soát.');
    }

    /** Nạp thẻ cào */
    public function card(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'loaithe' => ['required', 'string', 'in:VIETTEL,MOBIFONE,VINAPHONE,GARENA,ZING'],
            'menhgia' => ['required', 'integer', 'in:10000,20000,50000,100000,200000,500000'],
            'seri'    => ['required', 'string', 'max:32', 'regex:/^[A-Za-z0-9]+$/'],
            'pin'     => ['required', 'string', 'max:32', 'regex:/^[A-Za-z0-9]+$/'],
        ], [
            'loaithe.in'   => 'Loại thẻ không được hỗ trợ.',
            'menhgia.in'   => 'Mệnh giá không hợp lệ.',
            'seri.regex'   => 'Serial chỉ gồm chữ và số.',
            'pin.regex'    => 'Mã thẻ chỉ gồm chữ và số.',
        ]);

        $user = $request->user();

        /* Chống gửi trùng: cùng user + cùng serial còn đang chờ */
        $duplicate = Card::query()
            ->where('username', $user->email)
            ->where('status', 'pending')
            ->get()
            ->contains(fn (Card $c) => $c->seri === $data['seri']);

        if ($duplicate) {
            return back()->with('error', 'Thẻ này đang được xử lý.');
        }

        Card::query()->create([
            'code'     => 'CARD'.now()->format('YmdHis').random_int(100, 999),
            'username' => $user->email,
            'loaithe'  => $data['loaithe'],
            'menhgia'  => (int) $data['menhgia'],
            'thucnhan' => 0,      // admin/API xác định sau khi duyệt
            'seri'     => $data['seri'],   // cast 'encrypted'
            'pin'      => $data['pin'],    // cast 'encrypted'
            'status'   => 'pending',
        ]);

        return back()->with('success', 'Đã gửi thẻ, hệ thống đang xử lý.');
    }

    /** Lịch sử biến động số dư */
    public function transaction(Request $request): View
    {
        return view('client.transaction', [
            'flows' => MoneyFlow::query()
                ->where('username', $request->user()->email)   // binding
                ->latest('id')
                ->paginate(30),
        ]);
    }
}

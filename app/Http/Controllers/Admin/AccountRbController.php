<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountOrder;
use App\Models\AccountRb;
use App\Security\SqlInjectionGuard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * ==================================================================
 *  QUẢN LÝ NICK ROBUX (accountrb) + ĐƠN ORDER (accountorder)
 * ==================================================================
 *  BẢN GỐC (ajaxs/admin/add_nick_robux.php, edit_nick_robux.php,
 *  remove_robux.php, robuxorder.php) nối chuỗi mọi trường:
 *
 *      INSERT INTO accountrb (username, price, information)
 *      VALUES ('$username', '$price', '$information')
 *
 *  Trường `information` chứa cả cookie/mật khẩu nick nhưng lưu plaintext.
 *  Nay model AccountRb cast 'information' sang 'encrypted' nên dữ liệu
 *  đăng nhập được mã hoá ở tầng ứng dụng: kẻ đọc được DB cũng không
 *  dùng được nick.
 * ==================================================================
 */
class AccountRbController extends Controller
{
    private const SORTABLE = ['id', 'price', 'robux', 'rate', 'created_at'];

    public function index(Request $request): View
    {
        /* Cột/chiều sắp xếp không bind được bằng PDO -> bắt buộc allow-list */
        $column    = SqlInjectionGuard::column($request->query('sort'), self::SORTABLE, 'id');
        $direction = SqlInjectionGuard::direction($request->query('dir'), 'desc');

        $accounts = AccountRb::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status', (string) $request->query('status')))
            ->when($request->filled('keyword'), function ($q) use ($request) {
                $safe = addcslashes($request->string('keyword')->trim()->value(), '%_\\');
                $q->where('username', 'like', "%{$safe}%");
            })
            ->orderBy($column, $direction)
            ->paginate(30)
            ->withQueryString();

        return view('admin.accountrb.index', compact('accounts', 'column', 'direction'));
    }

    public function create(): View
    {
        return view('admin.accountrb.create');
    }

    /** Thêm nick — hỗ trợ nhập nhiều dòng, mỗi dòng một nick */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'rate'        => ['required', 'integer', 'min:0', 'max:100000'],
            'robux'       => ['required', 'integer', 'min:0', 'max:100000000'],
            'price'       => ['required', 'integer', 'min:0', 'max:1000000000'],
            'guarantee'   => ['nullable', 'string', 'max:64'],
            'premium'     => ['required', 'in:0,1'],
            'datejoin'    => ['nullable', 'string', 'max:64'],
            'information' => ['required', 'string', 'max:50000'],
        ]);

        $lines = collect(preg_split('/\r\n|\r|\n/', $data['information']))
            ->map(fn ($l) => trim((string) $l))
            ->filter()
            ->values();

        if ($lines->isEmpty()) {
            return back()->with('error', 'Chưa có dữ liệu tài khoản.')->withInput();
        }

        /* Transaction: hoặc thêm hết, hoặc không thêm gì — tránh nửa vời */
        DB::transaction(function () use ($lines, $data, $request): void {
            foreach ($lines as $line) {
                AccountRb::query()->create([
                    'seller'      => $request->user()->email,
                    'status'      => AccountRb::STATUS_ON_SALE,
                    'rate'        => (int) $data['rate'],
                    'robux'       => (int) $data['robux'],
                    'price'       => (int) $data['price'],
                    'guarantee'   => $data['guarantee'] ?? null,
                    'premium'     => (string) $data['premium'],
                    'datejoin'    => $data['datejoin'] ?? null,
                    'information' => $line,      // cast 'encrypted'
                    'time'        => now(),
                ]);
            }
        });

        return redirect()
            ->route('admin.accountrb.index')
            ->with('success', "Đã thêm {$lines->count()} tài khoản.");
    }

    public function edit(AccountRb $account): View
    {
        return view('admin.accountrb.edit', compact('account'));
    }

    public function update(Request $request, AccountRb $account): RedirectResponse
    {
        $data = $request->validate([
            'rate'        => ['required', 'integer', 'min:0', 'max:100000'],
            'robux'       => ['required', 'integer', 'min:0', 'max:100000000'],
            'price'       => ['required', 'integer', 'min:0', 'max:1000000000'],
            'guarantee'   => ['nullable', 'string', 'max:64'],
            'premium'     => ['required', 'in:0,1'],
            'status'      => ['required', 'in:1,2,3'],
            'information' => ['required', 'string', 'max:5000'],
        ]);

        $account->update($data);

        return back()->with('success', 'Cập nhật tài khoản thành công.');
    }

    public function destroy(AccountRb $account): RedirectResponse
    {
        /* Giữ lại nick đã bán để còn bảo hành và đối soát doanh thu */
        if ($account->status !== AccountRb::STATUS_ON_SALE) {
            return back()->with('error', 'Không thể xoá tài khoản đã bán.');
        }

        $account->delete();

        return back()->with('success', 'Đã xoá tài khoản.');
    }

    /** Danh sách đơn order robux (bảng accountorder) */
    public function orders(Request $request): View
    {
        $column    = SqlInjectionGuard::column($request->query('sort'), self::SORTABLE, 'id');
        $direction = SqlInjectionGuard::direction($request->query('dir'), 'desc');

        return view('admin.accountrb.orders', [
            'orders' => AccountOrder::query()
                ->when($request->filled('status'), fn ($q) => $q->where('status', (string) $request->query('status')))
                ->orderBy($column, $direction)
                ->paginate(30)
                ->withQueryString(),
            'column'    => $column,
            'direction' => $direction,
        ]);
    }

    public function editOrder(AccountOrder $order): View
    {
        return view('admin.accountrb.edit-order', compact('order'));
    }

    public function updateOrder(Request $request, AccountOrder $order): RedirectResponse
    {
        $data = $request->validate([
            'status'      => ['required', 'in:1,2,3'],
            'information' => ['nullable', 'string', 'max:5000'],
            'price'       => ['required', 'integer', 'min:0', 'max:1000000000'],
            'robux'       => ['required', 'integer', 'min:0', 'max:100000000'],
            'guarantee'   => ['nullable', 'string', 'max:64'],
        ]);

        $order->update($data);

        return back()->with('success', 'Cập nhật đơn thành công.');
    }
}

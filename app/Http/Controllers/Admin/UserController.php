<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;
use App\Security\SqlInjectionGuard;
use App\Services\BalanceService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

/**
 * ==================================================================
 *  QUẢN LÝ NGƯỜI DÙNG
 * ==================================================================
 *  BẢN GỐC (views/admin/ListUsers.php, user-edit.php, ajaxs/admin/removeUser.php):
 *
 *      $kw = $_GET['keyword'];
 *      SELECT * FROM users WHERE email LIKE '%$kw%' ORDER BY $sort
 *      DELETE FROM users WHERE id = '" . $_POST['id'] . "'
 *      UPDATE users SET money = '" . $_POST['money'] . "' WHERE ...
 *
 *  Ba vấn đề:
 *   1. keyword + sort + id nối chuỗi -> inject toàn diện.
 *   2. Sửa money trực tiếp, không ghi log -> không thể đối soát/audit.
 *      Nay đi qua BalanceService để mọi thay đổi đều có bản ghi.
 *   3. Admin có thể tự xoá/ban chính mình -> khoá mất hệ thống.
 * ==================================================================
 */
class UserController extends Controller
{
    private const SORTABLE = ['id', 'email', 'money', 'total_money', 'created_at', 'time_session'];

    public function __construct(private readonly BalanceService $balance) {}

    public function index(Request $request): View
    {
        /* Sắp xếp qua allow-list — cột/chiều không thể bind bằng PDO */
        $column    = SqlInjectionGuard::column($request->query('sort'), self::SORTABLE, 'id');
        $direction = SqlInjectionGuard::direction($request->query('dir'), 'desc');

        $keyword = $request->string('keyword')->trim()->value();

        $users = User::query()
            ->when($keyword !== '', function ($q) use ($keyword) {
                /* Escape wildcard để keyword "%" không quét toàn bảng */
                $safe = addcslashes($keyword, '%_\\');
                $q->where(function ($sub) use ($safe) {
                    $sub->where('email', 'like', "%{$safe}%")
                        ->orWhere('username', 'like', "%{$safe}%")
                        ->orWhere('telegram', 'like', "%{$safe}%");
                });
            })
            /* Lọc theo trạng thái khoá: giá trị từ URL được ép về bool,
               không đưa thẳng vào truy vấn. */
            ->when($request->query('banned') !== null, fn ($q) => $q->where('banned', $request->query('banned') === '1'))
            ->orderBy($column, $direction)
            ->paginate(30)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'keyword', 'column', 'direction'));
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
            'logs' => Log::query()->where('user_id', $user->id)->latest('id')->limit(20)->get(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'username'  => ['nullable', 'string', 'max:100'],
            'telegram'  => ['nullable', 'string', 'max:32', 'regex:/^[0-9]*$/'],
            'level'     => ['required', 'integer', 'in:0,1'],
            'banned'    => ['required', 'boolean'],
            'adjust'    => ['nullable', 'integer', 'min:-1000000000', 'max:1000000000'],
            'reason'    => ['nullable', 'string', 'max:255'],
            'password'  => ['nullable', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        /* Không cho admin tự hạ quyền / tự ban -> tránh khoá chết hệ thống */
        if ($user->is($request->user())) {
            if ((int) $data['level'] !== 1 || (bool) $data['banned']) {
                return back()->with('error', 'Bạn không thể tự hạ quyền hoặc tự khoá tài khoản của mình.');
            }
        }

        $user->fill([
            'username' => $data['username'] ?? $user->username,
            'telegram' => $data['telegram'] ?? $user->telegram,
        ]);

        /* level/banned nằm NGOÀI $fillable -> phải forceFill có chủ đích.
           Đây là cách cố tình bắt admin viết rõ ràng, tránh mass assignment. */
        $user->forceFill([
            'level'  => (int) $data['level'],
            'banned' => (bool) $data['banned'],
        ]);

        if (! empty($data['password'])) {
            $user->password = $data['password'];   // cast 'hashed' -> bcrypt
        }

        $user->save();

        /* Điều chỉnh số dư PHẢI đi qua service để có log + transaction */
        $adjust = (int) ($data['adjust'] ?? 0);

        if ($adjust !== 0) {
            $reason = 'Admin điều chỉnh: '.($data['reason'] ?? 'không ghi lý do');

            $adjust > 0
                ? $this->balance->credit($user, $adjust, $reason, false)
                : $this->balance->refund($user, abs($adjust), $reason);
        }

        Log::query()->create([
            'user_id'     => $request->user()->id,
            'ip'          => $request->ip(),
            'device'      => $request->userAgent(),
            'action'      => "Admin sửa user #{$user->id}".($adjust !== 0 ? " (số dư {$adjust})" : ''),
            'create_date' => now(),
        ]);

        return back()->with('success', 'Cập nhật người dùng thành công.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->with('error', 'Không thể xoá chính mình.');
        }

        if ($user->money > 0) {
            return back()->with('error', 'Người dùng còn số dư, vui lòng xử lý trước khi xoá.');
        }

        $id = $user->id;
        $user->delete();

        Log::query()->create([
            'user_id'     => $request->user()->id,
            'ip'          => $request->ip(),
            'device'      => $request->userAgent(),
            'action'      => "Admin xoá user #{$id}",
            'create_date' => now(),
        ]);

        return back()->with('success', 'Đã xoá người dùng.');
    }
}

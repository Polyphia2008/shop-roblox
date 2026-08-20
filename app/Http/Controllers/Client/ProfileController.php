<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

/**
 * ==================================================================
 *  TRANG CÁ NHÂN + ĐỔI MẬT KHẨU
 * ==================================================================
 *  BẢN GỐC (ajaxs/client/changePassword.php) có 3 lỗi nặng:
 *
 *   1. SQL injection:
 *          UPDATE users SET password = '" . sha1($_POST['new']) . "'
 *          WHERE token = '" . xss($_POST['token']) . "'
 *
 *   2. Hash yếu: sha1() KHÔNG salt, KHÔNG chậm -> bảng rainbow phá được
 *      ngay. Nay dùng bcrypt (cast 'hashed' trong model User).
 *
 *   3. Không hỏi mật khẩu hiện tại -> ai chiếm được session/token là đổi
 *      được mật khẩu. Nay bắt buộc 'current_password'.
 * ==================================================================
 */
class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        $user = $request->user();

        return view('client.profile', [
            'user'   => $user,
            'logins' => Log::query()
                ->where('user_id', $user->id)      // binding
                ->latest('id')
                ->limit(10)
                ->get(),
        ]);
    }

    /** Cập nhật thông tin liên hệ (KHÔNG cho sửa money/level/banned) */
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['nullable', 'string', 'max:100'],
            'telegram' => ['nullable', 'string', 'max:32', 'regex:/^[0-9]+$/'],
        ], [
            'telegram.regex' => 'Telegram ID chỉ gồm chữ số.',
        ]);

        /* Chỉ gán đúng 2 trường — mass assignment không thể chạm tới
           money / level / banned vì chúng không nằm trong $fillable. */
        $request->user()->update($data);

        return back()->with('success', 'Cập nhật thông tin thành công.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => [
                'required',
                'confirmed',
                Password::min((int) config('security.password.min_length', 8))
                    ->mixedCase()
                    ->numbers(),
            ],
        ], [
            'current_password.current_password' => 'Mật khẩu hiện tại không đúng.',
            'password.confirmed'                => 'Mật khẩu nhập lại không khớp.',
        ]);

        $user = $request->user();

        /* Cast 'hashed' trong model tự bcrypt giá trị này */
        $user->update(['password' => $data['password']]);

        /* Đổi mật khẩu -> đổi luôn token API cũ để phiên khác mất hiệu lực */
        $user->forceFill(['token' => \Illuminate\Support\Str::random(60)])->save();

        Log::query()->create([
            'user_id'     => $user->id,
            'ip'          => $request->ip(),
            'device'      => $request->userAgent(),
            'action'      => 'Đổi mật khẩu',
            'create_date' => now(),
        ]);

        /* Vô hiệu hoá các session khác đang mở */
        Auth::logoutOtherDevices($data['password']);
        $request->session()->regenerate();

        return back()->with('success', 'Đổi mật khẩu thành công.');
    }
}

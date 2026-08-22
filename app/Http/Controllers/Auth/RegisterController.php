<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function show(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();

        /* CHÚ Ý BẢO MẬT: chỉ truyền đúng các field cho phép.
           `level`, `money`, `banned` KHÔNG nằm trong $fillable của model
           nên dù kẻ tấn công gửi thêm level=1 vào form cũng bị bỏ qua. */
        $user = User::query()->create([
            'username' => $data['username'],
            'email'    => $data['email'],
            /* Mật khẩu tự hash bằng bcrypt qua cast 'hashed' */
            'password' => $data['password'],
            'telegram' => $data['telegram'] ?? null,
            'token'    => Str::random(60),
            'ip'       => $request->ip(),
            'device'   => substr((string) $request->userAgent(), 0, 500),
        ]);

        Log::query()->create([
            'user_id'     => $user->id,
            'ip'          => $request->ip(),
            'device'      => substr((string) $request->userAgent(), 0, 500),
            'action'      => 'Đăng ký tài khoản mới',
            'create_date' => now(),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('success', 'Đăng ký thành công. Chào mừng bạn!');
    }
}

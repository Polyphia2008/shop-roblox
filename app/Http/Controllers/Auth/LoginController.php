<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function show(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        /* Toàn bộ kiểm tra + rate limit nằm trong LoginRequest */
        $request->authenticate();

        /* Chống Session Fixation: sinh session ID mới sau khi đăng nhập.
           Bản gốc gán thẳng $_SESSION['login'] = token -> kẻ tấn công có
           thể ấn định session ID trước rồi chiếm phiên sau khi nạn nhân
           đăng nhập. */
        $request->session()->regenerate();

        $user = $request->user();

        /* Ghi audit log */
        Log::query()->create([
            'user_id'     => $user->id,
            'ip'          => $request->ip(),
            'device'      => substr((string) $request->userAgent(), 0, 500),
            'action'      => 'Đăng nhập thành công',
            'create_date' => now(),
        ]);

        $user->forceFill([
            'ip'           => $request->ip(),
            'time_session' => time(),
            'device'       => substr((string) $request->userAgent(), 0, 500),
        ])->save();

        return redirect()->intended(route('home'))
            ->with('success', 'Đăng nhập thành công.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        /* Vô hiệu hoá session cũ + sinh CSRF token mới */
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Bạn đã đăng xuất.');
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Xác thực đăng nhập.
 *
 * NÂNG CẤP BẢO MẬT so với legacy/ajaxs/client/login.php:
 *  1. Bản gốc nối chuỗi email vào SQL:
 *       WHERE email = '$email' AND password='".sha1($password)."'
 *     -> chỉ cần nhập  ' OR 1=1 --  là đăng nhập được vào tài khoản
 *     đầu tiên (thường là admin). Nay dùng Auth::attempt() -> prepared
 *     statement, tham số được bind, không thể chèn SQL.
 *  2. Mật khẩu: sha1 KHÔNG muối -> tra bảng rainbow ra ngay.
 *     Nay bcrypt (cast 'hashed') + so sánh hash_equals chống timing attack.
 *  3. Chống brute-force bằng RateLimiter (bản gốc dùng cột time_request
 *     với điều kiện so sánh bị sai logic nên không chặn được gì).
 */
class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email'    => ['required', 'string', 'email:rfc', 'max:190'],
            'password' => ['required', 'string', 'max:255'],
            'remember' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'Vui lòng nhập Email.',
            'email.email'       => 'Định dạng Email không đúng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ];
    }

    /** Thực hiện đăng nhập, ném ValidationException nếu thất bại. */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            /* Đếm số lần thất bại cho cặp (email + IP) */
            RateLimiter::hit($this->throttleKey(), 60);

            throw ValidationException::withMessages([
                /* Thông báo chung, KHÔNG nói "email không tồn tại" —
                   tránh để kẻ tấn công dò xem email nào có trong hệ thống */
                'email' => 'Email hoặc mật khẩu không chính xác.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /** Chặn khi vượt số lần thử cho phép. */
    public function ensureIsNotRateLimited(): void
    {
        [$maxAttempts, $decayMinutes] = $this->limitConfig();

        if (! RateLimiter::tooManyAttempts($this->throttleKey(), $maxAttempts)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => sprintf(
                'Bạn đã thử quá nhiều lần. Vui lòng đợi %d giây rồi thử lại.',
                $seconds,
            ),
        ]);
    }

    /** Khoá theo email + IP để không cho phép khoá chéo người khác. */
    public function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower((string) $this->input('email')).'|'.$this->ip(),
        );
    }

    /** @return array{int, int} [số lần, số phút] */
    private function limitConfig(): array
    {
        $raw = (string) config('security.rate_limit.login', '5,1');
        [$attempts, $minutes] = array_pad(explode(',', $raw), 2, '1');

        return [max(1, (int) $attempts), max(1, (int) $minutes)];
    }
}

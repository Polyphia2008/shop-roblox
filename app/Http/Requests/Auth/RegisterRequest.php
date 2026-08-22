<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * Xác thực đăng ký.
 *
 * NÂNG CẤP so với legacy/ajaxs/client/register.php:
 *  1. Bản gốc kiểm tra email trùng bằng cách nối chuỗi vào SQL.
 *     Nay dùng rule `unique:users,email` -> truy vấn có bind tham số.
 *  2. Bản gốc chấp nhận mật khẩu bất kỳ (kể cả "1").
 *     Nay bắt buộc tối thiểu 8 ký tự, có chữ hoa/thường/số/ký tự đặc biệt.
 *  3. Thêm `confirmed` -> buộc nhập lại mật khẩu, tránh gõ sai.
 */
class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:3', 'max:100', 'regex:/^[\p{L}\p{N}_.\s-]+$/u'],
            'email'    => ['required', 'string', 'email:rfc', 'max:190', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', $this->passwordRule()],
            'telegram' => ['nullable', 'string', 'max:100', 'regex:/^[0-9]{5,20}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.required'  => 'Vui lòng nhập tên hiển thị.',
            'username.regex'     => 'Tên hiển thị chỉ được chứa chữ, số, dấu cách, gạch dưới.',
            'email.required'     => 'Vui lòng nhập Email.',
            'email.email'        => 'Định dạng Email không đúng.',
            'email.unique'       => 'Email này đã được sử dụng.',
            'password.required'  => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp.',
            'telegram.regex'     => 'Telegram ID phải là dãy số (5–20 chữ số).',
        ];
    }

    private function passwordRule(): Password
    {
        $rule = Password::min((int) config('security.password.min_length', 8));

        if (config('security.password.require_mixed', true)) {
            $rule->mixedCase()->numbers()->symbols();
        }

        /* Đối chiếu danh sách mật khẩu đã bị rò rỉ (HaveIBeenPwned) */
        if (config('security.password.uncompromised', false)) {
            $rule->uncompromised();
        }

        return $rule;
    }
}

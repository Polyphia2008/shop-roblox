<?php

declare(strict_types=1);

/**
 * Cấu hình bảo mật — điều chỉnh qua .env, không cần sửa code.
 */
return [

    /*
    |--------------------------------------------------------------------------
    | Phát hiện SQL Injection
    |--------------------------------------------------------------------------
    | LƯU Ý: đây là lớp phòng thủ THỨ HAI. Lớp thứ nhất là prepared statement
    | của Eloquent — luôn bật, không thể tắt. Tắt mục này chỉ làm mất khả năng
    | ghi log/chặn sớm, KHÔNG khiến ứng dụng bị SQL Injection.
    */
    'sqli' => [
        'enabled' => env('SECURITY_SQLI_ENABLED', true),

        /* true = trả 403 và chặn; false = chỉ ghi log rồi cho đi tiếp */
        'block' => env('SECURITY_SQLI_BLOCK', true),

        /* Các route miễn quét (nội dung admin có thể chứa từ khoá SQL) */
        'except' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Content Security Policy
    |--------------------------------------------------------------------------
    */
    'csp' => [
        'enabled' => env('SECURITY_CSP_ENABLED', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Giới hạn tần suất (chống brute-force & spam)
    |--------------------------------------------------------------------------
    | Bản gốc dùng cột `time_request` trong DB với logic so sánh bị sai
    | (điều kiện luôn đúng/luôn sai) -> không chặn được gì.
    | Nay dùng RateLimiter chuẩn của Laravel.
    */
    'rate_limit' => [
        /* Đăng nhập: 5 lần / phút / (email + IP) */
        'login'    => env('SECURITY_RL_LOGIN', '5,1'),
        /* Đăng ký: 3 lần / 10 phút / IP */
        'register' => env('SECURITY_RL_REGISTER', '3,10'),
        /* Mua hàng: 10 lần / phút / user — chống double-spend spam */
        'purchase' => env('SECURITY_RL_PURCHASE', '10,1'),
        /* API chung: 60 lần / phút */
        'api'      => env('SECURITY_RL_API', '60,1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Kênh ghi log bảo mật
    |--------------------------------------------------------------------------
    */
    'log_channel' => env('SECURITY_LOG_CHANNEL', 'security'),

    /*
    |--------------------------------------------------------------------------
    | Mật khẩu
    |--------------------------------------------------------------------------
    */
    'password' => [
        'min_length'    => 8,
        /* Bắt buộc chữ hoa + chữ thường + số + ký tự đặc biệt */
        'require_mixed' => env('SECURITY_PWD_MIXED', true),
        /* Kiểm tra mật khẩu có trong danh sách bị rò rỉ (HaveIBeenPwned) */
        'uncompromised' => env('SECURITY_PWD_UNCOMPROMISED', false),
    ],
];

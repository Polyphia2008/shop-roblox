<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Người dùng.
 *
 * Bảo mật:
 *  - $fillable (allow-list) chống Mass Assignment: kẻ tấn công không thể
 *    gửi thêm field `level=1` hay `money=999999` vào form đăng ký.
 *  - `password` được hash tự động bằng cast 'hashed' (bcrypt),
 *    thay cho sha1() không muối của bản gốc.
 *  - `password`, `token`, `otp` bị ẩn khỏi mọi JSON output.
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * CHÚ Ý: `level`, `money`, `total_money`, `banned` KHÔNG nằm trong
     * $fillable. Chúng chỉ được thay đổi qua service tầng admin /
     * BalanceService bằng phương thức tường minh -> chống leo thang đặc quyền.
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'token',
        'ip',
        'device',
        'telegram',
        'bank',
        'time_request',
        'time_session',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'token',
        'otp',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'level'             => 'integer',
            'money'             => 'integer',
            'total_money'       => 'integer',
            'ck_user'           => 'integer',
            'banned'            => 'boolean',
            'time_request'      => 'integer',
            'time_session'      => 'integer',
        ];
    }

    /* ============================ Quan hệ ============================ */

    public function logs(): HasMany
    {
        return $this->hasMany(Log::class, 'user_id');
    }

    public function balanceLogs(): HasMany
    {
        return $this->hasMany(LogBalance::class, 'user_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'username', 'email');
    }

    /* ============================ Helper ============================ */

    public function isAdmin(): bool
    {
        return $this->level === 1;
    }

    public function isBanned(): bool
    {
        return $this->banned === true;
    }

    /** Người dùng đang online nếu hoạt động trong 5 phút gần nhất. */
    public function isOnline(): bool
    {
        return (time() - (int) $this->time_session) < 300;
    }
}

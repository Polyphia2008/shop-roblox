<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Ngân hàng nhận tiền (bảng `bank`). */
class Bank extends Model
{
    protected $table = 'bank';

    protected $fillable = ['short_name', 'accountNumber', 'accountName', 'logo', 'token'];

    /** Token API ngân hàng là dữ liệu cực kỳ nhạy cảm -> mã hoá at-rest. */
    protected function casts(): array
    {
        return ['token' => 'encrypted'];
    }

    protected $hidden = ['token'];
}

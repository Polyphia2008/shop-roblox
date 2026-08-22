<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Đơn đặt nick Robux theo yêu cầu (bảng `accountorder`). */
class AccountOrder extends Model
{
    protected $table = 'accountorder';

    protected $fillable = [
        'username', 'seller', 'status', 'rate', 'robux', 'price', 'guarantee',
        'premium', 'giaohang', 'information', 'magd', 'time',
    ];

    protected function casts(): array
    {
        return [
            'rate'        => 'integer',
            'robux'       => 'integer',
            'price'       => 'integer',
            'time'        => 'datetime',
            'information' => 'encrypted',
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Nick có Robux đang bán (bảng `accountrb`).
 *
 * status: 1 = đang bán, 2 = đã bán, 3 = đang bảo hành / khiếu nại.
 */
class AccountRb extends Model
{
    protected $table = 'accountrb';

    protected $fillable = [
        'username', 'seller', 'status', 'rate', 'robux', 'price', 'guarantee',
        'premium', 'datejoin', 'information', 'magd', 'time',
    ];

    /** `information` chứa user:pass của nick -> mã hoá at-rest trong DB. */
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

    public const STATUS_ON_SALE  = '1';
    public const STATUS_SOLD     = '2';
    public const STATUS_WARRANTY = '3';

    public function scopeOnSale($query)
    {
        return $query->where('status', self::STATUS_ON_SALE);
    }
}

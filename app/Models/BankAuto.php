<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Giao dịch ngân hàng tự động (bảng `bank_auto`).
 *
 * `tid` là UNIQUE -> chống cộng tiền 2 lần cho cùng 1 giao dịch
 * (lỗi double-credit của bản gốc).
 */
class BankAuto extends Model
{
    protected $table = 'bank_auto';

    protected $fillable = [
        'tid', 'bank', 'description', 'amount', 'received', 'create_gettime', 'user_id',
    ];

    protected function casts(): array
    {
        return [
            'amount'         => 'integer',
            'create_gettime' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

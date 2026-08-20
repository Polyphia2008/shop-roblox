<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Đơn nạp tiền (bảng `don_nap`). */
class DepositRequest extends Model
{
    protected $table = 'don_nap';

    protected $fillable = ['noidung', 'userid', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userid');
    }
}

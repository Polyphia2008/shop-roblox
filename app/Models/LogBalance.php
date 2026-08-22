<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Log biến động số dư (bảng `log_balance`). */
class LogBalance extends Model
{
    protected $table = 'log_balance';

    protected $fillable = [
        'money_before', 'money_change', 'money_after', 'content', 'user_id', 'time',
    ];

    protected function casts(): array
    {
        return [
            'money_before' => 'integer',
            'money_change' => 'integer',
            'money_after'  => 'integer',
            'time'         => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

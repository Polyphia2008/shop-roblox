<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Đơn hàng chung (bảng `orders`). */
class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'magd', 'title', 'soluong', 'money', 'username', 'live', 'type', 'display',
    ];

    protected function casts(): array
    {
        return [
            'soluong' => 'integer',
            'money'   => 'integer',
            'live'    => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'username', 'email');
    }

    public function scopeVisible($query)
    {
        return $query->where('display', 'show');
    }
}

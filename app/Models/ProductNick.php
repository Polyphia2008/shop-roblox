<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Nick thường thuộc 1 chuyên mục (bảng `product_nick`). */
class ProductNick extends Model
{
    protected $table = 'product_nick';

    protected $fillable = [
        'code', 'chuyenmuc', 'magd', 'username', 'note', 'status', 'seller', 'updated_time',
    ];

    protected function casts(): array
    {
        return ['updated_time' => 'datetime'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'chuyenmuc', 'code');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'live');
    }
}

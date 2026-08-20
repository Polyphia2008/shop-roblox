<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Chuyên mục sản phẩm (bảng `chuyenmuc`). */
class Category extends Model
{
    protected $table = 'chuyenmuc';

    protected $fillable = ['code', 'title', 'price', 'buy', 'note', 'logo', 'status'];

    protected function casts(): array
    {
        return ['price' => 'integer', 'buy' => 'integer'];
    }

    public function nicks(): HasMany
    {
        return $this->hasMany(ProductNick::class, 'chuyenmuc', 'code');
    }

    /** Số nick còn hàng của chuyên mục này. */
    public function availableCount(): int
    {
        return $this->nicks()->where('status', 'live')->count();
    }

    public function scopeVisible($query)
    {
        return $query->where('status', 'show');
    }
}

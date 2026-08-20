<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Log hành động người dùng (bảng `logs`) - phục vụ audit trail. */
class Log extends Model
{
    protected $table = 'logs';

    protected $fillable = ['user_id', 'ip', 'device', 'action', 'create_date'];

    protected function casts(): array
    {
        return ['create_date' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

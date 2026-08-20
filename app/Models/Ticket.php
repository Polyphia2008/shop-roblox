<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Ticket khiếu nại / bảo hành (bảng `ticket`). */
class Ticket extends Model
{
    protected $table = 'ticket';

    protected $fillable = ['type', 'lydo', 'nickrb', 'dichvu', 'status', 'time'];

    protected function casts(): array
    {
        return ['time' => 'datetime'];
    }

    public const STATUS_PENDING  = '0';
    public const STATUS_APPROVED = '1';
    public const STATUS_REJECTED = '2';
}

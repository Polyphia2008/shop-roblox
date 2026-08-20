<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Log dòng tiền (bảng `dongtien`). */
class MoneyFlow extends Model
{
    protected $table = 'dongtien';

    protected $fillable = [
        'sotientruoc', 'sotienthaydoi', 'sotiensau', 'thoigian', 'noidung', 'username',
    ];

    protected function casts(): array
    {
        return [
            'sotientruoc'   => 'integer',
            'sotienthaydoi' => 'integer',
            'sotiensau'     => 'integer',
            'thoigian'      => 'datetime',
        ];
    }
}

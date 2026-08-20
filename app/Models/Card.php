<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Thẻ cào (bảng `cards`). */
class Card extends Model
{
    protected $table = 'cards';

    protected $fillable = [
        'code', 'username', 'loaithe', 'menhgia', 'thucnhan', 'seri', 'pin', 'status', 'note',
    ];

    /** Seri / pin thẻ là dữ liệu nhạy cảm -> mã hoá at-rest. */
    protected function casts(): array
    {
        return [
            'menhgia'  => 'integer',
            'thucnhan' => 'integer',
            'seri'     => 'encrypted',
            'pin'      => 'encrypted',
        ];
    }

    protected $hidden = ['seri', 'pin'];
}

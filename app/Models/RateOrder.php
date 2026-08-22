<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Đơn rate (bảng `rateorder`). */
class RateOrder extends Model
{
    protected $table = 'rateorder';

    protected $fillable = ['code', 'status'];
}

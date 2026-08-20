<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Mức rate (bảng `mucrate`). */
class RateLevel extends Model
{
    protected $table = 'mucrate';

    protected $fillable = ['code', 'status'];
}

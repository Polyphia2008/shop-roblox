<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Cấu hình website dạng key => value.
 *
 * Bản gốc truy vấn bảng `settings` hàng chục lần trên MỘT request
 * (mỗi lần gọi $VCD->site('x') là 1 query). Nay toàn bộ được cache 1 lần.
 */
class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = ['name', 'value'];

    public const CACHE_KEY = 'settings.all';

    /** Lấy 1 giá trị cấu hình (có cache). */
    public static function get(string $name, ?string $default = null): ?string
    {
        return static::all_cached()[$name] ?? $default;
    }

    /** Toàn bộ cấu hình dưới dạng mảng key => value. */
    public static function all_cached(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, static fn (): array =>
            static::query()->pluck('value', 'name')->all()
        );
    }

    /** Ghi 1 giá trị cấu hình và xoá cache. */
    public static function put(string $name, ?string $value): void
    {
        static::query()->updateOrCreate(['name' => $name], ['value' => $value]);
        static::flush();
    }

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    protected static function booted(): void
    {
        static::saved(static fn () => static::flush());
        static::deleted(static fn () => static::flush());
    }
}

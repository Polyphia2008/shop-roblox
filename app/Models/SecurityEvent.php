<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Sự kiện bảo mật (bảng `security_events`).
 *
 * Được ghi bởi SqlInjectionGuard / middleware khi phát hiện payload tấn công.
 */
class SecurityEvent extends Model
{
    protected $table = 'security_events';

    protected $fillable = [
        'type', 'severity', 'ip', 'user_id', 'method', 'url',
        'parameter', 'payload', 'rule', 'user_agent',
    ];

    public const TYPE_SQLI      = 'sql_injection';
    public const TYPE_XSS       = 'xss';
    public const TYPE_TRAVERSAL = 'path_traversal';
    public const TYPE_RATELIMIT = 'rate_limit';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

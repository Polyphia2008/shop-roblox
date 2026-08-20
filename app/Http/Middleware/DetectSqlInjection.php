<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Security\SqlInjectionGuard;
use App\Models\SecurityEvent;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware quét mọi dữ liệu đầu vào để phát hiện SQL Injection.
 *
 * Đây là LỚP PHÒNG THỦ THỨ HAI. Lớp thứ nhất (và quan trọng nhất) là
 * prepared statement của Eloquent/Query Builder — luôn luôn hoạt động
 * bất kể middleware này có bật hay không.
 *
 * Vai trò của middleware:
 *   - Ghi log kẻ tấn công (IP, payload, tham số) vào bảng security_events.
 *   - Chặn request bằng HTTP 403 nếu bật chế độ block.
 *
 * Cấu hình tại config/security.php (bật/tắt qua .env, không cần sửa code).
 */
class DetectSqlInjection
{
    /**
     * Các đường dẫn được miễn quét.
     * Ví dụ nội dung bài viết của admin có thể chứa từ khoá SQL hợp lệ.
     *
     * @var list<string>
     */
    private array $except = [
        'admin/settings',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (! config('security.sqli.enabled', true)) {
            return $next($request);
        }

        if ($this->shouldSkip($request)) {
            return $next($request);
        }

        /* Quét query string, body, route parameter và cookie */
        $payload = array_merge(
            $request->query(),
            $request->post(),
            $request->route() ? $request->route()->parameters() : [],
        );

        $violation = SqlInjectionGuard::scan($payload);

        if ($violation === null) {
            return $next($request);
        }

        $this->report($request, $violation);

        if (config('security.sqli.block', true)) {
            return $this->deny($request);
        }

        return $next($request);
    }

    /** Ghi nhận sự kiện vào DB + file log. */
    private function report(Request $request, array $violation): void
    {
        $context = [
            'type'       => SecurityEvent::TYPE_SQLI,
            'severity'   => 'critical',
            'ip'         => $request->ip(),
            'user_id'    => $request->user()?->id,
            'method'     => $request->method(),
            'url'        => SqlInjectionGuard::truncateForLog($request->fullUrl(), 2000),
            'parameter'  => SqlInjectionGuard::truncateForLog($violation['parameter'], 190),
            'payload'    => SqlInjectionGuard::truncateForLog($violation['value']),
            'rule'       => $violation['rule'],
            'user_agent' => SqlInjectionGuard::truncateForLog((string) $request->userAgent(), 500),
        ];

        /* Ghi file log trước (luôn thành công, kể cả khi DB lỗi) */
        Log::channel(config('security.log_channel', 'stack'))
            ->warning('SQL injection attempt blocked', $context);

        /* Ghi DB — bọc try/catch để lỗi ghi log không làm sập request */
        try {
            SecurityEvent::query()->create($context);
        } catch (\Throwable $e) {
            Log::error('Cannot persist security event: '.$e->getMessage());
        }
    }

    /** Trả về phản hồi từ chối, tôn trọng Accept header. */
    private function deny(Request $request): Response
    {
        $message = 'Yêu cầu của bạn chứa dữ liệu không hợp lệ và đã bị từ chối.';

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'error',
                'msg'    => $message,
            ], Response::HTTP_FORBIDDEN);
        }

        return response()->view('errors.403', ['message' => $message], Response::HTTP_FORBIDDEN);
    }

    private function shouldSkip(Request $request): bool
    {
        foreach (array_merge($this->except, (array) config('security.sqli.except', [])) as $pattern) {
            if ($request->is($pattern)) {
                return true;
            }
        }

        return false;
    }
}

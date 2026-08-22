<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Gắn các HTTP security header vào mọi phản hồi.
 *
 * Bản gốc không có bất kỳ header bảo mật nào -> dễ bị clickjacking,
 * MIME sniffing, rò rỉ Referer sang site khác.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $headers = [
            /* Chặn nhúng site vào iframe -> chống clickjacking */
            'X-Frame-Options' => 'SAMEORIGIN',

            /* Không cho trình duyệt tự đoán MIME type */
            'X-Content-Type-Options' => 'nosniff',

            /* Không gửi URL đầy đủ sang site khác */
            'Referrer-Policy' => 'strict-origin-when-cross-origin',

            /* Tắt các API không dùng tới */
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=(), payment=()',

            /* Chặn Adobe/PDF cross-domain policy */
            'X-Permitted-Cross-Domain-Policies' => 'none',
        ];

        /* HSTS chỉ gắn khi chạy HTTPS, tránh khoá site khi dev HTTP */
        if ($request->isSecure()) {
            $headers['Strict-Transport-Security'] = 'max-age=31536000; includeSubDomains';
        }

        if (($csp = $this->contentSecurityPolicy()) !== null) {
            $headers['Content-Security-Policy'] = $csp;
        }

        foreach ($headers as $key => $value) {
            /* Không ghi đè header đã được set ở nơi khác */
            if (! $response->headers->has($key)) {
                $response->headers->set($key, $value);
            }
        }

        /* Xoá header tiết lộ công nghệ phía sau */
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }

    /**
     * CSP — toàn bộ asset đều self-hosted (build bằng Vite) nên không cần
     * cho phép CDN bên ngoài. 'unsafe-inline' cho style là cần thiết vì
     * Alpine/Tailwind có sinh style inline.
     */
    private function contentSecurityPolicy(): ?string
    {
        if (! config('security.csp.enabled', true)) {
            return null;
        }

        return implode('; ', [
            "default-src 'self'",
            "script-src 'self'",
            "style-src 'self' 'unsafe-inline'",
            "img-src 'self' data: https:",
            "font-src 'self' data:",
            "connect-src 'self'",
            "frame-ancestors 'self'",
            "base-uri 'self'",
            "form-action 'self'",
            "object-src 'none'",
        ]);
    }
}

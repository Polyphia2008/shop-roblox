<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Chuẩn hoá header của reverse proxy về dạng chuẩn `X-Forwarded-*`.
 *
 * VÌ SAO CẦN:
 * `TrustProxies` của Laravel chỉ hiểu các header chuẩn (`X-Forwarded-Proto`).
 * Một số proxy/CDN lại gửi tên riêng — ví dụ môi trường sandbox gửi
 * `X-Client-Proto: https` và `X-Forwarded-Port: 80`. Khi đó Laravel tưởng
 * request là HTTP, nên `route()` / `redirect()` sinh ra URL `http://`.
 *
 * HẬU QUẢ THẬT (không chỉ là chuyện thẩm mỹ):
 *  1. Trình duyệt đang ở HTTPS bị chuyển sang `http://` → trang treo hoặc
 *     bị chặn vì mixed-content. Chính luồng "khách vào /admin → chuyển tới
 *     trang đăng nhập" bị đứng.
 *  2. Cookie phiên đánh dấu `Secure` sẽ KHÔNG được gửi kèm trên `http://`,
 *     làm mất session và người dùng không đăng nhập được.
 *  3. Nếu ai đó thật sự truy cập qua `http://`, dữ liệu đăng nhập đi ở dạng
 *     rõ — hạ cấp bảo mật.
 *
 * Middleware này chỉ *dịch tên header*, không tự phong cho request là HTTPS:
 * quyền tin hay không vẫn do `trustProxies()` quyết định.
 */
class NormalizeProxyHeaders
{
    /**
     * Các tên header không chuẩn hay gặp, ánh xạ sang tên chuẩn.
     *
     * @var array<string, string>
     */
    private const PROTO_ALIASES = [
        'X-Client-Proto',      // sandbox / một số gateway Tencent (STGW)
        'X-Forwarded-Scheme',  // một số cấu hình nginx
        'CF-Visitor',          // Cloudflare (dạng JSON: {"scheme":"https"})
    ];

    /**
     * Tên header chứa IP thật của client, theo thứ tự ưu tiên.
     *
     * @var list<string>
     */
    private const IP_ALIASES = [
        'CF-Connecting-IP',  // Cloudflare
        'True-Client-IP',    // Cloudflare Enterprise / Akamai
        'X-Real-IP',         // nginx, sandbox gateway
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->headers->has('X-Forwarded-Proto')) {
            if ($scheme = $this->detectScheme($request)) {
                $request->headers->set('X-Forwarded-Proto', $scheme);
            }
        }

        /*
         * Nếu proxy chỉ gửi IP thật qua header riêng (X-Real-IP...) mà không
         * gửi X-Forwarded-For, `$request->ip()` sẽ trả về IP NỘI BỘ của proxy.
         * Khi đó bảng `security_events` ghi lại IP của chính hạ tầng thay vì
         * IP kẻ tấn công -> log mất giá trị truy vết, và rate-limit theo IP
         * gộp mọi người dùng vào cùng một khoá (một kẻ spam làm cả hệ thống
         * bị khoá oan).
         */
        if (! $request->headers->has('X-Forwarded-For')) {
            if ($ip = $this->detectClientIp($request)) {
                $request->headers->set('X-Forwarded-For', $ip);
            }
        }

        /*
         * Proxy gửi `X-Forwarded-Port: 80` kèm HTTPS là thông tin tự mâu
         * thuẫn; giữ lại sẽ khiến URL sinh ra thành `https://host:80`.
         * Bỏ đi để Laravel dùng cổng mặc định của scheme.
         */
        if ($request->headers->get('X-Forwarded-Proto') === 'https'
            && $request->headers->get('X-Forwarded-Port') === '80') {
            $request->headers->remove('X-Forwarded-Port');
        }

        return $next($request);
    }

    /** Tìm scheme thật từ các header không chuẩn. */
    private function detectScheme(Request $request): ?string
    {
        foreach (self::PROTO_ALIASES as $header) {
            $value = $request->headers->get($header);

            if ($value === null || $value === '') {
                continue;
            }

            /* Cloudflare: CF-Visitor: {"scheme":"https"} */
            if ($header === 'CF-Visitor') {
                $decoded = json_decode($value, true);
                $value   = is_array($decoded) ? ($decoded['scheme'] ?? null) : null;

                if (! is_string($value)) {
                    continue;
                }
            }

            $value = strtolower(trim(explode(',', $value)[0]));

            if ($value === 'https' || $value === 'http') {
                return $value;
            }
        }

        return null;
    }

    /**
     * Tìm IP thật của client từ các header không chuẩn.
     *
     * Chỉ nhận giá trị là địa chỉ IP hợp lệ: header do client gửi lên có thể
     * bị giả mạo bằng chuỗi bất kỳ, mà giá trị này sẽ đi vào log và khoá
     * rate-limit, nên phải kiểm tra định dạng trước khi dùng.
     */
    private function detectClientIp(Request $request): ?string
    {
        foreach (self::IP_ALIASES as $header) {
            $value = $request->headers->get($header);

            if ($value === null || $value === '') {
                continue;
            }

            $ip = trim(explode(',', $value)[0]);

            if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                return $ip;
            }
        }

        return null;
    }
}

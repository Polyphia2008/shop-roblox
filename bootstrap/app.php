<?php

use App\Http\Middleware\DetectSqlInjection;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureUserIsNotBanned;
use App\Http\Middleware\NormalizeProxyHeaders;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        /*
         * Middleware toàn cục.
         * - SecurityHeaders: gắn header bảo mật cho MỌI phản hồi.
         * - DetectSqlInjection: quét input, ghi log & chặn payload tấn công.
         *   (Lớp phòng thủ thứ hai — prepared statement vẫn là lớp chính.)
         */
        $middleware->append(SecurityHeaders::class);
        $middleware->append(DetectSqlInjection::class);

        /*
         * Dịch header proxy không chuẩn (X-Client-Proto, CF-Visitor...) sang
         * X-Forwarded-Proto. PHẢI chạy TRƯỚC TrustProxies, nên dùng prepend:
         * TrustProxies chỉ đọc header chuẩn, nếu không dịch trước thì Laravel
         * tưởng request là HTTP và sinh redirect `http://` -> trình duyệt đang
         * ở HTTPS bị treo, cookie Secure không được gửi kèm.
         */
        $middleware->prepend(NormalizeProxyHeaders::class);

        /* Tin cậy header proxy của Cloudflare để lấy đúng IP + scheme HTTPS */
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'admin'      => EnsureUserIsAdmin::class,
            'not.banned' => EnsureUserIsNotBanned::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();

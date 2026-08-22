<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Chỉ cho phép admin (level = 1) vào khu vực quản trị.
 *
 * Bản gốc dùng hàm CheckAdmin() in ra <script>location.href=...</script>
 * -> KHÔNG phải bảo vệ thật: nội dung trang vẫn được render và gửi về
 * trình duyệt, chỉ cần tắt JavaScript là xem được toàn bộ trang admin.
 * Nay chặn ngay tại middleware, request không bao giờ tới controller.
 */
class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user === null) {
            return redirect()->route('login');
        }

        if ($user->isBanned() || ! $user->isAdmin()) {
            abort(Response::HTTP_FORBIDDEN, 'Bạn không có quyền truy cập khu vực này.');
        }

        return $next($request);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\PurchaseRequest;
use App\Services\PurchaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use RuntimeException;
use Throwable;

/**
 * ==================================================================
 *  LUỒNG MUA HÀNG
 * ==================================================================
 *  Thay thế: ajaxs/client/muanick.php, muanick-game.php, ordernick.php
 *
 *  Các lỗi của bản gốc đã được sửa:
 *   1. Xác thực bằng token trong POST body:
 *          WHERE `token` = '" . xss($_POST['token']) . "'
 *      -> vừa inject được, vừa để token lộ trong log/history.
 *      Nay dùng session Laravel + middleware `auth`.
 *   2. Không có CSRF -> nay bắt buộc CSRF token.
 *   3. Không giới hạn tần suất -> nay có RateLimiter chống spam mua.
 * ==================================================================
 */
class PurchaseController extends Controller
{
    public function __construct(private readonly PurchaseService $purchase) {}

    /** Mua nick có Robux theo ID */
    public function robuxAccount(PurchaseRequest $request): JsonResponse|RedirectResponse
    {
        if ($blocked = $this->throttle($request)) {
            return $blocked;
        }

        try {
            $result = $this->purchase->buyRobuxAccount(
                $request->user(),
                $request->accountId(),   // đã validate là integer
            );

            return $this->ok($request, 'Thanh toán thành công.', [
                'magd'  => $result['order']->magd,
                'money' => $request->user()->fresh()->money,
            ]);
        } catch (RuntimeException $e) {
            /* Lỗi nghiệp vụ: số dư không đủ, hết hàng... — hiển thị cho user */
            return $this->fail($request, $e->getMessage());
        } catch (Throwable $e) {
            report($e);

            /* Lỗi hệ thống: KHÔNG trả chi tiết ra ngoài để tránh lộ thông tin */
            return $this->fail($request, 'Có lỗi xảy ra, vui lòng thử lại sau.');
        }
    }

    /** Mua nick thường theo chuyên mục */
    public function categoryNicks(Request $request): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'code'     => ['required', 'string', 'max:64', 'exists:chuyenmuc,code'],
            'quantity' => ['required', 'integer', 'min:1', 'max:50'],
        ], [
            'code.exists'      => 'Chuyên mục không tồn tại.',
            'quantity.max'     => 'Chỉ được mua tối đa 50 nick mỗi lần.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
        ]);

        if ($blocked = $this->throttle($request)) {
            return $blocked;
        }

        try {
            $result = $this->purchase->buyCategoryNicks(
                $request->user(),
                $data['code'],
                (int) $data['quantity'],
            );

            return $this->ok($request, 'Mua hàng thành công.', [
                'magd'  => $result['order']->magd,
                'money' => $request->user()->fresh()->money,
            ]);
        } catch (RuntimeException $e) {
            return $this->fail($request, $e->getMessage());
        } catch (Throwable $e) {
            report($e);

            return $this->fail($request, 'Có lỗi xảy ra, vui lòng thử lại sau.');
        }
    }

    /**
     * Chống spam: mỗi user chỉ được gọi mua N lần / M phút.
     * Bản gốc không có bước này nên bot có thể gọi liên tục để dò
     * race-condition (mua trùng một nick).
     */
    private function throttle(Request $request): JsonResponse|RedirectResponse|null
    {
        [$max, $minutes] = $this->limitConfig();

        $key = 'purchase:'.$request->user()->getAuthIdentifier();

        if (RateLimiter::tooManyAttempts($key, $max)) {
            $seconds = RateLimiter::availableIn($key);

            return $this->fail($request, "Bạn thao tác quá nhanh, thử lại sau {$seconds} giây.", 429);
        }

        RateLimiter::hit($key, $minutes * 60);

        return null;
    }

    /** @return array{0:int,1:int} */
    private function limitConfig(): array
    {
        $raw = (string) config('security.rate_limit.purchase', '10,1');
        $parts = array_map('intval', explode(',', $raw));

        return [max(1, $parts[0] ?? 10), max(1, $parts[1] ?? 1)];
    }

    private function ok(Request $request, string $message, array $payload = []): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'msg' => $message] + $payload);
        }

        return back()->with('success', $message);
    }

    private function fail(Request $request, string $message, int $code = 422): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json(['status' => 'error', 'msg' => $message], $code);
        }

        return back()->with('error', $message)->withInput();
    }
}

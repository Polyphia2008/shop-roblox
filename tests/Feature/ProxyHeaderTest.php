<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\SecurityEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Chuẩn hoá header reverse proxy.
 *
 * Hai lỗi thật phát hiện khi chạy thử site sau proxy HTTPS của sandbox —
 * proxy đó gửi `X-Client-Proto` và `X-Real-IP` thay vì các header chuẩn:
 *
 *  1. Laravel tưởng request là HTTP -> mọi redirect sinh ra `http://`.
 *     Trình duyệt đang ở HTTPS bị đẩy sang HTTP: trang treo, và cookie
 *     phiên đánh dấu `Secure` không được gửi kèm -> không đăng nhập được.
 *  2. `$request->ip()` trả về IP nội bộ của proxy -> bảng `security_events`
 *     ghi IP hạ tầng thay vì IP kẻ tấn công (mất khả năng truy vết), đồng
 *     thời rate-limit theo IP gộp mọi người dùng vào một khoá.
 */
class ProxyHeaderTest extends TestCase
{
    use RefreshDatabase;

    /* ================================================================
     *  PHẦN 1 — Nhận đúng scheme HTTPS
     * ================================================================ */

    /** @return array<string, array{0: array<string, string>}> */
    public static function httpsHeaders(): array
    {
        return [
            'X-Client-Proto (sandbox/STGW)' => [['X-Client-Proto' => 'https']],
            'X-Forwarded-Scheme (nginx)'    => [['X-Forwarded-Scheme' => 'https']],
            'CF-Visitor (Cloudflare)'       => [['CF-Visitor' => '{"scheme":"https"}']],
            'chuẩn X-Forwarded-Proto'       => [['X-Forwarded-Proto' => 'https']],
        ];
    }

    /**
     * @param  array<string, string>  $headers
     */
    #[Test]
    #[DataProvider('httpsHeaders')]
    public function it_detects_https_from_proxy_headers(array $headers): void
    {
        $this->get('/', $headers)->assertOk();

        $this->assertTrue(
            request()->isSecure(),
            'Không nhận ra HTTPS -> redirect sẽ sinh ra http:// và làm treo trình duyệt.',
        );
        $this->assertSame('https', request()->getScheme());
    }

    /**
     * Điểm mấu chốt: URL sinh ra phải là https, vì đây mới là thứ trình
     * duyệt thực sự đi theo.
     */
    #[Test]
    public function generated_redirect_url_uses_https(): void
    {
        /* Khách vào /admin -> bị đẩy về trang đăng nhập. */
        $response = $this->get('/admin', ['X-Client-Proto' => 'https']);

        $response->assertRedirect();

        $target = $response->headers->get('Location');

        $this->assertIsString($target);
        $this->assertStringStartsWith(
            'https://',
            $target,
            'Redirect ra http:// sẽ làm mất cookie Secure và treo trình duyệt.',
        );
    }

    /**
     * Middleware chỉ *dịch tên header*, không được tự phong cho request là
     * HTTPS. Phải gọi bằng URL tuyệt đối `http://` vì `APP_URL` có thể là
     * https, khiến request mặc định của test đã secure sẵn — lúc đó phép thử
     * không còn kiểm được gì.
     */
    #[Test]
    public function it_does_not_invent_https_when_request_is_plain_http(): void
    {
        $this->get('http://localhost/');

        $this->assertFalse(
            request()->isSecure(),
            'Không có header proxy nào mà vẫn coi là HTTPS -> middleware tự phong scheme.',
        );
    }

    /**
     * Proxy gửi `X-Forwarded-Port: 80` kèm HTTPS là thông tin tự mâu thuẫn;
     * nếu giữ lại, URL sinh ra sẽ thành `https://host:80`.
     */
    #[Test]
    public function contradictory_forwarded_port_is_dropped(): void
    {
        $response = $this->get('/admin', [
            'X-Client-Proto'   => 'https',
            'X-Forwarded-Port' => '80',
        ]);

        $target = (string) $response->headers->get('Location');

        $this->assertStringStartsWith('https://', $target);
        $this->assertStringNotContainsString(':80', $target);
    }

    /* ================================================================
     *  PHẦN 2 — Ghi đúng IP kẻ tấn công
     * ================================================================ */

    /** @return array<string, array{0: string}> */
    public static function ipHeaders(): array
    {
        return [
            'X-Real-IP (nginx/sandbox)' => ['X-Real-IP'],
            'CF-Connecting-IP'          => ['CF-Connecting-IP'],
            'True-Client-IP'            => ['True-Client-IP'],
        ];
    }

    #[Test]
    #[DataProvider('ipHeaders')]
    public function security_log_records_the_real_client_ip(string $header): void
    {
        config(['security.sqli.enabled' => true, 'security.sqli.block' => true]);

        $attacker = '170.106.202.227';

        $this->get('/auth/nick-game?keyword='.urlencode("' OR 1=1 --"), [
            $header => $attacker,
        ])->assertForbidden();

        $event = SecurityEvent::query()->latest()->first();

        $this->assertNotNull($event, 'Tấn công bị chặn nhưng không ghi log.');
        $this->assertSame(
            $attacker,
            $event->ip,
            'Log ghi IP nội bộ của proxy -> không truy vết được kẻ tấn công.',
        );
    }

    /**
     * Header do client gửi nên có thể bị giả mạo bằng chuỗi bất kỳ. Giá trị
     * này đi vào log và khoá rate-limit, vì vậy phải bị loại nếu không phải IP.
     */
    #[Test]
    public function spoofed_non_ip_header_is_ignored(): void
    {
        $this->get('/', ['X-Real-IP' => "'; DROP TABLE users; --"]);

        $this->assertNotSame("'; DROP TABLE users; --", request()->ip());
        $this->assertNotFalse(
            filter_var(request()->ip(), FILTER_VALIDATE_IP),
            'IP phải luôn là địa chỉ hợp lệ, không nhận chuỗi tuỳ ý.',
        );
    }

    #[Test]
    public function standard_forwarded_for_is_not_overwritten(): void
    {
        /* Nếu proxy đã gửi header chuẩn thì tôn trọng nó, không ghi đè. */
        $this->get('/', [
            'X-Forwarded-For' => '203.0.113.9',
            'X-Real-IP'       => '198.51.100.4',
        ]);

        $this->assertSame('203.0.113.9', request()->ip());
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Kiểm thử khói (smoke test) cho các trang công khai.
 *
 * Lưu ý: bắt buộc dùng RefreshDatabase. Bản scaffold mặc định của Laravel
 * chú thích dòng này lại, nên test chết ngay vì "no such table: mucrate" —
 * trang chủ có truy vấn bảng mức rate.
 */
final class ExampleTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function home_page_loads(): void
    {
        $this->get('/')->assertOk();
    }

    /** @return list<array{0: string}> */
    public static function publicPages(): array
    {
        return [
            ['/'],
            ['/client/nick-game'],
            ['/warranty-policy'],
            ['/use-bot'],
            ['/use-report'],
            ['/2fa'],
            ['/botcheck'],
            ['/auth/login'],
            ['/auth/register'],
        ];
    }

    #[Test]
    #[\PHPUnit\Framework\Attributes\DataProvider('publicPages')]
    public function public_pages_render_without_error(string $url): void
    {
        $this->get($url)->assertOk();
    }

    /**
     * Header bảo mật phải có mặt trên MỌI phản hồi — middleware
     * SecurityHeaders là middleware toàn cục.
     */
    #[Test]
    public function security_headers_are_present(): void
    {
        $response = $this->get('/');

        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $this->assertNotNull($response->headers->get('Content-Security-Policy'));
        $this->assertNotNull($response->headers->get('Referrer-Policy'));
    }

    /**
     * Nội dung do admin cấu hình phải được ESCAPE khi in ra, nếu không
     * một lần lưu cấu hình là XSS lưu trữ cho toàn bộ khách truy cập.
     */
    #[Test]
    public function setting_content_is_escaped_not_executed(): void
    {
        Setting::put('warranty_policy', '<script>alert(1)</script>Nội dung bảo hành');

        $response = $this->get('/warranty-policy');

        $response->assertOk();
        $response->assertDontSee('<script>alert(1)</script>', false);
        $response->assertSee('Nội dung bảo hành', false);
    }
}

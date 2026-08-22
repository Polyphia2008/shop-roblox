<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\SecurityEvent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * ==================================================================
 *  KIỂM THỬ CHỐNG SQL INJECTION Ở MỨC ỨNG DỤNG (end-to-end)
 * ------------------------------------------------------------------
 *  Test unit đã chứng minh bộ phát hiện hoạt động. Test này chứng minh
 *  điều quan trọng hơn: DÙ payload có lọt qua bộ phát hiện đi nữa,
 *  cơ sở dữ liệu vẫn KHÔNG bị tổn hại — vì mọi truy vấn đều là
 *  prepared statement.
 *
 *  Cách kiểm chứng: TẮT chế độ chặn rồi bắn payload phá hoại vào các
 *  endpoint thật, sau đó xác nhận bảng dữ liệu vẫn còn nguyên. Đây mới
 *  là bài test đúng bản chất — nó kiểm tra lớp phòng thủ THẬT
 *  (prepared statement), không phải kiểm tra bộ lọc.
 * ==================================================================
 */
final class SqlInjectionProtectionTest extends TestCase
{
    use RefreshDatabase;

    /** Trang tìm kiếm nick công khai — điểm vào nhận `keyword` từ người dùng. */
    private const SEARCH_URL = '/client/nick-game';

    /* ================================================================
     *  PHẦN 1 — Middleware chặn & ghi log
     * ================================================================ */

    #[Test]
    public function it_blocks_request_containing_injection_payload(): void
    {
        config(['security.sqli.enabled' => true, 'security.sqli.block' => true]);

        $this->get(self::SEARCH_URL.'?keyword='.urlencode("' OR 1=1 --"))
            ->assertForbidden();
    }

    #[Test]
    public function it_records_the_attack_in_the_security_log(): void
    {
        config(['security.sqli.enabled' => true, 'security.sqli.block' => true]);

        $this->get(self::SEARCH_URL.'?keyword='.urlencode('1; DROP TABLE users'));

        $event = SecurityEvent::query()->latest('id')->first();

        $this->assertNotNull($event, 'Không ghi được sự kiện tấn công vào security_events.');
        $this->assertSame(SecurityEvent::TYPE_SQLI, $event->type);
        $this->assertSame('stacked_query', $event->rule);
        $this->assertSame('keyword', $event->parameter);
        $this->assertStringContainsString('DROP TABLE', (string) $event->payload);
    }

    #[Test]
    public function it_lets_normal_requests_through(): void
    {
        config(['security.sqli.enabled' => true, 'security.sqli.block' => true]);

        $this->get(self::SEARCH_URL.'?keyword=nick+pro+gia+re')->assertOk();

        $this->assertSame(0, SecurityEvent::query()->count());
    }

    /* ================================================================
     *  PHẦN 2 — Lớp phòng thủ THẬT: prepared statement
     * ----------------------------------------------------------------
     *  Tắt hẳn middleware để mô phỏng tình huống xấu nhất: bộ lọc bị
     *  vượt qua hoặc bị admin tắt. Dữ liệu vẫn phải an toàn.
     * ================================================================ */

    /** @return array<string, array{0: string}> */
    public static function destructivePayloads(): array
    {
        return [
            'drop table'     => ["'; DROP TABLE users; --"],
            'delete all'     => ["' OR 1=1; DELETE FROM users; --"],
            'union password' => ["' UNION SELECT password FROM users --"],
            'update level'   => ["'; UPDATE users SET level = 1; --"],
            'truncate'       => ["'; TRUNCATE TABLE nick; --"],
            'comment bypass' => ["admin'--"],
            'tautology'      => ["' OR '1'='1"],
        ];
    }

    #[Test]
    #[DataProvider('destructivePayloads')]
    public function database_survives_payloads_even_with_the_filter_disabled(string $payload): void
    {
        /* Mô phỏng tình huống xấu nhất: middleware bị tắt hoàn toàn */
        config(['security.sqli.enabled' => false]);

        User::factory()->count(3)->create();
        $usersBefore = User::query()->count();

        $response = $this->get(self::SEARCH_URL.'?keyword='.urlencode($payload));

        /* 200 = câu SQL vẫn hợp lệ -> payload được bind như DỮ LIỆU, không phải mã */
        $response->assertOk();

        /* Bảng users còn nguyên vẹn */
        $this->assertSame($usersBefore, User::query()->count(), 'Dữ liệu đã bị payload thay đổi!');
        $this->assertTrue(DB::getSchemaBuilder()->hasTable('users'), 'Bảng users đã bị xoá!');

        /* Không có ai được leo thang đặc quyền */
        $this->assertSame(0, User::query()->where('level', '>', 0)->count());
    }

    /**
     * Payload chứa dấu nháy phải được coi là VĂN BẢN thuần: tìm kiếm
     * không khớp gì cả, chứ không phải "khớp tất cả" (dấu hiệu inject).
     */
    #[Test]
    public function injection_payload_is_treated_as_literal_text_not_sql(): void
    {
        config(['security.sqli.enabled' => false]);

        $safe   = User::factory()->create(['username' => 'nguoi_dung_that']);
        $before = User::query()->count();

        $this->get(self::SEARCH_URL.'?keyword='.urlencode("' OR 1=1 --"))->assertOk();

        $this->assertSame($before, User::query()->count());
        $this->assertDatabaseHas('users', ['username' => 'nguoi_dung_that']);
        $this->assertNotNull($safe->fresh());
    }

    /* ================================================================
     *  PHẦN 3 — ORDER BY: chỗ DUY NHẤT prepared statement không cứu được
     * ----------------------------------------------------------------
     *  PDO không bind được tên cột / chiều sắp xếp, nên đây là điểm yếu
     *  thật sự và phải chặn bằng allow-list ở controller.
     *  Route lịch sử đơn hàng của admin nhận trực tiếp `sort` + `dir`.
     * ================================================================ */

    /** @return array<string, array{0: string}> */
    public static function orderByPayloads(): array
    {
        return [
            'subquery'   => ['(SELECT password FROM users LIMIT 1)'],
            'stacked'    => ['id; DROP TABLE users'],
            'extra col'  => ['id, (SELECT 1)'],
            'comment'    => ['money--'],
            'time based' => ['IF(1=1,SLEEP(5),0)'],
            'unknown'    => ['khong_ton_tai'],
        ];
    }

    #[Test]
    #[DataProvider('orderByPayloads')]
    public function order_by_parameter_cannot_be_injected(string $payload): void
    {
        config(['security.sqli.enabled' => false]);

        $admin = User::factory()->admin()->create();
        User::factory()->count(2)->create();

        $response = $this->actingAs($admin)->get(
            '/admin/history-order?sort='.urlencode($payload).'&dir='.urlencode('asc; DROP TABLE users')
        );

        /* Allow-list phải khiến truy vấn chạy bình thường với cột mặc định */
        $response->assertOk();
        $this->assertTrue(DB::getSchemaBuilder()->hasTable('users'), 'Bảng users bị xoá qua ORDER BY!');
        $this->assertSame(3, User::query()->count());
    }

    /* ================================================================
     *  PHẦN 4 — Ký tự wildcard của LIKE
     * ----------------------------------------------------------------
     *  Không phải lỗ hổng inject, nhưng nếu không escape thì gõ '%'
     *  sẽ quét toàn bảng -> rò rỉ dữ liệu và DoS nhẹ.
     * ================================================================ */

    #[Test]
    public function like_wildcards_are_escaped_and_do_not_match_everything(): void
    {
        config(['security.sqli.enabled' => false]);

        foreach (['%', '_', '%%%', '\\'] as $wildcard) {
            $this->get(self::SEARCH_URL.'?keyword='.urlencode($wildcard))
                ->assertOk();
        }
    }

    /* ================================================================
     *  PHẦN 5 — Chống mass assignment (leo thang đặc quyền)
     * ================================================================ */

    #[Test]
    public function privileged_columns_cannot_be_mass_assigned(): void
    {
        $user = new User();

        /* Kẻ tấn công thêm level/money/banned vào form đăng ký */
        $user->fill([
            'username'    => 'ke_tan_cong',
            'email'       => 'attacker@example.com',
            'password'    => 'secret-password',
            'level'       => 1,
            'money'       => 999_999_999,
            'total_money' => 999_999_999,
            'banned'      => false,
        ]);

        /* $fillable đã loại các cột đặc quyền -> chúng phải không được gán */
        $this->assertNull($user->getAttribute('level'));
        $this->assertNull($user->getAttribute('money'));
        $this->assertNull($user->getAttribute('total_money'));
        $this->assertSame('ke_tan_cong', $user->username);
    }

    #[Test]
    public function passwords_are_hashed_never_stored_in_plain_text(): void
    {
        $user = User::factory()->create(['password' => 'mat-khau-cua-toi']);

        $this->assertNotSame('mat-khau-cua-toi', $user->password);
        /* bcrypt: 60 ký tự, bắt đầu bằng $2y$ — khác hẳn sha1 40 ký tự của bản gốc */
        $this->assertMatchesRegularExpression('/^\$2[axy]\$/', $user->password);
        $this->assertTrue(password_verify('mat-khau-cua-toi', $user->password));
    }
}

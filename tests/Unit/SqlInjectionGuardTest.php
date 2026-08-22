<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Security\SqlInjectionGuard;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * ==================================================================
 *  KIỂM THỬ LỚP PHÒNG THỦ CHỐNG SQL INJECTION
 * ------------------------------------------------------------------
 *  Bộ test này bảo vệ hai tính chất trái ngược nhau, cả hai đều
 *  bắt buộc phải đúng:
 *
 *   1. ĐỘ NHẠY (không bỏ sót): mọi payload tấn công kinh điển đều
 *      phải bị phát hiện — kể cả khi đã bị che giấu bằng URL-encode,
 *      HTML entity, \u escape, hoặc comment chèn giữa hai từ khoá.
 *
 *   2. ĐỘ CHÍNH XÁC (không báo động sai): dữ liệu thật của khách
 *      (tên tiếng Việt, ghi chú khiếu nại, mã giao dịch, mật khẩu
 *      mạnh) KHÔNG được bị chặn. Một bộ lọc báo động sai quá nhiều
 *      sẽ bị admin tắt đi, và khi đó nó bảo vệ được 0%.
 *
 *  Nhắc lại: lớp này chỉ là phòng thủ LỚP 2. Lớp 1 — và là lớp thật
 *  sự đáng tin cậy — là prepared statement của Eloquent.
 * ==================================================================
 */
final class SqlInjectionGuardTest extends TestCase
{
    /** @return list<array{0: string}> */
    public static function attackPayloads(): array
    {
        return [
            /* --- Union-based ------------------------------------------- */
            ["' UNION SELECT password FROM users --"],
            ["1' union all select null,null,version() #"],
            ['-1 UNION/**/SELECT/**/1,2,3'],

            /* --- Tautology / bypass đăng nhập -------------------------- */
            ["' OR 1=1 --"],
            ['" or "a"="a'],
            ["admin'-- "],
            ["' or 1=1 #"],
            ['1 OR 1<>2'],

            /* --- Xếp tầng câu lệnh ------------------------------------- */
            ['1; DROP TABLE users'],
            ["'; DELETE FROM orders WHERE 1=1 --"],
            ["1;UPDATE users SET level='admin'"],

            /* --- Dò metadata ------------------------------------------- */
            ['1 AND (SELECT 1 FROM information_schema.tables)'],
            ["' AND 1=(SELECT COUNT(*) FROM sqlite_master) --"],
            ['union select * from mysql.user'],

            /* --- Hàm nguy hiểm / RCE ----------------------------------- */
            ["' UNION SELECT LOAD_FILE('/etc/passwd') --"],
            ["1' INTO OUTFILE '/var/www/shell.php"],
            ["'; EXEC xp_cmdshell('whoami') --"],

            /* --- Blind / time-based ------------------------------------ */
            ["1' AND SLEEP(5) --"],
            ["1 OR benchmark(10000000,MD5('a'))"],
            ["1' AND pg_sleep(10) --"],
            ["1; WAITFOR DELAY '0:0:5'"],

            /* --- Né bộ lọc bằng mã hoá ký tự --------------------------- */
            ['CHAR(97,100,109,105,110)'],
            ['UNHEX(414243)'],

            /* --- DDL/DML thô trong tham số ----------------------------- */
            ['DROP DATABASE sellgame'],
            ['TRUNCATE TABLE orders'],
            ['INSERT INTO users (level) VALUES (1)'],
        ];
    }

    #[Test]
    #[DataProvider('attackPayloads')]
    public function it_detects_attack_payloads(string $payload): void
    {
        $this->assertNotNull(
            SqlInjectionGuard::detect($payload),
            "Không phát hiện được payload tấn công: {$payload}",
        );
    }

    /**
     * Payload bị che giấu. Điểm mấu chốt: normalize() phải giải mã TRƯỚC
     * khi so khớp — nếu không, kẻ tấn công chỉ cần URL-encode dấu nháy
     * là vượt qua toàn bộ bộ lọc.
     *
     * @return array<string, array{0: string, 1: string}>
     */
    public static function obfuscatedPayloads(): array
    {
        return [
            'url-encode một lớp'   => ['%27%20OR%201%3D1%20--', 'URL-encode'],
            'url-encode hai lớp'   => ['%2527%2520OR%25201%253D1%2520--', 'URL-encode lồng'],
            'html entity'          => ['&#39; OR 1=1 --', 'HTML entity'],
            'unicode escape'       => ['\\u0027 OR 1=1 --', '\\u escape'],
            'hex escape'           => ['\\x27 OR 1=1 --', '\\x escape'],
            'comment giữa từ khoá' => ["' UNION/*bypass*/SELECT 1 --", 'block comment'],
            'xuống dòng giữa từ'   => ["' UNION\nSELECT\t1 --", 'khoảng trắng lạ'],
            'ký tự NULL'           => ["' OR 1=1\0 --", 'NULL byte'],
        ];
    }

    #[Test]
    #[DataProvider('obfuscatedPayloads')]
    public function it_sees_through_obfuscation(string $payload, string $technique): void
    {
        $this->assertNotNull(
            SqlInjectionGuard::detect($payload),
            "Bị vượt qua bằng kỹ thuật {$technique}: {$payload}",
        );
    }

    /**
     * Dữ liệu hợp lệ của người dùng thật — TUYỆT ĐỐI không được chặn.
     *
     * @return list<array{0: string}>
     */
    public static function legitimateInputs(): array
    {
        return [
            ['Nguyễn Văn A'],
            ['nick_pro_2008'],
            ['GD20260821XY9'],
            ['Tôi mua nick lúc 10h nhưng chưa nhận được thông tin'],
            ['Nick bị mất Robux, mong shop bảo hành giúp em'],
            ['P@ssw0rd!Str0ng#2026'],
            ['a&b=c'],
            ['100% hài lòng'],
            ['1+1=2'],
            ['Giá: 50.000đ - 100.000đ'],
            ['user@example.com'],
            ['Số dư trước 1000, sau 2000'],
            ['Robux 10k rate 1.5'],
            ['select'],
            ['order'],
            ['update'],
            ['Chờ admin duyệt đơn (khoảng 5-10 phút)'],
            ['https://example.com/path?a=1&b=2'],
            ['C:\\Users\\admin\\Desktop'],
            ['Tôi đã đọc chính sách bảo hành, xin hỗ trợ'],
        ];
    }

    #[Test]
    #[DataProvider('legitimateInputs')]
    public function it_does_not_flag_legitimate_input(string $input): void
    {
        $this->assertNull(
            SqlInjectionGuard::detect($input),
            "Báo động sai với dữ liệu hợp lệ: {$input}",
        );
    }

    #[Test]
    public function it_ignores_non_string_and_empty_values(): void
    {
        $this->assertNull(SqlInjectionGuard::detect(null));
        $this->assertNull(SqlInjectionGuard::detect(''));
        $this->assertNull(SqlInjectionGuard::detect(123));
        $this->assertNull(SqlInjectionGuard::detect(1.5));
        $this->assertNull(SqlInjectionGuard::detect(true));
        $this->assertNull(SqlInjectionGuard::detect([]));
    }

    /* ================================================================
     *  scan() — quét đệ quy toàn bộ dữ liệu request
     * ================================================================ */

    #[Test]
    public function scan_returns_null_for_clean_input(): void
    {
        $this->assertNull(SqlInjectionGuard::scan([
            'keyword' => 'nick pro',
            'sort'    => 'id',
            'dir'     => 'desc',
            'nested'  => ['a' => 'ok', 'b' => ['c' => 'vẫn ổn']],
        ]));
    }

    #[Test]
    public function scan_finds_payload_nested_deeply(): void
    {
        $hit = SqlInjectionGuard::scan([
            'filter' => ['user' => ['name' => "' OR 1=1 --"]],
        ]);

        $this->assertNotNull($hit);
        $this->assertSame('filter.user.name', $hit['parameter']);
        $this->assertSame('tautology', $hit['rule']);
    }

    /**
     * Kẻ tấn công có thể nhét payload vào TÊN tham số chứ không chỉ giá
     * trị (ví dụ ?1' OR 1=1--=x). scan() phải kiểm tra cả khoá.
     */
    #[Test]
    public function scan_also_inspects_parameter_names(): void
    {
        $hit = SqlInjectionGuard::scan(["' OR 1=1 --" => 'harmless']);

        $this->assertNotNull($hit);
        $this->assertSame('tautology', $hit['rule']);
    }

    #[Test]
    public function scan_reports_the_rule_and_parameter(): void
    {
        $hit = SqlInjectionGuard::scan([
            'ok'   => 'bình thường',
            'evil' => '1; DROP TABLE users',
        ]);

        $this->assertNotNull($hit);
        $this->assertSame('evil', $hit['parameter']);
        $this->assertSame('stacked_query', $hit['rule']);
        $this->assertSame('1; DROP TABLE users', $hit['value']);
    }

    /* ================================================================
     *  ALLOW-LIST ĐỊNH DANH — phần BẮT BUỘC dùng, vì PDO không thể
     *  bind tên cột và hướng sắp xếp.
     * ================================================================ */

    #[Test]
    public function column_accepts_only_allow_listed_values(): void
    {
        $allowed = ['id', 'money', 'created_at'];

        $this->assertSame('money', SqlInjectionGuard::column('money', $allowed, 'id'));
        $this->assertSame('created_at', SqlInjectionGuard::column('created_at', $allowed, 'id'));
    }

    /**
     * Đây là test quan trọng nhất của cả file: nếu column() trả về bất cứ
     * thứ gì ngoài allow-list thì mệnh đề ORDER BY sẽ bị inject.
     *
     * @return list<array{0: string|null}>
     */
    public static function maliciousColumns(): array
    {
        return [
            ['(SELECT password FROM users LIMIT 1)'],
            ['id; DROP TABLE users'],
            ['id, (SELECT 1)'],
            ['money--'],
            ['`id`'],
            ['id/*x*/'],
            ['IF(1=1,SLEEP(5),0)'],
            ['unknown_column'],
            [''],
            [null],
        ];
    }

    #[Test]
    #[DataProvider('maliciousColumns')]
    public function column_falls_back_when_value_is_not_allow_listed(?string $input): void
    {
        $this->assertSame(
            'id',
            SqlInjectionGuard::column($input, ['id', 'money', 'created_at'], 'id'),
            'column() đã để lọt một định danh không nằm trong allow-list.',
        );
    }

    #[Test]
    public function direction_only_ever_returns_asc_or_desc(): void
    {
        $this->assertSame('asc', SqlInjectionGuard::direction('asc'));
        $this->assertSame('asc', SqlInjectionGuard::direction('ASC'));
        $this->assertSame('desc', SqlInjectionGuard::direction(' DESC '));

        /* Mọi giá trị lạ đều phải rơi về fallback an toàn */
        foreach (['asc; DROP TABLE users', 'asc--', 'random', '', null] as $bad) {
            $this->assertContains(
                SqlInjectionGuard::direction($bad),
                ['asc', 'desc'],
                'direction() trả về giá trị không phải asc/desc.',
            );
        }

        $this->assertSame('desc', SqlInjectionGuard::direction('asc; DROP TABLE users'));
    }

    #[Test]
    public function is_safe_identifier_rejects_sql_metacharacters(): void
    {
        $this->assertTrue(SqlInjectionGuard::isSafeIdentifier('id'));
        $this->assertTrue(SqlInjectionGuard::isSafeIdentifier('users.created_at'));
        $this->assertTrue(SqlInjectionGuard::isSafeIdentifier('_private'));

        foreach ([
            '1id', 'id;', 'id-1', 'id ', 'a.b.c', '`id`', 'id)', 'id--',
            'DROP TABLE', '', str_repeat('a', 65),
        ] as $bad) {
            $this->assertFalse(
                SqlInjectionGuard::isSafeIdentifier($bad),
                "isSafeIdentifier() chấp nhận sai định danh: {$bad}",
            );
        }
    }

    /* ================================================================
     *  Ghi log an toàn
     * ================================================================ */

    #[Test]
    public function truncate_for_log_limits_length_and_strips_newlines(): void
    {
        $long = str_repeat('A', 600);
        $out  = SqlInjectionGuard::truncateForLog($long);

        $this->assertStringEndsWith('...[truncated]', $out);
        $this->assertLessThan(600, mb_strlen($out));

        /* Chống log injection: payload không được tự tạo dòng log giả */
        $this->assertStringNotContainsString(
            "\n",
            SqlInjectionGuard::truncateForLog("dòng 1\ndòng 2\r\nERROR fake"),
        );
    }

    #[Test]
    public function truncate_for_log_keeps_short_values_intact(): void
    {
        $this->assertSame("' OR 1=1 --", SqlInjectionGuard::truncateForLog("' OR 1=1 --"));
    }
}

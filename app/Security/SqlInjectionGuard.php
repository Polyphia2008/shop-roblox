<?php

declare(strict_types=1);

namespace App\Security;

/**
 * ==================================================================
 *  SqlInjectionGuard - Lớp phòng thủ chống SQL Injection
 * ------------------------------------------------------------------
 *  TRIẾT LÝ THIẾT KẾ (rất quan trọng, đọc kỹ):
 *
 *  Lớp này KHÔNG PHẢI là biện pháp bảo vệ chính. Biện pháp bảo vệ
 *  CHÍNH và DUY NHẤT đáng tin cậy là **Prepared Statement** —
 *  toàn bộ ứng dụng đã dùng Eloquent / Query Builder nên 100% tham số
 *  đều được bind, kể cả khi kẻ tấn công gửi payload quái dị nhất.
 *
 *  Lớp này là **lớp phòng thủ thứ hai (defence in depth)** với 2 mục đích:
 *
 *   1) PHÁT HIỆN & GHI LOG: biết được ai đang cố tấn công mình, khi nào,
 *      bằng payload gì -> phục vụ điều tra, chặn IP, cảnh báo Telegram.
 *
 *   2) CHẶN SỚM: từ chối request có dấu hiệu tấn công rõ ràng ngay tại
 *      middleware, trước khi nó đi sâu vào ứng dụng.
 *
 *  ĐIỀU LỚP NÀY KHÔNG LÀM: nó KHÔNG "làm sạch" chuỗi rồi nhét vào SQL.
 *  Cách tiếp cận blacklist/sanitize-rồi-nối-chuỗi luôn có thể bị vượt qua
 *  và là sai lầm kinh điển. Không bao giờ dựa vào nó để tự nối SQL.
 *
 *  Ngoài ra lớp này còn cung cấp các hàm `assertSafeIdentifier()` và
 *  `assertSafeDirection()` — đây MỚI là phần bắt buộc dùng, vì tên
 *  bảng / tên cột / hướng sắp xếp KHÔNG THỂ bind bằng prepared statement.
 *  Chúng phải được kiểm tra bằng ALLOW-LIST (whitelist).
 * ==================================================================
 */
final class SqlInjectionGuard
{
    /**
     * Các mẫu (pattern) nhận diện payload SQL Injection phổ biến.
     * Mỗi phần tử: 'tên luật' => 'biểu thức chính quy'.
     */
    private const PATTERNS = [
        /* Union-based: ' UNION SELECT password FROM users -- */
        'union_select' => '/\bunion\b[\s\S]{0,40}?\bselect\b/i',

        /* Tautology / bypass đăng nhập: ' OR 1=1 --  |  " or "a"="a */
        'tautology' => '/(\'|"|`|\s)\s*(or|and)\s+([\'"`]?[\w\s]+[\'"`]?\s*(=|<>|!=|<|>)\s*[\'"`]?[\w\s]+[\'"`]?|\d+\s*(=|<>|!=)\s*\d+)/i',

        /* Kết thúc chuỗi rồi mở chú thích để bỏ phần còn lại của câu lệnh:
           dấu nháy theo sau bởi hai gạch ngang, dấu thăng, hoặc mở block comment */
        'comment_terminator' => '/(\'|"|`)\s*(--|#|\/\*)/',

        /* Xếp tầng câu lệnh: '; DROP TABLE users */
        'stacked_query' => '/;\s*(select|insert|update|delete|drop|alter|create|truncate|rename|grant|revoke|replace|merge)\b/i',

        /* Truy vấn hệ thống / metadata: information_schema, mysql.user */
        'schema_probe' => '/\b(information_schema|pg_catalog|sqlite_master|mysql\s*\.\s*user|sys\s*\.\s*databases)\b/i',

        /* Hàm nguy hiểm / RCE: LOAD_FILE, xp_cmdshell, INTO OUTFILE */
        'dangerous_function' => '/\b(load_file|outfile|dumpfile|xp_cmdshell|exec\s*\(|execute\s+immediate|pg_sleep|benchmark\s*\(|sleep\s*\(|waitfor\s+delay|utl_http|dbms_pipe)\b/i',

        /* Blind / time-based: AND SLEEP(5) | ' AND 1=1 AND SLEEP */
        'blind_probe' => '/\b(and|or)\b[\s\S]{0,30}?\b(sleep|benchmark|pg_sleep|waitfor)\s*\(/i',

        /* Toán tử/hàm né tránh bộ lọc: CHAR(), CONCAT() trong ngữ cảnh SQL */
        'obfuscation' => '/\b(char|chr|concat|concat_ws|unhex|hex|ascii)\s*\(\s*\d+/i',

        /* DDL/DML trực tiếp trong tham số đầu vào */
        'raw_statement' => '/\b(drop|truncate|alter)\s+(table|database|schema|index)\b/i',
        'raw_dml'       => '/\b(insert\s+into|delete\s+from|update\s+\w+\s+set)\b/i',
    ];

    /**
     * Kiểm tra một giá trị có dấu hiệu SQL Injection hay không.
     *
     * @return string|null Tên luật bị vi phạm, hoặc null nếu an toàn.
     */
    public static function detect(mixed $value): ?string
    {
        if (! is_string($value) || $value === '') {
            return null;
        }

        /* Giải mã các lớp che giấu thường gặp trước khi so khớp:
           %27 -> ' , &#39; -> ' , chuỗi \u0027 ... */
        $normalized = self::normalize($value);

        foreach (self::PATTERNS as $rule => $pattern) {
            if (preg_match($pattern, $normalized) === 1) {
                return $rule;
            }
        }

        return null;
    }

    /**
     * Quét đệ quy một mảng dữ liệu (thường là $request->all()).
     *
     * @param  array<array-key, mixed>  $input
     * @return array{parameter: string, rule: string, value: string}|null
     *         Vi phạm ĐẦU TIÊN tìm thấy, hoặc null nếu tất cả đều sạch.
     */
    public static function scan(array $input, string $prefix = ''): ?array
    {
        foreach ($input as $key => $value) {
            $name = $prefix === '' ? (string) $key : $prefix.'.'.$key;

            /* Chính TÊN tham số cũng có thể chứa payload */
            if (is_string($key) && ($rule = self::detect($key)) !== null) {
                return ['parameter' => $name, 'rule' => $rule, 'value' => $key];
            }

            if (is_array($value)) {
                if (($nested = self::scan($value, $name)) !== null) {
                    return $nested;
                }

                continue;
            }

            if (($rule = self::detect($value)) !== null) {
                return [
                    'parameter' => $name,
                    'rule'      => $rule,
                    'value'     => (string) $value,
                ];
            }
        }

        return null;
    }

    /**
     * Chuẩn hoá chuỗi để chống các kỹ thuật né bộ lọc.
     */
    private static function normalize(string $value): string
    {
        /* URL-decode nhiều lớp (tối đa 3 lần, tránh vòng lặp vô hạn) */
        for ($i = 0; $i < 3; $i++) {
            $decoded = rawurldecode($value);
            if ($decoded === $value) {
                break;
            }
            $value = $decoded;
        }

        /* Giải mã HTML entity: &#39; &quot; &lt; ... */
        $value = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        /* Chuyển \u0027 / \x27 thành ký tự thật */
        $value = (string) preg_replace_callback(
            '/\\\\(?:u\{?([0-9a-fA-F]{4})\}?|x([0-9a-fA-F]{2}))/',
            static fn (array $m): string => mb_chr((int) hexdec($m[1] !== '' ? $m[1] : $m[2]), 'UTF-8') ?: '',
            $value
        );

        /* Bỏ ký tự NULL và ký tự điều khiển dùng để cắt câu lệnh */
        $value = str_replace(["\0", "\x1a"], '', $value);

        /* Bỏ block comment rồi gộp khoảng trắng: chống kỹ thuật chèn
           comment hoặc xuống dòng/tab giữa hai từ khoá để né bộ lọc */
        $value = (string) preg_replace('#/\*.*?\*/#s', ' ', $value);
        $value = (string) preg_replace('/\s+/', ' ', $value);

        return $value;
    }

    /* ================================================================
     *  PHẦN BẮT BUỘC DÙNG: kiểm tra định danh bằng ALLOW-LIST
     * ----------------------------------------------------------------
     *  Prepared statement KHÔNG THỂ bind tên bảng / tên cột / ASC-DESC.
     *  Vì vậy khi cần sắp xếp hay lọc động theo input người dùng,
     *  BẮT BUỘC phải đối chiếu với danh sách cho phép.
     * ================================================================ */

    /**
     * Trả về tên cột an toàn, đã đối chiếu allow-list.
     *
     * @param  list<string>  $allowed  Danh sách cột được phép
     */
    public static function column(?string $column, array $allowed, string $fallback): string
    {
        $column = is_string($column) ? trim($column) : '';

        return in_array($column, $allowed, true) ? $column : $fallback;
    }

    /** Trả về hướng sắp xếp an toàn: chỉ 'asc' hoặc 'desc'. */
    public static function direction(?string $direction, string $fallback = 'desc'): string
    {
        $direction = is_string($direction) ? strtolower(trim($direction)) : '';

        return in_array($direction, ['asc', 'desc'], true) ? $direction : $fallback;
    }

    /**
     * Kiểm tra một định danh SQL (tên bảng/cột) có đúng định dạng an toàn.
     * Chỉ cho phép chữ, số, gạch dưới — và tối đa 1 dấu chấm (table.column).
     */
    public static function isSafeIdentifier(string $identifier): bool
    {
        return preg_match('/^[A-Za-z_][A-Za-z0-9_]{0,63}(\.[A-Za-z_][A-Za-z0-9_]{0,63})?$/', $identifier) === 1;
    }

    /**
     * Cắt ngắn payload trước khi ghi log, tránh log phình to / log injection.
     */
    public static function truncateForLog(string $value, int $limit = 500): string
    {
        $value = str_replace(["\r", "\n"], ' ', $value);

        return mb_strlen($value) > $limit
            ? mb_substr($value, 0, $limit).'...[truncated]'
            : $value;
    }
}

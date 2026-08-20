<?php
/**
 * ==================================================================
 *  core/helpers.php  -  ĐÃ ĐƯỢC VIẾT LẠI HOÀN TOÀN
 * ------------------------------------------------------------------
 *  NGUYÊN NHÂN CHÍNH GÂY LỖI 403 / TRẮNG TRANG:
 *
 *  File gốc bị mã hoá bằng ionCube Encoder. Khi hosting KHÔNG cài
 *  extension "ionCube Loader", PHP không thể đọc được file này.
 *  Vì index.php require_once() nó ở dòng thứ 4, toàn bộ website
 *  chết ngay từ dòng đầu -> hosting/Apache trả về 403 Forbidden
 *  hoặc 500 Internal Server Error hoặc trang trắng.
 *
 *  Bản mã hoá còn tự in ra thông báo:
 *      "Script error: the ionCube Loader for PHP needs to be installed"
 *  rồi die() -> không có cách nào chạy được nếu thiếu extension.
 *
 *  GIẢI PHÁP: Toàn bộ các hàm helper đã được DỰNG LẠI bằng PHP
 *  thuần (plain PHP) dựa trên cách chúng được sử dụng trong source.
 *  Nhờ vậy source chạy được trên MỌI hosting PHP 7.4 - 8.4,
 *  KHÔNG cần ionCube Loader nữa.
 * ------------------------------------------------------------------
 *  Các hàm được cung cấp (đúng tên như source gốc gọi):
 *   SITE_ROOT_URL, BASE_URL, redirect, xss, check_string, check_email,
 *   gettime, format_cash, myip, random, randomnick, telegramRequest,
 *   templateTele, sendTele, notiTele, PlusCredits, RemoveCredits,
 *   status_nick, status_report, premium, premium1, display_banned,
 *   timeAgo, display_online
 * ==================================================================
 */

/* Chặn truy cập trực tiếp file này qua URL */
if (!defined('IN_SITE')) {
    header('HTTP/1.1 403 Forbidden');
    die('The Request Not Found');
}

/* --------------------------------------------------------------
 * $VCD - đối tượng database dùng chung toàn site.
 * core/DB.php đã khai báo class DB và thường tạo sẵn $VCD.
 * Ở đây bảo đảm biến luôn tồn tại để các file view không bị
 * "Call to a member function on null".
 * -------------------------------------------------------------- */
if (!isset($VCD) || !($VCD instanceof DB)) {
    $VCD = new DB();
}

/* ==================================================================
 *  NHÓM 1: URL & ĐIỀU HƯỚNG
 * ================================================================== */

/**
 * Trả về URL gốc của website, luôn kết thúc bằng dấu "/"
 * Tự nhận diện http/https (kể cả khi chạy sau Cloudflare / proxy)
 * và tự nhận diện trường hợp site nằm trong thư mục con.
 */
function SITE_ROOT_URL()
{
    static $root = null;
    if ($root !== null) {
        return $root;
    }

    /* Ưu tiên cấu hình APP_URL trong .env nếu có */
    if (!empty($_ENV['APP_URL'])) {
        return $root = rtrim($_ENV['APP_URL'], '/') . '/';
    }
    if (!empty($_SERVER['APP_URL'])) {
        return $root = rtrim($_SERVER['APP_URL'], '/') . '/';
    }

    /* Nhận diện HTTPS: hỗ trợ cả reverse proxy / Cloudflare */
    $https = false;
    if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        $https = true;
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])
        && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
        $https = true;
    } elseif (!empty($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443) {
        $https = true;
    }

    $scheme = $https ? 'https' : 'http';
    $host   = !empty($_SERVER['HTTP_HOST'])
        ? $_SERVER['HTTP_HOST']
        : (!empty($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'localhost');

    /* Xác định thư mục con (nếu site không nằm ở gốc domain) */
    $base = '';
    if (!empty($_SERVER['DOCUMENT_ROOT'])) {
        $docRoot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));
        $appRoot = str_replace('\\', '/', realpath(dirname(__DIR__)));
        if ($docRoot && $appRoot && strpos($appRoot, $docRoot) === 0) {
            $base = trim(substr($appRoot, strlen($docRoot)), '/');
        }
    }

    $root = $scheme . '://' . $host . '/' . ($base !== '' ? $base . '/' : '');
    return $root;
}

/**
 * Ghép đường dẫn vào URL gốc.
 * Ví dụ: BASE_URL('client/login') -> https://domain.com/client/login
 */
function BASE_URL($path = '')
{
    return SITE_ROOT_URL() . ltrim((string) $path, '/');
}

/**
 * Chuyển hướng trang. Nếu header đã gửi thì dùng javascript thay thế
 * (tránh lỗi "Cannot modify header information").
 */
function redirect($url)
{
    if (!headers_sent()) {
        header('Location: ' . $url);
        exit();
    }
    die('<script>location.href=' . json_encode((string) $url) . ';</script>');
}

/* ==================================================================
 *  NHÓM 2: LÀM SẠCH & KIỂM TRA DỮ LIỆU
 * ================================================================== */

/**
 * Chống XSS: loại bỏ thẻ HTML và escape ký tự đặc biệt.
 * Hỗ trợ cả mảng (đệ quy).
 */
function xss($str)
{
    if (is_array($str)) {
        $out = array();
        foreach ($str as $k => $v) {
            $out[$k] = xss($v);
        }
        return $out;
    }
    if ($str === null) {
        return '';
    }
    return htmlspecialchars(strip_tags(trim((string) $str)), ENT_QUOTES, 'UTF-8');
}

/**
 * Làm sạch chuỗi trước khi ghép vào câu SQL (chống SQL Injection).
 * Ưu tiên dùng mysqli_real_escape_string qua $VCD->escape().
 */
function check_string($str)
{
    global $VCD;

    if ($str === null) {
        return '';
    }
    $str = trim((string) $str);

    if (isset($VCD) && is_object($VCD) && method_exists($VCD, 'escape')) {
        return $VCD->escape($str);
    }
    return addslashes($str);
}

/** Kiểm tra email hợp lệ */
function check_email($email)
{
    return (bool) filter_var(trim((string) $email), FILTER_VALIDATE_EMAIL);
}

/* ==================================================================
 *  NHÓM 3: THỜI GIAN & ĐỊNH DẠNG
 * ================================================================== */

/**
 * Thời gian hiện tại theo định dạng đang dùng trong database
 * (xem sellgame.sql: "2025/02/01 15:33:38")
 */
function gettime()
{
    return date('Y/m/d H:i:s');
}

/** Định dạng số tiền kiểu Việt Nam: 1000000 -> 1.000.000 */
function format_cash($money)
{
    return number_format((float) $money, 0, ',', '.');
}

/**
 * Hiển thị "x giây/phút/giờ/ngày trước"
 * (khai báo TRƯỚC display_online vì hàm đó gọi tới)
 */
function timeAgo($timestamp)
{
    $timestamp = (int) $timestamp;
    if ($timestamp <= 0) {
        return 'Chưa xác định';
    }

    $diff = time() - $timestamp;
    if ($diff < 0) {
        $diff = 0;
    }

    if ($diff < 60) {
        return $diff . ' giây trước';
    }
    if ($diff < 3600) {
        return floor($diff / 60) . ' phút trước';
    }
    if ($diff < 86400) {
        return floor($diff / 3600) . ' giờ trước';
    }
    if ($diff < 2592000) {
        return floor($diff / 86400) . ' ngày trước';
    }
    if ($diff < 31536000) {
        return floor($diff / 2592000) . ' tháng trước';
    }
    return floor($diff / 31536000) . ' năm trước';
}

/** Hiển thị trạng thái online (còn hoạt động trong 5 phút) */
function display_online($timeSession)
{
    $timeSession = (int) $timeSession;
    if ($timeSession > 0 && (time() - $timeSession) <= 300) {
        return '<span class="text-green-500 font-medium">Đang hoạt động</span>';
    }
    return '<span class="text-slate-500">' . timeAgo($timeSession) . '</span>';
}

/* ==================================================================
 *  NHÓM 4: MẠNG & CHUỖI NGẪU NHIÊN
 * ================================================================== */

/** Lấy IP thật của khách (hỗ trợ Cloudflare / proxy) */
function myip()
{
    $keys = array(
        'HTTP_CF_CONNECTING_IP',
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR',
    );

    foreach ($keys as $key) {
        if (empty($_SERVER[$key])) {
            continue;
        }
        foreach (explode(',', $_SERVER[$key]) as $ip) {
            $ip = trim($ip);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
}

/** Sinh chuỗi ngẫu nhiên */
function random($characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', $length = 6)
{
    $length = max(1, (int) $length);
    $max    = strlen($characters) - 1;
    if ($max < 0) {
        return '';
    }

    $out = '';
    for ($i = 0; $i < $length; $i++) {
        if (function_exists('random_int')) {
            try {
                $out .= $characters[random_int(0, $max)];
                continue;
            } catch (Throwable $e) {
                /* rơi xuống mt_rand */
            }
        }
        $out .= $characters[mt_rand(0, $max)];
    }
    return $out;
}

/** Sinh nickname ngẫu nhiên (mặc định 3 ký tự in hoa) */
function randomnick($characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', $length = 3)
{
    return random($characters, $length);
}

/* ==================================================================
 *  NHÓM 5: TELEGRAM
 * ================================================================== */

/**
 * Gửi 1 request tới Telegram Bot API.
 * Luôn bọc an toàn: lỗi mạng KHÔNG được làm sập website.
 */
function telegramRequest($token, $chatId, $message)
{
    $token  = trim((string) $token);
    $chatId = trim((string) $chatId);

    if ($token === '' || $chatId === '' || trim((string) $message) === '') {
        return false;
    }
    if (!function_exists('curl_init')) {
        return false;
    }

    $ch = curl_init('https://api.telegram.org/bot' . $token . '/sendMessage');
    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_TIMEOUT        => 5,
        CURLOPT_CONNECTTIMEOUT => 3,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_POSTFIELDS     => array(
            'chat_id'                  => $chatId,
            'text'                     => $message,
            'parse_mode'               => 'HTML',
            'disable_web_page_preview' => true,
        ),
    ));
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

/** Bọc nội dung thông báo kèm tên site + thời gian + IP */
function templateTele($message)
{
    global $VCD;

    $title = 'Website';
    if (isset($VCD) && is_object($VCD) && method_exists($VCD, 'site')) {
        $siteTitle = $VCD->site('title');
        if (!empty($siteTitle)) {
            $title = $siteTitle;
        }
    }

    return "<b>" . $title . "</b>\n"
        . "------------------------\n"
        . $message . "\n"
        . "------------------------\n"
        . "Thời gian: " . gettime() . "\n"
        . "IP: " . myip();
}

/** Gửi thông báo cho ADMIN (dùng token_telegram + chat_id_telegram) */
function sendTele($message)
{
    global $VCD;

    if (!isset($VCD) || !is_object($VCD) || !method_exists($VCD, 'site')) {
        return false;
    }

    $token  = $VCD->site('token_telegram');
    $chatId = $VCD->site('chat_id_telegram');

    return telegramRequest($token, $chatId, templateTele($message));
}

/** Gửi thông báo cho KHÁCH HÀNG (theo telegram id của user) */
function notiTele($message, $chatId = '')
{
    global $VCD;

    if (!isset($VCD) || !is_object($VCD) || !method_exists($VCD, 'site')) {
        return false;
    }

    $token = $VCD->site('token_bot_tele');
    if (empty($token)) {
        $token = $VCD->site('token_telegram');
    }
    if ($chatId === '' || $chatId === null) {
        $chatId = $VCD->site('chat_id_telegram');
    }

    return telegramRequest($token, $chatId, $message);
}

/* ==================================================================
 *  NHÓM 6: SỐ DƯ TÀI KHOẢN
 * ================================================================== */

/** Cộng tiền cho user + ghi log giao dịch */
function PlusCredits($userId, $amount, $reason = '')
{
    global $VCD;

    $userId = (int) $userId;
    $amount = (float) $amount;
    if ($userId <= 0 || $amount <= 0) {
        return false;
    }

    $user = $VCD->get_row("SELECT * FROM `users` WHERE `id` = '" . $userId . "' ");
    if (!$user) {
        return false;
    }

    $before = (float) (isset($user['money']) ? $user['money'] : 0);
    $after  = $before + $amount;

    $VCD->update('users', array(
        'money'       => $after,
        'total_money' => (float) (isset($user['total_money']) ? $user['total_money'] : 0) + $amount,
    ), " `id` = '" . $userId . "' ");

    $VCD->insert('log_balance', array(
        'user_id'       => $userId,
        'username'      => isset($user['username']) ? $user['username'] : '',
        'money'         => $amount,
        'money_before'  => $before,
        'money_after'   => $after,
        'type'          => 'plus',
        'note'          => $reason,
        'time'          => gettime(),
    ));

    return true;
}

/** Trừ tiền của user + ghi log giao dịch */
function RemoveCredits($userId, $amount, $reason = '')
{
    global $VCD;

    $userId = (int) $userId;
    $amount = (float) $amount;
    if ($userId <= 0 || $amount <= 0) {
        return false;
    }

    $user = $VCD->get_row("SELECT * FROM `users` WHERE `id` = '" . $userId . "' ");
    if (!$user) {
        return false;
    }

    $before = (float) (isset($user['money']) ? $user['money'] : 0);
    $after  = $before - $amount;

    $VCD->update('users', array(
        'money' => $after,
    ), " `id` = '" . $userId . "' ");

    $VCD->insert('log_balance', array(
        'user_id'       => $userId,
        'username'      => isset($user['username']) ? $user['username'] : '',
        'money'         => $amount,
        'money_before'  => $before,
        'money_after'   => $after,
        'type'          => 'minus',
        'note'          => $reason,
        'time'          => gettime(),
    ));

    return true;
}

/* ==================================================================
 *  NHÓM 7: HIỂN THỊ TRẠNG THÁI (BADGE)
 * ================================================================== */

/** Trạng thái nick game */
function status_nick($status)
{
    switch ((string) $status) {
        case '0':
            return '<span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-yellow-100 border-transparent text-yellow-500">Chờ xử lý</span>';
        case '1':
            return '<span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-green-100 border-transparent text-green-500">Còn hàng</span>';
        case '2':
            return '<span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-slate-100 border-transparent text-slate-500">Đã bán</span>';
        case '3':
            return '<span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-red-100 border-transparent text-red-500">Đã huỷ</span>';
        default:
            return '<span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-slate-100 border-transparent text-slate-500">Không rõ</span>';
    }
}

/** Trạng thái báo cáo / khiếu nại */
function status_report($status)
{
    switch ((string) $status) {
        case '0':
            return '<span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-yellow-100 border-transparent text-yellow-500">Đang chờ duyệt</span>';
        case '1':
            return '<span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-green-100 border-transparent text-green-500">Đã duyệt</span>';
        case '2':
            return '<span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-red-100 border-transparent text-red-500">Từ chối</span>';
        default:
            return '<span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-slate-100 border-transparent text-slate-500">Không rõ</span>';
    }
}

/** Nhãn tài khoản Premium (dạng badge) */
function premium($value)
{
    if ((string) $value === '1' || $value === true || strtolower((string) $value) === 'true') {
        return '<span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-purple-100 border-transparent text-purple-500">Có</span>';
    }
    return '<span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-slate-100 border-transparent text-slate-500">Không</span>';
}

/** Nhãn Premium (dạng chữ, dùng trong bảng danh sách nick) */
function premium1($value)
{
    if ((string) $value === '1' || $value === true || strtolower((string) $value) === 'true') {
        return '<span class="text-purple-500 font-medium">Có</span>';
    }
    return '<span class="text-slate-500">Không</span>';
}

/** Nhãn trạng thái khoá tài khoản */
function display_banned($banned)
{
    if ((string) $banned === '0' || $banned === '' || $banned === null) {
        return '<span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-green-100 border-transparent text-green-500">Hoạt động</span>';
    }
    return '<span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-red-100 border-transparent text-red-500">Đã khoá</span>';
}

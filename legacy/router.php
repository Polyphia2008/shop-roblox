<?php
/**
 * router.php - CHỈ DÙNG CHO MÔI TRƯỜNG PREVIEW / DEV (php -S)
 * ---------------------------------------------------------------
 * File này KHÔNG cần thiết khi chạy trên hosting Apache/LiteSpeed thật
 * (lúc đó .htaccess sẽ lo phần rewrite). Nó mô phỏng lại CHÍNH XÁC các
 * RewriteRule trong .htaccess để xem trước source bằng PHP built-in server.
 *
 * .htaccess đã chặn truy cập trực tiếp file này (router\.php nằm trong
 * danh sách file cấm) nên upload lên hosting vẫn an toàn.
 */

$uri  = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$uri  = urldecode((string) $uri);
$path = ltrim($uri, '/');

/* ==================================================================
 * 1) Chặn file / thư mục nhạy cảm (mô phỏng <FilesMatch> + [F,L])
 * ================================================================== */
$blockFile = '#(^|/)(\.env.*|\.htaccess|\.htpasswd|\.gitignore|error_log|composer\.(json|lock)|router\.php|ecosystem\.config\.cjs)$#i';
$blockExt  = '#\.(sql|zip|tar|gz|bak|log|ini|sh|lock|md)$#i';
$blockDir  = '#^(core|vendor|cron)(/|$)#i';

if (preg_match($blockFile, $path)
    || preg_match($blockExt, $path)
    || preg_match($blockDir, $path)
    || preg_match('#(^|/)\.git(/|$)#i', $path)) {
    http_response_code(403);
    header('Content-Type: text/html; charset=UTF-8');
    echo '<h1>403 Forbidden</h1><p>You don\'t have permission to access this resource.</p>';
    return true;
}

/* ==================================================================
 * 2) RewriteCond %{REQUEST_FILENAME} -f [OR] -d  =>  RewriteRule ^ - [L]
 *    File / thư mục thật thì phục vụ trực tiếp
 * ================================================================== */
$full = __DIR__ . '/' . $path;

if ($path !== '' && is_file($full)) {
    if (preg_match('#\.php$#i', $path)) {
        require $full;      // vd: /404.php, /update.php, /ajaxs/*.php
        return true;
    }
    return false;           // asset: css / js / img / font ...
}

/* DirectoryIndex index.php index.html */
if ($path !== '' && is_dir($full)) {
    $dir = rtrim($full, '/');
    foreach (array('index.php', 'index.html') as $idx) {
        if (is_file($dir . '/' . $idx)) {
            if ($idx === 'index.php') {
                require $dir . '/index.php';
                return true;
            }
            return false;
        }
    }
    /* Options -Indexes  =>  không liệt kê thư mục */
    http_response_code(403);
    echo '<h1>403 Forbidden</h1>';
    return true;
}

/* Chuẩn hoá: bỏ dấu / ở cuối cho việc so khớp route */
$key = rtrim($path, '/');

/* Hàm dispatch tới front controller */
$dispatch = function ($module, $action, array $extra = array()) {
    $_GET['module'] = $module;
    $_GET['action'] = $action;
    foreach ($extra as $k => $v) {
        $_GET[$k] = $v;
    }
    $_REQUEST = array_merge($_REQUEST, $_GET);
    require __DIR__ . '/index.php';
    return true;
};

/* ==================================================================
 * 3) ROUTE ADMIN (khớp thứ tự trong .htaccess)
 * ================================================================== */
$adminParam = array(
    'bank-edit', 'user-edit', 'edit-nick-robux',
    'edit-order-robux', 'edit-order-history',
);
foreach ($adminParam as $act) {
    if (preg_match('#^admin/' . preg_quote($act, '#') . '/([A-Za-z0-9-]+)$#', $key, $m)) {
        return $dispatch('admin', $act, array('id' => $m[1]));
    }
}
if (preg_match('#^admin/([A-Za-z0-9-]+)$#', $key, $m)) {
    return $dispatch('admin', $m[1]);
}
if ($key === 'admin') {
    return $dispatch('admin', 'home');
}

/* ==================================================================
 * 4) ROUTE CLIENT
 * ================================================================== */
/* Trang thông báo / chính sách */
$policy = array('warranty-policy', 'use-bot', 'use-report', '2fa');
if (in_array($key, $policy, true)) {
    return $dispatch('client', $key);
}

/* Frontend có tham số */
if (preg_match('#^DownloadFile/([A-Za-z0-9-]+)$#', $key, $m)) {
    return $dispatch('client', 'DownloadFile', array('magd' => $m[1]));
}
if ($key === 'botcheck/notification') {
    return $dispatch('client', 'checkbot', array('id' => 'noti'));
}
if ($key === 'botcheck') {
    return $dispatch('client', 'checkbot');
}
if (preg_match('#^orders/([A-Za-z0-9-]+)$#', $key, $m)) {
    return $dispatch('client', 'orders', array('magd' => $m[1]));
}

/* Nhóm /auth/* */
$authMap = array(
    'auth/nick-game'     => 'nick-game',
    'auth/history-nick'  => 'history-nick',
    'auth/deposit'       => 'deposit',
    'auth/transaction'   => 'transaction',
    'auth/history-order' => 'history-order',
    'auth/profile'       => 'profile',
    'auth/logout'        => 'logout',
    'auth/register'      => 'register',
    'auth/login'         => 'login',
);
if (isset($authMap[$key])) {
    return $dispatch('client', $authMap[$key]);
}

/* /client/xxx  và  /client */
if (preg_match('#^client/([A-Za-z0-9-]+)$#', $key, $m)) {
    return $dispatch('client', $m[1]);
}
if ($key === 'client') {
    return $dispatch('client', 'home');
}

/* Trang chủ */
if ($key === '') {
    return $dispatch('client', 'home');
}

/* ==================================================================
 * 5) Không khớp route nào -> trả 404 (giống Apache ErrorDocument 404)
 * ================================================================== */
if (!defined('IN_SITE')) {
    define('IN_SITE', true);
}
http_response_code(404);
require __DIR__ . '/frontend/views/errors/404.php';
return true;

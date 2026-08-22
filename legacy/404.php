<?php
/**
 * 404.php (thư mục gốc)
 * ------------------------------------------------------------------
 * File này là đích của "ErrorDocument 404 /404.php" trong .htaccess.
 * Bản gốc KHÔNG có file này -> Apache trả về trang lỗi mặc định,
 * và trong một số cấu hình hosting còn gây lỗi 403/500 lồng nhau.
 * ------------------------------------------------------------------
 */
if (!defined('IN_SITE')) {
    define('IN_SITE', true);
}

http_response_code(404);

$view = __DIR__ . '/frontend/views/errors/404.php';
if (is_file($view) && filesize($view) > 0) {
    require_once($view);
} else {
    echo '<!DOCTYPE html><html lang="vi"><head><meta charset="utf-8">'
        . '<title>404 - Không tìm thấy trang</title></head><body>'
        . '<h1>404 - Không tìm thấy trang</h1></body></html>';
}

<?php
/**
 * index.php - Front controller
 * ------------------------------------------------------------------
 * ĐÃ SỬA:
 *  1. Chặn Directory Traversal: $module/$action lấy trực tiếp từ $_GET nên
 *     có thể bị lợi dụng dạng ?module=../../ để đọc file ngoài thư mục.
 *     Nay chỉ cho phép [A-Za-z0-9_-].
 *  2. Sửa đường dẫn trang 404: bản gốc trỏ tới 'resources/views/errors/404.php'
 *     -> thư mục này KHÔNG TỒN TẠI trong source, gây Fatal error
 *     "Failed opening required" mỗi khi vào 1 URL không hợp lệ.
 *     Nay trỏ đúng tới 'frontend/views/errors/404.php'.
 *  3. Trả đúng HTTP status 404 cho trang không tồn tại.
 *  4. Dùng __DIR__ khi kiểm tra file_exists (bản gốc dùng đường dẫn
 *     tương đối -> sai khi cwd khác thư mục gốc).
 * ------------------------------------------------------------------
 */

define("IN_SITE", true);

require_once(__DIR__ . '/core/DB.php');
require_once(__DIR__ . '/core/helpers.php');

$module = !empty($_GET['module']) ? $_GET['module'] : 'client';
$action = !empty($_GET['action']) ? $_GET['action'] : 'home';

/* Chỉ cho phép ký tự an toàn -> chống directory traversal (../) */
$module = preg_replace('/[^A-Za-z0-9_-]/', '', (string) $module);
$action = preg_replace('/[^A-Za-z0-9_-]/', '', (string) $action);

if ($module === '') {
    $module = 'client';
}
if ($action === '') {
    $action = 'home';
}

$path = __DIR__ . "/frontend/views/$module/$action.php";

if (is_file($path)) {
    require_once($path);
    exit();
}

/* Trang không tồn tại -> hiển thị 404 */
http_response_code(404);

$notFound = __DIR__ . '/frontend/views/errors/404.php';
if (is_file($notFound) && filesize($notFound) > 0) {
    require_once($notFound);
} else {
    echo '<!DOCTYPE html><html lang="vi"><head><meta charset="utf-8">'
        . '<title>404 - Không tìm thấy trang</title></head><body>'
        . '<h1>404 - Không tìm thấy trang</h1></body></html>';
}
exit();

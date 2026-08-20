<?php
/**
 * frontend/views/errors/404.php
 * ------------------------------------------------------------------
 * SỬA LỖI: file gốc RỖNG (0 byte). Kết hợp với việc index.php trỏ sai
 * đường dẫn ('resources/views/errors/404.php' không tồn tại), mọi URL
 * không hợp lệ đều gây Fatal error thay vì hiển thị trang 404.
 * ------------------------------------------------------------------
 */
if (!defined('IN_SITE')) {
    header('HTTP/1.1 403 Forbidden');
    die('The Request Not Found');
}

$homeUrl = function_exists('BASE_URL') ? BASE_URL('') : '/';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Không tìm thấy trang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="<?= BASE_URL('public') ?>/assets/vendor/css/fontawesome6.min.css" rel="stylesheet">
</head>
<body class="bg-slate-900 text-slate-200 min-h-screen flex items-center justify-center px-4">
    <main id="error-page" class="text-center max-w-lg">
        <p class="text-7xl md:text-9xl font-extrabold text-red-500 tracking-tight">404</p>

        <h1 class="mt-4 text-2xl md:text-3xl font-bold text-white">
            Không tìm thấy trang
        </h1>

        <p class="mt-3 text-slate-400">
            Đường dẫn bạn truy cập không tồn tại, đã bị đổi tên hoặc đã bị xoá.
        </p>

        <nav class="mt-8 flex flex-wrap gap-3 justify-center">
            <a href="<?= htmlspecialchars($homeUrl, ENT_QUOTES, 'UTF-8'); ?>"
               id="back-home-link"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-md bg-red-500 hover:bg-red-600 text-white font-medium transition">
                <i class="fas fa-home"></i> Về trang chủ
            </a>
            <button type="button"
                    id="go-back-button"
                    onclick="history.back()"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-md border border-slate-600 hover:bg-slate-800 text-slate-200 font-medium transition">
                <i class="fas fa-arrow-left"></i> Quay lại
            </button>
        </nav>
    </main>
</body>
</html>

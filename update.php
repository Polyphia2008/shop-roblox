<?php
/**
 * ==================================================================
 *  update.php - ĐÃ THAY THẾ BẢN MÃ HOÁ ionCube
 * ------------------------------------------------------------------
 *  File gốc bị mã hoá bằng ionCube Encoder giống core/helpers.php.
 *  Nó là chức năng "tự động cập nhật mã nguồn": tải bản mới từ máy
 *  chủ của tác giả rồi tự ghi đè file trong hosting.
 *
 *  KHÔNG THỂ và KHÔNG NÊN phục hồi chức năng này, vì:
 *   1. Cần ionCube Loader mới chạy được -> chính là nguyên nhân
 *      gây lỗi 403 / trắng trang trên hosting không có extension này.
 *   2. Nó tải và thực thi code từ máy chủ bên thứ ba, kèm khoá bản
 *      quyền (key_ban_quyen). Đây là rủi ro bảo mật rất lớn: nếu máy
 *      chủ đó bị chiếm, toàn bộ website của bạn bị chiếm theo.
 *   3. Mã nguồn giờ đã nằm trên Git -> cập nhật bằng git pull an toàn
 *      và minh bạch hơn nhiều.
 *
 *  File này nay chỉ là trang thông báo, CHỈ ADMIN xem được.
 * ==================================================================
 */

define('IN_SITE', true);

require_once(__DIR__ . '/core/DB.php');
require_once(__DIR__ . '/core/helpers.php');
require_once(__DIR__ . '/core/is_user.php');

/* Chỉ cho admin truy cập */
CheckLogin();
CheckAdmin();

$version = 'không xác định';
if (is_file(__DIR__ . '/version.php')) {
    $content = file_get_contents(__DIR__ . '/version.php');
    if (preg_match('/[\'"]?version[\'"]?\s*=>?\s*[\'"]([^\'"]+)[\'"]/i', $content, $m)) {
        $version = $m[1];
    } elseif (preg_match('/\$version\s*=\s*[\'"]([^\'"]+)[\'"]/i', $content, $m)) {
        $version = $m[1];
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật mã nguồn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-900 text-slate-200 min-h-screen flex items-center justify-center px-4 py-10">
    <main id="update-notice" class="w-full max-w-2xl bg-slate-800 rounded-xl border border-slate-700 p-6 md:p-8">
        <header class="flex items-start gap-4">
            <span class="shrink-0 w-12 h-12 rounded-lg bg-amber-500/10 text-amber-400 flex items-center justify-center text-xl">
                <i class="fas fa-triangle-exclamation"></i>
            </span>
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-white">
                    Tự động cập nhật đã được vô hiệu hoá
                </h1>
                <p class="mt-1 text-sm text-slate-400">
                    Phiên bản hiện tại: <span class="font-mono text-slate-200"><?= htmlspecialchars($version, ENT_QUOTES, 'UTF-8'); ?></span>
                </p>
            </div>
        </header>

        <section class="mt-6 space-y-4 text-sm leading-relaxed text-slate-300">
            <p>
                File <code class="px-1.5 py-0.5 rounded bg-slate-900 text-amber-300">update.php</code>
                gốc bị mã hoá bằng <strong>ionCube Encoder</strong>. Đây chính là một trong
                các nguyên nhân khiến website báo lỗi
                <strong class="text-red-400">403 Forbidden</strong> / trắng trang
                khi hosting không cài extension <em>ionCube Loader</em>.
            </p>

            <div class="rounded-lg bg-slate-900/70 border border-slate-700 p-4">
                <h2 class="font-semibold text-white mb-2">
                    <i class="fas fa-shield-halved mr-1 text-emerald-400"></i>
                    Vì sao không phục hồi chức năng này?
                </h2>
                <ul class="list-disc list-inside space-y-1 text-slate-400">
                    <li>Bắt buộc phải có ionCube Loader mới chạy được.</li>
                    <li>Tải và thực thi mã nguồn từ máy chủ bên thứ ba — rủi ro bảo mật cao.</li>
                    <li>Có thể ghi đè các bản sửa lỗi bạn vừa thực hiện.</li>
                </ul>
            </div>

            <div class="rounded-lg bg-slate-900/70 border border-slate-700 p-4">
                <h2 class="font-semibold text-white mb-2">
                    <i class="fas fa-code-branch mr-1 text-sky-400"></i>
                    Cách cập nhật an toàn
                </h2>
                <pre class="mt-1 overflow-x-auto text-xs text-emerald-300 bg-black/40 rounded p-3">git pull origin main</pre>
                <p class="mt-2 text-slate-400">
                    Hoặc tải file .zip mới rồi upload lại qua File Manager của cPanel.
                </p>
            </div>
        </section>

        <footer class="mt-6 pt-5 border-t border-slate-700">
            <a href="<?= htmlspecialchars(BASE_URL('admin'), ENT_QUOTES, 'UTF-8'); ?>"
               id="back-admin-link"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-md bg-sky-500 hover:bg-sky-600 text-white font-medium transition">
                <i class="fas fa-arrow-left"></i> Về trang quản trị
            </a>
        </footer>
    </main>
</body>
</html>

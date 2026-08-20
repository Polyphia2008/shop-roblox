# Shop Roblox — Web bán tài khoản game (sell-game / tgdev)

Mã nguồn PHP + MySQL bán tài khoản Roblox / Robux, **đã được sửa toàn bộ lỗi
403 Forbidden và các lỗi tương thích PHP 8**.

---

## 1. Tóm tắt: vì sao bản gốc bị lỗi 403 Forbidden?

Không phải một lỗi duy nhất, mà là **8 lỗi cộng dồn**. Dưới đây là danh sách
đầy đủ kèm cách khắc phục.

| # | Vấn đề | File | Hậu quả | Đã sửa |
|---|--------|------|---------|--------|
| 1 | **File bị mã hoá ionCube Encoder** | `core/helpers.php` | `index.php` require file này ở dòng 4 → thiếu ionCube Loader là **chết cả website** → 403 / 500 / trắng trang. **Đây là nguyên nhân số 1.** | Viết lại **toàn bộ 24 hàm** bằng PHP thuần |
| 2 | **Thiếu `DirectoryIndex`** | `.htaccess` | Apache/LiteSpeed không tự chọn `index.php`, kết hợp `Options -Indexes` → **403 ngay trang chủ** | Thêm `DirectoryIndex index.php index.html` |
| 3 | **Cú pháp Apache 2.2** (`Order Deny,Allow`, `satisfy all`) | `.htaccess` | Apache 2.4 không bật `mod_access_compat` → lỗi cú pháp → **500 toàn site** | Dùng song song cú pháp 2.2 + 2.4 qua `<IfModule>` |
| 4 | **`AddHandler ...ea-php74___lsphp`** của cPanel hosting cũ | `.htaccess` | Hosting mới không có package `ea-php74` → Apache không xử lý được `.php` → **403 hoặc tải file .php về máy** | Đã xoá |
| 5 | **`.env` bị đảo giá trị** (`DB_DATABASE=root`, `DB_USERNAME=sellgame`) | `.env` | `mysqli_connect()` thất bại → in `BẢO TRÌ HỆ THỐNG` | Đảo lại đúng thứ tự |
| 6 | **Trỏ sai đường dẫn trang 404** (`resources/views/errors/404.php` — thư mục không tồn tại) + file `frontend/views/errors/404.php` **rỗng 0 byte** + **không có `404.php` ở gốc** | `index.php` | Mọi URL không hợp lệ → Fatal error thay vì trang 404 | Sửa path, viết lại view 404, tạo `404.php` |
| 7 | **mysqli ném Exception từ PHP 8.1** — cú pháp `mysqli_connect(...) or die(...)` mất tác dụng | `core/DB.php` | `Uncaught mysqli_sql_exception` → **500** | `mysqli_report(MYSQLI_REPORT_OFF)` + kiểm tra thủ công |
| 8 | **`include($_SERVER['DOCUMENT_ROOT'].'/404')`** — thiếu đuôi `.php` | `frontend/views/admin/Header.php` | PHP Warning + trắng trang khi vào admin mà chưa đăng nhập | Trỏ đúng view 404 + trả HTTP 404 |

### Các lỗi lập trình khác đã sửa kèm

| Lỗi | File | Mô tả |
|-----|------|-------|
| Thiếu dấu cách trong SQL | `core/DB.php` | `'WHERE'.$where` → sinh `WHERE\`id\`=1` → câu lệnh luôn thất bại |
| `die('Câu truy vấn bị sai')` | `core/DB.php` | Một query lỗi làm sập cả trang → nay trả mảng rỗng |
| `->fetch_array()` trên `false` | `core/DB.php` | Fatal error khi query lỗi → nay null-safe |
| Charset `utf8` | `core/DB.php` | Không hiển thị đúng emoji → đổi `utf8mb4` |
| `session_start()` vô điều kiện | `core/DB.php` | Warning "session already started" → nay kiểm tra trước |
| **Directory Traversal** | `index.php` | `?module=../../` đọc được file ngoài thư mục → nay lọc `[A-Za-z0-9_-]` |
| Biến `$RateCode` chưa khai báo | `frontend/views/client/nick-game.php` | Dùng ở 3 chỗ nhưng chỉ khai báo trong `home.php` |
| `$getUser['email']` khi chưa login | `frontend/views/client/transaction.php` | "Trying to access array offset on null" |
| Sai biến vòng lặp | `frontend/views/client/home.php` (dòng 665) | Trong vòng `$accountrb2` lại dùng `$accountrb` → nút "Chi tiết" hỏng |
| Vòng lặp chuyển hướng HTTPS | `.htaccess` | Sau Cloudflare, `%{HTTPS}` luôn `off` → `ERR_TOO_MANY_REDIRECTS` → nay kiểm tra `X-Forwarded-Proto` |
| RewriteRule thiếu `$` và `[QSA]` | `.htaccess` | `^admin` khớp cả `/administrator`; mất query string; ảnh/CSS bị rewrite |
| Tự động cập nhật qua ionCube | `update.php` | Tải & chạy code từ máy chủ bên thứ ba → rủi ro bảo mật → thay bằng trang thông báo |

---

## 2. 24 hàm đã dựng lại trong `core/helpers.php`

Bản gốc bị mã hoá ionCube. Toàn bộ được viết lại bằng PHP thuần dựa trên
cách chúng được gọi trong source:

| Nhóm | Hàm |
|------|-----|
| URL & điều hướng | `SITE_ROOT_URL()`, `BASE_URL()`, `redirect()` |
| Làm sạch dữ liệu | `xss()`, `check_string()`, `check_email()` |
| Thời gian & định dạng | `gettime()`, `format_cash()`, `timeAgo()`, `display_online()` |
| Mạng & ngẫu nhiên | `myip()`, `random()`, `randomnick()` |
| Telegram | `telegramRequest()`, `templateTele()`, `sendTele()`, `notiTele()` |
| Số dư | `PlusCredits()`, `RemoveCredits()` |
| Hiển thị trạng thái | `status_nick()`, `status_report()`, `premium()`, `premium1()`, `display_banned()` |

> `class Bot` không cần dựng lại — nó được định nghĩa cục bộ trong
> `frontend/views/client/checkbot.php`.

---

## 3. Danh sách URL (route)

### Khách hàng
| URL | Chức năng |
|-----|-----------|
| `/` | Trang chủ |
| `/auth/login` | Đăng nhập |
| `/auth/register` | Đăng ký |
| `/auth/logout` | Đăng xuất |
| `/auth/profile` | Thông tin cá nhân |
| `/auth/deposit` | Nạp tiền |
| `/auth/transaction` | Lịch sử giao dịch |
| `/auth/nick-game` | Danh sách nick game |
| `/auth/history-nick` | Lịch sử mua nick |
| `/auth/history-order` | Lịch sử đơn hàng |
| `/orders/{magd}` | Chi tiết đơn hàng |
| `/DownloadFile/{magd}` | Tải file tài khoản đã mua |
| `/botcheck` | Kiểm tra bot |
| `/botcheck/notification` | Gửi thông báo qua bot |
| `/warranty-policy` | Chính sách bảo hành |
| `/use-bot` | Hướng dẫn dùng bot |
| `/use-report` | Hướng dẫn báo cáo |
| `/2fa` | Hướng dẫn 2FA |

### Quản trị (yêu cầu `level = 1`)
| URL | Chức năng |
|-----|-----------|
| `/admin` | Dashboard |
| `/admin/product` | Quản lý sản phẩm |
| `/admin/ListUsers` | Quản lý người dùng |
| `/admin/user-edit/{id}` | Sửa người dùng |
| `/admin/ListBank` | Quản lý ngân hàng |
| `/admin/bank-edit/{id}` | Sửa ngân hàng |
| `/admin/Setting` | Cấu hình website |
| `/admin/chuyen-muc` | Chuyên mục |
| `/admin/don-hang` | Đơn hàng |
| `/admin/nick-robux` · `/admin/add-nick-robux` · `/admin/edit-nick-robux/{id}` | Quản lý nick Robux |
| `/admin/order-robux` · `/admin/edit-order-robux/{id}` | Đơn Robux |
| `/admin/muc-rate` · `/admin/order-rate` | Mức rate |
| `/admin/history-order` · `/admin/edit-order-history/{id}` · `/admin/history-rb` | Lịch sử |
| `/admin/ticket` · `/admin/ticket-order` | Hỗ trợ / khiếu nại |
| `/update.php` | Thông báo tự động cập nhật đã tắt |

### API AJAX
`POST /ajaxs/client/*` — `login`, `register`, `muanick`, `muanick-game`,
`ordernick`, `changePassword`, `updatebank`, `Report`, `HuyReport`
`POST /ajaxs/admin/*` — `product`, `add_nick_robux`, `edit_nick_robux`,
`remove_robux`, `robuxorder`, `rateorder`, `add_mucrate`, `remove_mucrate`,
`chuyen-muc`, `removeUser`, `removeBank`, `remove_ticket`

---

## 4. Cấu trúc dữ liệu

**Hệ quản trị:** MySQL / MariaDB — charset `utf8mb4_unicode_ci`
**Schema:** `sellgame.sql` (17 bảng)

| Bảng | Nội dung |
|------|----------|
| `users` | Người dùng (`level=1` là admin), số dư, token, trạng thái khoá |
| `accountrb` | Kho nick Robux (rate, robux, giá, premium, bảo hành) |
| `accountorder` | Đơn hàng nick |
| `product_nick` | Sản phẩm nick game |
| `orders` | Đơn hàng chung |
| `chuyenmuc` | Chuyên mục sản phẩm |
| `mucrate` · `rateorder` | Mức rate & đơn theo rate |
| `bank` · `bank_auto` | Ngân hàng & nạp tự động |
| `cards` · `don_nap` · `dongtien` | Thẻ, đơn nạp, dòng tiền |
| `log_balance` · `logs` | Log số dư & hệ thống |
| `settings` | Cấu hình site (36 khoá: title, telegram token…) |
| `ticket` | Hỗ trợ / khiếu nại |

---

## 5. Hướng dẫn cài lên hosting (cPanel)

```bash
# 1. Upload toàn bộ source vào public_html/
# 2. Tạo database trong cPanel > MySQL Databases
# 3. Import file sellgame.sql qua phpMyAdmin
#    (chọn charset utf8mb4 để tiếng Việt không bị lỗi ???)
# 4. Sao chép cấu hình mẫu rồi điền thông tin database
cp .env.example .env
```

Nội dung `.env` cần sửa:

```env
DB_HOST=localhost
DB_DATABASE=ten_database      # ĐÚNG: tên database
DB_USERNAME=ten_user          # ĐÚNG: tên user
DB_PASSWORD=mat_khau
APP_URL=                      # để trống, hoặc https://tenmien.com
```

**5. Chọn phiên bản PHP:** cPanel → *Select PHP Version* → **PHP 7.4 – 8.2**
(khuyến nghị 8.1). **Tuyệt đối không** thêm lại dòng `AddHandler ...ea-php74`
vào `.htaccess`.

**6. Bật extension:** `mysqli`, `mbstring`, `curl`, `openssl`
→ **không cần ionCube Loader nữa.**

**7. Đăng nhập admin:** dùng tài khoản có `level = 1` trong bảng `users`
(schema mẫu có `admin` / `thegioidev@gmail.com`).
**Hãy đổi mật khẩu ngay sau khi cài xong.**

### Nếu vẫn gặp 403 sau khi cài

```bash
# Phân quyền chuẩn cho shared hosting
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
```

Nếu hosting quá cũ, thử tạm đổi tên `.htaccess` thành `.htaccess.bak`
để xác nhận lỗi có đến từ Apache config hay không.

---

## 6. Chạy thử ở môi trường local

```bash
# Cần: PHP >= 7.4 (kèm mysqli, mbstring, curl) + MySQL/MariaDB
mysql -e "CREATE DATABASE sellgame CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql --default-character-set=utf8mb4 sellgame < sellgame.sql

# router.php mô phỏng các RewriteRule của .htaccess
php -S localhost:3000 router.php
```

> `router.php` và `ecosystem.config.cjs` **chỉ dùng cho môi trường dev**.
> Trên hosting thật, `.htaccess` đảm nhiệm — và cả hai file này đã được
> `.htaccess` chặn truy cập từ bên ngoài.

---

## 7. Ghi chú bảo mật

- ✅ `.env` đã nằm trong `.gitignore` — **không bao giờ commit mật khẩu**
- ✅ `.htaccess` chặn truy cập `core/`, `vendor/`, `cron/`, `.env`, `*.sql`, `error_log`
- ✅ Đã bịt lỗ Directory Traversal trong `index.php`
- ✅ Đã tắt tính năng tự động cập nhật (tải & chạy code từ bên thứ ba)
- ⚠️ Source gốc ghép chuỗi trực tiếp vào câu SQL ở nhiều nơi. `check_string()`
  đã dùng `mysqli_real_escape_string`, nhưng nên chuyển dần sang
  **prepared statement** để an toàn tuyệt đối.
- ⚠️ **Hãy đổi mật khẩu tài khoản admin mẫu** trong `sellgame.sql`.

---

## 8. Trạng thái

| | |
|---|---|
| **Nền tảng** | PHP + MySQL (Apache / LiteSpeed) |
| **PHP** | 7.4 → 8.4 (đã kiểm tra trên 8.4) |
| **Lint** | 82 file PHP — **0 lỗi cú pháp** |
| **Runtime** | **0 PHP Warning / Notice / Fatal** trên mọi route |
| **ionCube** | ❌ **Không còn cần thiết** |
| **Repo** | https://github.com/Polyphia2008/shop-roblox |
| **Preview (tạm thời)** | https://3000-ip4grk9ihqlgu7vx1jtvr-8f57ffe2.sandbox.novita.ai |

### Kết quả kiểm thử

| Nhóm | Kết quả |
|------|---------|
| 18 route khách hàng | ✅ HTTP 200 |
| 18 route quản trị | ✅ HTTP 200 (khi đã đăng nhập admin) |
| URL không tồn tại | ✅ HTTP 404 (đúng chuẩn, trước đây trả 200 hoặc Fatal error) |
| `.env`, `core/`, `vendor/`, `cron/`, `*.sql`, `error_log`, `.git/` | ✅ HTTP 403 (bị chặn) |
| Directory Traversal (`?module=../../`) | ✅ HTTP 404 (bị chặn) |
| PHP Warning / Notice / Fatal | ✅ **0 lỗi** trên toàn bộ route |

> ⚠️ Đây là ứng dụng PHP truyền thống, **không thể** deploy lên
> Cloudflare Pages/Workers. Cần hosting hỗ trợ PHP + MySQL.

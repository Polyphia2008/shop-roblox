# Shop Roblox — Bản viết lại trên Laravel 13

Viết lại toàn bộ shop bán tài khoản Roblox từ mã PHP thuần (thư mục `legacy/`)
sang **Laravel 13**, với mục tiêu chính là **chặn SQL injection** và các lỗ hổng
bảo mật nghiêm trọng khác của bản gốc.

Mã nguồn cũ vẫn được giữ nguyên trong `legacy/` để đối chiếu — mỗi controller
mới đều có khối chú thích trích dẫn đúng câu SQL cũ mà nó thay thế.

---

## Mục lục

- [Vì sao phải viết lại](#vì-sao-phải-viết-lại)
- [Chống SQL injection: 3 lớp](#chống-sql-injection-3-lớp)
- [Các lỗ hổng khác đã xử lý](#các-lỗ-hổng-khác-đã-xử-lý)
- [Công nghệ sử dụng](#công-nghệ-sử-dụng)
- [Cài đặt](#cài-đặt)
- [Kiểm thử](#kiểm-thử)
- [Cấu trúc thư mục](#cấu-trúc-thư-mục)
- [Cấu hình bảo mật](#cấu-hình-bảo-mật)
- [Ghi chú vận hành](#ghi-chú-vận-hành)

---

## Vì sao phải viết lại

Bản gốc nối chuỗi trực tiếp dữ liệu người dùng vào câu SQL. Ví dụ thật trong
`legacy/ajaxs/client/login.php:24`:

```php
$getUser = $VCD->get_row(
    "SELECT * FROM `users` WHERE `email` = '$email' AND `password`='" . sha1($password) . "' "
);
```

Chỉ cần nhập email `' OR 1=1 -- ` là đăng nhập được vào tài khoản đầu tiên
trong bảng, thường chính là admin. Toàn bộ 60+ file `ajaxs/` đều theo khuôn
mẫu này.

Ba vấn đề trong đúng một dòng code trên:

| Vấn đề | Hậu quả |
|---|---|
| `$email` nối thẳng vào SQL | SQL injection → chiếm quyền admin |
| `sha1($password)` không muối | Rò rỉ DB là tra bảng rainbow ra mật khẩu ngay |
| So khớp mật khẩu ngay trong SQL | Không thể dùng hàm băm chậm, mở đường cho tấn công thời gian |

Hàm `xss()` mà bản gốc dùng để "làm sạch" chỉ escape HTML — **không** giúp gì
cho SQL. Cách tiếp cận "lọc rồi nối chuỗi" luôn có thể bị vượt qua; giải pháp
đúng duy nhất là **prepared statement**.

---

## Chống SQL injection: 3 lớp

Điểm quan trọng nhất cần hiểu: **lớp 1 mới là lớp bảo vệ thật**. Lớp 2 và 3
chỉ để phát hiện sớm và bịt phần mà lớp 1 về mặt kỹ thuật không thể bịt.

### Lớp 1 — Prepared statement (bảo vệ thật, luôn bật)

100% truy vấn đi qua Eloquent / Query Builder, nên mọi giá trị đều được bind
như **dữ liệu**, không bao giờ được hiểu là **mã**:

```php
// Giá trị được bind — payload quái dị đến đâu cũng chỉ là chuỗi tìm kiếm
$order = Order::query()
    ->where('magd', $magd)
    ->where('username', $request->user()->email)   // đồng thời chống IDOR
    ->firstOrFail();
```

Lớp này không thể tắt và không phụ thuộc bất kỳ cấu hình nào.

### Lớp 2 — Allow-list cho định danh (BẮT BUỘC)

PDO **không thể** bind tên bảng, tên cột hay chiều sắp xếp. Đây là chỗ duy
nhất prepared statement không cứu được, nên bắt buộc phải đối chiếu danh sách
cho phép:

```php
private const SORTABLE = ['id', 'money', 'soluong', 'created_at'];

$column    = SqlInjectionGuard::column($request->query('sort'), self::SORTABLE, 'id');
$direction = SqlInjectionGuard::direction($request->query('dir'), 'desc');

$orders = Order::query()->orderBy($column, $direction)->paginate(40);
```

Bất kỳ giá trị nào ngoài danh sách đều bị thay bằng mặc định an toàn — kể cả
`(SELECT password FROM users LIMIT 1)` hay `id; DROP TABLE users`.

### Lớp 3 — Phát hiện & ghi log (phòng thủ theo tầng)

`App\Security\SqlInjectionGuard` có 10 luật nhận diện (union-based, tautology,
stacked query, dò `information_schema`, `LOAD_FILE`, time-based blind…).
Trước khi so khớp, chuỗi được **chuẩn hoá** để không bị né bộ lọc bằng
URL-encode nhiều lớp, HTML entity, `\u0027`, comment `/**/` chèn giữa từ khoá,
hay NULL byte.

Middleware `DetectSqlInjection` quét query string, body và route parameter
(**kể cả tên tham số**, vì payload có thể nằm ở khoá), rồi:

- ghi vào bảng `security_events` + log channel `security`;
- trả về **403** nếu bật chế độ chặn.

Trang 403 **không** in ra payload hay tên luật đã khớp — nếu in, kẻ tấn công
sẽ biết chính xác bộ lọc nào bắt được mình để dò cách vượt qua.

> **Lưu ý thiết kế:** lớp 3 không "làm sạch chuỗi rồi nối vào SQL". Nó chỉ
> phát hiện và chặn. Nếu tắt lớp 3 (`SECURITY_SQLI_ENABLED=false`), ứng dụng
> **vẫn an toàn** nhờ lớp 1 — điều này được chứng minh bằng test tự động, xem
> phần [Kiểm thử](#kiểm-thử).

### Escape wildcard của LIKE

Không phải lỗ hổng inject, nhưng nếu bỏ qua thì gõ `%` sẽ khớp toàn bộ bảng:

```php
$safe = addcslashes($keyword, '%_\\');
$q->where('code', 'like', "%{$safe}%");
```

---

## Các lỗ hổng khác đã xử lý

| # | Lỗ hổng bản gốc | Cách xử lý |
|---|---|---|
| 1 | **Cổng admin bằng JavaScript**: `legacy/core/is_user.php:55` in ra `<script>location.href=...</script>` nhưng **vẫn render toàn bộ HTML trang admin**. Tắt JS hoặc dùng `curl` là đọc sạch trang quản trị. | Middleware `EnsureUserIsAdmin` chặn trước khi vào controller. Có test khẳng định phản hồi 403 **không chứa** một mảnh HTML admin nào. |
| 2 | **Mật khẩu `sha1()` không muối** | Cast `'hashed'` (bcrypt). Test kiểm tra hash khớp `/^\$2[axy]\$/`. |
| 3 | **IDOR**: xem đơn bằng `?magd=` mà không kiểm tra chủ sở hữu → đổi mã trên URL là tải được nick người khác. | Mọi truy vấn theo user đều kèm điều kiện sở hữu. Có test riêng cho kịch bản kẻ tấn công đoán đúng mã giao dịch. |
| 4 | **Không có CSRF**, xoá/sửa bằng link GET | Toàn bộ ghi dữ liệu dùng POST/PATCH/DELETE + CSRF token. |
| 5 | **Cộng tiền không transaction, không khoá bản ghi** → bấm duyệt 2 lần là cộng tiền 2 lần | `DB::transaction()` + `lockForUpdate()` + **đọc lại trạng thái sau khi khoá** rồi mới xử lý. |
| 6 | **Giá do client gửi lên** | Giá luôn đọc lại từ DB trong `PurchaseService`. |
| 7 | **Leo thang đặc quyền qua mass assignment** | `level`, `money`, `total_money`, `banned` **không** nằm trong `$fillable`; chỉ đổi được qua service tường minh. |
| 8 | **Token Telegram hardcode trong source** | Lưu trong `settings` (cast `encrypted`); giao diện admin **không bao giờ** hiển thị lại giá trị, chỉ báo "Đã cấu hình". |
| 9 | **Ghi thẳng mọi khoá `$_POST` vào bảng `settings`** → tạo/ghi đè bất kỳ khoá cấu hình nội bộ | Allow-list cố định 13 khoá; khoá lạ bị bỏ qua hoàn toàn. |
| 10 | **Mật khẩu/thẻ cào/token bank lưu dạng thô** | Cast `'encrypted'` cho thông tin nick, seri/pin thẻ, token ngân hàng. |
| 11 | **Chống brute-force sai logic** (`time_request` với điều kiện luôn đúng) | `RateLimiter` chuẩn của Laravel cho đăng nhập, đăng ký, mua hàng. |
| 12 | **Không đổi session ID sau đăng nhập** → session fixation | `session()->regenerate()` sau đăng nhập và sau khi đổi mật khẩu. |
| 13 | **XSS lưu trữ** qua nội dung admin cấu hình | Luôn in bằng `{{ }}`; không dùng `{!! !!}` ở bất kỳ đâu. Có test khẳng định `<script>` bị escape. |

---

## Công nghệ sử dụng

| Thành phần | Phiên bản | Ghi chú |
|---|---|---|
| Laravel | `^13.17` (chạy 13.26.1) | Bản mới nhất tại thời điểm viết |
| PHP | `^8.3` (chạy 8.4) | `declare(strict_types=1)` toàn bộ |
| Tailwind CSS | **4.1.8** (ghim cứng) | Khớp bản build tham chiếu; cấu hình CSS-first, **không** có `tailwind.config.js` |
| Vite | `^8.0` (Rolldown) | `manualChunks` dạng hàm |
| Alpine.js | `^3.16` | Bundle sẵn, **không** dùng CDN |
| lodash | `^4.18` | Tách thành chunk riêng |
| lazysizes | `^5.3` | Lazy-load ảnh: `class="lazyload" data-src="..."` |
| core-js | `^3.50` | Polyfill cho trình duyệt cũ |

Tailwind 4 dùng cú pháp mới: `@theme inline`, `@source`, `@utility`. Lưu ý
`@apply` **không** dùng được class khai báo trong `@layer components`, nên các
class nền tảng (`btn`, `badge`, `alert`) phải khai báo bằng `@utility`.

---

## Cài đặt

```bash
# 1. Phụ thuộc
composer install
npm install

# 2. Cấu hình
cp .env.example .env
php artisan key:generate

# 3. Cơ sở dữ liệu (mặc định SQLite; đổi DB_CONNECTION=mysql nếu cần)
touch database/database.sqlite
php artisan migrate

# 4. Biên dịch asset
npm run build      # hoặc: npm run dev
```

Chạy thử:

```bash
php artisan serve
```

---

## Kiểm thử

```bash
php artisan test
```

Kết quả thực tế: **141 test / 302 assertion — toàn bộ xanh.**

| Bộ test | Nội dung |
|---|---|
| `tests/Unit/SqlInjectionGuardTest.php` | 27 payload tấn công kinh điển; 8 kỹ thuật né bộ lọc (URL-encode 1–2 lớp, HTML entity, `\u`/`\x` escape, comment giữa từ khoá, NULL byte); **20 dữ liệu hợp lệ không được báo động sai**; allow-list cột/chiều sắp xếp; cắt log chống log injection. |
| `tests/Feature/SqlInjectionProtectionTest.php` | Middleware chặn & ghi log đúng luật. Quan trọng nhất: **TẮT hẳn bộ lọc** rồi bắn 7 payload phá hoại — DB vẫn nguyên vẹn, không ai leo thang đặc quyền. Chứng minh prepared statement là lớp bảo vệ thật. Thêm: ORDER BY không inject được, LIKE wildcard đã escape, chống mass assignment, mật khẩu được băm. |
| `tests/Feature/AccessControlTest.php` | 12 route admin × 2 kịch bản (khách / user thường), kèm khẳng định phản hồi 403 không lọt HTML admin. IDOR: kẻ tấn công biết đúng mã giao dịch vẫn bị chặn. Logout chỉ nhận POST. Session ID đổi sau đăng nhập. |
| `tests/Feature/ExampleTest.php` | 9 trang công khai render OK; header bảo mật có mặt; nội dung cấu hình bị escape thay vì thực thi. |

Test **độ chính xác** (không báo động sai) quan trọng ngang test độ nhạy: một
bộ lọc chặn cả `100% hài lòng` hay `Giá: 50.000đ - 100.000đ` sẽ bị admin tắt
đi, và khi đó nó bảo vệ được 0%.

### Hai lỗi thật do test phát hiện

1. **`components/flash.blade.php` tham chiếu `$errors` không kiểm tra `isset`.**
   `ShareErrorsFromSession` thuộc nhóm middleware `web`, chạy **sau** middleware
   toàn cục. Nên khi `DetectSqlInjection` render trang 403, biến `$errors` chưa
   tồn tại → trang 403 nổ thành **500 kèm stack trace**. Kẻ tấn công vừa biết
   mình bị phát hiện, vừa nhận thêm thông tin nội bộ.

2. **`UserFactory` dùng cột `name` không tồn tại** (bảng dùng `username`) →
   mọi feature test đều chết ngay từ dòng tạo dữ liệu.

---

## Cấu trúc thư mục

```
app/
├── Security/SqlInjectionGuard.php    # Bộ phát hiện + allow-list định danh
├── Http/
│   ├── Middleware/                   # DetectSqlInjection, SecurityHeaders,
│   │                                 # EnsureUserIsAdmin, EnsureUserIsNotBanned
│   ├── Requests/                     # Validation tách riêng (Auth, Client)
│   └── Controllers/
│       ├── Auth/                     # Đăng nhập, đăng ký
│       ├── Client/                   # 6 controller phía khách
│       └── Admin/                    # 8 controller phía quản trị
├── Models/                           # 18 model, $fillable allow-list,
│                                     # cast hashed/encrypted
└── Services/
    ├── BalanceService.php            # Cộng/trừ tiền: transaction + lock + sổ kép
    ├── PurchaseService.php           # Bán hàng: chống bán trùng, giá đọc từ DB
    └── NotificationService.php       # Telegram, token lấy từ cấu hình

resources/
├── css/app.css                       # Tailwind 4 CSS-first (@theme/@utility)
├── js/app.js                         # Alpine + lodash + lazysizes + core-js
└── views/
    ├── client/                       # 14 trang khách
    ├── admin/                        # 17 trang quản trị
    ├── layouts/, partials/, components/, errors/
    └── auth/

legacy/                               # Mã nguồn gốc, chỉ để đối chiếu
```

Thống kê: 17 controller, 18 model, 43 view, 4 middleware, 3 service, 5 migration,
**80 route** (giữ nguyên toàn bộ URL cũ để không vỡ link đã chia sẻ).

---

## Cấu hình bảo mật

Điều chỉnh qua `.env`, không cần sửa code (xem `config/security.php`):

```env
SECURITY_SQLI_ENABLED=true    # Bật lớp phát hiện (lớp 3)
SECURITY_SQLI_BLOCK=true      # true = trả 403; false = chỉ ghi log
SECURITY_CSP_ENABLED=true     # Content Security Policy

SECURITY_RL_LOGIN=5,1         # Đăng nhập: 5 lần / 1 phút
SECURITY_RL_REGISTER=3,10     # Đăng ký:   3 lần / 10 phút
SECURITY_RL_PURCHASE=10,1     # Mua hàng: 10 lần / 1 phút
SECURITY_RL_API=60,1          # API chung: 60 lần / 1 phút

SECURITY_LOG_CHANNEL=security # Kênh ghi log bảo mật
SECURITY_LOG_DAYS=90          # Số ngày giữ log

SECURITY_PWD_MIXED=true       # Bắt buộc hoa + thường + số + ký tự đặc biệt
SECURITY_PWD_UNCOMPROMISED=false  # Đối chiếu HaveIBeenPwned (cần gọi mạng)
```

Cú pháp giới hạn tần suất là `số_lần,số_phút`. `SECURITY_PWD_UNCOMPROMISED`
mặc định `false` vì nó gọi API bên ngoài — bật khi production có mạng ổn định.

Đặt `SECURITY_SQLI_BLOCK=false` khi mới lên production để quan sát log trước,
tránh chặn oan người dùng thật. Nhắc lại: **tắt các cờ này không làm ứng dụng
bị SQL injection**, vì lớp prepared statement luôn hoạt động.

Xem log tấn công:

```bash
php artisan tinker --execute="App\Models\SecurityEvent::latest()->take(20)->get()"
```

Hoặc vào trang **Nhật ký bảo mật** trong khu vực quản trị.

---

## Ghi chú vận hành

- **Cột không thể sửa qua giao diện**: trang cấu hình liệt kê các khoá tồn tại
  trong bảng `settings` nhưng nằm ngoài allow-list, để admin biết chúng cố ý
  không sửa được.
- **Token ngân hàng / Telegram**: ô nhập để trống nghĩa là **giữ nguyên** giá
  trị cũ. Ô nhập token bị `disabled` cho đến khi bấm "Đổi token" — input
  `disabled` không được submit, nhờ vậy lưu các mục khác không vô tình xoá token.
- **Ẩn đơn hàng** chỉ đổi cờ `display`, không xoá dữ liệu, để còn đối soát sổ sách.
- **Duyệt nạp tiền**: admin tự nhập số tiền **đã đối soát**, hệ thống không lấy
  số tiền khách khai báo.
- **Xoá bản ghi** bị chặn khi còn ràng buộc (chuyên mục còn hàng, nick đã bán).

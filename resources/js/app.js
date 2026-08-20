/**
 * ==================================================================
 *  app.js — điểm vào JavaScript
 * ------------------------------------------------------------------
 *  Thư viện theo yêu cầu:
 *    - core-js   : polyfill để chạy được trên trình duyệt cũ
 *    - lodash    : tiện ích xử lý dữ liệu (import lẻ cho nhẹ bundle)
 *    - lazysizes : lazy-load ảnh, tăng tốc tải trang
 *
 *  Toàn bộ được BUILD LOCAL bằng Vite — KHÔNG dùng CDN ngoài.
 *  Lý do: CDN ngoài vi phạm Content-Security-Policy đã bật, đồng thời
 *  từng gây lỗi "Mixed Content" và 429 Too Many Requests ở bản trước.
 * ==================================================================
 */

/* ------------------------------------------------------------------
 * 1) Polyfill — nạp ĐẦU TIÊN, trước mọi code khác
 * ---------------------------------------------------------------- */
import 'core-js/stable';

/* ------------------------------------------------------------------
 * 2) lazysizes — tự tải ảnh khi sắp lọt vào khung nhìn.
 *    Dùng trong Blade:
 *      <img data-src="/img/a.webp" class="lazyload" alt="...">
 * ---------------------------------------------------------------- */
import 'lazysizes';
import 'lazysizes/plugins/attrchange/ls.attrchange';

/* ------------------------------------------------------------------
 * 3) lodash — CHỈ import hàm cần dùng.
 *    `import _ from 'lodash'` kéo cả ~70kB gzip vào bundle;
 *    import lẻ như dưới đây chỉ tốn vài kB.
 * ---------------------------------------------------------------- */
import debounce from 'lodash/debounce';
import throttle from 'lodash/throttle';

/* ------------------------------------------------------------------
 * 4) axios — gọi API kèm CSRF token
 * ---------------------------------------------------------------- */
import axios from 'axios';

window.axios = axios;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/* Gắn CSRF token vào mọi request ghi dữ liệu.
   Bản gốc KHÔNG có CSRF -> kẻ tấn công có thể dụ người dùng đã đăng nhập
   bấm vào link để tự động mua hàng / đổi mật khẩu mà họ không hay biết. */
const csrf = document.head.querySelector('meta[name="csrf-token"]');

if (csrf) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrf.content;
}

/* ------------------------------------------------------------------
 * 5) Alpine.js — tương tác nhẹ trong Blade.
 *    Bản trước lỗi "Alpine is not defined" vì nạp Alpine qua CDN SAU
 *    khi HTML đã dùng x-data. Nay Alpine nằm trong bundle nên luôn có
 *    mặt trước khi DOM được xử lý.
 * ---------------------------------------------------------------- */
import Alpine from 'alpinejs';

window.Alpine = Alpine;

/* ------------------------------------------------------------------
 * 6) Tiện ích dùng chung
 * ---------------------------------------------------------------- */

/** Định dạng tiền Việt: 1000000 -> "1.000.000" */
export const formatCash = (value) => new Intl.NumberFormat('vi-VN').format(Number(value) || 0);

/** Sao chép văn bản vào clipboard, trả về true/false. */
export const copyText = async (text) => {
    try {
        await navigator.clipboard.writeText(text);
        return true;
    } catch {
        return false;
    }
};

/**
 * Ô tìm kiếm có debounce — tránh gửi request mỗi lần gõ 1 chữ.
 * Chờ 350ms sau lần gõ cuối mới gửi (dùng lodash/debounce).
 */
export const bindSearch = (input, onSearch, wait = 350) => {
    if (!input) return;
    input.addEventListener(
        'input',
        debounce((e) => onSearch(e.target.value.trim()), wait),
    );
};

/** Gắn xử lý cuộn có throttle — tối đa 1 lần / 200ms (dùng lodash/throttle). */
export const bindScroll = (handler, wait = 200) => {
    window.addEventListener('scroll', throttle(handler, wait), { passive: true });
};

/* Hiện/ẩn nút "lên đầu trang" khi cuộn quá 400px */
bindScroll(() => {
    const btn = document.getElementById('back-to-top');
    if (btn) {
        btn.classList.toggle('hidden', window.scrollY < 400);
    }
});

/* ------------------------------------------------------------------
 * 7) Chế độ tối — lưu lựa chọn vào localStorage
 * ---------------------------------------------------------------- */
const applyTheme = (theme) => {
    document.documentElement.classList.toggle('dark', theme === 'dark');
    localStorage.setItem('theme', theme);
};

window.toggleTheme = () =>
    applyTheme(document.documentElement.classList.contains('dark') ? 'light' : 'dark');

applyTheme(
    localStorage.getItem('theme') ??
        (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'),
);

/* Khởi động Alpine sau khi mọi thứ đã sẵn sàng */
Alpine.start();

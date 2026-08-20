/**
 * PostCSS — dùng @tailwindcss/postcss thay cho @tailwindcss/vite.
 *
 * Lý do: bản Tailwind cần dùng là 4.1.8 (khớp CHÍNH XÁC với bản build
 * tham chiếu https://license.thegioidev.com/assets/css/styles.css),
 * nhưng @tailwindcss/vite@4.1.8 chỉ hỗ trợ peer vite ^5 || ^6, trong khi
 * Laravel 13 đi kèm Vite 8. Plugin PostCSS không có ràng buộc đó nên ta
 * giữ được ĐÚNG Tailwind 4.1.8 mà vẫn dùng được Vite 8.
 */
export default {
    plugins: {
        '@tailwindcss/postcss': {},
        autoprefixer: {},
    },
};

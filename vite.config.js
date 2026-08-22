import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],

    build: {
        /* Tách vendor thành chunk riêng để trình duyệt cache lâu dài:
           lodash / core-js / alpine gần như không đổi giữa các lần deploy,
           nên không nên bắt người dùng tải lại khi ta chỉ sửa code app.

           LƯU Ý: Vite 8 dùng Rolldown, `manualChunks` BẮT BUỘC là hàm
           (truyền object sẽ lỗi "manualChunks is not a function"). */
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (!id.includes('node_modules')) return;
                    if (id.includes('lodash')) return 'lodash';
                    if (id.includes('core-js')) return 'polyfill';
                    if (/alpinejs|axios|lazysizes/.test(id)) return 'vendor';
                },
            },
        },
        chunkSizeWarningLimit: 600,
    },

    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});

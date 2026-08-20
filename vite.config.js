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
           nên không nên bắt người dùng tải lại khi ta chỉ sửa code app. */
        rollupOptions: {
            output: {
                manualChunks: {
                    lodash: ['lodash'],
                    polyfill: ['core-js'],
                    vendor: ['alpinejs', 'axios', 'lazysizes'],
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

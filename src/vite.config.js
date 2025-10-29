import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    server: {
        host: true,      // kontajner počúva na 0.0.0.0
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost', // browser sa pripája cez tvoj Windows -> localhost:5173
            port: 5173,
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
})

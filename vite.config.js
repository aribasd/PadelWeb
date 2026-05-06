import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    server: {
        // Windows: evita lentitud per IPv6/localhost ([::1]).
        host: '127.0.0.1',
        strictPort: true,
        // Força que el laravel-vite-plugin escrigui IPv4 a public/hot
        origin: 'http://127.0.0.1:5173',
        hmr: {
            host: '127.0.0.1',
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/react-entry.jsx',
            ],
            refresh: [
                'resources/views/**',
                'routes/**',
            ],
        }),
        react(),
    ],
});
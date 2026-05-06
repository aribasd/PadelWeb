import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    server: {
        // Windows/Laragon: evitar IPv6/localhost ([::1]) i quadrar amb el vhost .test
        host: '127.0.0.1',
        strictPort: true,
        // Important: quan navegues via http://padelweb.test, el browser ha de veure el mateix host/port
        origin: 'http://padelweb.test:5173',
        hmr: {
            host: 'padelweb.test',
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/react-entry.jsx',
            ],
            // En Windows/Laragon, mirar tots els Blade provoca recàrregues completes
            // i fa que l'IDE/terminal se sentin pesats quan edites vistes.
            refresh: false,
        }),
        react(),
    ],
});
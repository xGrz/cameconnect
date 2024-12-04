import {defineConfig} from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';
import fs from 'fs';
import dotenv from 'dotenv';

dotenv.config();

const host = `${process.env.APP_URL}`
    .replace('http://', '')
    .replace('https://', '');


export default defineConfig({
    server: {
        host,
        hmr: {host},
        https: {
            key: fs.readFileSync(`/home/grzesiek/configs/ssl/CERTS-Storage/` + host + `.key`),
            cert: fs.readFileSync(`/home/grzesiek/configs/ssl/CERTS-Storage/` + host + `.crt`),
        },
        watch: {
            usePolling: true,
        }
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [
                ...refreshPaths
            ],
        }),
    ],
});

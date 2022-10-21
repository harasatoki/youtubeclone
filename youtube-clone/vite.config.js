import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    // server:{
    //     host: true
    // },
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
            'resources/js/bootstrap.js',
            'resources/js/test.js',
        ]),
    ],
});

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';


export default defineConfig({
    plugins: [
        laravel(
            [
            'resources/css/app.css',
            'resources/js/app.js',
            'resources/js/cart.js',
        ]
        //     {
        //     input: ['resources/css/app.css', 'resources/js/app.js'],
        //     input: ['resources/js/cart.js', 'resources/js/cart.js'],
        //     refresh: true,
        // }
        ),
    ],
});

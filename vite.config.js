import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
import { resolve } from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/components.css',
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                'resources/js/dashboard.js',
                'resources/js/catalog.js',
                'resources/js/theme.js',
            ],
            refresh: [
                'resources/views/**',
                'app/Http/Controllers/**',
                'app/Models/**',
                'app/Livewire/**',
                'routes/**',
            ],
            fonts: [
                bunny('Inter', {
                    weights: [300, 400, 500, 600, 700, 800],
                }),
                bunny('Poppins', {
                    weights: [400, 500, 600, 700],
                }),
                bunny('JetBrains Mono', {
                    weights: [400, 500],
                }),
            ],
        }),
        tailwindcss(),
    ],
    
    // Resolve aliases for cleaner imports
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources'),
            '@css': resolve(__dirname, 'resources/css'),
            '@js': resolve(__dirname, 'resources/js'),
            '@views': resolve(__dirname, 'resources/views'),
            '@vendor': resolve(__dirname, 'vendor'),
        },
    },
    
    // Server configuration
    server: {
        watch: {
            ignored: ['**/storage/**', '**/vendor/**', '**/node_modules/**'],
        },
        hmr: {
            overlay: true,
        },
        cors: true,
        strictPort: false,
    },
    
    // Build optimization
    build: {
        sourcemap: process.env.APP_ENV !== 'production',
        minify: process.env.APP_ENV === 'production' ? 'esbuild' : false,
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules/axios') || id.includes('node_modules/alpinejs') || id.includes('node_modules/chart.js')) {
                        return 'vendor';
                    }
                    if (id.includes('resources/js/theme.js') || id.includes('@js/theme.js')) {
                        return 'theme';
                    }
                },
            },
        },
        chunkSizeWarningLimit: 1000,
        // Ensure CSS is extracted properly
        cssCodeSplit: true,
        assetsInlineLimit: 4096, // Inline small assets as base64
    },
    
    // CSS optimization
    css: {
        postcss: './postcss.config.js',
        preprocessorOptions: {
            css: {
                importLoaders: 1,
            },
        },
    },
    
    // Optimize dependencies
    optimizeDeps: {
        include: [
            'axios',
            'alpinejs',
            'chart.js',
            '@js/theme.js',
        ],
        exclude: [
            'laravel-vite-plugin',
        ],
    },
    
    // Define environment variables available in client
    define: {
        __APP_ENV__: JSON.stringify(process.env.APP_ENV || 'local'),
        __APP_URL__: JSON.stringify(process.env.APP_URL || 'http://localhost'),
        __APP_VERSION__: JSON.stringify(process.env.APP_VERSION || '1.0.0'),
    },
});

// Debug information (uncomment for debugging)
// console.log('Vite configuration loaded');
// console.log('Environment:', process.env.APP_ENV);
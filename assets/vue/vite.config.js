import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [vue()],
    server: {
        port: 5173,
        proxy: {
            '/api': 'http://localhost:8000', // Redirige les appels API vers Symfony
        }
    },
    build: {
        outDir: '../../public/build', // Symfony récupère le build ici
        emptyOutDir: true,
        rollupOptions: {
            input: 'index.html' // Assurer que l'entrée est correcte
        }
    }
});

import {defineConfig} from "vite";

export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 8000,
        strictPort: true,
        proxy: {
            '/api': {
                target: 'http://176.109.109.225:8080',
                changeOrigin: true,
                rewrite: (path) => path.replace(/^\/api/, '')
            }
        }
    },

    optimizeDeps: {
        include: ["webix", "webix-jet"]
    }
});

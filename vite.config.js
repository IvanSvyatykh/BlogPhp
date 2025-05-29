import { defineConfig } from "vite";

export default defineConfig({
    server: { 
        host: '0.0.0.0',
        port: 8000,
        strictPort: true,
        proxy: {
            '/api': {
              target: 'http://127.0.0.1:8080',
              changeOrigin: true,
              rewrite: (path) => path.replace(/^\/api/, '')
            }
          }
    },

    optimizeDeps: {
        include: ["webix", "webix-jet"]
    }
});

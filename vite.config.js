import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [
    vue(),
    // laravel({
    //   input: ['resources/css/app.css', 'resources/js/app.js'],
    //   refresh: true,
    // }),
  ],
  build: {
    define: {
      '__VUE_I18N_FULL_INSTALL__': true,
      '__VUE_I18N_LEGACY_API__': false,
    },
  },
  root: './frontend'
});

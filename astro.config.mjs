// @ts-check
import { defineConfig } from 'astro/config';

import tailwindcss from '@tailwindcss/vite';

import sitemap from '@astrojs/sitemap';

// https://astro.build/config
export default defineConfig({
  site: 'https://b2b.porcorosso.com.ar',
  vite: {
    plugins: [tailwindcss()]
  },
  // /gracias queda fuera del sitemap: es la confirmación de envío, no tiene
  // valor de búsqueda y no queremos que aparezca suelta en Google.
  integrations: [sitemap({ filter: (page) => !page.includes("/gracias") })]
});
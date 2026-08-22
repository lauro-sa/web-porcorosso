# Guía para agentes de IA

Punto de entrada para cualquier asistente (Claude Code, Cursor, ChatGPT, Copilot,
Codex) que trabaje en este repo. **Leelo antes de tocar nada.**

> Si venís a hacer un cambio y no sabés por dónde empezar: leé este archivo entero,
> después [ROADMAP.md](ROADMAP.md) para saber qué falta, y [DEPLOY.md](DEPLOY.md)
> antes de publicar.

## Qué es esto

Landing **B2B mayorista** de Porco Rosso, productor porcino argentino. Su único
objetivo es captar consultas de negocios (restaurantes, hoteles, carnicerías,
distribuidoras) en CABA y Gran Buenos Aires. **No es una tienda ni apunta a
consumidor final.**

Vive en **https://b2b.porcorosso.com.ar**

## Stack

- **Astro 6** con `output: static`. Sin adapter, sin SSR: son archivos HTML planos.
- **Tailwind CSS v4** por plugin de Vite. No hay `tailwind.config.js`: los tokens
  de marca están en [src/styles/global.css](src/styles/global.css) dentro de `@theme`.
- **PHP 8.3** en el servidor, usado por un único script que recibe los leads.
- Node 22.12+ para desarrollar.

```bash
npm run dev      # desarrollo
npm run build    # genera dist/
npm run preview  # previsualiza el build
```

## Publicar

El build se hace local y se suben archivos por SSH. Está todo en
[DEPLOY.md](DEPLOY.md): credenciales, ruta y comando de `rsync`.

**Después de cualquier cambio hay que buildear y sincronizar**, o producción queda
distinta del código. Para comprobar si están alineados, comparar por contenido y no
por fecha (`rsync --checksum -n`), porque cada build cambia las fechas y da falsos
positivos.

## Reglas que no son obvias

Cada una salió de un problema real:

1. **Nombres de archivo sin acentos ni eñes en `public/` y `src/assets/`.** macOS
   guarda los acentos en forma NFD y el navegador los pide en NFC: el servidor
   Linux devuelve 404 aunque el archivo esté ahí. Ya pasó con `chorizo-bombón.jpg`.

2. **No tocar los DNS de la raíz.** `porcorosso.com.ar` apunta a **Shopify**, donde
   vive la tienda de consumidor final. Solo el subdominio `b2b` va al hosting de
   Hostinger. Ver [ROADMAP.md](ROADMAP.md) para el plan de dominios completo.

3. **Las imágenes van en `src/assets/` y se usan con `<Image>` de `astro:assets`**,
   nunca con `<img>` apuntando a `public/`. Así Astro genera las variantes
   responsive. Única excepción: `public/images/og/og-image.png`, que se queda en
   `public/` y en PNG porque se referencia por URL absoluta en los meta tags y
   porque WhatsApp y Facebook no leen WebP de forma fiable.

4. **Nunca uses `git add -A`.** El directorio tiene carpetas de material de diseño
   con PDFs de decenas de MB. Están en `.gitignore`, pero conviene agregar archivos
   por nombre igual.

5. **El teléfono del canal B2B (+54 9 11 7271-4251) no es el de la tienda.** Si se
   cambia, hay que actualizarlo en los enlaces de WhatsApp, los `tel:`, el JSON-LD,
   las preguntas frecuentes y `llms.txt`, y escribirlo siempre igual: para el SEO
   local el teléfono tiene que ser idéntico en todos lados.

6. **`public/llms.txt` no es documentación interna.** Es contenido público para los
   rastreadores de IA, con los datos de la empresa. Si cambian datos del negocio
   (teléfono, zonas, escala), hay que actualizarlo también.

7. **No inventes datos comerciales.** Pedido mínimo, plazos de entrega, medios de
   pago y condición fiscal **no están confirmados**. No los agregues a las preguntas
   frecuentes ni al schema hasta que el titular los confirme: irían a Google y a las
   IA como si fueran hechos.

## Cómo llegan los leads

El formulario postea a [public/contacto.php](public/contacto.php), que guarda cada
consulta en un CSV fuera de `public_html` y manda un mail. El CSV es la fuente de
verdad: si el mail falla, el lead igual quedó guardado.

**El front solo muestra éxito si el envío salió de verdad.** Antes mostraba la
pantalla de éxito siempre y los leads se perdían en silencio. No revertir eso.

Al enviar, redirige a `/gracias`, que existe como URL propia para poder contar
conversiones en Google Ads. Va con `noindex` y fuera del sitemap a propósito.

## SEO y GEO

El sitio está pensado para tres canales: búsqueda orgánica, campañas pagas y
recomendación en asistentes de IA. Al escribir contenido, tener en cuenta:

- **El nombre colisiona con la película de Studio Ghibli de 1992**, que domina las
  búsquedas. Por eso el nombre aparece siempre pegado a términos que lo
  desambiguan (proveedor mayorista, carne porcina, Ituzaingó), y por eso `llms.txt`
  lo aclara de forma explícita.
- **Las respuestas de las preguntas frecuentes se redactan para poder citarse
  solas**: repiten el sujeto ("Porco Rosso") en vez de usar pronombres, porque un
  modelo de lenguaje cita el párrafo suelto, sin el contexto de alrededor.
- Los datos concretos (kilos por semana, cantidad de clientes) son lo que las IA
  citan. Mantenerlos coherentes entre el sitio y `llms.txt`.

## Estado y qué falta

**Todo lo pendiente está en [ROADMAP.md](ROADMAP.md)**, dividido en lo que se puede
hacer solo y lo que necesita cuentas o datos del titular. Mantenerlo actualizado al
cerrar tareas.

Lo más importante hoy: **no hay medición instalada** (falta GA4 y la etiqueta de
Google Ads), así que no se puede pautar todavía.

⚠️ **Dato contradictorio sin resolver:** el sitio dice **1.600 madres porcinas** y la
información pública de la empresa dice **3.000**. Aparece en el hero, en la franja
de cifras y en `llms.txt`. No cambiarlo sin confirmación del titular.

## Mapa de documentos

| Archivo | Para qué |
|---|---|
| [AGENTS.md](AGENTS.md) | Este archivo. Punto de entrada. |
| [ROADMAP.md](ROADMAP.md) | Qué falta, priorizado. Incluye el informe de auditoría SEO/GEO. |
| [DEPLOY.md](DEPLOY.md) | Servidor, publicación y manejo de leads. |
| [NOTAS-PROYECTO.md](NOTAS-PROYECTO.md) | Origen del proyecto y decisiones con el cliente. |
| [RTM-BRAND.md](RTM-BRAND.md) | Marca: paleta, tipografías, tono. |

## Convenciones

- **Todo el contenido de cara al usuario va en español rioplatense** (vos, no tú).
- Los comentarios en el código explican **por qué**, no qué hace la línea.
- Los mensajes de commit van en español y explican la razón del cambio.

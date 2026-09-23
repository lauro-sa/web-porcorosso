# Guía para agentes de IA

Punto de entrada para cualquier asistente que trabaje en este proyecto —Claude,
ChatGPT, Grok, Gemini, Copilot, Cursor, Codex, el que sea— tenga acceso al repo o no.
**Leelo antes de tocar nada.**

> Si venís a hacer un cambio y no sabés por dónde empezar: leé este archivo entero,
> después [ROADMAP.md](ROADMAP.md) para saber qué falta, y [DEPLOY.md](DEPLOY.md)
> antes de publicar.

## Qué es esto

Landing **B2B mayorista** de Porco Rosso, productor porcino argentino. Su único
objetivo es captar consultas de negocios (restaurantes, hoteles, carnicerías,
distribuidoras) en CABA y Gran Buenos Aires. **No es una tienda ni apunta a
consumidor final.**

Vive en **https://b2b.porcorosso.com.ar**

## El registro va todo a un solo lugar

**Este repo es el único lugar donde queda el registro del proyecto. Sin excepción,
y sin importar en qué asistente se haya hecho el trabajo.**

No vale dejarlo en el historial de un chat. Los chats se pierden, se cierran, se
rompen o quedan en una cuenta que el que viene después no tiene. Ya pasó dos veces
con el borrador de la campaña de Google Ads: se corrompió, hubo que rehacerlo de
cero, y lo único que se salvó fue lo que estaba escrito acá.

### Dónde va cada cosa

| Si trabajaste en… | Escribí en |
|---|---|
| Código del sitio | El código, con el porqué en los comentarios, y el commit |
| Qué falta o quedó a medias | [ROADMAP.md](ROADMAP.md) |
| Google Ads: palabras clave, negativas, anuncios, presupuesto, decisiones | [ADS.md](ADS.md) |
| Publicación, servidor, manejo de leads | [DEPLOY.md](DEPLOY.md) |
| Algo inesperado que costó tiempo descubrir | "Reglas que no son obvias", acá abajo |
| Estado general al cerrar la sesión | "Dónde quedó todo", acá abajo |

### Si no tenés acceso al repo

Es el caso de un asistente que corre en el navegador —por ejemplo el que opera la
cuenta de Google Ads— o de cualquier chat web. No podés escribir los archivos, pero
**la regla te sigue aplicando igual**: el trabajo tiene que terminar acá.

Cerrá tu sesión entregando el registro **listo para pegar**: en Markdown, diciendo
explícitamente en qué archivo y bajo qué sección va. El titular lo pega, o se lo pasa
al asistente que sí tiene el repo. Lo que no sirve es dejarlo suelto en la
conversación y confiar en que alguien se acuerde.

Y al revés: si arrancás una sesión sin acceso al repo, pedí que te peguen
[AGENTS.md](AGENTS.md), [ROADMAP.md](ROADMAP.md) y [ADS.md](ADS.md) antes de opinar.
Casi todo lo que vas a proponer ya está decidido ahí, con el motivo al lado.

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
   porque WhatsApp y Facebook no leen WebP de forma fiable. Si se reemplaza, hay
   que mirarle el contraste: la versión anterior tenía el logo en `#352323` sobre
   un fondo `#2b1a17` —1.12:1, invisible— y el preview de WhatsApp se veía como un
   rectángulo marrón vacío. La actual es el logo hueso sobre morcilla, 12.7:1.

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

8. **Las rutas internas van con barra final.** El servidor devuelve un 301 de
   `/mayoristas` a `/mayoristas/`. Un enlace sin barra gasta un salto de más y una
   canónica sin barra apunta a una URL que redirige, que es un error que Google
   marca. Comprobado con `curl` contra producción.

9. **Las secciones viven en la home.** Desde `/mayoristas` o `/gastronomicos`, un
   `href="#productos"` no lleva a ningún lado. `NavBar.astro` y `Footer.astro`
   resuelven esto con `aSeccion()`, que antepone la barra cuando no estás en la
   home. Si agregás un enlace a una sección, usalo.

10. **El `background-color` del `<body>` arrastra la barra de estado de iOS.** En
    Safari de iPhone, la franja de la hora, el wifi y la batería se pinta con el
    fondo del `body`. No con el del `<html>` y no con el `meta theme-color`:
    comprobado a mano en el simulador pintando cada uno de rojo, y solo el `body`
    la cambia. El `theme-color` igual sirve, pero para la barra de abajo, para
    Chrome en Android y para las PWA. Antes el `body` era frigo y el navbar quedaba
    de otro color, así que se veía un corte horizontal debajo de la hora.

    Dos consecuencias para el que venga:

    - Si cambiás el fondo del `body` en `global.css`, no estás cambiando solo el
      fondo de la página: estás cambiando esa franja. `NavBar.astro` además lo pasa
      de hueso a frigo al scrollear, para que empalme con su velo.
    - **El contenido no puede pasar por detrás de esa franja** en Safari como
      navegador. El viewport arranca debajo; `viewport-fit=cover` no la abre. El
      efecto de app a pantalla completa solo existe si el sitio se agrega a la
      pantalla de inicio, o sea en modo PWA, y hoy no hay manifest.

11. **El velo del navbar en mobile son varias capas y no una sola.** `backdrop-filter`
    desenfoca con un radio fijo: donde termina la capa el fondo pasa de golpe de
    borroso a nítido y se lee como una línea, aunque el color venga bajando suave.
    Desvanecerlo con máscara es peor, porque deja imagen borrosa encima de imagen
    nítida, o sea un fantasma. Por eso `#nav-veil` apila cuatro capas de blur
    decreciente más una de color aparte. Si lo simplificás a una sola capa vuelve
    la línea. Medido: el velo le saca el 96% del detalle al contenido de atrás.

## Cómo llegan los leads

El formulario postea a [public/contacto.php](public/contacto.php), que guarda cada
consulta en un CSV fuera de `public_html` y manda un mail. El CSV es la fuente de
verdad: si el mail falla, el lead igual quedó guardado.

**El front solo muestra éxito si el envío salió de verdad.** Antes mostraba la
pantalla de éxito siempre y los leads se perdían en silencio. No revertir eso.

Al enviar, redirige a `/gracias`, que existe como URL propia para poder contar
conversiones en Google Ads. Va con `noindex` y fuera del sitemap a propósito.

Desde `/gracias` se abre WhatsApp con la consulta ya escrita en viñetas, para que
llegue al canal B2B sin repreguntar datos. Es un paso **después** del guardado, no
un reemplazo: si la persona cierra WhatsApp sin enviar, el lead igual está en el CSV.
El mensaje se arma en `armarMensajeWhatsApp()` de
[ContactForm.astro](src/components/ContactForm.astro); si se agrega un campo o una
opción al formulario, sumarlo ahí y en `ETIQUETAS_VALOR`, o llega en crudo.

## Páginas

| URL | Para quién | Qué capta |
|---|---|---|
| `/` | General | El nombre de la marca y las búsquedas amplias |
| `/mayoristas/` | Carnicerías, distribuidoras, elaboradores, autoservicios | "carne de cerdo por mayor", "proveedor para carnicerías" |
| `/gastronomicos/` | Hoteles, restaurantes, bares, catering | "proveedor de cerdo para hoteles en CABA", "cortes para buffet" |
| `/privacidad/` | Legales | Nada, es requisito de Google Ads |
| `/gracias/` | Post-envío | Nada: `noindex` y fuera del sitemap, existe para medir conversiones |

Las dos páginas de segmento existen porque en la home los dos públicos competían por
las mismas palabras. Cada una emite `Service` + `OfferCatalog`, `BreadcrumbList` y su
propio `FAQPage`; el componente [Faq.astro](src/components/Faq.astro) acepta su juego
de preguntas por props y sin props muestra las de la home.

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
Google Ads), así que no se puede pautar todavía. El código ya está listo en
[Medicion.astro](src/components/Medicion.astro) y cubre los tres canales de lead
—WhatsApp, llamada y formulario—; solo faltan los IDs, que los tiene el titular.

⚠️ **Dato contradictorio sin resolver:** el sitio dice **1.600 madres porcinas** y la
información pública de la empresa dice **3.000**. Aparece en el hero, en la franja
de cifras y en `llms.txt`. No cambiarlo sin confirmación del titular.

## Dónde quedó todo

*Última actualización: 22 de septiembre de 2026.*

**Producción no es `main`: es la rama `produccion`.** El titular quiere mantener por
ahora **una sola landing** y subir las páginas de segmento más adelante, cuando lo
autorice. Por eso el 22/09 se publicó desde `produccion`, que sale de `43a07f0` (lo que
estaba online) y suma solo la consulta por WhatsApp. **No publicar `main` entero sin
autorización del titular**: subiría `/mayoristas/`, `/gastronomicos/` y todo lo de abajo.
Cómo publicar un cambio suelto: ver "Publicar solo una parte" en [DEPLOY.md](DEPLOY.md).

⚠️ La campaña ya empezó a gastar (según el titular, 22/09) y producción **no tiene
medición**: Google Ads no ve los leads. Los anuncios van a la home, que funciona.

Sin publicar (está en `main`, no en `produccion`):

- El color de la barra de estado de iOS (`theme-color`, en `NavBar.astro`,
  `Layout.astro` y `global.css`). Quedó pendiente de probarse en un iPhone real.
- Las páginas **`/mayoristas/` y `/gastronomicos/`**, con el navbar, el pie y la
  sección de segmentos de la home enlazando a ellas.
- El `llms.txt` actualizado, que ahora responde explícitamente que la empresa
  abastece hoteles y enlaza las dos páginas nuevas.
- La **medición de conversiones** ([Medicion.astro](src/components/Medicion.astro)),
  a la espera de los IDs de GA4 y Google Ads. Incluye la captura del GCLID, que ya
  funciona sin depender de esos IDs.
- El cambio en [contacto.php](public/contacto.php) que suma la columna **GCLID** al CSV.
  Se agrega al final, después de Origen, para no correr las columnas de los leads que ya
  estén guardados.

**Por qué se hicieron las páginas de segmento:** un usuario le preguntó a un asistente
de IA a quién comprarle cerdo para un hotel en CABA y Porco Rosso apareció cuarto en
una lista, con un teléfono inventado —o sea que el modelo ni leyó el sitio—. El sitio
nombraba hoteles al pasar y no decía *buffet*, *desayuno*, *banquete* ni *gramaje* una
sola vez. Ahora hay una página que responde esa intención de búsqueda exacta.

**Publicado y funcionando:** la consulta del formulario abierta en WhatsApp con los
datos en viñetas (22/09/2026, desde `produccion`), el sitio, el formulario que manda los leads a mail y
planilla, `/gracias`, `/privacidad`, las preguntas frecuentes, `llms.txt` y las
imágenes responsive.

**En curso, esperando a Google:** la propiedad de Search Console está verificada y
el sitemap enviado, pero Google todavía no lo rastreó. Es normal en un sitio nuevo;
tarda días. **No reenviar el sitemap**, reenviarlo reinicia la cola.

**Lo próximo, en orden:**

1. Crear el **Perfil de Empresa de Google** — depende del titular, es gratis y tarda
   días en verificarse. Es lo que más mueve la aguja: define si aparecen en
   búsquedas locales y es la fuente que más citan los asistentes de IA.
2. Instalar **GA4 y la etiqueta de Google Ads** — falta que el titular pase los IDs.
   Es el último bloqueante para poder pautar. El código ya está hecho: solo hay que
   pegarlos en [Medicion.astro](src/components/Medicion.astro) y publicar. La primera
   campaña se está armando pausada; la secuencia de encendido, paso por paso, está en
   [ROADMAP.md](ROADMAP.md) bajo "Encender la campaña de Google Ads".
3. Crear las **páginas por producto** — las de segmento ya están hechas. Esto se puede
   hacer sin depender de nadie y es lo que más mueve el SEO a mediano plazo. El plan
   completo está en [ROADMAP.md](ROADMAP.md).

## Antes de terminar tu sesión

**Todos los que trabajen acá dejan registro. Sin excepción.** Si no queda escrito,
el que venga después no tiene forma de saberlo y repite trabajo o rompe algo. Vale
para cualquier asistente, con repo o sin repo: ver "El registro va todo a un solo
lugar" arriba.

Antes de cerrar, hacé estas cuatro cosas:

1. **Actualizá [ROADMAP.md](ROADMAP.md).** Marcá lo que completaste y agregá lo
   nuevo que haya aparecido. Si una tarea quedó a medias, escribí explícitamente
   hasta dónde llegaste y qué falta.
2. **Actualizá la sección "Dónde quedó todo"** de este archivo, con la fecha. Es lo
   primero que lee el que llega: tiene que reflejar el presente, no el pasado.
3. **Commiteá explicando por qué**, no qué. El "qué" ya se ve en el diff; lo que se
   pierde es la razón. El historial de git es la bitácora detallada del proyecto.
4. **Si tropezaste con algo inesperado**, agregalo a "Reglas que no son obvias" acá
   arriba. Cada una de esas reglas está porque alguien perdió tiempo con eso antes.

Si dejás trabajo sin publicar, decilo. Que el código esté commiteado no significa
que esté en producción: son dos pasos distintos, y [DEPLOY.md](DEPLOY.md) explica
cómo verificar que estén alineados.

## Mapa de documentos

| Archivo | Para qué |
|---|---|
| [AGENTS.md](AGENTS.md) | Este archivo. Punto de entrada. |
| [ROADMAP.md](ROADMAP.md) | Qué falta, priorizado. Incluye el informe de auditoría SEO/GEO. |
| [DEPLOY.md](DEPLOY.md) | Servidor, publicación y manejo de leads. |
| [NOTAS-PROYECTO.md](NOTAS-PROYECTO.md) | Origen del proyecto y decisiones con el cliente. |
| [ADS.md](ADS.md) | Google Ads: palabras clave, negativas, anuncios y decisiones de la campaña. |
| [RTM-BRAND.md](RTM-BRAND.md) | Marca: paleta, tipografías, tono. |

## Convenciones

- **Todo el contenido de cara al usuario va en español rioplatense** (vos, no tú).
- Los comentarios en el código explican **por qué**, no qué hace la línea.
- Los mensajes de commit van en español y explican la razón del cambio.

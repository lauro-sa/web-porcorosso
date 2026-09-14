# Roadmap — SEO, GEO y captación de leads

> **Informe de auditoría completo:**
> https://claude.ai/code/artifact/d12db052-b9fa-4671-82d1-cccccde43c24
>
> Estado de SEO, GEO y medición de b2b.porcorosso.com.ar, con el diagnóstico
> que originó este roadmap. Auditoría del 16 de agosto de 2026.

El objetivo del sitio es captar clientes mayoristas por tres vías: búsqueda orgánica
en Google, campañas pagas (Google Ads y redes) y recomendación en asistentes de IA
(ChatGPT, Claude, Perplexity, Gemini). Cada tarea de acá abajo sirve a alguna de las tres.

---

## Hecho

- [x] Sitio publicado en `b2b.porcorosso.com.ar` con certificado SSL
- [x] **Formulario conectado** a `contacto.php`: guarda en CSV y notifica por mail.
      Ya no muestra "éxito" cuando el envío falla
- [x] Anti-spam sin dependencias: honeypot + descarte de envíos instantáneos
- [x] **Sección de preguntas frecuentes** con marcado `FAQPage`, redactada para ser
      citable por modelos de lenguaje ([src/components/Faq.astro](src/components/Faq.astro))
- [x] **Política de privacidad** publicada en `/privacidad` y enlazada desde el pie
- [x] `sameAs` y `foundingDate` en el JSON-LD, para anclar la entidad a sus perfiles reales
- [x] `llms.txt` con los datos verificables de la empresa y la desambiguación explícita
      respecto de la película de Studio Ghibli
- [x] Imágenes convertidas a WebP: 2,39 MB → 0,96 MB (−60%). El `dist/` pasó de 3,2 MB a 1,6 MB
- [x] Corregida imagen rota de "Productos elaborados" (acento NFD en el nombre del archivo)
- [x] Enlaces a Instagram y a preguntas frecuentes en el pie
- [x] **Página `/gracias`** con URL propia tras enviar, con `noindex` y fuera del sitemap.
      Es lo que permite contar la conversión en Google Ads y GA4
- [x] **Borrador del formulario** en `localStorage`: quien abandona a mitad retoma donde
      quedó. Compartido entre el formulario de la sección y el del modal, se borra al
      enviar y caduca solo a los 7 días
- [x] **`srcset` responsive con `astro:assets`**: las imágenes se mudaron a `src/assets/`
      y Astro genera una variante por tamaño de pantalla. Una foto de producto en celular
      pasó de 153 KB a 29 KB
- [x] **Teléfono B2B propio**: +54 9 11 7271-4251, el WhatsApp Business con el que se
      maneja el canal mayorista. Reemplaza al anterior en todo el sitio
- [x] **Páginas por segmento**: [/mayoristas](src/pages/mayoristas.astro) y
      [/gastronomicos](src/pages/gastronomicos.astro). Antes los dos públicos convivían
      en la home y competían por las mismas palabras. La de gastronómicos está escrita
      con foco hotelero, que era el hueco más grande: el sitio nombraba hoteles al pasar
      y no decía *buffet*, *desayuno*, *banquete* ni *gramaje* una sola vez. Cada una
      lleva `Service` + `OfferCatalog`, `BreadcrumbList` y sus propias preguntas
      frecuentes, y sirve como destino de campaña en Ads
- [x] **`BreadcrumbList`** en las páginas internas ([src/components/Breadcrumb.astro](src/components/Breadcrumb.astro))
- [x] **`@id` fijo en el `LocalBusiness`** — el marcado se repite en cada página; sin un
      identificador estable, buscadores y modelos pueden leer una entidad distinta por
      página en vez de un mismo negocio
- [x] **Rutas con barra final** — el servidor redirige `/pagina` a `/pagina/` con un 301.
      Las canónicas y los enlaces internos apuntan directo a la URL que responde 200
- [x] **Medición de los tres canales de lead** ([src/components/Medicion.astro](src/components/Medicion.astro)).
      Antes solo el formulario dejaba rastro, porque termina en `/gracias/`; los clics a
      WhatsApp y a los teléfonos eran invisibles, y son el canal principal en B2B.
      Pautando así, Google Ads optimizaría hacia lo único que ve. Los clics se enganchan
      solos en cualquier página, sin instrumentar botón por botón
- [x] **GCLID guardado con cada lead** — el identificador del clic de Google Ads se
      captura al aterrizar, se persiste 90 días y viaja al CSV. Habilita subir
      conversiones sin conexión: cuando una consulta termina siendo cliente semanas
      después, ese dato entrena al algoritmo para buscar leads que compran en vez de
      leads que completan formularios. **No se puede reconstruir hacia atrás**, por eso
      se hizo antes de encender la campaña. Ver [ADS.md](ADS.md)
- [x] **La redirección post-envío va a `/gracias/`** con barra final. Antes pasaba por un
      301 justo en el momento en que se cuenta la conversión
- [x] **`scroll-padding-top`**: los saltos a `#productos`, `#nosotros`, etc. ya no quedan
      escondidos detrás del navbar fijo

---

## Bloqueado: necesita datos o cuentas del titular

Nada de esto se puede hacer sin información que solo tiene el dueño del negocio.

### Cuentas a crear o dar acceso

- [ ] **Perfil de Empresa de Google** — Es lo más importante que falta y es gratis.
      Sin esto no aparecen en el mapa ni en las búsquedas locales, y además es la
      fuente que más citan los asistentes de IA cuando alguien pregunta por proveedores
      de una zona. Requiere verificación, que suele tardar días.
- [x] **Google Search Console** — propiedad verificada con el archivo
      `public/google7cd04a9cd3102cbd.html`. El sitemap se envió el 21/8/2026 y
      quedó en estado "No se ha podido obtener", que es lo normal en una
      propiedad recién creada: Google lo encoló y todavía no lo rastreó. El
      servidor lo entrega bien (200, `application/xml`, sin bloqueo a Googlebot),
      así que no hay nada que arreglar. **No reenviar el sitemap**: reenviarlo
      reinicia la cola. Si en una semana sigue igual, revisar.
- [ ] **Google Analytics 4 + etiqueta de Google Ads** — hace falta el ID de medición
      y el ID de conversión. Sin esto, Google Ads compra clics a ciegas: no puede
      optimizar hacia quien realmente consulta, ni hacer remarketing.
      **El sitio ya está preparado**: los tres tipos de lead que le interesan al
      titular —WhatsApp, llamada y formulario— disparan su evento desde
      [src/components/Medicion.astro](src/components/Medicion.astro). Solo falta pegar
      los IDs ahí; mientras estén vacíos no se carga ningún script de terceros ni se
      deja una cookie. Cada acción tiene su propia etiqueta de conversión, así que en
      Google Ads conviene crear tres conversiones separadas y no una sola.
- [ ] **Píxel de Meta** — para campañas en Instagram y Facebook, y para remarketing.
- [ ] **reCAPTCHA v3** — falta la site key. El código ya está listo en
      [Layout.astro](src/layouts/Layout.astro) (comentado) y en
      [ContactForm.astro](src/components/ContactForm.astro).

### Datos del negocio a confirmar

- [ ] **Cuántas madres porcinas son.** El sitio dice **1.600**, pero
      [NOTAS-PROYECTO.md](NOTAS-PROYECTO.md) y la información pública de la empresa
      dicen **3.000**. Es un dato que se cita en el hero, en las cifras y en `llms.txt`:
      conviene que sea el correcto y el mismo en todos lados.
- [ ] **Pedido mínimo mayorista** — no está publicado en ningún lado. Es de las primeras
      preguntas de un comprador B2B y hoy queda sin responder.
- [ ] **¿Venden media res?** El sitio **no dice "media res" ni una vez**, pero
      `"media res de cerdo"` es palabra clave cargada en Ads y el titular mandó
      **siete variantes** de ese término (14/09/2026), o sea que da por hecho que se
      vende. Es el hueco de contenido más grande que hay hoy: se está por pagar
      clics de una búsqueda que la landing no responde. Confirmar y, si va, escribirlo.
- [ ] **¿Abastecen comedores, colegios, empresas y eventos?** El titular pidió
      palabras clave para esos cuatro segmentos. El sitio no dice *colegio*,
      *escuela* ni *institucional* ni una vez. Si los abastecen, es contenido
      nuevo; si no, esas palabras clave no se cargan.
- [ ] **¿Se dice "pechito" y "matambre", o solo "matambrito"?** El sitio nombra
      *matambrito* y no nombra *pechito*. Son búsquedas distintas en concordancia
      de frase: no se capturan entre sí.
- [ ] **Plazos de entrega** y días de reparto por zona.
- [ ] **Medios de pago y condiciones** (cuenta corriente, plazos, contado).
- [ ] **Condición fiscal / facturación** (si emiten factura A).
- [ ] **Mail donde quiere recibir los leads** — hoy van a `hola@porcorosso.com.ar`.
      Se puede agregar más de un destinatario en `contacto.php`.

Cada uno de esos datos confirmados es una pregunta más en las preguntas frecuentes,
que es contenido que Google muestra desplegado y que las IA citan. Las páginas
`/mayoristas` y `/gastronomicos` están escritas dejándoles el lugar: son las primeras
cuatro preguntas de un jefe de compras y hoy quedan sin responder.

---

## Encender la campaña de Google Ads

La primera campaña se arma **pausada** y se activa después. El orden importa: lo que
se gaste antes de que la medición esté publicada no se puede analizar ni recuperar.

**Antes de activar, en este orden:**

1. [ ] El titular crea las **tres conversiones** en Google Ads —clic a WhatsApp, clic a
       teléfono y envío de formulario— y pasa las etiquetas, más el ID de GA4.
       Tres y no una: es la única forma de saber por dónde entran los leads.
2. [ ] Pegar los IDs en [src/components/Medicion.astro](src/components/Medicion.astro).
       Es el único archivo a tocar. **Si la conversión del formulario se creó "por URL"
       apuntando a `/gracias/`, dejar `CONVERSIONES.formulario` vacío**: Google ya la
       cuenta sola con la etiqueta base, y cargarla ahí contaría el mismo lead dos
       veces. WhatsApp y teléfono sí necesitan su etiqueta, porque son clics.
3. [ ] Buildear y publicar según [DEPLOY.md](DEPLOY.md). **Sin esto, la campaña corre a
       ciegas**: el sitio en producción todavía no tiene la medición ni las páginas de
       segmento.
4. [ ] Comprobar en producción que las tres conversiones registran: entrar al sitio,
       tocar el botón de WhatsApp, tocar el teléfono y mandar el formulario de prueba.
       En Google Ads las conversiones tardan unas horas en aparecer.
5. [ ] Revisar que los anuncios apunten a la página que corresponde: gastronómicos a
       `/gastronomicos/` y mayoristas a `/mayoristas/`, no los dos a la home. Una
       landing específica sube el nivel de calidad y abarata el clic.
6. [ ] Recién ahí, activar la campaña.

**Notas de la cuenta:**

- Se trabaja en el **modo normal de Google Ads, nunca en modo experto**. Es una
  decisión del titular: prefiere una campaña más simple antes que una interfaz que no
  puede manejar solo.
- Al terminar de crearla, Google Ads la deja **activa**. Hay que pausarla a mano
  enseguida si todavía no es momento de que gaste.
- Palabras clave negativas imprescindibles: las de la película de Studio Ghibli
  (ghibli, miyazaki, película, anime, ver online, streaming, latino, subtitulada) y las
  de consumidor final. El nombre colisiona y sin eso se paga por clics inútiles.
- No hay fotos ni videos en formato de recurso publicitario, así que la campaña tiene
  que funcionar solo con texto.

---

## Se puede hacer sin depender de nadie

Ordenado por relación entre impacto y esfuerzo.

- [ ] **Páginas por producto** — ver la sección siguiente.
- [ ] **Cerrar la brecha entre lo que se puja y lo que el sitio dice.** Cruce del
      14/09/2026 (ver [ADS.md](ADS.md), "Revisión de la lista que pasó el titular"):
      hay palabras clave cargadas cuya intención la landing no responde con esas
      palabras. Google cobra más caro el clic cuando la página no coincide con la
      búsqueda, así que esto **sube el CPC antes de encender**. No se arregla
      pegando listas de palabras —eso es relleno y Google lo penaliza—, se arregla
      escribiendo el contenido que falta. Depende de los datos de arriba.
- [ ] **`Product` / `OfferCatalog` en la home** — las páginas de segmento ya emiten su
      catálogo; falta describir las tres familias de producto en la home, donde hoy son
      solo texto.
- [ ] **Optimizar la imagen de Open Graph** — sigue en PNG a propósito (WhatsApp y
      Facebook no leen WebP de forma fiable), pero se puede comprimir.

---

## Plan de páginas por producto

La idea es que cada familia de producto tenga su propia URL, para captar búsquedas
específicas que hoy se pierden. Alguien que busca "bondiola por mayor Buenos Aires"
debería encontrar una página sobre bondiola, no la home general.

### Estructura propuesta

```
/                          Landing general (la actual)                    [publicada]
/mayoristas                Carnicerías, distribuidoras, elaboradores      [hecha]
/gastronomicos             Hoteles, restaurantes, bares, catering         [hecha]
/productos/piezas-enteras  Bondiola, matambrito, costillitas, pork belly, carré...
/productos/al-vacio        Cortes fraccionados y porcionados
/productos/elaborados      Milanesas, chorizo bombón, morcillas, salchicha parrillera
/privacidad                Legales                                       [publicada]
/gracias                   Confirmación de envío, para medir conversiones [publicada]
```

### Qué debería tener cada página de producto

- Un H1 con la búsqueda real que quiere captar, no el nombre interno del producto
- Fotos propias del corte (las que ya existen, más las que haya)
- Descripción del corte, usos gastronómicos y formatos de entrega disponibles
- Marcado `Product` en JSON-LD
- Tres a cinco preguntas frecuentes propias de ese producto
- El mismo formulario, con el producto ya preseleccionado
- Enlaces cruzados hacia las otras familias

### Por qué conviene hacerlo

Cada página nueva es una entrada más a la que Google puede mandar tráfico, un destino
más específico para una campaña de Ads —lo que mejora el nivel de calidad y baja el
costo por clic— y una fuente más para que un asistente de IA responda con precisión
cuando alguien pregunta por un corte puntual.

**Requisito previo:** definir para cada familia qué búsquedas se quieren captar, y
conseguir fotos propias de los cortes que hoy no están fotografiados.

---

## GEO: aparecer en los asistentes de IA

El sitio ya hace su parte: es HTML estático que los rastreadores leen sin problema,
el `robots.txt` está abierto, hay `FAQPage`, `LocalBusiness` y `llms.txt`.

Lo que falta no está en el código.

- [ ] **Menciones externas.** Los modelos no aprenden principalmente del sitio propio,
      aprenden de dónde te mencionan. Directorios gastronómicos y del rubro cárnico,
      cámaras sectoriales, notas en medios especializados, reseñas de clientes reales.
      Un sitio impecable sin menciones es casi invisible para una IA.
- [ ] **Resolver la colisión de nombre.** Buscar "Porco Rosso" devuelve casi
      exclusivamente la película de Studio Ghibli de 1992. Contra eso, la única defensa
      es que el nombre aparezca siempre pegado a los términos que lo desambiguan
      —proveedor mayorista, carne porcina, Ituzaingó, Buenos Aires— tanto en el sitio
      como fuera de él. `llms.txt` ya lo declara explícitamente.
- [ ] **Ampliar presencia en redes.** Hoy solo existe Instagram (@porcorossoba, 533
      seguidores). No hay Facebook ni LinkedIn. LinkedIn pesa especialmente en B2B y
      es una fuente que los modelos leen.
- [ ] **Publicar contenido con datos propios.** Cifras de producción, calendario de
      cortes, guías de rendimiento por pieza. El contenido con datos que no están en
      otro lado es el que las IA terminan citando.

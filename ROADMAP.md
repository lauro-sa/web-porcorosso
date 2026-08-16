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
- [ ] **Google Search Console** — verificar la propiedad del subdominio para ver
      posiciones, errores de rastreo y qué consultas traen visitas.
- [ ] **Google Analytics 4 + etiqueta de Google Ads** — hace falta el ID de medición
      y el ID de conversión. Sin esto, Google Ads compra clics a ciegas: no puede
      optimizar hacia quien realmente consulta, ni hacer remarketing.
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
- [ ] **Plazos de entrega** y días de reparto por zona.
- [ ] **Medios de pago y condiciones** (cuenta corriente, plazos, contado).
- [ ] **Condición fiscal / facturación** (si emiten factura A).
- [ ] **Mail donde quiere recibir los leads** — hoy van a `hola@porcorosso.com.ar`.
      Se puede agregar más de un destinatario en `contacto.php`.

Cada uno de esos datos confirmados es una pregunta más en las preguntas frecuentes,
que es contenido que Google muestra desplegado y que las IA citan.

---

## Se puede hacer sin depender de nadie

Ordenado por relación entre impacto y esfuerzo.

- [ ] **Páginas por segmento** — una para mayoristas (carnicerías, distribuidoras,
      elaboradores) y otra para gastronómicos (restaurantes, hoteles, catering).
      Hoy ese contenido convive en la home y compite consigo mismo. Además sirven como
      destino específico de campaña, lo que sube el nivel de calidad en Ads y abarata el clic.
- [ ] **Páginas por producto** — ver la sección siguiente.
- [ ] **`Product` / `OfferCatalog` en el JSON-LD** — describir las tres familias de
      producto como catálogo estructurado, no solo como texto.
- [ ] **`BreadcrumbList`** cuando existan páginas internas.
- [ ] **Optimizar la imagen de Open Graph** — sigue en PNG a propósito (WhatsApp y
      Facebook no leen WebP de forma fiable), pero se puede comprimir.

---

## Plan de páginas por producto

La idea es que cada familia de producto tenga su propia URL, para captar búsquedas
específicas que hoy se pierden. Alguien que busca "bondiola por mayor Buenos Aires"
debería encontrar una página sobre bondiola, no la home general.

### Estructura propuesta

```
/                          Landing general (la actual)
/mayoristas                Carnicerías, distribuidoras, elaboradores
/gastronomicos             Restaurantes, bares, hoteles, catering
/productos/piezas-enteras  Bondiola, matambrito, costillitas, pork belly, carré...
/productos/al-vacio        Cortes fraccionados y porcionados
/productos/elaborados      Milanesas, chorizo bombón, morcillas, salchicha parrillera
/privacidad                Legales (ya publicada)
/gracias                   Confirmación de envío, para medir conversiones
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

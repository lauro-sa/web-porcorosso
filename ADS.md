# Google Ads — Primera campaña

Insumos y decisiones de la primera campaña. **Está acá porque el borrador de Google
Ads ya se rompió dos veces**, y estas listas son trabajo que no se puede perder cada
vez que una pestaña se cae. Si hay que rehacer la campaña, se rehace copiando de acá.

Estado al 14 de septiembre de 2026: **armada y frenada en la pantalla de facturación**.
No gastó nada y no puede: sin facturación cargada la cuenta no publica.
La secuencia de encendido está en [ROADMAP.md](ROADMAP.md).

⚠️ **La cuenta nunca estuvo en modo inteligente.** Es una cuenta estándar recorriendo el
asistente de alta de usuario nuevo, y eso se ve en que ofrece cosas que el modo
inteligente no tiene: elegir tipo de campaña, concordancias con comillas, redes,
opciones de ubicación, estrategia de oferta y plantilla de seguimiento. O sea que la
regla del titular —nunca modo experto— se cumplió sin costo: la interfaz completa
estuvo disponible desde el principio. Para confirmarlo cuando la cuenta se desbloquee:
si fuera modo inteligente, el menú de configuración mostraría "Cambiar al modo experto".
No debería estar.

## Decisiones tomadas

| Qué | Cómo quedó | Por qué |
|---|---|---|
| Interfaz | **Modo normal, nunca experto** | Decisión del titular. Prefiere una campaña simple a una interfaz que no puede manejar solo. |
| Tipo de campaña | **Búsqueda** | Google preseleccionaba Máximo rendimiento, que exige imágenes y video —no hay— y reparte en YouTube, Gmail y Display, donde nadie busca un proveedor. |
| Objetivo | **Clientes potenciales → Contactos** | Es el único paraguas que deja optimizar por las tres conversiones a la vez. Las otras opciones encajonan en una sola. |
| Redes | **Display y socios de búsqueda apagados** | Sin imágenes, Google armaría banners solo y los mostraría a gente leyendo recetas. |
| Ubicaciones | **CABA + 28 partidos del GBA** | El radio que proponía Google era casi todo Zona Oeste: faltaba CABA, que es el mercado principal, y toda Zona Sur. |
| Opciones de ubicación | **Presencia**, no "presencia o interés" | "Interés" muestra el anuncio a gente que no está en la zona. A esos no se les puede entregar. |
| Concordancia | **Frase**, las 32 entre comillas | Amplia quema plata; exacta deja sin datos a una cuenta nueva. |
| Puja inicial | **Maximizar clics, techo de CPC ARS 1.200** | La cuenta no tiene ni una conversión: una puja que optimiza hacia conversiones no tiene de qué aprender. Además es lo que más rápido llena el informe de términos de búsqueda, que alimenta las negativas. Google traía "Maximiza las conversiones" preseleccionada. El techo no lo sugiere Google: es ~5× el CPC estimado, funciona como red contra un clic desmedido, no como límite de entrega. |
| Presupuesto | **ARS 12.000/día**, personalizado | El preset más bajo de Google era 20.970. Ver la sección de números. |
| Zona horaria | **Buenos Aires** | Se aplica a toda la cuenta y **no se puede cambiar nunca más**. |
| Facturación | **Prepago por transferencia** (Banelco / PagoMisCuentas) | No es tarjeta con pago automático: se transfiere por adelantado y el saldo se consume. Con la campaña pausada el saldo no se toca. El lado bueno: el saldo es en sí mismo un tope duro de gasto. |

**Cuándo cambiar la puja:** a las 15-30 conversiones en 30 días, con las tres etiquetas
verificadas, pasar a Maximizar conversiones sin CPA objetivo y darle 2-3 semanas.
El CPA objetivo recién después, y en el CPA real observado: si se pone por debajo,
la campaña se ahoga y deja de mostrar.

## Los números, y el riesgo que traen

Estimación de Google para esta configuración exacta, a ARS 12.000/día:

| | |
|---|---|
| CPC promedio | ARS 240,68 |
| Clics por semana | 349 (~1.500/mes) |
| Costo semanal | ARS 83.999 |

Al 2-5% de conversión de una landing B2B fría, eso da **entre 30 y 75 consultas por
mes**. Ese es el número esperable.

### Google no predice el gasto: lo asume

Las dos estimaciones que mostró tienen el costo semanal **exactamente igual al
presupuesto por siete**: 12.000 × 7 = 84.000 contra los 83.999 que informó, y
26.213 × 7 = 183.493 contra los 183.493. Clavado en los dos casos.

O sea que el "costo semanal" **no es una predicción de cuánto se va a poder gastar**:
es el presupuesto multiplicado por los días, y de ahí derivan los clics y el CPC. No
puede usarse como evidencia de que hay volumen suficiente. La pregunta del subgasto
sigue abierta.

**Lo único que sí dice algo sobre el inventario es la elasticidad entre los dos
escenarios:** subir el presupuesto de 12.000 a 26.213 (×2,18) compra apenas ×1,46 más
clics, y el CPC salta 50%. Eso da una elasticidad de **0,48**: duplicar el presupuesto
compraría solo 1,4 veces más clics. Es la firma de una subasta flaca — para gastar más
hay que pagar más caro por el mismo inventario, no comprar más inventario. El techo de
volumen no está muy por encima de los 12.000/día.

**Lo que Google ofrecía antes de fijar la estrategia era humo:** 26.213/día prometiendo
58 conversiones semanales. Con 508 clics semanales eso implica 11,4% de conversión, y
encima modelado sin un solo dato de esta cuenta, que no tiene ninguna conversión medida.
Contraste útil: 58 leads por semana son ~250 por mes, y el negocio tiene 40 clientes
B2B activos en total. Ese volumen no existe en este mercado.

### ⚠️ El riesgo real no es gastar de más: es no poder gastar

Las 33 palabras clave son de nicho, en concordancia de frase, restringidas a CABA y GBA.
"cerdo por mayor" no tiene miles de búsquedas mensuales en esa zona. Las estimaciones de
Google suelen asumir más volumen del que un nicho chico tiene, y **si no hay a quién
mostrarle el anuncio, la campaña no gasta el presupuesto por más que esté disponible**.

Eso importa porque el crédito promocional tiene fecha fija, y todo el cálculo de cuándo
encender depende de a qué ritmo se gaste:

| Si gasta por día | Días de publicación para llegar a 300.000 | Hay que encender el |
|---|---|---|
| ARS 12.000 (lo presupuestado) | 25 | 12 de octubre |
| ARS 9.000 | 33 | 4 de octubre |
| ARS 6.000 | 50 | **17 de septiembre** |
| ARS 4.000 | 75 | ya no llega |

**El 12 de octubre no es una fecha objetivo: es un techo.** Si se espera hasta ahí y
recién entonces se descubre que gasta 6.000/día, ya no hay remedio. Encender apenas la
medición esté publicada compra las dos cosas a la vez: gasto acumulado y el dato real
del ritmo, que se ve en 3 a 5 días de campaña corriendo.

**Primera tarea al desbloquear la cuenta:** mirar el volumen real en el Planificador de
Palabras Clave. Devuelve rangos amplios ("100 a 1 mil") y para términos B2B de nicho
varios pueden volver en el escalón más bajo o sin datos, y además informa volumen del
término sin considerar que acá se usan en concordancia de frase, que captura menos.
Sirve para ordenar cuáles tienen algo de tráfico y cuáles son cero; la respuesta
definitiva la da la primera semana de gasto real.

**Diales si el volumen resulta bajo**, de menos a más costoso:

1. **Publicar `/gastronomicos/` y `/mayoristas/`** y apuntar los anuncios ahí. Una
   landing que responde exactamente a lo buscado sube el nivel de calidad, y el nivel de
   calidad **baja el CPC**: más clics por el mismo presupuesto, sin tocar la campaña.
   Es el único dial que no implica comprar tráfico peor.
2. **Volver a prender socios de búsqueda.** Se apagaron a propósito; es reversible en un
   clic y es el lever de volumen más barato.
3. **Sumar palabras clave** más amplias, o pasar dos o tres de las genéricas a
   concordancia amplia con las negativas puestas de escudo.
4. **Asumir que no se completa la promoción.**

⚠️ **Gastar 300.000 que no se iban a gastar, para cobrar 300.000 de crédito, solo
conviene si esos 300.000 valían la pena por sí solos.** Si el mercado es flaco y hay que
forzar el gasto comprando clics malos, el crédito sale caro. Conviene tenerlo decidido
antes de estar apurados contra el 6 de noviembre.

## Conversiones

Las tres valen lo mismo para el negocio. **Ojo: se miden de dos maneras distintas.**

| Acción | Cómo se mide | Qué hay que hacer |
|---|---|---|
| Envío de formulario | **Por URL**, `b2b.porcorosso.com.ar/gracias/` | Nada en el código. Google la detecta con la etiqueta base. `CONVERSIONES.formulario` en [Medicion.astro](src/components/Medicion.astro) **queda vacío**: llenarlo contaría el lead dos veces. |
| Clic a WhatsApp | Etiqueta propia | Cargar la etiqueta en `CONVERSIONES.whatsapp`. |
| Clic a teléfono | Etiqueta propia | Cargar la etiqueta en `CONVERSIONES.telefono`. |

Los clics no son cargas de página, así que Google no puede detectarlos solo. El sitio
ya los engancha en cualquier página y sobre cualquier enlace.

### GCLID: la puerta a las conversiones sin conexión

**Ya implementado.** El sitio captura el `gclid` de la URL de aterrizaje y lo
guarda 90 días, así que sobrevive a que el visitante navegue entre páginas antes de
completar el formulario. Viaja con el lead y queda en la columna **GCLID** del CSV,
al lado de Origen. También captura `wbraid` y `gbraid`, sus reemplazos cuando el
navegador restringe el seguimiento.

Origen dice **por qué landing** entró el lead; el GCLID dice **qué clic exacto** lo
trajo. Y sobre todo: en un ciclo de venta B2B un formulario no es una venta, es una
consulta que puede terminar en un cliente de 500 kg mensuales o en nada. Con el GCLID
guardado, cuando una consulta se convierte en cliente semanas después ese dato se sube
a Google Ads y el algoritmo pasa a buscar **leads que compran**, no leads que completan
formularios. Es lo que hace que optimizar hacia conversiones tenga sentido de verdad.

No se puede reconstruir hacia atrás: por eso se guarda desde el primer día, antes de
que la campaña arranque.

**Los 90 días corren desde el clic, no desde la consulta.** Google no importa
conversiones sin conexión subidas más de 90 días después del clic asociado. Como el
GCLID se persiste hasta 90 días, un visitante puede hacer clic en un anuncio y completar
el formulario 80 días más tarde: ese lead llega con **10 días de ventana, no con 90**.

Por eso el CSV guarda tres columnas y no una:

| Columna | Qué dice |
|---|---|
| `GCLID` | El identificador del clic, para subirlo a Google Ads |
| `Fecha del clic` | Cuándo ocurrió el clic, que no es cuándo llegó la consulta |
| `Subir conversion antes de` | Fecha límite ya calculada, para no sacar la cuenta lead por lead |

Las dos fechas quedan vacías si el dato no es confiable: el timestamp lo pone el
navegador del visitante, así que se descarta lo que venga del futuro o de hace más de
90 días. Mejor la columna vacía que una fecha inventada que haga creer que todavía hay
ventana.

**Qué conviene subir, dado ese plazo:** no la venta cerrada —un ciclo B2B de volumen
puede tardar más de 90 días y la ventana se cierra mientras se negocia—, sino **un hito
intermedio pero real que ocurra dentro del plazo**: presupuesto enviado, visita
agendada, primer pedido. Cualquiera de los tres es una señal mucho más honesta que un
formulario completado. Cuál de ellos se decide con los primeros leads reales a la vista,
no antes.

Dato al pasar: las *conversiones avanzadas de clientes potenciales* —la variante que usa
datos del usuario en vez de GCLID— tienen una ventana más corta, de 63 días. El camino
por GCLID es el más largo de los dos.

Del lado de Google Ads hace falta crear una acción de conversión de tipo **importación**,
separada de las tres actuales.

⚠️ **Verificar que el auto-etiquetado esté activo en Google Ads.** Sin él, el `gclid`
ni siquiera viaja en la URL y no hay nada que guardar. Viene prendido por defecto.

El GCLID va al CSV pero **no al mail**: al comercial que lee la consulta no le dice
nada y solo agrega ruido.

## Palabras clave (33, todas en concordancia de frase)

Van entre comillas literales en Google Ads. Ninguna es un producto pelado: todas
llevan "proveedor", "distribuidor", "mayorista", "por mayor" o "frigorífico" adentro.
Ese es el primer filtro anti-consumidor final, y el que más ahorra.

```
"proveedor de cerdo"
"proveedor de carne de cerdo"
"proveedor de carne porcina"
"proveedor de carne para restaurantes"
"proveedor de carne para hoteles"
"proveedor de carne para catering"
"proveedor gastronomico de carne"
"proveedor para carnicerias"
"proveedor de cerdo caba"
"proveedor de cerdo gba"
"distribuidora de cerdo"
"distribuidor de carne de cerdo"
"mayorista de carnes"
"frigorifico de cerdo"
"frigorifico porcino"
"carne de cerdo por mayor"
"carne porcina por mayor"
"cerdo por mayor"
"cerdo al por mayor"
"venta de cerdo por mayor"
"carne de cerdo mayorista"
"carne de cerdo para carniceria"
"cortes de cerdo por mayor"
"carne de cerdo al vacio por mayor"
"media res de cerdo"
"bondiola por mayor"
"pork belly por mayor"
"matambrito de cerdo por mayor"
"costillitas de cerdo por mayor"
"milanesas de cerdo por mayor"
"chorizo por mayor"
"morcilla por mayor"
"carne de chancho por mayor"
```

Las 20 primeras ya estaban cargadas. Las 12 nuevas cubren huecos reales: **frigorífico**
—como se dice el rubro en Argentina, y como se define la propia empresa en `llms.txt`—,
**carne porcina** —el término formal, el que usa el título del sitio—, **carnicerías**
—el sustantivo del cliente mayorista, que no estaba—, **media res** —búsqueda típica de
carnicería— y los **elaborados**, que se venden y no tenían ninguna palabra propia.

## Palabras clave negativas

Van en una **lista de exclusión compartida** (Herramientas → Configuración compartida),
no dentro de la campaña: así se aplica también a la segunda campaña y se mantiene en un
solo lugar. **No existe un paso de negativas en el asistente de creación**: hay que
cargarlas aparte.

Están separadas en dos grupos a propósito. **Las de frase no se pueden poner como
palabra suelta**: `res` sola anularía `"media res de cerdo"`, que es una búsqueda que
se quiere captar. Verificado: ninguna de estas anula ninguna palabra clave propia.

### Amplias (palabra suelta)

**Las negativas no matchean variantes cercanas**: a diferencia de las palabras clave,
no cubren plurales, ni acentos, ni errores de tipeo. Cada forma va cargada aparte, y por
eso la lista es larga y repetitiva. No es descuido.

```
ghibli miyazaki hayao pelicula película peliculas películas film films filme filmes
anime animada animadas animado animados animacion animación dibujo dibujos latino
castellano subtitulada subtitulado subtitulos subtítulos streaming netflix torrent
torrents doblaje soundtrack poster posters póster afiche afiches funko funkos cosplay
remera remeras taza tazas personaje personajes reparto sinopsis 1992 hidroavion
hidroavión receta recetas cocinar coccion cocción supermercado supermercados coto
carrefour jumbo mercadolibre minorista minoristas trabajo trabajos empleo empleos
curso cursos capacitacion capacitación franquicia franquicias sueldo sueldos wikipedia
universidad tesis monografia monografía ternera novillo novillos cordero corderos
chivito pescado pescados mariscos jamon jamón gratis
```

### De frase (entre comillas)

```
"ver online"       "ver gratis"        "pelicula completa"   "banda sonora"
"studio ghibli"    "porco rosso pelicula"                    "mercado libre"
"al horno"         "para el asado"     "a domicilio"         "cerca de mi"
"cerdos en pie"    "chanchos en pie"   "lechones vivos"      "cria de cerdos"
"genetica porcina" "alimento balanceado"                     "carne de res"
"media res de novillo"                 "precio por kilo"     "cuanto sale"
"que es"           "como hacer"
```

### Las que se decidió NO poner, y por qué

Son trampas: parecen negativas obvias y matarían clientes reales.

- **parrilla / parrillera** — "proveedor para parrillas" es un cliente ideal, y se vende
  salchicha parrillera.
- **pollo** — se venden milanesas de pollo.
- **vacío** — es un corte de cerdo del catálogo, y además "envasado al vacío".
- **asado** suelto — "tapa de asado" es producto y un catering busca "carne para asados".
  Por eso va solo como frase `"para el asado"`.
- **delivery** — un restaurante de delivery es cliente.
- **precio / oferta** sueltos — un comprador mayorista busca precio. Por eso va solo
  `"precio por kilo"`, que es lenguaje de consumidor final.
- **lechón** — no está en el catálogo hoy, pero es plausible que se pida. Se excluye
  solo `"lechones vivos"`, que es cría, no consumo.
- **chancho / chanchos** — es como se dice cerdo en criollo. `"carne de chancho por
  mayor"` es una búsqueda real de una carnicería chica, y de hecho se sumó como palabra
  clave. Solo se excluye `"chanchos en pie"`, que es ganado vivo.
- **vaca / vacuna** — se sacaron. Bloquean al gastronómico multi-proteína, que busca
  "proveedor de carne vacuna y porcina" y compraría cerdo igual, y chocaban de sentido
  con la propia clave `"mayorista de carnes"`. Se filtran después por términos de
  búsqueda, que es reversible. `ternera`, `novillo` y `cordero` sí quedan: ahí ya se
  está buscando otro animal, no un proveedor.

### Cuánto importan realmente

Menos de lo que parece **en esta campaña**, y conviene saberlo: ninguna palabra clave
es la marca, así que nadie que busque la película va a caer acá —quien busca "Porco
Rosso Ghibli" no tipea "cerdo por mayor"—. El riesgo real aparece el día que se haga
una campaña de marca, o si alguien acepta la recomendación de Google de pasar todo a
concordancia amplia. Se cargan igual porque cuestan cero y protegen de eso.

⚠️ **Nunca aceptar la recomendación "Aplicar todas" de concordancia amplia.** Google la
ofrece de forma insistente. Convierte las 32 frases en amplia y abre la puerta a todo.

## Anuncio

15 títulos (máx. 30 caracteres) y 4 descripciones (máx. 90), verificados contra los
datos reales de la empresa. Todas las descripciones tienen que ser distintas entre sí:
Google marca la calidad en rojo si se repiten.

**Títulos** (los 15 cargados, leídos de pantalla):

```
Carne de Cerdo por Mayor      Proveedor de Cerdo B2B        Cerdo para Hoteles
Cerdo para Restaurantes       Proveedor para Carnicerías    Directo del Productor
Sin Intermediarios            Entregas en CABA y GBA        Cortes a Medida al Vacío
Cadena de Frío Propia         Trazabilidad Completa         Productor Porcino Propio
Abastecé tu Cocina            Presupuesto Mayorista         Pedí tu Presupuesto
```

Balance: 3 mayoristas, 3 gastronómicos, 9 neutros. Con las 33 palabras clave cubriendo
los dos públicos, 3 y 3 es mejor reparto que 4 y 2. **"Solo Venta Mayorista" quedó
afuera** y así se decidió dejarlo: el filtro anti-consumidor final ya lo hacen las
palabras clave —todas llevan "mayorista", "proveedor" o "por mayor"— y otros tres
títulos. No hacía falta gastar un lugar de los 15 en repetirlo.

**Descripciones:**

```
Productor porcino integrado. Criamos, faenamos y entregamos con logística propia.  (81)
Abastecemos hoteles, restaurantes y catering. Pedí presupuesto sin compromiso.      (78)
Cortes al gramaje de tu cocina, envasados al vacío. Entregas en CABA y GBA.         (75)
Más de 40 negocios B2B ya trabajan con nosotros. Contanos qué necesitás.            (72)
```

⚠️ **No usar el dato de las madres porcinas en ningún anuncio**: el sitio dice 1.600 y
la información de la empresa dice 3.000, y está sin resolver. Ver [ROADMAP.md](ROADMAP.md).
Tampoco precios, plazos ni pedido mínimo: no están definidos.

## URL de destino, y por qué arrastra la estructura de la campaña

Hoy todos los anuncios van a `https://b2b.porcorosso.com.ar`, porque
`/gastronomicos/` y `/mayoristas/` **todavía no están publicadas** (dan 404).

**Un anuncio tiene una sola URL final.** Así que mandar tráfico a dos destinos exige
dos grupos de anuncios: publicar las landings y dividir la campaña en grupos son el
mismo trabajo, no dos proyectos. Cuando estén online: grupo Gastronómicos →
`/gastronomicos/`, grupo Mayoristas → `/mayoristas/`, cada uno con sus palabras clave y
su anuncio, compartiendo presupuesto y aprendizaje. Es la estructura que se quería desde
el principio, y los grupos se agregan desde Campañas → Grupos de anuncios → +, sin
cambiar de modo.

Dos avisos de timing: cambiar la URL final **reemplaza el anuncio**, y el nuevo vuelve a
revisión (~1 día hábil), así que no conviene hacerlo el día que tiene que estar
corriendo. Y el destino es solo uno de los tres factores del Nivel de calidad —los otros
son CTR esperado y relevancia del anuncio—, así que ayuda pero no es palanca infinita, y
no crea demanda: hace rendir más cada peso.

### La página de gracias es una sola, y así tiene que quedar

Verificado en el build: las tres landings usan **el mismo componente de
formulario**, el mismo bundle de JS, y las tres redirigen a `/gracias/`. Se reutilizó el
componente en vez de duplicarlo, así que no hay forma de que se desincronicen.

**No crear páginas de gracias separadas por landing.** La conversión del formulario está
definida por URL: si cada landing terminara en su propia página, esa conversión dejaría
de contarlas justo cuando haya que evaluar si las landings específicas bajaron el CPC.
Si alguna vez hicieran falta páginas separadas, tienen que compartir prefijo
(`/gracias/gastronomicos`) y la conversión pasa a configurarse por "la URL contiene
/gracias".

Esto no impide saber de qué landing vino cada lead: `contacto.php` ya guarda el
`HTTP_REFERER` en la columna **Origen** del CSV, y el envío es del mismo dominio, así
que llega la ruta completa. La atribución por grupo de anuncios y palabra clave la hace
Google por el clic, no por la URL de destino.

## La promoción de ARS 300.000

**No hay código que canjear ni momento que elegir**: se aplica sola al completar la
facturación. Y el plazo no son 60 días desde el canje, es **fecha fija de calendario**:

> "La inversión se debe realizar antes del 6 nov 2026."

Eso da vuelta el consejo anterior: **demorar no protege nada, achica la ventana.**

- Al 14 de septiembre de 2026 quedan **53 días**.
- A 12.000/día hacen falta 25 días de publicación, así que la fecha tope para encender
  es el **12 de octubre**... siempre que la campaña logre gastar ese ritmo. Si gasta
  menos, la fecha se adelanta, y algunos escenarios ya están encima:

| Si gasta por día | Última fecha para encender | Estado al 14/09 |
|---|---|---|
| ARS 12.000 | 12 de octubre | faltan 28 días |
| ARS 10.000 | 7 de octubre | faltan 23 días |
| ARS 8.000 | 30 de septiembre | faltan 16 días |
| ARS 6.000 | 17 de septiembre | **faltan 3 días** |
| ARS 5.000 | 7 de septiembre | ya pasó |

**Conviene cargar la facturación pronto, no tarde.** Ni bien se carga, la cuenta se
desbloquea, se pausa la campaña en el acto y recién ahí se pueden crear la lista de
exclusión y las tres conversiones, que es todo lo que quedó trabado detrás de esto. El
saldo queda quieto mientras la campaña esté pausada. Se puede cargar en tramos, no hace
falta poner los 300.000 de una.

**El camino crítico es la medición del sitio**, que hoy no está publicada. Ver
[ROADMAP.md](ROADMAP.md).

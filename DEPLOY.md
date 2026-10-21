# Deploy — b2b.porcorosso.com.ar

La landing B2B es un sitio **estático** de Astro. El build se hace local y se suben
archivos por SSH. El servidor no necesita Node: solo sirve HTML, CSS, imágenes y un
único script PHP que recibe los leads.

## Datos del servidor

| | |
|---|---|
| Proveedor | Hostinger (hosting compartido, Business/Premium) |
| Host | `212.85.6.214` |
| Puerto SSH | `65002` |
| Usuario | `u512253031` |
| Clave privada | `~/.ssh/hostinger_porcorosso` |
| Carpeta del sitio | `/home/u512253031/domains/porcorosso.com.ar/public_html/b2b` |
| URL | https://b2b.porcorosso.com.ar |
| PHP | 8.3 |

La clave pública está autorizada en hPanel → Avanzado → Acceso SSH, con el nombre
`claude-code-deploy`.

⚠️ **La clave privada no está en el repo y nunca debe estarlo.** Vive solo en la
máquina desde la que se viene publicando. Si trabajás desde otra computadora, o sos
un agente sin acceso a ese archivo, **no vas a poder desplegar**: podés hacer
cambios y commitearlos, pero publicar requiere una clave nueva.

Para habilitar otra máquina, generá un par nuevo y subí la pública al panel:

```bash
ssh-keygen -t ed25519 -f ~/.ssh/hostinger_porcorosso -C "deploy-porcorosso" -N ""
cat ~/.ssh/hostinger_porcorosso.pub
```

Esa clave pública se pega en hPanel → Avanzado → Acceso SSH → Claves SSH. Después
de eso, el comando de publicación de abajo funciona igual.

## Publicar cambios

⚠️ Desde la rama `produccion`, no desde `main`: ver la sección siguiente.

```bash
npm run build
rsync -avz --delete -e "ssh -i ~/.ssh/hostinger_porcorosso -p 65002" \
  dist/ u512253031@212.85.6.214:/home/u512253031/domains/porcorosso.com.ar/public_html/b2b/
```

`--delete` sincroniza exacto: lo que no está en `dist/` se borra del servidor. Como
`dist/` se regenera entero en cada build, es el comportamiento deseado.

## La rama `produccion`

Producción se publica **siempre desde la rama `produccion`, nunca desde `main`**.
`produccion` es `main` más un commit que borra `/mayoristas/` y `/gastronomicos/` y sus
enlaces, porque el titular todavía no autorizó subirlas.

Para publicar lo nuevo de `main`:

```bash
git worktree add ../porcorosso-online produccion   # si no existe ya
cd ../porcorosso-online && ln -s ../web-porcorosso/node_modules node_modules
git merge main
npm run build
rsync -rn --checksum --delete --itemize-changes -e "ssh -i ~/.ssh/hostinger_porcorosso -p 65002" \
  dist/ u512253031@212.85.6.214:/home/u512253031/domains/porcorosso.com.ar/public_html/b2b/
# si la lista está bien, repetir sin -n para publicar
```

Mirar la lista del `-n` antes de publicar: tienen que aparecer solo los archivos del
cambio. `sitemap-index.xml` y los dos logos WebP aparecen siempre, porque cambian en
cada build aunque el contenido sea el mismo; es normal.

Si un merge choca con las páginas borradas (porque en `main` se editaron), resolver
dejándolas borradas. Cuando el titular autorice subirlas: `git branch -f produccion
main` y publicar.

## Los leads del formulario

El formulario postea a `/contacto.php` ([public/contacto.php](public/contacto.php)),
que hace dos cosas con cada consulta:

1. **La guarda en un CSV** en `/home/u512253031/domains/porcorosso.com.ar/leads/leads-b2b.csv`.
   Esa carpeta está **fuera** de `public_html`, con permisos `700`, así que no se puede
   descargar desde la web. El CSV lleva BOM, por lo que Excel abre los acentos bien.
2. **Manda un mail** a `hola@porcorosso.com.ar` con la consulta formateada, poniendo el
   correo del interesado en `Reply-To` para poder responder directo.

El CSV es la fuente de verdad: si el mail falla (SPF, MX en otro proveedor, cuota del
hosting), el lead ya quedó guardado igual. La consulta solo se da por perdida si fallan
las dos vías, y en ese caso el visitante ve un aviso con el WhatsApp como alternativa,
en lugar de la pantalla de éxito.

### Copia a Flux (el CRM)

Después de guardar en el CSV y mandar el mail, `contacto.php` le contesta al navegador
y **recién ahí** manda una copia del lead a Flux by Salix. Si Flux no responde o
rechaza la copia, el lead no se pierde (ya está en el CSV y en el mail) y queda una
línea en `leads/errores.log`.

La URL y la clave **no están en el repo**. Viven en
`/home/u512253031/domains/porcorosso.com.ar/privado/flux.php`, fuera de `public_html`.
Mientras ese archivo no exista, no se manda nada a Flux. Flux sugiere una variable de
entorno `FLUX_CLAVE_FORMULARIO`, pero en el hosting compartido de Hostinger no hay una
forma simple de dársela a PHP: por eso va en un archivo.

La clave se genera en Flux: Marketing → Formularios → «Formulario B2B (landing)» →
Compartir → «Recibir desde tu servidor» → Generar clave. Se muestra una sola vez.
**No pegarla en ningún chat.** Este comando la pide sin mostrarla y escribe el archivo
en el servidor. Correrlo en una terminal propia (zsh), no dentro de un asistente:

```bash
read -rs "CLAVE?Clave de Flux: " && echo && \
ssh -i ~/.ssh/hostinger_porcorosso -p 65002 u512253031@212.85.6.214 \
  'mkdir -p ~/domains/porcorosso.com.ar/privado && chmod 700 ~/domains/porcorosso.com.ar/privado && umask 077 && cat > ~/domains/porcorosso.com.ar/privado/flux.php' <<FIN
<?php return ['url' => 'https://flux.salixweb.com/api/publico/f/frm_724af40a219aab961175db75/recibir', 'clave' => '$CLAVE'];
FIN
unset CLAVE
```

Si alguien regenera la clave en Flux, la anterior deja de andar: hay que reemplazarla
en ese archivo. Lo que mande la landing a partir de ahí va a figurar como rechazado
(401) en Flux y en `errores.log`.

### Errores del script

`contacto.php` escribe sus errores en
`/home/u512253031/domains/porcorosso.com.ar/leads/errores.log`, junto al CSV. Hostinger
los escribiría por defecto en un archivo `error_log` dentro de la carpeta pública: ver
la regla 14 de [AGENTS.md](AGENTS.md).

### Bajar los leads

```bash
scp -i ~/.ssh/hostinger_porcorosso -P 65002 \
  u512253031@212.85.6.214:/home/u512253031/domains/porcorosso.com.ar/leads/leads-b2b.csv .
```

### Anti-spam

`contacto.php` descarta envíos automatizados por dos vías, antes de tocar el CSV:

- **Honeypot**: un campo `sitio_web` invisible para personas. Si viene completo, se
  descarta con una respuesta `200` normal para no delatar la trampa.
- **Tiempo de completado**: si el formulario se envía en menos de 3 segundos, se descarta.

Falta activar reCAPTCHA v3, que ya está preparado en el código y solo necesita la clave.
Ver [ROADMAP.md](ROADMAP.md).

## Notas de DNS

El dominio `porcorosso.com.ar` usa nameservers de Hostinger (`nova`/`cosmos.dns-parking.com`),
pero está registrado en NIC.ar. La raíz apunta a **Shopify** (`23.227.38.65`) y `www` a
`shops.myshopify.com`: ahí vive la tienda de consumidor final. **No tocar esos registros.**
El subdominio `b2b` es el único que apunta al hosting de Hostinger.

## Trampa conocida: acentos en nombres de archivo

macOS guarda los acentos en forma NFD y Linux espera NFC, así que un archivo llamado
`chorizo-bombón.jpg` se sube con un nombre que el servidor no encuentra cuando el
navegador lo pide, y devuelve 404 aunque el archivo esté ahí. **Nombrar los archivos de
`public/` sin acentos ni eñes.**

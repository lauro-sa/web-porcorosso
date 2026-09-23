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

```bash
npm run build
rsync -avz --delete -e "ssh -i ~/.ssh/hostinger_porcorosso -p 65002" \
  dist/ u512253031@212.85.6.214:/home/u512253031/domains/porcorosso.com.ar/public_html/b2b/
```

`--delete` sincroniza exacto: lo que no está en `dist/` se borra del servidor. Como
`dist/` se regenera entero en cada build, es el comportamiento deseado.

## Publicar solo una parte

Producción se publica desde la rama **`produccion`**, no desde `main`. `main` tiene
trabajo que el titular todavía no autorizó a subir (las páginas de segmento, la
medición). Para publicar un cambio suelto:

```bash
git worktree add ../porcorosso-publicar produccion
cd ../porcorosso-publicar && ln -s ../web-porcorosso/node_modules node_modules
# traer solo los archivos del cambio desde main, o hacer cherry-pick si no choca
git checkout main -- ruta/al/archivo
npm run build
rsync -rn --checksum --delete --itemize-changes -e "ssh -i ~/.ssh/hostinger_porcorosso -p 65002" \
  dist/ u512253031@212.85.6.214:/home/u512253031/domains/porcorosso.com.ar/public_html/b2b/
```

Mirar la lista del `-n` antes de publicar de verdad: tienen que aparecer solo los
archivos del cambio. Aparecen siempre `sitemap-index.xml` y los dos logos WebP, porque
cambian en cada build aunque el contenido sea el mismo; eso es normal. Después,
commitear en `produccion`, borrar el symlink y `git worktree remove`.

Cuando el titular autorice subir todo, se publica `main` y `produccion` se pone al día
con `git branch -f produccion main`.

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

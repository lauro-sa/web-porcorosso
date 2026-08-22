# Porco Rosso — Landing B2B

Sitio mayorista de Porco Rosso, productor porcino argentino. Capta consultas de
restaurantes, hoteles, carnicerías y distribuidoras en CABA y Gran Buenos Aires.

**En producción:** https://b2b.porcorosso.com.ar

> 🤖 **¿Sos un agente de IA?** Empezá por **[AGENTS.md](AGENTS.md)**.

## Arrancar

```sh
npm install
npm run dev      # http://localhost:4321
```

| Comando | Qué hace |
|---|---|
| `npm run dev` | Servidor de desarrollo |
| `npm run build` | Genera `dist/` |
| `npm run preview` | Previsualiza el build |

Requiere Node 22.12 o superior.

## Stack

Astro 6 estático + Tailwind CSS v4. El sitio se compila a HTML plano y se sirve
desde Hostinger; el único código que corre en el servidor es
[public/contacto.php](public/contacto.php), que recibe los leads del formulario.

## Documentación

| Archivo | Para qué |
|---|---|
| [AGENTS.md](AGENTS.md) | Punto de entrada: stack, reglas del repo y trampas conocidas |
| [ROADMAP.md](ROADMAP.md) | Qué falta, priorizado, con el informe de auditoría SEO/GEO |
| [DEPLOY.md](DEPLOY.md) | Cómo publicar y cómo llegan los leads |
| [NOTAS-PROYECTO.md](NOTAS-PROYECTO.md) | Origen del proyecto y decisiones con el cliente |
| [RTM-BRAND.md](RTM-BRAND.md) | Marca: paleta, tipografías y tono |

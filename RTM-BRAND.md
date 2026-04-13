# Porco Rosso - RTM Brand Book 2025

Trazabilidad de implementación de assets del Brand Book en la web.

| Estado | Significado |
|--------|-------------|
| OK | Implementado correctamente |
| PARCIAL | Implementado pero incompleto |
| PENDIENTE | No implementado aún |
| REVISAR | Requiere confirmación del dueño |

---

## Colores de marca

| Color | Hex | Variable CSS | Estado | Dónde se usa |
|-------|-----|-------------|--------|-------------|
| Morcilla (marrón oscuro) | `#352323` | `--color-morcilla` | OK | Textos, fondos oscuros, NavBar, Footer |
| Frigo (blanco) | `#f4f2f2` | `--color-frigo` | OK | Fondo principal del body, secciones claras |
| Carne / Rojo Res | `#982c2a` | `--color-carne` | OK | Acentos, CTAs, títulos destacados, card Porcino Premium |
| Piel (rosa) | `#dd8790` | `--color-piel` | OK | Acentos secundarios, variante de tag |
| Hueso (crema) | `#f3e3cc` | `--color-hueso` | OK | Fondo Hero, sección Productos, cards |

**Variantes adicionales creadas (no en Brand Book, derivadas):**
- `--color-carne-dark: #7a2321`
- `--color-carne-light: #b33533`
- `--color-piel-light: #e8a5ac`
- `--color-morcilla-light: #4a3535`

---

## Tipografías

| Fuente | Uso en Brand Book | Variable CSS | Estado | Notas |
|--------|------------------|-------------|--------|-------|
| TAY Big Bird | Accent/labels | `--font-accent` | OK | Self-hosted desde `/public/fonts/TAYBigBird.otf`. Se usa en tags, labels, elementos UI |
| Montserrat Light | Body/contenido | `--font-body` | OK | Cargada desde Google Fonts (pesos 300-700). Reemplazó a Inter el 12/04/2026 |
| Acme Gothic | Display/títulos | `--font-display` | REVISAR | No disponible. Se usa **Barlow Condensed** como stand-in. Confirmar con dueño |

---

## Logo

| Variante | Archivo fuente (Brand Book) | Estado | Dónde se usa |
|----------|---------------------------|--------|-------------|
| Logo Morcilla (principal) | `pngs/Porco Rosso - Morcilla-01.png` | OK | NavBar, referencia general |
| Logo Morcilla (alternativo) | `pngs/Porco Rosso - Morcilla-02.png` | PARCIAL | Disponible, poco usado |
| Logo Rojo Res | `pngs/Porco Rosso - Rojo Res-01.png` | PENDIENTE | No integrado en la web |
| Logo Rosa Piel | `pngs/Porco Rosso - Rosa Piel-01.png` | PENDIENTE | No integrado en la web |
| Logo Crudo Hueso | `pngs/Porco Rosso - Crudo Hueso-01.png` | PENDIENTE | Podría usarse sobre fondos oscuros |
| Logo Blanco Frigo | `pngs/Porco Rosso - Blanco Frigo-01.png` | PENDIENTE | Podría usarse en Footer oscuro |
| Logo solo "Rosso" | Visible en posteos redes | PENDIENTE | No integrado |
| Logo solo "Porco" | Visible en posteos redes | PENDIENTE | No integrado |

---

## Ilustraciones (Familia de personajes)

| Personaje | Archivo fuente | Estado | Dónde se usa |
|-----------|---------------|--------|-------------|
| Papa Pig (cara) | `Ilustraciones PORCO-01.png` | OK | `About.astro` - sección Nosotros |
| Papa Pig (cuerpo) | `Ilustraciones PORCO-02.png` | OK | `Hero.astro` - fondo decorativo |
| Papa Pig (variante) | `Ilustraciones PORCO-06.png` | PENDIENTE | Disponible, no usado |
| Pig Pig | `Ilustraciones PORCO-03.png`, `04.png` | PENDIENTE | No integrado |
| Nona Pig | `Ilustraciones PORCO-05.png` | PENDIENTE | No integrado |
| Kiddo Pig | `Ilustraciones PORCO-07.png` | PENDIENTE | No integrado |
| Mama Pig | `Ilustraciones PORCO-08.png` | PENDIENTE | No integrado |

---

## Tono y mensajes

| Mensaje del Brand Book | Estado en la web | Notas |
|----------------------|-----------------|-------|
| "Aquí se cría, se produce & se disfruta en familia" | REVISAR | El sitio usa "Carne de calidad, hecha con oficio" como headline principal. Confirmar cuál prefiere el dueño |
| "Un gusto, Don Porco Rosso" | PENDIENTE | Aparece en posteos del Brand Book, no usado en la web |
| Concepto familia/artesanal | OK | El tono general del sitio refleja lo familiar y artesanal |
| Enfoque cadena completa (cría → venta) | OK | Presente en Hero y About |

---

## Assets de redes (disponibles para integrar)

| Asset | Estado | Posible uso web |
|-------|--------|----------------|
| Posteos (F1-F6) | PENDIENTE | Referencia visual, galería, o sección de redes |
| Historias Almacén (A1-A3) | PENDIENTE | Sección almacén/tienda |
| Historias Nosotros (N1-N7) | PENDIENTE | Sección about ampliada |
| Historias Productos (P1-P5) | PENDIENTE | Sección productos |
| Profile IG | PENDIENTE | Link a redes |
| Highlights (HL 08-12) | PENDIENTE | Referencia visual |

---

## Catálogo de productos (del InDesign)

Productos fotografiados disponibles en el Brand Book:
- Bondiola, Matambrito, Costillitas, Pork Belly, Solomillo, Vacío Flecha
- Tapa de Asado, Tira de centro, Ribs de carré
- Chorizo Bombón, Morcilla Dulce, Morcilla Salada, Salchicha Parrillera
- Secreto Porteño, Caprichito

**Estado**: PARCIAL — Las fotos del catálogo están en la carpeta del Brand Book pero la web usa imágenes propias en `/public/images/productos/`.

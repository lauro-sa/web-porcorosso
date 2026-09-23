/**
 * Enlaces de WhatsApp al canal B2B.
 *
 * Todos los botones de WhatsApp del sitio arman su enlace aca, y el formulario
 * y /gracias toman de aca el numero, para que numero y firma esten en un solo
 * lugar. Si cambia el telefono, ver tambien
 * la regla 5 de AGENTS.md: se repite en los tel:, el JSON-LD, las preguntas
 * frecuentes y llms.txt.
 *
 * Cada boton manda un saludo propio segun desde donde se toca, y todos cierran
 * con una firma en cursiva (entre guiones bajos, formato de WhatsApp) para que
 * quien atiende sepa que el contacto vino de la web. La firma no lleva la
 * direccion del sitio a proposito: con un link, WhatsApp agrega una vista previa
 * grande y el mensaje deja de ser discreto.
 *
 * El formulario usa otra firma ("desde el formulario de la web"), que arma
 * ContactForm.astro junto con los datos de la consulta.
 */

export const WHATSAPP_B2B = "5491172714251";

export const FIRMA_WEB = "_Enviado desde la web B2B de Porco Rosso._";

export function enlaceWhatsApp(saludo: string): string {
  const texto = `${saludo}\n\n${FIRMA_WEB}`;
  return `https://wa.me/${WHATSAPP_B2B}?text=${encodeURIComponent(texto)}`;
}
